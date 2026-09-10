# Wangzai Shopping 数字商品商店

基于 Laravel 10 + Livewire 3 + Blade 构建的数字商品商店，支持中英双语、微信/支付宝扫码支付凭证审核、完整订单状态流转。

## 技术栈

| 层 | 技术 |
|----|------|
| 后端 | PHP 8.3 + Laravel 10 + Livewire 3 |
| 前端 | Blade + Bootstrap 5 + jQuery + Swiper（纯服务端渲染，无 Vue/React） |
| 数据库 | MySQL 8 |
| 富文本 | Summernote |
| 图标 | Bootstrap Icons + Font Awesome |
| i18n | Laravel 官方本地化（`lang/zh.json`，默认中文） |

## 功能特性

### 用户端
- 商品浏览、搜索、分类筛选、限时抢购
- 商品详情 + 多订阅套餐选择
- 购物车、心愿单
- 收货信息填写（姓名、电话、详细地址、城市、邮编）
- **两种支付方式**：
  - **转账类**（银行/移动支付）：填写账号 + 交易流水号
  - **扫码类**（微信/支付宝）：展示收款二维码 → 用户上传付款截图 → 管理员审核
- 订单状态查询（个人中心 → 订单）
- 商品评价、个人资料、修改密码

### 管理端（`/admin/dashboard`）
- 商品管理：增删改查、多图、多订阅套餐、库存、限时抢购
- 分类管理、品牌管理
- **支付方式配置**：转账类（账号）+ 扫码类（二维码图片），可启用/禁用
- **支付凭证审核**：集中审核用户上传的付款截图，通过/驳回（附驳回原因）
- **订单管理**：查看收货信息、凭证图、统一状态流转
- 通用设置（站名/Logo/Favicon/地图/货币/政策条款）
- 关于设置、Meta 设置（SEO）
- 个人资料、密码、头像

### 订单状态流转

```
未付款 → 审核中 → 待发货 → 运输中 → 已到货
  ↓         ↓
(上传凭证) (驳回→重新上传)
```

| 状态 | 含义 | 触发 |
|------|------|------|
| 未付款 | 扫码类下单后未上传凭证 | 下单 |
| 审核中 | 凭证上传/转账下单，待管理员核实 | 上传凭证 / 转账下单 |
| 待发货 | 审核通过，等待发货 | 管理员审核通过 |
| 运输中 | 已发货 | 管理员点「确认发货」 |
| 已到货 | 确认送达 | 管理员点「确认到货」 |
| 已驳回 | 凭证审核未通过 | 管理员驳回，用户可重新上传 |

## 本地开发

### 环境要求
- PHP ≥ 8.3（扩展：pdo_mysql, xml, curl, mbstring, zip, gd）
- Composer
- MySQL ≥ 8.0
- Node.js（仅前端资源编译时需要）

### 步骤

```bash
git clone https://github.com/waylanguo-web/Wangzai_Shopping.git
cd Wangzai_Shopping
composer install
cp .env.example .env
php artisan key:generate
```

编辑 `.env` 配置数据库：
```env
DB_DATABASE=digital_shop
DB_USERNAME=root
DB_PASSWORD=你的密码
MAIL_MAILER=log    # 开发环境用 log，邮件写入 storage/logs/laravel.log
```

初始化数据：
```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder   # 创建管理员
php artisan storage:link                        # 创建图片软链接
php artisan serve
```

访问 `http://localhost:8000`，管理后台 `http://localhost:8000/admin/dashboard`。

### 默认管理员

| 字段 | 值 |
|------|-----|
| 邮箱 | `admin@example.com` |
| 密码 | `admin123` |

> ⚠️ 生产环境务必修改密码。

### 语言切换

默认中文，通过页面顶部语言切换器切换中/英文，或访问 `/locale/zh`、`/locale/en`。

## 项目结构

```
app/
├── Http/Middleware/SetLocale.php       # 语言中间件
├── Livewire/
│   ├── Admin/                          # 管理端组件
│   │   ├── PaymentReviewComponent.php  # 凭证审核
│   │   ├── PaymentSettingComponent.php # 支付配置（转账+扫码）
│   │   └── OrderDetailsComponent.php   # 订单详情+发货+确认到货
│   └── User/                           # 用户端组件
│       ├── CheckoutComponent.php       # 结账（动态展示扫码/转账）
│       └── UploadProofComponent.php    # 上传支付凭证
├── Models/
│   ├── Order.php                       # 含 display_status 统一状态属性
│   └── PaymentProof.php               # 支付凭证
database/migrations/                    # 含支付凭证、收货信息等迁移
docs/
├── 管理员操作手册.md                    # 后台操作完整指南
└── 部署指南.md                         # Linux 生产部署详细指南
lang/zh.json                            # 简体中文翻译（335 词条）
```

## 文档

- [管理员操作手册](docs/管理员操作手册.md) — 后台配置、商品上架、支付配置、订单发货完整工作流
- [部署指南](docs/部署指南.md) — 阿里云 Linux 服务器部署 + GitHub Actions 自动化

## 维护命令

```bash
php artisan optimize:clear      # 清除所有缓存
php artisan migrate             # 执行数据库迁移
php artisan storage:link        # 重建图片软链接
php artisan db:seed --class=AdminUserSeeder  # 重置管理员
```

## License

本项目基于 [digital-product-shop](https://github.com/mabdusshakur/digital-product-shop) 二次开发。
