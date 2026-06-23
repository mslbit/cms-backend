<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\Page;
use App\Domain\ValueObject\PageMetadata;
use App\Domain\ValueObject\PublishStatus;
use App\Domain\ValueObject\Section;
use App\DTO\CreatePageDTO;
use App\DTO\UpdatePageDTO;
use App\Model\PageModel;

/**
 * Page 实体工厂
 * 负责从不同来源创建 Page 实体
 */
class PageFactory
{
    /**
     * 从 Model 创建 Entity
     */
    public static function fromModel(PageModel $model): Page
    {
        $metadata = [];
        if (!empty($model->metadata)) {
            $metadata = PageMetadata::fromArray($model->metadata);
        }

        return new Page([
            'id' => $model->id,
            'title' => $model->title,
            'slug' => $model->slug,
            'status' => $model->status,
            'description' => $model->description,
            'sections' => $model->sections ?? [],
            'metadata' => $metadata,
            'theme' => $model->theme,
            'layout' => $model->layout,
            'created_at' => $model->created_at?->toDateTimeString(),
            'updated_at' => $model->updated_at?->toDateTimeString(),

        ]);
    }

    /**
     * 从创建 DTO 创建 Entity
     */
    public static function fromInput(CreatePageDTO $input): Page
    {
        return new Page([
            'title' => $input->title,
            'slug' => $input->slug,
            'status' => PublishStatus::DRAFT,
            'description' => $input->description,
            'sections' => $input->sections,
            'metadata' => $input->metadata,
            'theme' => $input->theme,
            'layout' => $input->layout,
        ]);
    }

    /**
     * 将更新 DTO 合并到已有 Entity
     */
    public static function mergeInput(Page $page, UpdatePageDTO $input): Page
    {
        if ($input->title !== null) {
            $page->setData('title', $input->title);
        }
        if ($input->slug !== null) {
            $page->setData('slug', $input->slug);
        }
        if ($input->description !== null) {
            $page->setData('description', $input->description);
        }
        if ($input->status !== null) {
            $page->setStatus($input->status);
        }
        if ($input->sections !== null) {
            $page->setData('sections', $input->sections);
        }
        if ($input->metadata !== null) {
            $page->setData('metadata', $input->metadata);
        }
        if ($input->theme !== null) {
            $page->setData('theme', $input->theme);
        }
        if ($input->layout !== null) {
            $page->setData('layout', $input->layout);
        }

        return $page;
    }

    /**
     * 从数组创建 Entity
     */
    public static function fromArray(array $data): Page
    {
        $metadata = null;
        if (!empty($data['metadata'])) {
            $metadata = is_array($data['metadata'])
                ? PageMetadata::fromArray($data['metadata'])
                : $data['metadata'];
        }

        return new Page([
            'id' => $data['id'] ?? null,
            'title' => $data['title'] ?? '',
            'slug' => $data['slug'] ?? '',
            'status' => $data['status'] ?? PublishStatus::DRAFT,
            'description' => $data['description'] ?? null,
            'sections' => $data['sections'] ?? [],
            'metadata' => $metadata,
            'theme' => $data['theme'] ?? null,
            'layout' => $data['layout'] ?? null,
            'created_at' => $data['created_at'] ?? null,
            'updated_at' => $data['updated_at'] ?? null,

        ]);
    }

    /**
     * Entity 转为 Model 持久化数据
     */
    public static function toModelData(Page $page): array
    {
        $metadata = $page->getMetadata();

        return [
            'title' => $page->getTitle(),
            'slug' => $page->getSlug(),
            'status' => $page->getStatus()->toInt(),
            'description' => $page->getDescription(),
            'sections' => $page->getSections(),
            'metadata' => $metadata instanceof PageMetadata ? $metadata->toArray() : $metadata,
            'theme' => $page->getTheme(),
            'layout' => $page->getLayout(),
        ];
    }
}