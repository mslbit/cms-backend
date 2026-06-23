<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * 分页查询 DTO
 */
class ListQueryDTO
{
    public function __construct(
        public readonly ?string $status = null,
        public readonly ?string $category = null,
        public readonly int $page = 1,
        public readonly int $pageSize = 10
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['status'] ?? null,
            $data['category'] ?? null,
            (int) ($data['page'] ?? 1),
            (int) ($data['pageSize'] ?? 10)
        );
    }
}