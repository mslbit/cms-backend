<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

/**
 * Pages 数据填充
 * cms_pages 表：页面内容（home, logistics-woocommerce-plugin 等）
 * sections 使用 TipTap 文档格式（type/attrs/content）
 * status: 0=草稿, 1=已发布, 2=已归档（对应 PublishStatus 枚举）
 *
 * 注意：所有数组字段（navItems, items, tags 等）都是原生数组，不使用 json_encode
 * 整个 sections 字段由 Eloquent 的 JSON cast 一次性序列化
 */
class Page extends Seeder
{
    public function run()
    {
        //\App\Model\PageModel::query()->delete();

        $pages = [
            [
                'title' => '首页',
                'slug' => 'home',
                'status' => 1,
                'description' => '跨境电商技术专家，专注插件与主题开发',
                'sections' => $this->getHomeSections(),
                'metadata' => [
                    'seo' => [
                        'title' => '跨境电商技术专家 | 插件·主题·定制开发',
                        'description' => '专注跨境电商平台插件与主题开发，覆盖Shopify、Magento、WooCommerce、WordPress',
                        'keywords' => '跨境电商,Shopify插件,Magento主题,WooCommerce开发,WordPress定制',
                    ],
                    'layout' => 'default',
                ],
            ],
            [
                'title' => '物流 WooCommerce 插件',
                'slug' => 'logistics-woocommerce-plugin',
                'status' => 1,
                'description' => '物流企业专属定制，让 WooCommerce 订单和运单自动跑起来',
                'sections' => $this->getLogisticsPluginSections(),
                'metadata' => [
                    'seo' => [
                        'title' => '物流 WooCommerce 插件 | MaisCraft',
                        'description' => '物流企业专属定制，让 WooCommerce 订单和运单自动跑起来',
                    ],
                    'layout' => 'default',
                ],
            ],
            [
                'title' => 'Magento 游戏充值卡商城',
                'slug' => 'magento-game-card',
                'status' => 1,
                'description' => '基于 Magento 2 的数字商品电商平台，即买即充',
                'sections' => $this->getMagentoGameCardSections(),
                'metadata' => [
                    'seo' => [
                        'title' => 'Magento 游戏充值卡商城 | MaisCraft',
                        'description' => '基于 Magento 2 的数字商品电商平台，即买即充',
                    ],
                    'layout' => 'default',
                ],
            ],
            [
                'title' => 'WordPress 跨境电商方案',
                'slug' => 'wordpress-ecommerce',
                'status' => 1,
                'description' => '想用 WordPress 做跨境电商，但不知道从哪下手？',
                'sections' => $this->getWordPressEcommerceSections(),
                'metadata' => [
                    'seo' => [
                        'title' => 'WordPress 跨境电商方案 | MaisCraft',
                        'description' => '想用 WordPress 做跨境电商，但不知道从哪下手？',
                    ],
                    'layout' => 'default',
                ],
            ],
        ];

        foreach ($pages as $p) {
            \App\Model\PageModel::create($p);
            echo "Inserted page: {$p['slug']}" . PHP_EOL;
        }
    }

