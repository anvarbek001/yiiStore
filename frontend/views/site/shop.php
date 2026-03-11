<?php

use yii\helpers\Html;
use common\components\FileUploader;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\LanguageSwitcher;

$images = $product->productImages;
?>
<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($product->name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f0f13;
            --surface: #17171f;
            --surface2: #1e1e2a;
            --border: #2a2a38;
            --accent: #6c63ff;
            --accent2: #ff6584;
            --text: #e8e8f0;
            --muted: #6b6b80;
            --success: #43d9a2;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* ── Back button ── */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 10px 20px;
            margin: 32px 48px 0;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            transition: color .2s, border-color .2s;
        }

        .back-btn:hover {
            color: var(--accent);
            border-color: var(--accent);
        }

        /* ── Main layout ── */
        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            padding: 40px 48px 80px;
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeUp .5s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
                padding: 24px 20px;
            }

            .back-btn {
                margin: 20px 20px 0;
            }
        }

        /* ── Carousel ── */
        .carousel-wrap {
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--border);
            background: var(--surface);
            position: sticky;
            top: 32px;
        }

        .carousel-item img {
            width: 100%;
            height: 420px;
            object-fit: cover;
        }

        .no-image {
            height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            background: var(--surface2);
        }

        /* Carousel override */
        .carousel-indicators [data-bs-target] {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.4);
        }

        .carousel-indicators .active {
            background: #fff;
        }

        /* Thumbnails */
        .thumbnails {
            display: flex;
            gap: 10px;
            padding: 14px;
            overflow-x: auto;
            background: var(--surface2);
        }

        .thumbnails::-webkit-scrollbar {
            height: 4px;
        }

        .thumbnails::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        .thumb {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color .2s;
        }

        .thumb.active {
            border-color: var(--accent);
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── Info panel ── */
        .info-panel {
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding-top: 8px;
        }

        .product-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 8px;
            letter-spacing: .3px;
        }

        .badge-user {
            background: rgba(108, 99, 255, .15);
            color: var(--accent);
        }

        .badge-cat {
            background: rgba(255, 101, 132, .12);
            color: var(--accent2);
        }

        .badge-subcat {
            background: rgba(67, 217, 162, .1);
            color: var(--success);
        }

        .product-name {
            font-family: 'Syne', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.15;
        }

        .product-price {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--success);
        }

        .divider {
            height: 1px;
            background: var(--border);
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .product-desc {
            font-size: 0.95rem;
            color: var(--muted);
            line-height: 1.7;
        }

        /* Stats row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .stat-box {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            text-align: center;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 4px;
        }

        /* CTA */
        .btn-buy {
            width: 100%;
            background: var(--accent);
            border: none;
            color: #fff;
            padding: 16px;
            border-radius: 14px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            box-shadow: 0 4px 24px rgba(108, 99, 255, .4);
            transition: transform .2s, box-shadow .2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-buy:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(108, 99, 255, .55);
            color: #fff;
        }

        .cta-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-wishlist {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 14px;
            border-radius: 14px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: border-color .2s, color .2s;
        }

        .btn-wishlist:hover {
            border-color: var(--accent2);
            color: var(--accent2);
        }

        /* Seller card */
        .seller-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .seller-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: #fff;
            flex-shrink: 0;
        }

        .seller-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .seller-label {
            font-size: 0.78rem;
            color: var(--muted);
            margin-top: 2px;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        /* ── Product Shop Panel ── */
        .product_shop {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .shop-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Miqdor */
        .quantity-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface2);
            color: var(--text);
            font-size: 1.2rem;
            cursor: pointer;
            transition: border-color .2s, color .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .qty-input {
            width: 60px;
            height: 38px;
            text-align: center;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
        }

        .qty-input::-webkit-inner-spin-button,
        .qty-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        .qty-stock {
            font-size: 0.82rem;
            color: var(--muted);
            margin-left: 6px;
        }

        .qty-stock strong {
            color: var(--success);
        }

        /* Yetkazib berish */
        .delivery-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .delivery-option {
            cursor: pointer;
        }

        .delivery-option input[type="radio"] {
            display: none;
        }

        .delivery-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: var(--surface2);
            transition: border-color .2s;
        }

        .delivery-option input:checked+.delivery-card {
            border-color: var(--accent);
            background: rgba(108, 99, 255, .08);
        }

        .delivery-icon {
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .delivery-name {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .delivery-time {
            display: block;
            font-size: 0.78rem;
            color: var(--muted);
        }

        .delivery-price {
            margin-left: auto;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--success);
            white-space: nowrap;
        }

        /* Jami */
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 14px;
        }

        .total-label {
            font-size: 0.88rem;
            color: var(--muted);
            font-weight: 600;
        }

        .total-price {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--success);
        }

        .btn-cart {
            width: 100%;
            gap: 7px;
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 11px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 3px 14px rgba(108, 99, 255, .3);
            text-decoration: none;
        }

        .btn-cart:hover {
            background: #5a52e0;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(108, 99, 255, .45);
            color: #fff;
        }

        .btn-cart svg {
            flex-shrink: 0;
        }

        /* Savatda bo'lganda */
        .btn-cart.in-cart {
            background: var(--accent2);
            box-shadow: 0 3px 14px rgba(255, 101, 132, .3);
            cursor: default;
        }

        .btn-cart.in-cart:hover {
            background: var(--accent2);
            transform: none;
            box-shadow: 0 3px 14px rgba(255, 101, 132, .3);
        }
    </style>
