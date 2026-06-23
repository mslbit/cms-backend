<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\DataObject;
use Maiscraft\GraphQL\Annotation\Type;
use Maiscraft\GraphQL\Annotation\Field;

#[Type(description: '分页结果')]
class PagePaginator extends DataObject
{
    #[Field(type: 'Page[]')]
    public function getItems(): array
    {
        return $this->data['data'] ?? [];
    }

    public function getTotal(): int
    {
        return $this->data['total'] ?? 0;
    }

    public function getCurrentPage(): int
    {
        return $this->data['current_page'] ?? 1;
    }

    public function getPerPage(): int
    {
        return $this->data['per_page'] ?? 10;
    }

    public function getLastPage(): int
    {
        return $this->data['last_page'] ?? 1;
    }
}
