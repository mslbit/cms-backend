<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateAdminTables extends Migration
{
    public string $description = 'Create RBAC tables: admin_users, roles, menus';

    public function up(): void
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->unique();
            $table->string('password', 255);
            $table->string('name', 100)->nullable()->comment('显示名');
            $table->string('email', 255)->nullable();
            $table->string('avatar', 500)->nullable();
            $table->smallInteger('status')->default(1)->comment('1=启用 0=禁用');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()->comment('角色标识');
            $table->string('label', 100)->nullable()->comment('角色显示名');
            $table->string('description', 255)->nullable();
            $table->smallInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('菜单标识');
            $table->string('label', 100)->comment('显示名');
            $table->string('icon', 100)->nullable()->comment('图标');
            $table->string('path', 255)->nullable()->comment('前端路由路径');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父菜单ID');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->smallInteger('status')->default(1)->comment('1=启用 0=禁用');
            $table->timestamps();

            $table->index('parent_id');
            $table->index('sort');
        });

        Schema::create('role_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_id');
            $table->timestamps();

            $table->unique(['role_id', 'menu_id']);
            $table->index('role_id');
            $table->index('menu_id');
        });

        Schema::create('admin_user_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_user_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->unique(['admin_user_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_user_roles');
        Schema::dropIfExists('role_menu');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('admin_users');
    }
}