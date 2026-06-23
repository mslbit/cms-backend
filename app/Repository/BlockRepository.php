<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Entity\Block;
use App\Domain\ValueObject\PublishStatus;
use App\Interface\BlockRepositoryInterface;
use App\Model\BlockModel;

/**
 * Block 仓储实现
 */
class BlockRepository implements BlockRepositoryInterface
{
    public function findById(int $id): ?Block
    {
        $model = BlockModel::find($id);
        return $model !== null ? $this->toEntity($model) : null;
    }

    public function findBySlug(string $slug): ?Block
    {
        $model = BlockModel::where('slug', $slug)->first();
        return $model !== null ? $this->toEntity($model) : null;
    }

    public function findByPosition(string $position): array
    {
        return BlockModel::where('position', $position)
            ->where('status', PublishStatus::PUBLISHED->toInt())
            ->get()
            ->map(fn(BlockModel $model) => $this->toEntity($model))
            ->toArray();
    }

    public function findAll(?int $status = null): array
    {
        $query = BlockModel::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->get()->map(fn(BlockModel $model) => $this->toEntity($model))->toArray();
    }

    public function save(Block $block): Block
    {
        $modelData = $this->toModelData($block);
        $blockId = $block->getRawId();

        if ($blockId === null) {
            $model = BlockModel::create($modelData);
            $block->setData('id', $model->id);
            $block->setData('created_at', $model->created_at?->toDateTimeString());
            $block->setData('updated_at', $model->updated_at?->toDateTimeString());
        } else {
            $model = BlockModel::find($blockId);
            if ($model === null) {
                throw new \RuntimeException(sprintf('Block with id %d not found', $blockId));
            }
            $model->update($modelData);
            $block->setData('updated_at', $model->updated_at?->toDateTimeString());
        }

        return $block;
    }

    public function delete(int $id): bool
    {
        $model = BlockModel::find($id);
        if ($model === null) {
            return false;
        }

        return $model->delete();
    }

    private function toEntity(BlockModel $model): Block
    {
        return new Block([
            'id' => $model->id,
            'slug' => $model->slug,
            'type' => $model->type,
            'content' => $model->content ?? [],
            'position' => $model->position,
            'status' => $model->status,
            'created_at' => $model->created_at?->toDateTimeString(),
            'updated_at' => $model->updated_at?->toDateTimeString(),
        ]);
    }

    private function toModelData(Block $block): array
    {
        return [
            'slug' => $block->getSlug(),
            'type' => $block->getType(),
            'content' => $block->getContent(),
            'position' => $block->getPosition(),
            'status' => $block->getStatus()->toInt(),
        ];
    }
}
