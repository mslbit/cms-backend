<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\DataObject;
use App\Domain\ValueObject\PageMetadata;
use App\Domain\ValueObject\PublishStatus;
use Maiscraft\GraphQL\Annotation\Field;

/**
 * Page 实体
 * 领域模型 + GraphQL Output Type
 */
class Page extends DataObject
{
    public function getTitle(): string
    {
        return $this->data['title'] ?? '';
    }

    public function getSlug(): string
    {
        return $this->data['slug'] ?? '';
    }

    public function getStatus(): PublishStatus
    {
        $raw = $this->data['status'] ?? 0;
        if ($raw instanceof PublishStatus) {
            return $raw;
        }
        return PublishStatus::fromInt((int) $raw);
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    #[Field(type: 'JSON')]
    public function getSections(): array
    {
        return $this->data['sections'] ?? [];
    }

    public function getMetadata(): ?PageMetadata
    {
        return $this->data['metadata'] ?? null;
    }

    #[Field(type: 'JSON')]
    public function getTheme(): ?array
    {
        return $this->data['theme'] ?? null;
    }

    #[Field(type: 'JSON')]
    public function getLayout(): ?array
    {
        return $this->data['layout'] ?? null;
    }

    public function getCreatedAt(): ?string
    {
        return $this->data['created_at'] ?? null;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->data['updated_at'] ?? null;
    }

    public function setStatus(PublishStatus $status): void
    {
        $this->data['status'] = $status;
    }

    public function publish(): void
    {
        $this->data['status'] = PublishStatus::PUBLISHED;
    }

    public function archive(): void
    {
        $this->data['status'] = PublishStatus::ARCHIVED;
    }

    public function isPublished(): bool
    {
        return $this->getStatus() === PublishStatus::PUBLISHED;
    }
}