    private function getHomeSections(): array
    {
        return [
            [
                'type' => 'heroBanner',
                'attrs' => [
                    'title' => '跨境电商技术专家',
                    'desc' => '从 WooCommerce、Magento、Shopify 到 WordPress，专注跨境电商平台插件与主题开发，让您的独立站有技可依',
                    'position' => 'hero',
                    'subtitle' => '插件 · 主题 · 定制开发',
                ],
                'content' => [
                    ['type' => 'slot', 'attrs' => ['name' => 'cta', 'layout' => 'row'], 'content' => [
                        ['type' => 'uButton', 'attrs' => ['label' => '聊聊您的项目', 'to' => '/#contact', 'size' => 'xl', 'color' => 'accent', 'variant' => 'solid']],
                        ['type' => 'uButton', 'attrs' => ['label' => '先看看案例', 'to' => '/#portfolio', 'size' => 'xl', 'color' => 'neutral', 'variant' => 'outline']],
                    ]],
                    ['type' => 'slot', 'attrs' => ['name' => 'platforms', 'layout' => 'row'], 'content' => [
                        ['type' => 'uBadge', 'attrs' => ['label' => 'Shopify', 'variant' => 'subtle']],
                        ['type' => 'uBadge', 'attrs' => ['label' => 'Magento', 'variant' => 'subtle']],
                        ['type' => 'uBadge', 'attrs' => ['label' => 'WooCommerce', 'variant' => 'subtle']],
                        ['type' => 'uBadge', 'attrs' => ['label' => 'WordPress', 'variant' => 'subtle']],
                    ]],
                    ['type' => 'slot', 'attrs' => ['name' => 'seal'], 'content' => [['type' => 'sealStamp']]],
                ],
            ],
            [
                'type' => 'servicesSection',
                'attrs' => ['title' => '我们能做什么', 'desc' => '专注跨境电商平台插件与主题开发，让您的独立站功能更强、体验更好', 'position' => 'services'],
                'content' => [
                    ['type' => 'slot', 'attrs' => ['name' => 'cards', 'layout' => 'row', 'class' => 'grid sm:grid-cols-2 lg:grid-cols-4 gap-6'], 'content' => [
                        ['type' => 'serviceCard', 'attrs' => ['title' => 'Magento', 'desc' => '企业级电商首选，支持百万级 SKU 与高并发场景', 'icon' => 'i-lucide-hexagon', 'badge' => 'Enterprise', 'items' => ['自定义模块开发', '性能优化与缓存策略', '多店铺/多语言方案', '支付与物流集成'], 'tags' => ['模块开发', '整站搭建', '性能优化']]],
                        ['type' => 'serviceCard', 'attrs' => ['title' => 'WooCommerce', 'desc' => 'WordPress 生态最灵活的电商方案，快速上线低成本运营', 'icon' => 'i-lucide-circle-dot', 'badge' => 'Flexible', 'items' => ['主题深度定制', '插件功能扩展', '订阅与会员系统', 'SEO 与转化优化'], 'tags' => ['插件开发', '主题定制', '整站搭建']]],
                        ['type' => 'serviceCard', 'attrs' => ['title' => 'WordPress', 'desc' => '全球占有率最高的 CMS，内容与商业一体化解决方案', 'icon' => 'i-lucide-square-code', 'badge' => 'Popular', 'items' => ['企业官网开发', '主题与区块编辑器', 'API 对接与数据迁移', '安全加固与维护'], 'tags' => ['主题定制', '插件开发', '安全加固']]],
                        ['type' => 'serviceCard', 'attrs' => ['title' => 'Shopify', 'desc' => '开箱即用的 SaaS 电商，专注品牌增长与用户体验', 'icon' => 'i-lucide-shopping-bag', 'badge' => 'Growth', 'items' => ['Liquid 主题开发', 'App 功能定制', '店铺迁移与升级', '转化率提升方案'], 'tags' => ['主题定制', 'App开发', '店铺迁移']]],
                    ]],
                ],
            ],
            [
                'type' => 'painPointsSection',
                'attrs' => ['title' => '懂电商，更懂你的痛点', 'desc' => '我们不只是写代码——我们理解跨境卖家的每一个焦虑', 'position' => 'painpoints'],
                'content' => [
                    ['type' => 'slot', 'attrs' => ['name' => 'cards', 'layout' => 'row'], 'content' => [
                        ['type' => 'painPointCard', 'attrs' => ['title' => '插件冲突，功能受限', 'desc' => '现成插件无法满足业务逻辑，二次开发成本高、周期长', 'icon' => 'i-lucide-wrench']],
                        ['type' => 'painPointCard', 'attrs' => ['title' => '主题千篇一律', 'desc' => '品牌辨识度低，用户跳出率高，转化始终上不去', 'icon' => 'i-lucide-palette']],
                        ['type' => 'painPointCard', 'attrs' => ['title' => '性能瓶颈', 'desc' => '页面加载慢、大促崩溃，流量来了接不住', 'icon' => 'i-lucide-zap']],
                        ['type' => 'painPointCard', 'attrs' => ['title' => '多市场适配难', 'desc' => '多语言、多币种、多仓发货，技术方案碎片化', 'icon' => 'i-lucide-globe']],
                        ['type' => 'painPointCard', 'attrs' => ['title' => '安全与合规', 'desc' => '支付安全、数据隐私、GDPR合规，稍有不慎就是灾难', 'icon' => 'i-lucide-shield']],
                        ['type' => 'painPointCard', 'attrs' => ['title' => '上线周期不可控', 'desc' => '需求反复、沟通低效，项目一拖再拖', 'icon' => 'i-lucide-rocket']],
                    ]],
                ],
            ],
            [
                'type' => 'processSection',
                'attrs' => ['title' => '合作方式', 'desc' => '每一步你都清楚进度', 'position' => 'process'],
                'content' => [
                    ['type' => 'slot', 'attrs' => ['name' => 'steps'], 'content' => [
                        ['type' => 'processStep', 'attrs' => ['title' => '聊聊你的想法', 'desc' => '通过表单或邮件告诉我你的项目构想、预算和预期时间。我通常在半天内回复，给出初步评估和建议。', 'index' => 0]],
                        ['type' => 'processStep', 'attrs' => ['title' => '方案与报价', 'desc' => '根据你的需求，我出一份技术方案和分阶段报价。没有隐藏费用，不满意随时可以调整或终止。', 'index' => 1, 'items' => ['技术方案', '分阶段报价', '项目排期']]],
                        ['type' => 'processStep', 'attrs' => ['title' => '开发与交付', 'desc' => '确认方案后进入开发，每周同步进度和演示。你可以随时看到项目最新状态，有问题当场就能聊。', 'index' => 2, 'items' => ['每周进度同步', '可预览的测试环境', '阶段验收']]],
                        ['type' => 'processStep', 'attrs' => ['title' => '上线与支持', 'desc' => '上线后提供30天免费维护，快速响应任何问题。后续可按需购买技术支持包，也可以培训你的团队自主运营。', 'index' => 3, 'items' => ['30天免费维护', '技术支持包', '团队培训']]],
                    ]],
                    ['type' => 'slot', 'attrs' => ['name' => 'note'], 'content' => [
                        ['type' => 'processNote', 'attrs' => ['desc' => '小项目一般1-2周搞定，大项目4-12周。不扯虚的，按节奏走，每周你都能看到东西在往前推。']],
                    ]],
                ],
            ],
            [
                'type' => 'aboutSection',
                'attrs' => ['title' => '关于我们', 'desc' => '深耕跨境电商技术，懂平台更懂业务', 'position' => 'about'],
                'content' => [
                    ['type' => 'slot', 'attrs' => ['name' => 'profile'], 'content' => [
                        ['type' => 'aboutProfile', 'attrs' => [
                            'title' => '跨境电商技术团队',
                            'desc' => '我们专注跨境电商平台的技术开发，从 WooCommerce 物流插件到 Magento 整站搭建，深入理解物流、支付、库存、多语言等跨境电商核心场景。不只是写代码——我们帮您找到最合适的技术方案，让独立站真正跑起来。',
                            'tagline' => '插件 · 主题 · 整站 · 远程协作',
                            'items' => [
                                ['title' => '核心平台', 'desc' => '4大电商平台'],
                                ['title' => '插件交付', 'desc' => '定制插件已上线'],
                                ['title' => '响应速度', 'desc' => '24小时内回复'],
                                ['title' => '工作模式', 'desc' => '远程高效协作'],
                            ],
                        ]],
                    ]],
                    ['type' => 'slot', 'attrs' => ['name' => 'skills'], 'content' => [
                        ['type' => 'aboutSkills', 'attrs' => [
                            'items' => [
                                ['title' => '电商平台', 'items' => ['Shopify', 'Magento 2', 'WooCommerce', 'WordPress', 'Shopify Plus']],
                                ['title' => '插件 & 主题', 'items' => ['Liquid', 'PHP', 'Magento Module', 'WooCommerce Extension', 'WordPress Plugin']],
                                ['title' => '技术 & 运维', 'items' => ['MySQL', 'Redis', 'Elasticsearch', 'Docker', 'AWS', 'CI/CD', 'Nginx']],
                            ],
                            'tags' => [
                                ['title' => 'WooCommerce', 'desc' => '7年'],
                                ['title' => 'Magento', 'desc' => '6年'],
                                ['title' => 'Shopify', 'desc' => '5年'],
                                ['title' => 'WordPress', 'desc' => '8年'],
                            ],
                        ]],
                    ]],
                ],
            ],
            [
                'type' => 'portfolioSection',
                'attrs' => ['title' => '产品案例', 'desc' => '每个产品，解决一个真实场景', 'position' => 'portfolio'],
                'content' => [
                    ['type' => 'slot', 'attrs' => ['name' => 'cards', 'layout' => 'row'], 'content' => [
                        ['type' => 'portfolioCard', 'attrs' => ['title' => '物流 WooCommerce 插件', 'desc' => '物流企业专属定制，让 WooCommerce 订单和运单自动跑起来', 'url' => '/logistics-woocommerce-plugin', 'tags' => ['插件开发', 'WooCommerce'], 'price' => '¥8,000 起']],
                        ['type' => 'portfolioCard', 'attrs' => ['title' => 'Magento 游戏充值卡商城', 'desc' => '基于 Magento 2 的数字商品电商平台，即买即充', 'url' => '/magento-game-card', 'tags' => ['整站搭建', 'Magento'], 'price' => '¥15,000 起']],
                        ['type' => 'portfolioCard', 'attrs' => ['title' => 'WordPress 跨境电商方案', 'desc' => '想用 WordPress 做跨境电商，但不知道从哪下手？', 'url' => '/wordpress-ecommerce', 'tags' => ['整站搭建', 'WordPress'], 'price' => '¥5,000 起']],
                    ]],
                ],
            ],
            [
                'type' => 'contactSection',
                'attrs' => [
                    'title' => [
                        ['type' => 'text', 'text' => '准备好让你的店铺'],
                        ['type' => 'text', 'marks' => [['type' => 'textStyle', 'attrs' => ['color' => '#B8860B']]], 'text' => '起飞'],
                        ['type' => 'text', 'text' => '了吗？'],
                    ],
                    'desc' => '告诉我们你的需求，我发相关案例和方案给你参考，无任何隐藏费用。',
                    'position' => 'contact',
                ],
                'content' => [
                    ['type' => 'slot', 'attrs' => ['name' => 'info'], 'content' => [
                        ['type' => 'contactInfo', 'attrs' => [
                            'title' => '不确定要做什么？没关系',
                            'desc' => '很多客户找到我们的时候，想法还不成熟，这太正常了。你不需要准备好所有东西才能来聊——把大概方向说一下，我们帮你理一理，看看哪些能做、哪些可以先放一放。',
                            'items' => [
                                ['title' => '不收费', 'desc' => '初次沟通、需求分析、初步评估全部免费'],
                                ['title' => '回复快', 'desc' => '一般半天内回复，忙的时候最迟一天'],
                                ['title' => '不绑定', 'desc' => '聊完觉得不合适完全没关系，没有任何压力'],
                            ],
                            'tags' => [
                                ['title' => 'Email', 'desc' => 'hello@maiscraft.dev', 'url' => 'mailto:hello@maiscraft.dev'],
                                ['title' => 'WeChat', 'desc' => 'maiscraft_dev', 'url' => '#'],
                            ],
                        ]],
                    ]],
                    ['type' => 'slot', 'attrs' => ['name' => 'form'], 'content' => [
                        ['type' => 'contactForm', 'attrs' => [
                            'title' => '留个邮箱，我发案例给你看',
                            'desc' => '填多填少都行，我会根据你的情况挑最相关的案例发过去。',
                            'items' => [
                                ['title' => '定制插件开发'],
                                ['title' => '主题定制'],
                                ['title' => '整站搭建'],
                                ['title' => '性能优化'],
                                ['title' => '还没想好，先聊聊'],
                            ],
                        ]],
                    ]],
                ],
            ],
        ];
    }

