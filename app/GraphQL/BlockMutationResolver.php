<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\Domain\Entity\Block;
use App\Domain\GlobalId;
use App\Domain\ValueObject\PublishStatus;
use App\Interface\BlockRepositoryInterface;
use Maiscraft\GraphQL\Annotation\Mutation;
use Maiscraft\GraphQL\Annotation\Arg;
use Maiscraft\GraphQL\Contract\ResolverInterface;

/**
 * Block Mutation Resolver
 * CRUD 操作，需要认证（由 buildResolver 自动检查 context['auth_user_id']）
 */
class BlockMutationResolver implements ResolverInterface
{
    public function __construct(
        private BlockRepositoryInterface $blockRepository
    ) {
    }

    #[Mutation(description: 'Create a new block')]
    public function createBlock(
        string $slug,
        string $type,
        ?array $content = null,
        ?string $position = null,
        ?PublishStatus $status = null
    ): Block {
        $block = new Block([
            'slug' => $slug,
            'type' => $type,
            'content' => $content ?? [],
            'position' => $position,
            'status' => $status ?? PublishStatus::DRAFT,
        ]);

        return $this->blockRepository->save($block);
    }

    #[Mutation(description: 'Update an existing block')]
    public function updateBlock(
        #[Arg(type: 'ID!')] string $id,
        ?string $slug = null,
        ?string $type = null,
        ?array $content = null,
        ?string $position = null,
        ?PublishStatus $status = null
    ): ?Block {
        $block = $this->blockRepository->findById(GlobalId::decodeId($id) ?? 0);
        if ($block === null) {
            return null;
        }

        if ($slug !== null) {
            $block->setData('slug', $slug);
        }
        if ($type !== null) {
            $block->setData('type', $type);
        }
        if ($content !== null) {
            $block->setData('content', $content);
        }
        if ($position !== null) {
            $block->setData('position', $position);
        }
        if ($status !== null) {
            $block->setStatus($status);
        }

        return $this->blockRepository->save($block);
    }

    #[Mutation(description: 'Delete a block')]
    public function deleteBlock(#[Arg(type: 'ID!')] string $id): bool
    {
        return $this->blockRepository->delete(GlobalId::decodeId($id) ?? 0);
    }
}