</head>

<body>

    <a href="<?= \yii\helpers\Url::to(['site/index']) ?>" class="back-btn">
        ← Orqaga
    </a>

    <div class="product-detail">
        <!-- Chap: Carousel -->
        <div>
            <div class="carousel-wrap">
                <?php if (!empty($images)): ?>
                    <div id="mainCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            <?php foreach ($images as $i => $img): ?>
                                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                    <img src="<?= FileUploader::getUrl($img->image) ?>"
                                        alt="<?= Html::encode($product->name) ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($images) > 1): ?>
                            <div class="carousel-indicators">
                                <?php foreach ($images as $i => $img): ?>
                                    <button type="button" data-bs-target="#mainCarousel"
                                        data-bs-slide-to="<?= $i ?>"
                                        <?= $i === 0 ? 'class="active"' : '' ?>></button>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Thumbnails -->
                    <?php if (count($images) > 1): ?>
                        <div class="thumbnails">
                            <?php foreach ($images as $i => $img): ?>
                                <div class="thumb <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>">
                                    <img src="<?= FileUploader::getUrl($img->image) ?>"
                                        alt="thumb <?= $i + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="no-image">📦</div>
                <?php endif; ?>
                <!-- Sotuvchi -->
                <div>
                    <div class="section-label mt-3">Sotuvchi</div>
                    <div class="seller-card">
                        <div class="seller-avatar"><?= mb_strtoupper(mb_substr($product->user->username, 0, 1)) ?></div>
                        <div>
                            <div class="seller-name"><?= Html::encode($product->user->username) ?></div>
                            <div class="seller-label">Ro'yxatdan o'tgan sotuvchi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- O'ng: Info -->
        <div class="info-panel">

            <!-- Badges -->
            <div class="product-badges">
                <span class="badge badge-user">👤 <?= Html::encode($product->user->username) ?></span>
                <span class="badge badge-cat"><?= Html::encode($product->category->name) ?></span>
                <span class="badge badge-subcat"><?= Html::encode($product->subcategory->name) ?></span>
            </div>

            <!-- Nom -->
            <div class="product-name"><?= Html::encode($product->name) ?></div>

            <!-- Narx -->
            <?php if ($product->latestBlog): ?>
                <div style="display:flex; flex-direction:column; gap:2px;">
                    <span style="font-size:1rem; color:var(--muted); text-decoration:line-through;">
                        <?= number_format($product->price, 0, '.', ' ') ?>
                    </span>
                    <span class="card-price" style="color:var(--accent2);">
                        <span style="font-size: 3rem;">
                            <?= number_format($product->latestBlog->discount_price, 0, '.', ' ') ?>
                        </span>
                        <span style="font-size:1rem; background:rgba(255,101,132,.15); color:var(--accent2); padding:2px 6px; border-radius:5px; margin-left:4px;">
                            -<?= round((1 - $product->latestBlog->discount_price / $product->price) * 100) ?>%
                        </span>
                    </span>
                </div>
            <?php else: ?>
                <span class="card-price"><?= number_format($product->price, 0, '.', ' ') ?></span>
            <?php endif; ?>

            <div class="divider"></div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-box">
                    <div class="stat-value"><?= count($images) ?></div>
                    <div class="stat-label">Rasmlar</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $product->status ? '✓' : '⏳' ?></div>
                    <div class="stat-label">Holat</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= date('d.m.Y', strtotime($product->created_at)) ?></div>
                    <div class="stat-label">Sana</div>
                </div>
            </div>
            <?php
            $form = ActiveForm::begin(['id' => $product->id]);
            ?>
            <div class="product_shop">

                <!-- Jami narx -->
                <div class="shop-section">
                    <div class="total-row">
                        <span class="total-label">Jami:</span>
                        <span class="total-price" id="total-price">
                            <?php if ($product->latestBlog): ?>
                                <?= number_format($product->latestBlog->discount_price, 0, '.', ' ') ?> so'm
                            <?php else: ?>
                                <?= number_format($product->price, 0, '.', ' ') ?> so'm
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
            <!-- Korzinka tugmasi -->
            <?php if ($product->oneKorzinka()): ?>
                <!-- Allaqachon savatda -->
                <button class="btn-cart in-cart xarid_btn" data-id="<?= $product->id ?>" data-in-cart="1">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                    Savatda ✓
                </button>
            <?php else: ?>
                <!-- Savatga qo'shish -->
                <button class="btn-cart xarid_btn" data-id="<?= $product->id ?>" data-in-cart="0">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                    Korzinka+
                </button>
            <?php endif; ?>
            <?php $form = ActiveForm::end(); ?>

            <!-- Tavsif -->
            <?php if ($product->description): ?>
                <div>
                    <div class="section-label">Tavsif</div>
                    <p class="product-desc"><?= nl2br(Html::encode($product->description)) ?></p>
                </div>
            <?php endif; ?>

            <div class="divider"></div>

            <!-- CTA tugmalar -->
            <div class="cta-group">
                <?php if ($product->isFavourite()): ?>
                    <button class="btn-wishlist" style="border-color:var(--accent2); color:var(--accent2);">
                        ♥ Saqlangan
                    </button>
                <?php else: ?>
                    <button class="btn-wishlist" id="btn_favourite">♡ Sevimlilarga qo'shish</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        :root {
            --bg: #0f0f13;
            --surface: #17171f;
            --surface2: #1e1e2a;
            --border: #2a2a38;
            --accent: #6c63ff;
            --accent2: #ff6584;
            --text: #e8e8f0;
            --muted: #6b6b80;
            --success: #43d9a2;
        }

        /* ── Header ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 48px 48px 32px;
            border-bottom: 1px solid var(--border);
        }

        .page-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.6rem;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #fff 40%, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header .count {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .page-header .count b {
            color: var(--accent);
        }

        .btn-add {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 20px rgba(108, 99, 255, .35);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(108, 99, 255, .5);
        }

        /* ── Grid ── */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            padding: 40px 48px;
        }

        /* ── Card ── */
        .product-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: transform .25s, border-color .25s, box-shadow .25s;
            animation: fadeUp .4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card:hover {
            transform: translateY(-6px);
            border-color: var(--accent);
            box-shadow: 0 12px 40px rgba(108, 99, 255, .2);
        }

        .card-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--surface2), var(--border));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .card-body {
            padding: 20px;
        }

        .card-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: .3px;
        }

        .badge-user {
            background: rgba(108, 99, 255, .15);
            color: var(--accent);
        }

        .badge-cat {
            background: rgba(255, 101, 132, .12);
            color: var(--accent2);
        }

        .badge-subcat {
            background: rgba(67, 217, 162, .1);
            color: var(--success);
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .card-desc {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ── Card Actions ── */
        .card-actions {
            display: flex;
            gap: 8px;
            padding: 0 20px 14px;
        }

        .btn-cart {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 11px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 3px 14px rgba(108, 99, 255, .3);
            text-decoration: none;
        }

        .btn-cart:hover {
            background: #5a52e0;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(108, 99, 255, .45);
            color: #fff;
        }

        .btn-cart svg {
            flex-shrink: 0;
        }

        /* Savatda bo'lganda */
        .btn-cart.in-cart {
            background: var(--accent2);
            box-shadow: 0 3px 14px rgba(255, 101, 132, .3);
            cursor: default;
        }

        .btn-cart.in-cart:hover {
            background: var(--accent2);
            transform: none;
            box-shadow: 0 3px 14px rgba(255, 101, 132, .3);
        }

        .btn-wishlist {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 11px;
            cursor: pointer;
            transition: background .2s, border-color .2s, transform .15s;
            flex-shrink: 0;
            color: var(--muted);
            font-size: 1.2rem;
        }

        .btn-wishlist:hover {
            background: rgba(255, 101, 132, .15);
            border-color: var(--accent2);
            color: var(--accent2);
            transform: translateY(-1px);
        }

        .btn-wishlist.active {
            background: rgba(255, 101, 132, .15);
            border-color: var(--accent2);
            color: var(--accent2);
        }

        /* ── Card Footer ── */
        .card-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-price {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--success);
        }

        .btn-detail {
            background: var(--surface2);
            color: var(--text);
            border: 1px solid var(--border);
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s, border-color .2s;
        }

        .btn-detail:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* ── Empty ── */
        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 80px 20px;
            color: var(--muted);
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 1rem;
        }

        /* ── Flash ── */
        .flash {
            padding: 14px 48px;
            font-size: 0.9rem;
        }

        .flash-success {
            background: rgba(67, 217, 162, .1);
            color: var(--success);
            border-left: 3px solid var(--success);
        }

        .flash-error {
            background: rgba(255, 101, 132, .1);
            color: var(--accent2);
            border-left: 3px solid var(--accent2);
        }

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }
    </style>

    <!-- Grid -->
    <h1>O'xshash mahsulotlar</h1>
    <div class="products-grid">
        <?php foreach ($recommendedProducts as $i => $product): ?>
            <div class="product-card" style="animation-delay: <?= $i * 0.06 ?>s">

                <!-- Rasm / Carousel -->
                <div class="card-img" style="position:relative; overflow:hidden;">
                    <?php $images = $product->productImages;
                    if (!empty($images)): ?>
                        <div id="carousel-<?= $product->id ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" style="height:100%;">
                                <?php foreach ($images as $j => $img): ?>
                                    <a href="<?= Url::to(['site/shop', 'id' => $product->id]) ?>">
                                        <div class="carousel-item <?= $j === 0 ? 'active' : '' ?>" style="height:100%;">
                                            <img src="<?= FileUploader::getUrl($img->image) ?>"
                                                class="d-block w-100"
                                                alt="<?= Html::encode($product->name) ?>"
                                                style="height:100%; object-fit:cover;">
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($images) > 1): ?>
                                <div class="carousel-indicators">
                                    <?php foreach ($images as $j => $img): ?>
                                        <button type="button"
                                            data-bs-target="#carousel-<?= $product->id ?>"
                                            data-bs-slide-to="<?= $j ?>"
                                            <?= $j === 0 ? 'class="active"' : '' ?>></button>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carousel-<?= $product->id ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carousel-<?= $product->id ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div style="display:flex; align-items:center; justify-content:center; height:100%; font-size:48px;">📦</div>
                    <?php endif; ?>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <div class="card-meta">
                        <span class="badge badge-user">👤 <?= Html::encode($product->user->username) ?></span>
                        <span class="badge badge-cat"><?= Html::encode($product->category->name) ?></span>
                        <span class="badge badge-subcat"><?= Html::encode($product->subcategory->name) ?></span>
                        <span class="badge badge-subcat"><?= Html::encode($product->subSubCategory->name) ?></span>
                    </div>
                    <div class="card-title"><?= Html::encode($product->name) ?></div>
                    <p class="card-desc"><?= Html::encode($product->description) ?></p>
                </div>

                <!-- Korzinka + Sevimlilar tugmalari -->
                <div class="card-actions">

                    <!-- Korzinka tugmasi -->
                    <?php if ($product->oneKorzinka()): ?>
                        <button class="btn-cart in-cart xarid_btn" data-id="<?= $product->id ?>" data-in-cart="1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                            </svg>
                            Savatda ✓
                        </button>
                    <?php else: ?>
                        <!-- Savatga qo'shish -->
                        <button class="btn-cart xarid_btn" data-id="<?= $product->id ?>" data-in-cart="0">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                            </svg>
                            Korzinka+
                        </button>
                    <?php endif; ?>

                    <!-- Sevimlilar tugmasi -->
                    <?php if ($product->isFavourite()): ?>
                        <button class="btn-wishlist active favourite_btn" data-id="<?= $product->id ?>" data-fav="1" title="Sevimlilarda bor">
                            ♥
                        </button>
                        <button class="btn-wishlist favourite_btn" data-id="<?= $product->id ?>" data-fav="0" title="Sevimlilarga qo'shish">
                            ♡
                        </button>
                    <?php endif; ?>

                </div>

                <!-- Footer -->
                <div class="card-footer">
                    <?php if ($product->latestBlog): ?>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <span style="font-size:0.75rem; color:var(--muted); text-decoration:line-through;">
                                <?= number_format($product->price, 0, '.', ' ') ?>
                            </span>
                            <span class="card-price" style="color:var(--accent2);">
                                <?= number_format($product->latestBlog->discount_price, 0, '.', ' ') ?>
                                <span style="font-size:0.7rem; background:rgba(255,101,132,.15); color:var(--accent2); padding:2px 6px; border-radius:5px; margin-left:4px;">
                                    -<?= round((1 - $product->latestBlog->discount_price / $product->price) * 100) ?>%
                                </span>
                            </span>
                        </div>
                    <?php else: ?>
                        <span class="card-price"><?= number_format($product->price, 0, '.', ' ') ?></span>
                    <?php endif; ?>

                    <a href="<?= Url::to(['site/shop', 'id' => $product->id]) ?>" class="btn-detail">Ko'rish</a>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <script>
        const CSRF_TOKEN = '<?= Yii::$app->request->csrfToken ?>';
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.xarid_btn');
            if (!btn) return;

            e.preventDefault();

            if (btn.dataset.inCart === '1') {
                alert('Mahsulot allaqachon savatda!');
                return;
            }

            const productId = btn.dataset.id;

            fetch('/index.php?r=site/korzinka', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btn.innerHTML = `
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Savatda ✓
                        `;
                        btn.classList.add('in-cart');
                        btn.dataset.inCart = '1';
                    } else {
                        alert(data.message || 'Xatolik yuz berdi');
                    }
                })
                .catch(() => alert('Server bilan bog\'lanishda xatolik'));
        });

        /* ─── SEVIMLILAR ─── */
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.favourite_btn');
            if (!btn) return;

            e.preventDefault();

            const productId = btn.dataset.id;

            fetch('/index.php?r=site/favourite', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (btn.dataset.fav === '0') {
                            btn.textContent = '♥';
                            btn.classList.add('active');
                            btn.dataset.fav = '1';
                            btn.title = 'Sevimlilarda bor';
                        } else {
                            btn.textContent = '♡';
                            btn.classList.remove('active');
                            btn.dataset.fav = '0';
                            btn.title = "Sevimlilarga qo'shish";
                        }
                    } else {
                        alert(data.message || 'Xatolik yuz berdi');
                    }
                })
                .catch(() => alert('Server bilan bog\'lanishda xatolik'));
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal-<?= $product->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">To'lovni tasdiqlang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tasdiqlash</button>
                    <button type="button" class="btn btn-primary">Bekor qilish</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const CSRF_TOKEN = '<?= Yii::$app->request->csrfToken ?>';
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.xarid_btn');
            if (!btn) return;

            e.preventDefault();

            if (btn.dataset.inCart === '1') {
                alert('Mahsulot allaqachon savatda!');
                return;
            }

            const productId = btn.dataset.id;

            fetch('/index.php?r=site/korzinka', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btn.innerHTML = `
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                            Savatda ✓
                        `;
                        btn.classList.add('in-cart');
                        btn.dataset.inCart = '1';
                    } else {
                        alert(data.message || 'Xatolik yuz berdi');
                    }
                })
                .catch(() => alert('Server bilan bog\'lanishda xatolik'));
        });
    </script>
    <script>
        const basePrice = <?= $product->price ?>;
        const qtyInput = document.getElementById('qty-input');
        const totalPrice = document.getElementById('total-price');

        function updateTotal() {
            const qty = parseInt(qtyInput.value) || 1;
            const formatted = (basePrice * qty).toLocaleString('uz-UZ');
            totalPrice.textContent = formatted + " so'm";
        }

        document.getElementById('qty-minus').addEventListener('click', () => {
            if (qtyInput.value > 1) {
                qtyInput.value--;
                updateTotal();
            }
        });

        document.getElementById('qty-plus').addEventListener('click', () => {
            if (qtyInput.value < 99) {
                qtyInput.value++;
                updateTotal();
            }
        });

        qtyInput.addEventListener('input', updateTotal);
    </script>
    <script>
        const btnFavourite = document.getElementById('btn_favourite');
        btnFavourite.addEventListener('click', (e) => {
            e.preventDefault();
            fetch('/index.php?r=site/favourite', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                    },
                    body: JSON.stringify({
                        product_id: "<?= $product->id ?>"
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btnFavourite.textContent = '♥ Saqlangan';
                        btnFavourite.style.borderColor = 'var(--accent2)';
                        btnFavourite.style.color = 'var(--accent2)';
                    } else {
                        alert(data.message);
                    }
                });
        })
    </script>
    <script>
        // Thumbnail + carousel sync
        const carousel = document.getElementById('mainCarousel');
        if (carousel) {
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);
            const thumbs = document.querySelectorAll('.thumb');

            thumbs.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    bsCarousel.to(parseInt(thumb.dataset.index));
                });
            });

            carousel.addEventListener('slid.bs.carousel', e => {
                thumbs.forEach(t => t.classList.remove('active'));
                if (thumbs[e.to]) thumbs[e.to].classList.add('active');
            });
        }
    </script>
</body>

</html>