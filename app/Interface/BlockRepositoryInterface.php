<?php

declare(strict_types=1);

namespace App\Interface;

use App\Domain\Entity\Block;

/**
 * Block 仓储接口
 */
interface BlockRepositoryInterface
{
    /**
     * 根据 ID 查找区块
     */
    public function findById(int $id): ?Block;

    /**
     * 根据 slug 查找区块
     */
    public function findBySlug(string $slug): ?Block;

    /**
     * 根据 position 查找区块列表
     */
    public function findByPosition(string $position): array;

    /**
     * 查找所有区块
     */
    public function findAll(?int $status = null): array;

    /**
     * 保存区块
     */
    public function save(Block $block): Block;

    /**
     * 删除区块
     */
    public function delete(int $id): bool;
}
