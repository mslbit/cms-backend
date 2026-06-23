<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * GraphQL 全局 ID 编解码
 * 编码格式：base64('Type:rawId')
 */
class GlobalId
{
    public static function encode(string $type, int|string $id): string
    {
        return base64_encode($type . ':' . $id);
    }

    public static function decode(string $globalId): ?array
    {
        $decoded = base64_decode($globalId, true);
        if ($decoded === false) {
            return null;
        }

        $parts = explode(':', $decoded, 2);
        if (count($parts) !== 2) {
            return null;
        }

        return ['type' => $parts[0], 'id' => $parts[1]];
    }

    public static function decodeId(string $globalId): ?int
    {
        $result = self::decode($globalId);
        return $result !== null ? (int) $result['id'] : null;
    }

    public static function decodeType(string $globalId): ?string
    {
        $result = self::decode($globalId);
        return $result['type'] ?? null;
    }
}