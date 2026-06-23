<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\Domain\Entity\Page;
use App\Domain\Factory\PageFactory;
use App\Domain\GlobalId;
use App\DTO\CreatePageDTO;
use App\DTO\UpdatePageDTO;
use App\Interface\PageRepositoryInterface;
use Maiscraft\GraphQL\Annotation\Mutation;
use Maiscraft\GraphQL\Annotation\Arg;
use Maiscraft\GraphQL\Contract\ResolverInterface;

/**
 * Page Mutation Resolver
 * CRUD 操作，需要认证（由 buildResolver 自动检查 context['auth_user_id']）
 */
class PageMutationResolver implements ResolverInterface
{
    public function __construct(
        private PageRepositoryInterface $pageRepository
    ) {
    }

    #[Mutation(description: 'Create a new page')]
    public function createPage(CreatePageDTO $input): Page
    {
        $page = PageFactory::fromInput($input);
        return $this->pageRepository->save($page);
    }

    #[Mutation(description: 'Update an existing page')]
    public function updatePage(
        #[Arg(type: 'ID!')] string $id,
        UpdatePageDTO $input
    ): ?Page {
        $page = $this->pageRepository->findById((int) $id);
        if ($page === null) {
            return null;
        }

        PageFactory::mergeInput($page, $input);
        return $this->pageRepository->save($page);
    }

    #[Mutation(description: 'Delete a page')]
    public function deletePage(#[Arg(type: 'ID!')] string $id): bool
    {
        return $this->pageRepository->delete((int) $id);
    }
}