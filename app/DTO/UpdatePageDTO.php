<?php

declare(strict_types=1);

namespace App\DTO;

use App\Domain\ValueObject\PageMetadata;
use App\Domain\ValueObject\Section;

/**
 * 更新页面 DTO
 */
class UpdatePageDTO
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $slug = null,
        public readonly ?string $description = null,
        public readonly ?string $status = null,
        public readonly ?array $sections = null,
        public readonly ?PageMetadata $metadata = null,
        public readonly ?array $theme = null,
        public readonly ?array $layout = null
    ) {
    }

    /**
     * 从数组创建 DTO
     */
    public static function fromArray(array $data): self
    {
        $sections = null;
        if (isset($data['sections'])) {
            $sections = [];
            foreach ($data['sections'] as $sectionData) {
                $sections[] = Section::fromArray($sectionData);
            }
        }

        $metadata = null;
        if (isset($data['metadata'])) {
            $metadata = PageMetadata::fromArray($data['metadata']);
        }

        return new self(
            $data['title'] ?? null,
            $data['slug'] ?? null,
            $data['description'] ?? null,
            $data['status'] ?? null,
            $sections,
            $metadata,
            $data['theme'] ?? null,
            $data['layout'] ?? null
        );
    }

    /**
     * 检查是否有更新
     */
    public function hasUpdates(): bool
    {
        return $this->title !== null
            || $this->slug !== null
            || $this->description !== null
            || $this->status !== null
            || $this->sections !== null
            || $this->metadata !== null
            || $this->theme !== null
            || $this->layout !== null;
    }
}