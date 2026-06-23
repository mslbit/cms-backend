<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Page 模型
 * 纯数据库映射，不包含业务逻辑
 */
class PageModel extends Model
{
    protected ?string $table = 'pages';

    protected array $fillable = [
        'title',
        'slug',
        'status',
        'description',
        'sections',
        'metadata',
        'theme',
        'layout',
    ];

    protected array $casts = [
        'sections' => 'array',
        'metadata' => 'array',
        'theme' => 'array',
        'layout' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
