<?php

use common\components\FileUploader;
use yii\helpers\Html;

$this->title = "Buyurtmalar";
?>

<style>
    * {
        box-sizing: border-box;
    }

    .page-wrap {
        padding: 1.5rem 0;
    }

    .section-label {
        font-size: 12px;
        color: #999;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    /* Grid */
    .order-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    /* Kartochka */
    .order-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #eee;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .order-card:hover {
        border-color: #ccc;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    /* Rasm */
    .card-img-wrap {
        position: relative;
        height: 180px;
        background: #f8f8f8;
        overflow: hidden;
        flex-shrink: 0;
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .no-image-box {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
    }

    /* Status badge */
    .status-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 6px;
        padding: 3px 9px;
        z-index: 10;
    }

    .status-0 {
        background: #fff3cd;
        color: #856404;
    }

    /* Kutilmoqda */
    .status-1 {
        background: #d1ecf1;
        color: #0c5460;
    }

    /* Qabul qilindi */
    .status-2 {
        background: #d4edda;
        color: #155724;
    }

    /* Yetkazildi */
    .status-3 {
        background: #f8d7da;
        color: #721c24;
    }

    /* Bekor qilindi */

    /* Body */
    .card-body-inner {
        padding: 12px 14px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .card-name {
        font-size: 14px;
        font-weight: 500;
        color: #222;
        line-height: 1.35;
    }

    /* Info qatorlar */
    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
    }

    .info-label {
        color: #aaa;
    }

    .info-value {
        color: #333;
        font-weight: 500;
    }

    .info-value.green {
        color: #0F6E56;
        font-size: 15px;
        font-weight: 600;
    }

    .divider-line {
        border: none;
        border-top: 1px solid #f0f0f0;
        margin: 4px 0;
    }

    /* Yetkazish va to'lov */
    .pill {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        border-radius: 20px;
        padding: 3px 10px;
        background: #f5f5f5;
        color: #555;
    }

    /* Manzil */
    .address-row {
        font-size: 12px;
        color: #888;
        display: flex;
        align-items: flex-start;
        gap: 5px;
        line-height: 1.4;
    }

    .address-icon {
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Bo'sh holat */
    .empty-state {
        grid-column: 1 / -1;
        padding: 3rem;
        text-align: center;
        color: #bbb;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 15px;
    }

    .empty-sub {
        font-size: 13px;
        margin-top: 4px;
    }

    /* Jami */
    .total-bar {
        background: #f9f9f9;
        border-radius: 10px;
        border: 1px solid #eee;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.2rem;
    }

    .total-label {
        font-size: 13px;
        color: #888;
    }

    .total-value {
        font-size: 18px;
        font-weight: 600;
        color: #0F6E56;
    }
</style>

<div class="page-wrap container">

    <p class="section-label">Savatcha</p>

    <?php if (empty($korzinkas)): ?>
        <div class="order-grid">
            <div class="empty-state">
                <div class="empty-icon">🛒</div>
                <div class="empty-text">Savatcha bo'sh</div>
                <div class="empty-sub">Mahsulotlarni savatga qo'shing</div>
            </div>
        </div>
    <?php else: ?>

        <?php
        // Jami narxni hisoblash
        $total = 0;
        foreach ($korzinkas as $k) {
            $total += ($k->price ?: ($k->product->price ?? 0)) * $k->count;
        }
        ?>

        <!-- Jami -->
        <div class="total-bar">
            <span class="total-label">
                Jami (<?= count($korzinkas) ?> ta mahsulot)
            </span>
            <span class="total-value">
                <?= number_format($total, 0, '.', ' ') ?> so'm
            </span>
        </div>

        <div class="order-grid">
            <?php foreach ($korzinkas as $k): ?>
                <?php
                $product = $k->product;
                if (!$product) continue;

                $price   = $k->price ?: $product->price;
                $images  = $product->productImages ?? [];

                $statusMap = [
                    0 => ['Kutilmoqda', 'status-0'],
                    1 => ['Qabul qilindi', 'status-1'],
                    2 => ['Yetkazildi', 'status-2'],
                    3 => ['Bekor qilindi', 'status-3'],
                ];
                $statusKey   = $k->status ?? 0;
                $statusLabel = $statusMap[$statusKey][0] ?? 'Noma\'lum';
                $statusClass = $statusMap[$statusKey][1] ?? 'status-0';
                ?>
                <div class="order-card">

                    <!-- Rasm -->
                    <div class="card-img-wrap">
                        <span class="status-badge <?= $statusClass ?>">
                            <?= $statusLabel ?>
                        </span>

                        <?php if (!empty($images)): ?>
                            <img
                                src="<?= Html::encode(FileUploader::getUrl($images[0]->image)) ?>"
                                alt="<?= Html::encode($product->name) ?>">
                        <?php else: ?>
                            <div class="no-image-box">📦</div>
                        <?php endif; ?>
                    </div>

                    <!-- Body -->
                    <div class="card-body-inner">

                        <div class="card-name"><?= Html::encode($product->name) ?></div>

                        <hr class="divider-line">

                        <div class="info-row">
                            <span class="info-label">Narx</span>
                            <span class="info-value green">
                                <?= number_format($price, 0, '.', ' ') ?> so'm
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Miqdor</span>
                            <span class="info-value"><?= $k->count ?> ta</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Jami</span>
                            <span class="info-value">
                                <?= number_format($price * $k->count, 0, '.', ' ') ?> so'm
                            </span>
                        </div>

                        <hr class="divider-line">

                        <!-- Yetkazish va to'lov -->
                        <div class="info-row">
                            <?php if ($k->yetkazish_turi): ?>
                                <span class="pill">🚚 <?= Html::encode($k->yetkazish_turi) ?></span>
                            <?php endif; ?>
                            <?php if ($k->tolov_turi): ?>
                                <span class="pill">💳 <?= Html::encode($k->tolov_turi) ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Manzil -->
                        <?php if ($k->address): ?>
                            <div class="address-row">
                                <span class="address-icon">📍</span>
                                <span><?= Html::encode($k->address) ?></span>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>