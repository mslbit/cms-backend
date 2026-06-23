<?php

declare(strict_types=1);

namespace App\DTO;

use App\Domain\ValueObject\PageMetadata;
use App\Domain\ValueObject\Section;

/**
 * 创建页面 DTO
 */
class CreatePageDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly ?string $description = null,
        public readonly array $sections = [],
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
        $sections = [];
        if (!empty($data['sections'])) {
            foreach ($data['sections'] as $sectionData) {
                $sections[] = Section::fromArray($sectionData);
            }
        }

        $metadata = null;
        if (!empty($data['metadata'])) {
            $metadata = PageMetadata::fromArray($data['metadata']);
        }

        return new self(
            $data['title'],
            $data['slug'],
            $data['description'] ?? null,
            $sections,
            $metadata,
            $data['theme'] ?? null,
            $data['layout'] ?? null
        );
    }
}