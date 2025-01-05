<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\Fixtures\ThereIs;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(User::class);
    }

    public function testLoginPageIsAccessible(): void
    {
        $this->client->request('GET', '/login');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Connexion');
    }

    public function testLoginWithValidCredentials(): void
    {
        $user = ThereIs::aUser()
            ->withEmail('test@gmail.com')
            ->withPassword('password')
            ->verified()
            ->build()
        ;

        $this->client->request('GET', '/login');

        $this->client->submitForm('Se connecter', [
            '_username' => 'test@gmail.com',
            '_password' => 'password',
        ]);

        self::assertResponseRedirects('/');
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $this->client->request('GET', '/login');

        $this->client->submitForm('Se connecter', [
            '_username' => 'test@gmail.com',
            '_password' => 'password',
        ]);

        self::assertResponseRedirects('/login');
    }

    public function testCantLoginWithUnverifiedUser(): void
    {
        $user = ThereIs::aUser()
            ->withEmail('test@gmail.com')
            ->withPassword('password')
            ->build();

        $this->client->request('GET', '/login');

        $this->client->submitForm('Se connecter', [
            '_username' => 'test@gmail.com',
            '_password' => 'password',
        ]);

        self::assertResponseRedirects('/login');
    }

    public function testLogout(): void
    {
        $user = ThereIs::aUser()
            ->withEmail('test@gmail.com')
            ->withPassword('password')
            ->verified()
            ->build()
        ;

        $this->client->loginUser($this->repository->find($user->getId()));

        $this->client->request('GET', '/logout');

        self::assertResponseRedirects('/');
    }

    public function testRegister(): void
    {
        $this->client->request('GET', '/register');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('S\'inscrire', [
            'registration_form[email]' => 'test@gmail.com',
            'registration_form[plainPassword][first]' => 'Aqw159@xsZ357',
            'registration_form[plainPassword][second]' => 'Aqw159@xsZ357',
            'registration_form[agreeTerms]' => true,
        ]);

        self::assertResponseRedirects('/login');
    }

    public function testCantRegisterWithoutAgreeingToTerms(): void
    {
        $this->client->request('GET', '/register');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('S\'inscrire', [
            'registration_form[email]' => 'test@gmail.com',
            'registration_form[plainPassword][first]' => 'Aqw159@xsZ357',
            'registration_form[plainPassword][second]' => 'Aqw159@xsZ357',
        ]);

        self::assertResponseStatusCodeSame(422);
    }

    public function testCantRegisterWithInvalidEmail(): void
    {
        $this->client->request('GET', '/register');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('S\'inscrire', [
            'registration_form[email]' => 'test',
            'registration_form[plainPassword][first]' => 'Aqw159@xsZ357',
            'registration_form[plainPassword][second]' => 'Aqw159@xsZ357',
            'registration_form[agreeTerms]' => true,
        ]);

        self::throwException(new \ErrorException('Email "test" does not comply with addr-spec of RFC 2822'));
    }

    public function testCantRegisterWithInvalidPassword(): void
    {
        $this->client->request('GET', '/register');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('S\'inscrire', [
            'registration_form[email]' => 'test@gmail.com',
            'registration_form[plainPassword][first]' => 'password',
            'registration_form[plainPassword][second]' => 'password',
            'registration_form[agreeTerms]' => true,
        ]);

        self::throwException(new \ErrorException('Password is too short (4 chars), it should be at least 12 characters long'));
    }

    public function testEmailSendAfterRegistration(): void
    {
        $this->client->request('GET', '/register');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('S\'inscrire', [
            'registration_form[email]' => 'test@gmail.com',
            'registration_form[plainPassword][first]' => 'Aqw159@xsZ357',
            'registration_form[plainPassword][second]' => 'Aqw159@xsZ357',
            'registration_form[agreeTerms]' => true,
        ]);

        self::assertEmailCount(1);
    }

    public function testCanVerifyUserAfterRegistration(): void
    {
        $this->client->request('GET', '/register');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('S\'inscrire', [
            'registration_form[email]' => 'test@gmail.com',
            'registration_form[plainPassword][first]' => 'Aqw159@xsZ357',
            'registration_form[plainPassword][second]' => 'Aqw159@xsZ357',
            'registration_form[agreeTerms]' => true,
        ]);

        /** @var User $user */
        $user = $this->repository->findOneBy(['email' => 'test@gmail.com']);

        self::assertResponseRedirects('/login');
        self::assertEmailCount(1);

        $email = $this->getMailerMessage();

        self::assertEmailHtmlBodyContains($email, 'Confirmer mon e-mail');
        $pattern = '/\/verify\/email\?[^"]+/';

        $verifiedLink = null;

        if (preg_match($pattern, quoted_printable_decode($email->toString()), $matches)) {
            $verifiedLink = $matches[0];
        }

        self::assertNotNull($verifiedLink);

        $this->client->followRedirect();

        $this->client->submitForm('Se connecter', [
            '_username' => 'test@gmail.com',
            '_password' => 'Aqw159@xsZ357',
        ]);

        self::assertResponseRedirects('/login');

        $crawler = $this->client->followRedirect();

        self::assertSame('Veuillez validé votre compte par email.', $crawler->filter('div.text-red-600.text-center')->text());

        $this->client->request('GET', $verifiedLink);

        self::assertResponseRedirects('/login');

        $this->client->followRedirect();

        $this->client->submitForm('Se connecter', [
            '_username' => 'test@gmail.com',
            '_password' => 'Aqw159@xsZ357',
        ]);

        self::assertResponseRedirects('/');
    }

    public function testForgotPassword(): void
    {
        $user = ThereIs::aUser()
            ->withEmail('test@gmail.com')
            ->withPassword('password')
            ->verified()
            ->build()
        ;

        $this->client->request('GET', '/reset-password');

        self::assertResponseIsSuccessful();

        $this->client->submitForm('Réinitialiser', [
            'reset_password_request_form[email]' => 'test@gmail.com',
        ]);

        self::assertResponseRedirects('/reset-password/check-email');
        $email = $this->getMailerMessage();
        self::assertEmailCount(1);
        self::assertEmailHeaderSame($email, 'To', 'test@gmail.com');

        $crawler = $this->client->followRedirect();

        self::assertSame('Email de réinitialisation de mot de passe', $crawler->filter('h1.text-3xl')->text());

        $pattern = '/\/reset-password\/reset\/\w+/';
        $resetLink = null;

        if (preg_match($pattern, quoted_printable_decode($email->toString()), $matches)) {
            $resetLink = $matches[0];
        }

        self::assertNotNull($resetLink);

        $this->client->request('GET', $resetLink);

        self::assertResponseRedirects('/reset-password/reset');

        $this->client->followRedirect();

        $crawler = $this->client->submitForm('Réinitialiser', [
            'change_password_form[plainPassword][first]' => 'Aqw159@xsZ357',
            'change_password_form[plainPassword][second]' => 'Aqw159@xsZ357',
        ]);

        self::assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->client->submitForm('Se connecter', [
            '_username' => 'test@gmail.com',
            '_password' => 'Aqw159@xsZ357',
        ]);

        self::assertResponseRedirects('/');
    }
}
