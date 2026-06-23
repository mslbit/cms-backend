<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

/**
 * 创建 cms_blocks 表
 * 存储站点级内容区块实例（header/footer/sidebar 等）
 * 与 pages 表分离，blocks 通过 position 字段关联到页面插槽位置
 */
class CreateBlocksTable extends Migration
{
    public string $description = 'Create blocks table for site-level content blocks';

    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();

            $table->string('slug', 255)->unique()->comment('唯一标识，如 header, footer, sidebar-promo');
            $table->string('type', 100)->comment('区块类型：layout, component, promo 等');
            $table->jsonb('content')->nullable()->comment('TipTap 格式的内容数据');
            $table->string('position', 100)->nullable()->comment('插槽位置：header, footer, sidebar, home-hero-after 等');
            $table->smallInteger('status')->default(0)->comment('0=draft, 1=published, 2=archived');

            $table->timestamps();

            $table->index('position');
            $table->index('status');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
}