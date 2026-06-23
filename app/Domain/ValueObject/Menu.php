<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\DataObject;
use Maiscraft\GraphQL\Annotation\Type;
use Maiscraft\GraphQL\Annotation\Field;

#[Type(description: '菜单项')]
class Menu extends DataObject
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getLabel(): ?string
    {
        return $this->data['label'] ?? null;
    }

    public function getIcon(): ?string
    {
        return $this->data['icon'] ?? null;
    }

    public function getPath(): ?string
    {
        return $this->data['path'] ?? null;
    }

    #[Field(type: 'Menu[]')]
    public function getChildren(): array
    {
        return $this->data['children'] ?? [];
    }
}