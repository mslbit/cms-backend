<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use App\Model\AdminUserModel;
use App\Model\RoleModel;
use App\Model\MenuModel;
use Hyperf\DbConnection\Db;

class Admin extends Seeder
{
    public function run()
    {
        $superAdmin = AdminUserModel::create([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'name' => '超级管理员',
            'status' => 1,
        ]);

        $adminRole = RoleModel::create([
            'name' => 'super_admin',
            'label' => '超级管理员',
            'description' => '拥有所有权限',
            'status' => 1,
        ]);

        $superAdmin->roles()->attach($adminRole->id);

        $menus = [
            ['name' => 'dashboard', 'label' => '仪表盘', 'icon' => 'i-lucide-home', 'path' => '/', 'parent_id' => 0, 'sort' => 0, 'status' => 1],
            ['name' => 'pages', 'label' => '页面管理', 'icon' => 'i-lucide-file-text', 'path' => '/pages', 'parent_id' => 0, 'sort' => 1, 'status' => 1],
            ['name' => 'blocks', 'label' => '区块管理', 'icon' => 'i-lucide-blocks', 'path' => '/blocks', 'parent_id' => 0, 'sort' => 2, 'status' => 1],
            ['name' => 'settings', 'label' => '系统设置', 'icon' => 'i-lucide-settings', 'path' => '/settings', 'parent_id' => 0, 'sort' => 3, 'status' => 1],
            ['name' => 'roles', 'label' => '角色管理', 'icon' => 'i-lucide-shield', 'path' => '/settings/roles', 'parent_id' => 0, 'sort' => 4, 'status' => 1],
            ['name' => 'admin_users', 'label' => '管理员', 'icon' => 'i-lucide-users', 'path' => '/settings/admin-users', 'parent_id' => 0, 'sort' => 5, 'status' => 1],
        ];

        foreach ($menus as $menu) {
            $menuModel = MenuModel::create($menu);
            $adminRole->menus()->attach($menuModel->id);
        }

        // Casbin RBAC 规则：g = 角色继承, p = 权限策略
        // g: 用户ID -> 角色名（grouping）
        Db::table('casbin_rule')->insert([
            ['ptype' => 'g', 'v0' => (string) $superAdmin->id, 'v1' => 'super_admin', 'v2' => null, 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'dashboard', 'v2' => 'read', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'pages', 'v2' => 'read', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'pages', 'v2' => 'write', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'blocks', 'v2' => 'read', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'blocks', 'v2' => 'write', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'settings', 'v2' => 'read', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'settings', 'v2' => 'write', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'roles', 'v2' => 'read', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'roles', 'v2' => 'write', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'admin_users', 'v2' => 'read', 'v3' => null, 'v4' => null, 'v5' => null],
            ['ptype' => 'p', 'v0' => 'super_admin', 'v1' => 'admin_users', 'v2' => 'write', 'v3' => null, 'v4' => null, 'v5' => null],
        ]);
    }
}
