<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\DataObject;
use Maiscraft\GraphQL\Annotation\Type;
use Maiscraft\GraphQL\Annotation\Field;

#[Type(description: '认证结果')]
class AuthResult extends DataObject
{
    public function getToken(): ?string
    {
        return $this->data['token'] ?? null;
    }

    public function getUser(): ?AdminUserResult
    {
        return isset($this->data['user']) ? AdminUserResult::fromArray($this->data['user']) : null;
    }

    #[Field(type: 'Menu[]')]
    public function getMenus(): array
    {
        return $this->data['menus'] ?? [];
    }
}