<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\Domain\Entity\Block;
use App\Domain\GlobalId;
use App\Domain\ValueObject\PublishStatus;
use App\Interface\BlockRepositoryInterface;
use Maiscraft\GraphQL\Annotation\Query;
use Maiscraft\GraphQL\Annotation\Arg;
use Maiscraft\GraphQL\Contract\ResolverInterface;

/**
 * Block Query Resolver
 * 公开查询，无需认证
 */
class BlockQueryResolver implements ResolverInterface
{
    public function __construct(
        private BlockRepositoryInterface $blockRepository
    ) {
    }

    #[Query(description: 'Get a block by ID')]
    public function block(#[Arg(type: 'ID!')] string $id): ?Block
    {
        return $this->blockRepository->findById(GlobalId::decodeId($id) ?? 0);
    }

    #[Query(description: 'Get a block by slug')]
    public function blockBySlug(string $slug): ?Block
    {
        return $this->blockRepository->findBySlug($slug);
    }

    #[Query(description: 'Get blocks by position')]
    public function blocksByPosition(string $position): array
    {
        return $this->blockRepository->findByPosition($position);
    }

    #[Query(description: 'Get all blocks', type: 'Block[]')]
    public function blocks(?PublishStatus $status = null): array
    {
        return $this->blockRepository->findAll($status?->toInt());
    }
}