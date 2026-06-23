<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\DataObject;
use Maiscraft\GraphQL\Annotation\Type;

#[Type(description: '管理员信息')]
class AdminUserResult extends DataObject
{
    public function getId(): ?string
    {
        $id = $this->data['id'] ?? null;
        return $id !== null ? (string) $id : null;
    }

    public function getUsername(): ?string
    {
        return $this->data['username'] ?? null;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }

    public function getAvatar(): ?string
    {
        return $this->data['avatar'] ?? null;
    }
}