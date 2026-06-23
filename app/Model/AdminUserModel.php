<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class AdminUserModel extends Model
{
    protected ?string $table = 'admin_users';

    protected array $fillable = [
        'username', 'password', 'name', 'email', 'avatar', 'status', 'last_login_at',
    ];

    protected array $casts = [
        'status' => 'integer',
    ];

    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'admin_user_roles', 'admin_user_id', 'role_id');
    }

    public function menus(): array
    {
        $roles = $this->roles;
        $menuIds = [];
        foreach ($roles as $role) {
            foreach ($role->menus as $menu) {
                $menuIds[$menu->id] = true;
            }
        }
        return MenuModel::whereIn('id', array_keys($menuIds))
            ->where('status', 1)
            ->orderBy('sort')
            ->orderBy('id')
            ->get()
            ->all();
    }
}