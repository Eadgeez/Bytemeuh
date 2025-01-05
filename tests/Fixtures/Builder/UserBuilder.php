<?php

declare(strict_types=1);

namespace App\Tests\Fixtures\Builder;

use App\Entity\User;
use App\Tests\Fixtures\Factory\UserFactory;

class UserBuilder implements BuilderInterface
{
    private ?string $email = null;
    private array $roles = [];
    private ?string $plainPassword = null;
    private bool $verified = false;

    public function withEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function withRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function verified(): self
    {
        $this->verified = true;

        return $this;
    }

    public function build(bool $persist = true): User
    {
        $user = UserFactory::createOne(array_filter([
            'email' => $this->email,
            'roles' => $this->roles,
            'plainPassword' => $this->plainPassword,
            'verified' => $this->verified,
        ]));

        if ($persist) {
            $user->_save();
        }

        return $user;
    }

    public function getEntityClass(): string
    {
        return User::class;
    }
}