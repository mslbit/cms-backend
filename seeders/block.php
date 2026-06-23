<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

/**
 * Blocks 数据填充
 * cms_blocks 表：站点级内容区块实例（header/footer/sidebar 等）
 * content 使用 TipTap 文档格式（type/attrs/content）
 * status: 0=草稿, 1=已发布, 2=已归档（对应 PublishStatus 枚举）
 *
 * 注意：所有数组字段（navItems, serviceItems 等）都是原生数组，不使用 json_encode
 * 整个 content 字段由 Eloquent 的 JSON cast 一次性序列化
 */
class Block extends Seeder
{
    public function run()
    {
     

        $blocks = [
            [
                'slug' => 'header',
                'type' => 'headerSection',
                'content' => [
                    'brand' => '匠心·迈斯联',
                    'brandIcon' => '匠',
                    'navItems' => [
                        ['id' => 'services', 'label' => '服务', 'to' => '/#services'],
                        ['id' => 'process', 'label' => '合作', 'to' => '/#process'],
                        ['id' => 'about', 'label' => '关于', 'to' => '/#about'],
                        ['id' => 'portfolio', 'label' => '案例', 'to' => '/#portfolio'],
                        ['id' => 'contact', 'label' => '优势', 'slot' => 'contact-btn'],
                    ],
                ],
                'position' => 'header',
                'status' => 1,
            ],
            [
                'slug' => 'footer',
                'type' => 'footerSection',
                'content' => [
                    'brand' => '匠心·迈斯联',
                    'brandIcon' => '匠',
                    'tagline' => '跨境电商插件与主题专家 · 值得信赖的技术伙伴',
                    'navItems' => [
                        ['id' => 'services', 'label' => '服务', 'to' => '/#services'],
                        ['id' => 'painpoints', 'label' => '优势', 'to' => '/#painpoints'],
                        ['id' => 'process', 'label' => '合作', 'to' => '/#process'],
                        ['id' => 'about', 'label' => '关于', 'to' => '/#about'],
                        ['id' => 'portfolio', 'label' => '案例', 'to' => '/#portfolio'],
                        ['id' => 'contact', 'label' => '联系', 'to' => '/#contact'],
                    ],
                    'serviceItems' => [
                        ['label' => '插件开发', 'href' => '/#services'],
                        ['label' => '主题定制', 'href' => '/#services'],
                        ['label' => '整站搭建', 'href' => '/#services'],
                        ['label' => '性能优化', 'href' => '/#services'],
                    ],
                    'copyright' => '© ' . date('Y') . ' 匠心·迈斯联. All Rights Reserved.',
                    'motto' => '以匠心致初心，以代码筑梦想',
                ],
                'status' => 1,
            ],
        ];

        foreach ($blocks as $b) {
            \App\Model\BlockModel::create($b);
            echo "Inserted block: {$b['slug']}" . PHP_EOL;
        }
    }
}
