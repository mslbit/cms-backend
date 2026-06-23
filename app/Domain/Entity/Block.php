<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\DataObject;
use App\Domain\ValueObject\PublishStatus;
use Maiscraft\GraphQL\Annotation\Field;

/**
 * Block 实体
 * 站点级内容区块实例，如 header/footer/sidebar 等
 * content 存储 TipTap 格式数据
 */
class Block extends DataObject
{
    public function getSlug(): string
    {
        return $this->data['slug'] ?? '';
    }

    public function getType(): string
    {
        return $this->data['type'] ?? '';
    }

    #[Field(type: 'JSON')]
    public function getContent(): array
    {
        return $this->data['content'] ?? [];
    }

    public function getPosition(): ?string
    {
        return $this->data['position'] ?? null;
    }

    public function getStatus(): PublishStatus
    {
        $raw = $this->data['status'] ?? 0;
        if ($raw instanceof PublishStatus) {
            return $raw;
        }
        return PublishStatus::fromInt((int) $raw);
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

    public function isPublished(): bool
    {
        return $this->getStatus() === PublishStatus::PUBLISHED;
    }
}