    private function getLogisticsPluginSections(): array
    {
        return [
            ['type' => 'landingHero', 'attrs' => ['title' => '物流 WooCommerce 插件', 'desc' => '物流企业用 WooCommerce 管理订单，但运单生成、物流追踪、状态回传全靠手动操作。客服天天复制粘贴单号，客户查物流要打电话问，效率低还容易出错。', 'position' => 'hero', 'category' => '插件开发 · WooCommerce', 'price' => '¥8,000 起', 'priceLabel' => '定制开发', 'priceNote' => '根据物流接口数量和功能复杂度定价，先出方案后报价', 'ctaPrimary' => '聊聊我的物流对接需求', 'ctaSecondary' => '看看插件演示']],
            ['type' => 'landingSolution', 'attrs' => ['title' => '我怎么帮你解决', 'desc' => '为物流企业定制开发的 WooCommerce 插件，实现订单自动生成运单、物流状态实时追踪、异常件自动告警。客服不用再手动操作，客户自助查件，双方都省心。', 'position' => 'solution', 'items' => ['WooCommerce 物流插件定制开发', '运单自动生成与批量打印', '物流状态实时追踪与同步', '异常件自动告警（邮件/短信）', '客户自助查件页面', '后台操作培训与文档'], 'tags' => ['WooCommerce', 'WordPress', 'PHP', 'REST API', 'MySQL', 'Redis']]],
            ['type' => 'landingFaq', 'attrs' => ['title' => '你可能想问的', 'position' => 'faq', 'items' => [['q' => '支持哪些物流公司？', 'a' => '插件架构做了适配层设计，主流物流（顺丰、中通、圆通、韵达等）均可对接。如果有自有物流系统，也可以通过 API 直连。'], ['q' => '和现有 WooCommerce 订单系统冲突吗？', 'a' => '不会。插件遵循 WooCommerce 标准扩展规范，不修改核心代码，和现有主题及其他插件兼容。'], ['q' => '后续物流接口变了怎么办？', 'a' => '接口层独立维护，物流公司接口变更只需更新适配器，不影响业务逻辑。也可以购买技术支持包，由我们维护。']]]],
            ['type' => 'landingAction', 'attrs' => ['title' => '聊聊我的物流对接需求', 'desc' => '留下你的邮箱和项目简述，我会在半天内回复你具体的方案和报价。', 'position' => 'action']],
        ];
    }

