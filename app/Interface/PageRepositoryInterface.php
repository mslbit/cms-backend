<?php

declare(strict_types=1);

namespace App\Interface;

use App\Domain\Entity\Page;
use App\Domain\ValueObject\PagePaginator;
use Hyperf\Contract\LengthAwarePaginatorInterface;

/**
 * Page 仓储接口
 */
interface PageRepositoryInterface
{
    /**
     * 根据 ID 查找页面
     */
    public function findById(int $id): ?Page;

    /**
     * 根据 Slug 查找页面
     */
    public function findBySlug(string $slug): ?Page;

    /**
     * 查找所有页面（支持分页和状态筛选）
     * 
     * @deprecated 使用 paginate() 替代，返回框架分页器结果
     */
    public function findAll(?int $status = null, int $page = 1, int $pageSize = 10): array;

    /**
     * 分页查询（使用 Hyperf 分页器）
     */
    public function paginate(?int $status = null, int $page = 1, int $pageSize = 10): LengthAwarePaginatorInterface;

    /**
     * 统计页面数量
     */
    public function count(?int $status = null): int;

    /**
     * 保存页面（创建或更新）
     */
    public function save(Page $page): Page;

    /**
     * 删除页面
     */
    public function delete(int $id): bool;

    /**
     * 分页查询返回 PagePaginator
     */
    public function paginateToPaginator(?int $status = null, int $page = 1, int $pageSize = 10): PagePaginator;
}