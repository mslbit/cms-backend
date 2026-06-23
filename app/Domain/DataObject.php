<?php

declare(strict_types=1);

namespace App\Domain;
use Maiscraft\GraphQL\Annotation\Field;
/**
 * 数据对象基类
 * 提供魔法方法代理属性访问，统一数据容器
 * Entity 和 DTO 共用此基类
 */
class DataObject
{
    protected array $data = [];

    protected static string $globalIdType = '';

    public function __construct(#[Field(hidden: true)] array $data = [])
    {
        $this->data = $data;
    }

    #[Field(type: 'ID')]
    public function getId(): ?string
    {
        $id = $this->data['id'] ?? null;
        if ($id === null) {
            return null;
        }

        $type = static::$globalIdType ?: (new \ReflectionClass(static::class))->getShortName();
        return GlobalId::encode($type, $id);
    }

    public function getRawId(): ?int
    {
        return $this->data['id'] ?? null;
    }

    /**
     * 魔法方法：getter/setter 代理
     * getTitle() → getData('title')
     * setTitle('xxx') → setData('title', 'xxx')
     */
    public function __call(string $method, array $args)
    {
        $prefix = substr($method, 0, 3);
        $key = $this->camelToSnake(substr($method, 3));

        if ($prefix === 'get') {
            return $this->data[$key] ?? null;
        }

        if ($prefix === 'set' && count($args) === 1) {
            $this->data[$key] = $args[0];
            return $this;
        }

        if (str_starts_with($method, 'is') && strlen($method) > 2) {
            $boolKey = $this->camelToSnake(substr($method, 2));
            return (bool) ($this->data[$boolKey] ?? false);
        }

        if (str_starts_with($method, 'has') && strlen($method) > 3) {
            $hasKey = $this->camelToSnake(substr($method, 3));
            return isset($this->data[$hasKey]);
        }

        if (str_starts_with($method, 'uns') && strlen($method) > 3) {
            $unsKey = $this->camelToSnake(substr($method, 3));
            unset($this->data[$unsKey]);
            return $this;
        }

        throw new \BadMethodCallException(
            sprintf('Method %s does not exist on %s', $method, static::class)
        );
    }

    public function __get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function __unset(string $key): void
    {
        unset($this->data[$key]);
    }

    /**
     * 获取数据
     */
    #[Field(hidden:true)]
    public function getData(?string $key = null): mixed
    {
        if ($key === null) {
            return $this->data;
        }
        return $this->data[$key] ?? null;
    }

    /**
     * 设置数据
     */
      #[Field(hidden:true)]
    public function setData(string $key, mixed $value): static
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * 批量设置数据
     */
    public function addData(array $data): static
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
     * 检查数据是否存在
     */
    public function hasData(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * 移除数据
     */
    public function unsetData(?string $key = null): static
    {
        if ($key === null) {
            $this->data = [];
        } else {
            unset($this->data[$key]);
        }
        return $this;
    }

    /**
     * 转换为数组
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            if ($value instanceof DataObject) {
                $result[$key] = $value->toArray();
            } elseif (is_array($value)) {
                $result[$key] = array_map(
                    fn($item) => $item instanceof DataObject ? $item->toArray() : $item,
                    $value
                );
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * 从数组创建
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /**
     * camelCase 转 snake_case
     */
    protected function camelToSnake(string $input): string
    {
        return strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($input)));
    }
}