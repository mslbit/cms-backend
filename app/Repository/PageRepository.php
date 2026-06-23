<?php

declare(strict_types=1);

namespace App\Repository;

use App\Constants\ErrorCode;
use App\Domain\Entity\Page;
use App\Domain\Factory\PageFactory;
use App\Domain\ValueObject\PagePaginator;
use App\Domain\ValueObject\PublishStatus;
use App\Exception\BusinessException;
use App\Interface\PageRepositoryInterface;
use App\Model\PageModel;
use Hyperf\Contract\LengthAwarePaginatorInterface;

/**
 * Page 仓储实现
 * 集中 Model ↔ Entity 转换，包含业务校验
 */
class PageRepository implements PageRepositoryInterface
{
    public function findById(int $id): ?Page
    {
        $model = PageModel::find($id);
        return $model !== null ? PageFactory::fromModel($model) : null;
    }

    public function findBySlug(string $slug): ?Page
    {
       
        $model = PageModel::where('slug', $slug)->first();
       
        return $model !== null ? PageFactory::fromModel($model) : null;
    }

    public function findAll(?int $status = null, int $page = 1, int $pageSize = 10): array
    {
        $paginator = $this->paginate($status, $page, $pageSize);
        return $paginator->items();
    }

    public function paginate(?int $status = null, int $page = 1, int $pageSize = 10): LengthAwarePaginatorInterface
    {
        $query = PageModel::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->paginate($pageSize, ['*'], 'page', $page);
    }

    public function count(?int $status = null): int
    {
        $query = PageModel::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->count();
    }

    public function save(Page $page): Page
    {
        $modelData = PageFactory::toModelData($page);
        $pageId = $page->getId();

        if ($pageId === null) {
            $existing = PageModel::where('slug', $page->getSlug())->first();
            if ($existing !== null) {
                throw new BusinessException(ErrorCode::PAGE_SLUG_EXISTS);
            }

            $model = PageModel::create($modelData);
            $page->setData('id', $model->id);
            $page->setData('created_at', $model->created_at?->toDateTimeString());
            $page->setData('updated_at', $model->updated_at?->toDateTimeString());
        } else {
            $slug = $page->getSlug();
            $existing = PageModel::where('slug', $slug)->first();
            if ($existing !== null && $existing->id !== $pageId) {
                throw new BusinessException(ErrorCode::PAGE_SLUG_EXISTS);
            }

            $model = PageModel::find($pageId);
            if ($model === null) {
                throw new \RuntimeException(sprintf('Page with id %d not found', $pageId));
            }

            $model->update($modelData);
            $page->setData('updated_at', $model->updated_at?->toDateTimeString());
        }

        return $page;
    }

    public function delete(int $id): bool
    {
        $model = PageModel::find($id);
        if ($model === null) {
            return false;
        }

        return $model->delete();
    }

    /**
     * 分页查询返回 PagePaginator
     */
    public function paginateToPaginator(?int $status = null, int $page = 1, int $pageSize = 10): PagePaginator
    {
        $paginator = $this->paginate($status, $page, $pageSize);

        $items = [];
        foreach ($paginator->items() as $model) {
            $items[] = PageFactory::fromModel($model);
        }

        return new PagePaginator([
            'data' => $items,
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'last_page' => $paginator->lastPage(),
        ]);
    }
}
