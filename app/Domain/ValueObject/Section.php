<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\DataObject;
use Maiscraft\GraphQL\Annotation\Type;
use Maiscraft\GraphQL\Annotation\Field;

/**
 * 页面板块（TipTap 节点格式）
 * TipTap 结构: { type, attrs, content }
 * type 自由定义，前后端通过 tipTapComponentMap / tipTapToBlocks 映射
 * 新增组件只需：1.前端注册组件 2.前端加映射 3.后端存数据——无需改此文件
 */
#[Type(description: '页面板块（TipTap 节点格式）')]
class Section extends DataObject
{
    public function __construct(#[Field(hidden: true)] array $data = [])
    {
        parent::__construct($data);

        if (empty($data['type'])) {
            throw new \InvalidArgumentException('Section type cannot be empty');
        }
    }

    /**
     * TipTap 节点类型（camelCase，如 heroBanner/serviceCard/uButton）
     * 前端 tipTapComponentMap 负责映射到组件
     */
    public function getType(): string
    {
        return $this->data['type'] ?? '';
    }

    /**
     * TipTap attrs → Block 根级字段 + props
     * 前端提取 title/desc/position/visible 到根级，剩余到 props
     */
    #[Field(type: 'JSON')]
    public function getAttrs(): ?array
    {
        return $this->data['attrs'] ?? null;
    }

    /**
     * TipTap content → Block slots
     * slot 节点转为 BlockSlot，非 slot 节点递归转换
     */
    #[Field(type: 'JSON')]
    public function getContent(): ?array
    {
        return $this->data['content'] ?? null;
    }

    public static function fromArray(array $data): static
    {
        return new static([
            'type' => $data['type'],
            'attrs' => $data['attrs'] ?? null,
            'content' => $data['content'] ?? null,
        ]);
    }
}
