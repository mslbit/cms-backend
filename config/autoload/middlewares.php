<?php

declare(strict_types=1);

use App\Middleware\CorsMiddleware;

/**
 * HTTP 全局中间件配置
 *
 * 仅保留 CORS 中间件，认证由 GraphQL 层按操作类型处理：
 * - Query（公开查询）：无需认证
 * - Mutation（CRUD）：需要认证
 */
return [
    'http' => [
        CorsMiddleware::class,
    ],
];
