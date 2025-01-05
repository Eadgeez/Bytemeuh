<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'admin:update:right',
    description: 'Make or revoke admin user',
)]
class UpdateAdminRight extends Command
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $make = $io->confirm('Do you want to make the user an admin?', true);

        return $io->ask('Please enter the email address of the admin user', null, function ($email) use ($io, $make) {
            # update existing user to role admin
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($user) {
                if (!$make) {
                    $user->setRoles([]);
                } else {
                    $user->setRoles(['ROLE_ADMIN']);
                }
                $this->entityManager->flush();

                $io->success($make ? 'User updated to admin' : 'Admin right revoked');

                return Command::SUCCESS;
            }

            $io->error('User not found');

            return Command::FAILURE;
        });
    }
}