    private function getMagentoGameCardSections(): array
    {
        return [
            ['type' => 'landingHero', 'attrs' => ['title' => 'Magento 游戏充值卡商城', 'desc' => '游戏充值卡属于虚拟商品，传统电商平台的实物发货流程完全不适用。需要即时发卡、库存实时扣减、多面值规格管理——这些 Magento 原生都不支持。', 'position' => 'hero', 'category' => '整站搭建 · Magento', 'price' => '¥15,000 起', 'priceLabel' => '整站方案', 'priceNote' => '根据游戏数量和风控需求定价，含完整培训', 'ctaPrimary' => '聊聊虚拟商品商城需求', 'ctaSecondary' => '看看系统演示']],
            ['type' => 'landingSolution', 'attrs' => ['title' => '我怎么帮你解决', 'desc' => '基于 Magento 2 搭建的数字商品商城，定制开发虚拟商品即时发卡系统，支持多游戏、多面值、批量导入卡密，客户下单后秒收卡密。内置风控策略防止恶意刷单。', 'position' => 'solution', 'items' => ['Magento 2 整站搭建与配置', '虚拟商品即时发卡系统', '多游戏/多面值规格管理', '卡密批量导入与库存管理', '风控策略（频率限制/异常检测）', '支付网关对接'], 'tags' => ['Magento 2', 'PHP', 'MySQL', 'Redis', 'Elasticsearch', 'RabbitMQ']]],
            ['type' => 'landingFaq', 'attrs' => ['title' => '你可能想问的', 'position' => 'faq', 'items' => [['q' => '支持哪些支付方式？', 'a' => '支持支付宝、微信支付、PayPal、Stripe 等主流支付网关。也可以根据需求对接本地支付渠道。'], ['q' => '卡密安全怎么保障？', 'a' => '卡密加密存储，发货后自动标记已售。内置风控系统可配置购买频率、单日限额、异常 IP 检测等策略。'], ['q' => '后续想加新游戏怎么办？', 'a' => '后台有游戏和面值管理模块，添加新游戏只需要配置规格和导入卡密，不需要改代码。']]]],
            ['type' => 'landingAction', 'attrs' => ['title' => '聊聊虚拟商品商城需求', 'desc' => '留下你的邮箱和项目简述，我会在半天内回复你具体的方案和报价。', 'position' => 'action']],
        ];
    }

