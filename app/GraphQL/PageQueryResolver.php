<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\Domain\Entity\Page;
use App\Domain\GlobalId;
use App\Domain\ValueObject\PublishStatus;
use App\Interface\PageRepositoryInterface;
use Maiscraft\GraphQL\Annotation\Query;
use Maiscraft\GraphQL\Annotation\Arg;
use Maiscraft\GraphQL\Contract\ResolverInterface;

/**
 * Page Query Resolver
 * 公开查询，无需认证
 */
class PageQueryResolver implements ResolverInterface
{
    public function __construct(
        private PageRepositoryInterface $pageRepository
    ) {
    }

    #[Query(description: 'Get a page by ID')]
    public function page(#[Arg(type: 'ID!')] string $id): ?Page
    {
        return $this->pageRepository->findById(GlobalId::decodeId($id) ?? 0);
    }

    #[Query(description: 'Get a page by slug')]
    public function pageBySlug(string $slug): ?Page
    {
        return $this->pageRepository->findBySlug($slug);
    }

    #[Query(description: 'Get paginated pages', type: 'PagePaginator')]
    public function pages(?PublishStatus $status = null, ?int $page = null, ?int $pageSize = null)
    {
        return $this->pageRepository->paginateToPaginator(
            $status?->toInt(),
            $page ?? 1,
            $pageSize ?? 10
        );
    }
}