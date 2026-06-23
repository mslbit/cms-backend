<?php

declare(strict_types=1);

use App\Interface\PageRepositoryInterface;
use App\Interface\BlockRepositoryInterface;
use App\Repository\PageRepository;
use App\Repository\BlockRepository;

return [
    // 仓储接口绑定
    PageRepositoryInterface::class => PageRepository::class,
    BlockRepositoryInterface::class => BlockRepository::class,
];