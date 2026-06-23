<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Maiscraft\GraphQL\Annotation\Type;

/**
 * 发布状态枚举
 * pages 和 blocks 共用
 * GraphQL 输入输出使用枚举名（DRAFT/PUBLISHED/ARCHIVED）
 * 数据库存储为 smallint（0/1/2），通过 toInt/fromInt 转换
 */
#[Type(description: '发布状态')]
enum PublishStatus
{
    case DRAFT;
    case PUBLISHED;
    case ARCHIVED;

    /**
     * 从数据库整数值创建枚举
     */
    public static function fromInt(int $value): self
    {
        return match ($value) {
            1 => self::PUBLISHED,
            2 => self::ARCHIVED,
            default => self::DRAFT,
        };
    }

    /**
     * 转为数据库存储值
     */
    public function toInt(): int
    {
        return match ($this) {
            self::DRAFT => 0,
            self::PUBLISHED => 1,
            self::ARCHIVED => 2,
        };
    }

    /**
     * 获取中文标签
     */
    public function label(): string
    {
        return match ($this) {
            self::DRAFT => '草稿',
            self::PUBLISHED => '已发布',
            self::ARCHIVED => '已归档',
        };
    }
}