    private function getWordPressEcommerceSections(): array
    {
        return [
            ['type' => 'landingHero', 'attrs' => ['title' => 'WordPress 跨境电商方案', 'desc' => '看了很多建站教程，越看越晕。WooCommerce 插件装了十几个，页面还是乱糟糟的。支付不对、运费算不明白、结账流程太复杂客户直接跑了。', 'position' => 'hero', 'category' => '整站搭建 · WordPress', 'price' => '¥5,000 起', 'priceLabel' => '建站方案', 'priceNote' => '根据功能需求定价，含主题定制和完整培训', 'ctaPrimary' => '聊聊我想做什么', 'ctaSecondary' => '看看已上线的站点']],
            ['type' => 'landingSolution', 'attrs' => ['title' => '我怎么帮你解决', 'desc' => '我帮你从头搭建一套基于 WordPress + WooCommerce 的跨境电商网站，或者在现有站点上改造升级。不是那种套个主题就交差的，而是根据你的产品特点和目标市场，定制一个真正好用的在线商店。', 'position' => 'solution', 'items' => ['WooCommerce 完整搭建与配置', '主题定制（适配品牌调性）', '支付网关对接（Stripe / PayPal / 本地支付）', '运费计算规则配置', '结账流程优化（减少弃单率）', '基础 SEO 设置', '多语言/多币种配置（可选）', '后台操作培训（录屏 + 文档）'], 'tags' => ['WordPress', 'WooCommerce', 'PHP', 'Elementor', 'Stripe', 'PayPal', 'Yoast SEO']]],
            ['type' => 'landingFaq', 'attrs' => ['title' => '你可能想问的', 'position' => 'faq', 'items' => [['q' => 'WordPress 做电商靠谱吗？会不会很慢？', 'a' => '全球 30% 以上的电商网站用的就是 WooCommerce。性能和 Shopify 比确实需要多关注一些，但我会做好缓存、CDN、数据库优化，跑起来不比 Shopify 慢。而且最大的好处是完全自主可控，没有平台抽成。'], ['q' => '我自己能管理后台吗？', 'a' => '能。交付的时候我会录一套操作视频，教你怎么添加商品、处理订单、看数据报表。日常运营完全可以自己搞定，遇到技术问题再找我。'], ['q' => '后续想加功能怎么办？', 'a' => 'WordPress 生态最大的优势就是扩展性强。会员系统、订阅制、批发价、拼团……基本上你能想到的功能都有成熟方案。后续加功能可以买技术支持包，也可以让我来做定制开发。']]]],
            ['type' => 'landingAction', 'attrs' => ['title' => '聊聊我想做什么', 'desc' => '留下你的邮箱和项目简述，我会在半天内回复你具体的方案和报价。', 'position' => 'action']],
        ];
    }
}
