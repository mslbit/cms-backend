<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class MenuModel extends Model
{
    protected ?string $table = 'menus';

    protected array $fillable = [
        'name', 'label', 'icon', 'path', 'parent_id', 'sort', 'status',
    ];

    protected array $casts = [
        'parent_id' => 'integer',
        'sort' => 'integer',
        'status' => 'integer',
    ];

    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'role_menu', 'menu_id', 'role_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id')
            ->where('status', 1)
            ->orderBy('sort')
            ->orderBy('id');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }
}