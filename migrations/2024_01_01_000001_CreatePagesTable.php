<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreatePagesTable extends Migration
{
    /**
     * 迁移说明
     */
    public string $description = 'Create pages table for CMS';

    /**
     * 执行迁移
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            // 主键
            $table->id();

            // 基础字段
            $table->string('title', 255)->comment('Page title');
            $table->string('slug', 255)->unique()->comment('URL slug');
            $table->smallInteger('status')->default(0)->comment('0=draft, 1=published, 2=archived');
            $table->text('description')->nullable()->comment('Page description');

            // JSON 字段
            $table->jsonb('sections')->nullable()->comment('Page sections (blocks)');
            $table->jsonb('metadata')->nullable()->comment('SEO and other metadata');
            $table->jsonb('theme')->nullable()->comment('Theme configuration');
            $table->jsonb('layout')->nullable()->comment('Layout configuration');

            // 软删除和时间戳
            $table->softDeletes();
            $table->timestamps();

            // 索引
            $table->index('status');
            $table->index('slug');
        });
    }

    /**
     * 回滚迁移
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
}
