<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class RoleModel extends Model
{
    protected ?string $table = 'roles';

    protected array $fillable = [
        'name', 'label', 'description', 'status',
    ];

    protected array $casts = [
        'status' => 'integer',
    ];

    public function menus()
    {
        return $this->belongsToMany(MenuModel::class, 'role_menu', 'role_id', 'menu_id');
    }

    public function adminUsers()
    {
        return $this->belongsToMany(AdminUserModel::class, 'admin_user_roles', 'role_id', 'admin_user_id');
    }
}