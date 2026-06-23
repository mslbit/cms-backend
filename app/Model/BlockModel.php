<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Block 模型
 * 纯数据库映射，不包含业务逻辑
 */
class BlockModel extends Model
{
    protected ?string $table = 'blocks';

    protected array $fillable = [
        'slug',
        'type',
        'content',
        'position',
        'status',
    ];

    protected array $casts = [
        'content' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
