<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\DataObject;

class PageMetadata extends DataObject
{
    public function getSeo(): ?SeoMetadata
    {
        return $this->data['seo'] ?? null;
    }

    public function getLayout(): string
    {
        return $this->data['layout'] ?? 'default';
    }

    public function setSeo(?SeoMetadata $seo): void
    {
        $this->data['seo'] = $seo;
    }

    public function setLayout(string $layout): void
    {
        $this->data['layout'] = $layout;
    }

    public static function fromArray(array $data): static
    {
        $seo = isset($data['seo']) ? SeoMetadata::fromArray($data['seo']) : null;
        return new static([
            'seo' => $seo,
            'layout' => $data['layout'] ?? 'default',
        ]);
    }
}
