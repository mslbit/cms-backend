<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\DataObject;

class SeoMetadata extends DataObject
{
    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function getKeywords(): ?string
    {
        return $this->data['keywords'] ?? null;
    }

    public function setTitle(?string $title): void
    {
        $this->data['title'] = $title;
    }

    public function setDescription(?string $description): void
    {
        $this->data['description'] = $description;
    }

    public function setKeywords(?string $keywords): void
    {
        $this->data['keywords'] = $keywords;
    }
}
