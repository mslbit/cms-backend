<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreatePageDTO;
use App\DTO\UpdatePageDTO;
use App\Interface\PageRepositoryInterface;
use App\Constants\ErrorCode;
use App\Domain\Entity\Page;
use App\Exception\BusinessException;
use Hyperf\Contract\LengthAwarePaginatorInterface;

class PageService
{
    public function __construct(
        private readonly PageRepositoryInterface $pageRepository
    ) {
    }

    public function getPageById(int $id): ?Page
    {
        return $this->pageRepository->findById($id);
    }

    public function getPageBySlug(string $slug): ?Page
    {
        return $this->pageRepository->findBySlug($slug);
    }

    public function getPages(?string $status = null, int $page = 1, int $pageSize = 10): LengthAwarePaginatorInterface
    {
        return $this->pageRepository->paginate($status, $page, $pageSize);
    }

    public function createPage(CreatePageDTO $dto): Page
    {
        $existing = $this->pageRepository->findBySlug($dto->slug);
        if ($existing !== null) {
            throw new BusinessException(ErrorCode::PAGE_SLUG_EXISTS);
        }

        $page = new Page(
            $dto->title,
            $dto->slug,
            Page::STATUS_DRAFT,
            $dto->description,
            $dto->sections,
            $dto->metadata,
            $dto->theme,
            $dto->layout
        );

        return $this->pageRepository->save($page);
    }

    public function updatePage(int $id, UpdatePageDTO $dto): ?Page
    {
        $page = $this->pageRepository->findById($id);

        if ($page === null) {
            return null;
        }

        if ($dto->slug !== null && $dto->slug !== $page->getSlug()) {
            $existing = $this->pageRepository->findBySlug($dto->slug);
            if ($existing !== null && $existing->getId() !== $id) {
                throw new BusinessException(ErrorCode::PAGE_SLUG_EXISTS);
            }
            $page->setSlug($dto->slug);
        }

        if ($dto->title !== null) {
            $page->setTitle($dto->title);
        }

        if ($dto->description !== null) {
            $page->setDescription($dto->description);
        }

        if ($dto->status !== null) {
            $page->setStatus($dto->status);
        }

        if ($dto->sections !== null) {
            $page->setSections($dto->sections);
        }

        if ($dto->metadata !== null) {
            $page->setMetadata($dto->metadata);
        }

        if ($dto->theme !== null) {
            $page->setTheme($dto->theme);
        }

        if ($dto->layout !== null) {
            $page->setLayout($dto->layout);
        }

        return $this->pageRepository->save($page);
    }

    public function deletePage(int $id): bool
    {
        $page = $this->pageRepository->findById($id);

        if ($page === null) {
            return false;
        }

        return $this->pageRepository->delete($id);
    }
}
