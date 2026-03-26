<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\FileUploader; // agar rasmlar uchun shu bo'lsa

/** @var yii\web\View $this */
/** @var common\models\Korzinka[] $korzinkas */
$this->title = 'Savat';
?>

<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->title ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        .page-header {
            padding: 40px 48px 24px;
            border-bottom: 1px solid var(--border);
        }

        .page-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cart-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 48px;
        }

        @media (max-width: 992px) {
            .cart-container {
                padding: 24px 20px;
            }

            .page-header {
                padding: 32px 20px 20px;
            }
        }

        .cart-item {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.25s;
        }

        .cart-item:hover {
            border-color: var(--accent2);
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(255, 101, 132, 0.12);
        }

        .item-row {
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .item-image {
            width: 140px;
            height: 140px;
            flex-shrink: 0;
            border-radius: 12px;
            overflow: hidden;
            background: var(--surface2);
            margin-right: 24px;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            font-size: 3rem;
            opacity: 0.4;
        }

        .item-details {
            flex: 1;
        }

        .item-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .item-meta {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .item-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--success);
            margin-bottom: 12px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            width: fit-content;
            margin-bottom: 12px;
        }

        .quantity-btn {
            width: 38px;
            height: 38px;
            background: transparent;
            border: none;
            color: var(--text);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quantity-btn:hover {
            background: rgba(108, 99, 255, 0.15);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            background: transparent;
            border: none;
            color: var(--text);
            font-size: 1rem;
            font-weight: 600;
        }

        .item-total {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--accent2);
            min-width: 110px;
            text-align: right;
        }

        .remove-btn {
            color: var(--muted);
            font-size: 1.4rem;
            cursor: pointer;
            transition: color 0.2s;
            margin-left: 20px;
        }

        .remove-btn:hover {
            color: var(--accent2);
        }

        .cart-summary {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            margin-top: 32px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 1.05rem;
        }

        .summary-total {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent2);
            border-top: 1px solid var(--border);
            padding-top: 16px;
            margin-top: 12px;
        }

        .btn-checkout {
            background: var(--accent);
            color: white;
            border: none;
            padding: 16px 32px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 12px;
            width: 100%;
            margin-top: 20px;
            transition: all 0.25s;
        }

        .btn-checkout:hover {
            background: var(--accent2);
            transform: translateY(-2px);
        }

        .empty-cart {
            text-align: center;
            padding: 120px 20px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 6rem;
            opacity: 0.3;
            margin-bottom: 24px;
        }

        .btn-browse {
            background: var(--accent);
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        /* ── Modal Override ── */
        .modal-content {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(108, 99, 255, 0.15);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--surface2), #1a1a28);
            border-bottom: 1px solid var(--border);
            padding: 24px 28px;
        }

        .modal-title {
            font-family: 'Syne', sans-serif !important;
            font-weight: 800 !important;
            font-size: 1.3rem !important;
            background: linear-gradient(135deg, #fff 40%, var(--accent)) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            color: unset !important;
        }

        .btn-close {
            filter: invert(1) brightness(0.6);
            transition: filter 0.2s, transform 0.2s;
        }

        .btn-close:hover {
            filter: invert(1) brightness(1);
            transform: rotate(90deg);
        }

        .modal-body {
            background: var(--surface);
            padding: 28px;
        }

        .modal-body .col-form-label {
            color: var(--muted) !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.6px !important;
            margin-bottom: 6px !important;
        }

        .modal-body .form-control,
        .modal-body .form-select {
            background: var(--surface2) !important;
            border: 1px solid var(--border) !important;
            border-radius: 10px !important;
            color: var(--text) !important;
            padding: 11px 14px !important;
            font-size: 0.95rem !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }

        .modal-body .form-control:focus,
        .modal-body .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.15) !important;
            outline: none !important;
        }

        .modal-body .form-control:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }

        .modal-body .form-select option {
            background: var(--surface2);
            color: var(--text);
        }

        .modal-body textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        /* Kuryer info box */
        #kuryer_value {
            background: rgba(108, 99, 255, 0.08) !important;
            border: 1px solid rgba(108, 99, 255, 0.2) !important;
            border-radius: 10px !important;
            padding: 12px 16px !important;
            color: var(--text) !important;
            font-size: 0.9rem !important;
        }

        #kuryer_value strong {
            color: var(--accent);
        }

        .modal-footer {
            background: var(--surface2);
            border-top: 1px solid var(--border);
            padding: 16px 28px;
            gap: 10px;
        }

        .modal-footer .btn-secondary {
            background: transparent !important;
            border: 1px solid var(--border) !important;
            color: var(--muted) !important;
            border-radius: 10px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            transition: all 0.2s !important;
        }

        .modal-footer .btn-secondary:hover {
            border-color: var(--accent2) !important;
            color: var(--accent2) !important;
        }

        .modal-footer .btn-primary {
            background: var(--accent) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 24px !important;
            font-family: 'Syne', sans-serif !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            box-shadow: 0 4px 16px rgba(108, 99, 255, 0.35) !important;
            transition: all 0.2s !important;
        }

        .modal-footer .btn-primary:hover {
            background: var(--accent2) !important;
            box-shadow: 0 6px 20px rgba(255, 101, 132, 0.4) !important;
            transform: translateY(-1px);
        }

        /* Modal backdrop */
        .modal-backdrop.show {
            opacity: 0.75;
            backdrop-filter: blur(4px);
        }

        /* Modal animation */
        .modal.fade .modal-dialog {
            transform: translateY(30px) scale(0.97);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
        }

        .modal.show .modal-dialog {
            transform: translateY(0) scale(1);
        }

        @media (max-width: 768px) {
            .item-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .item-image {
                width: 100%;
                height: 220px;
                margin-right: 0;
                margin-bottom: 20px;
            }

            .item-total,
            .remove-btn {
                text-align: right;
                margin-left: auto;
            }
        }
    </style>
</head>

<body>

    <div class="page-header">
        <h1>🛒 Savat</h1>
    </div>

    <div class="cart-container">

        <?php if (!empty($korzinkas)): ?>
            <?php
            $grandTotal = 0;
            foreach ($korzinkas as $item):
                $product = $item->product;
                $price    = $item->product->blogs->discount_price ?? $product->price ?? 0;
                $qty      = $item->count ?? 1;
                $subtotal = $price * $qty;
                if ($item->status == 0) {
                    $grandTotal += $subtotal;
                }

                $images = $product->productImages ?? [];
                $imgUrl = !empty($images) ? FileUploader::getUrl($images[0]->image) : null;
            ?>

                <div class="cart-item" data-item-id="<?= $item->id ?>" data-base-price="<?= $price ?>">
                    <div class="item-row">
                        <div class="item-image">
                            <?php if ($imgUrl): ?>
                                <img src="<?= $imgUrl ?>" alt="<?= Html::encode($product->name ?? '') ?>">
                            <?php else: ?>
                                <div class="item-no-image">🛍️</div>
                            <?php endif; ?>
                        </div>

                        <div class="item-details">
                            <div class="item-title"><?= Html::encode($product->name ?? 'Noma\'lum') ?></div>
                            <div class="item-meta">
                                <?= Html::encode($product->category->name ?? '') ?>
                                <?php if ($product->subcategory): ?> • <?= Html::encode($product->subcategory->name) ?><?php endif; ?>
                            </div>

                            <div class="item-price"><?= number_format($price, 0, '.', ' ') ?> so‘m</div>

                            <?php if ($item->status == 1): ?>
                                <div style="background: rgba(67, 217, 162, 0.08);
                                            border: 1px solid rgba(67, 217, 162, 0.25);
                                            border-radius: 10px;
                                            padding: 10px 14px;
                                            margin-bottom: 10px;
                                            font-size: 0.88rem;
                                            color: var(--success);
                                            display: flex;
                                            flex-direction: column;
                                            gap: 4px;
                                        ">
                                    <?php if ($item->yetkazish_turi == 'olib_ketish'): ?>
                                        <span>✅ Xarid qilindi &mdash; olib ketish mumkin: <strong>ertaga</strong></span>
                                    <?php else: ?>
                                        <span>✅ Xarid qilindi &mdash; yetkazib berish muddati: <strong>ertaga</strong></span>
                                    <?php endif; ?>
                                    <?php if ($item->tolov_turi == 'payme' || $item->tolov_turi == 'click'): ?>
                                        <span><strong>✅To'lov amalga oshirilgan</strong></span>
                                    <?php elseif ($item->tolov_turi == 'naqt'): ?>
                                        <span>✖️To'lanmagan: to'lov turi naqt</span>
                                    <?php elseif ($item->muddatli_tolov_summasi && $item->muddatli_tolov_summasi > 0): ?>
                                        <span>✅Oylik to'lov: <?= number_format($item->muddatli_tolov_summasi, 0, '.', ' ') ?></span>
                                    <?php endif; ?>

                                    <?php if ($item->yetkazish_turi == 'kuryer'): ?>
                                        <span style="color: var(--accent2);
                                            background: rgba(255, 101, 132, 0.08);
                                            border: 1px solid rgba(255, 101, 132, 0.2);
                                            border-radius: 7px;
                                            padding: 4px 10px;
                                            width: fit-content;
                                            font-weight: 600;
                                        ">🚚 Kuryer xizmati: 30 000 so'm</span>
                                    <?php endif; ?>
                                </div>
                                <div class="quantity-control">
                                    <input type="number" class="quantity-input" value="<?= $qty ?>" min="1" readonly>
                                </div>
                            <?php else: ?>
                                <div class="quantity-control">
                                    <button class="quantity-btn incr-btn">+</button>
                                    <input type="number" class="quantity-input" value="<?= $qty ?>" min="1" readonly>
                                    <button class="quantity-btn decr-btn">-</button>

                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="margin-left: auto; display: flex; align-items: center; gap: 28px;">
                            <div class="item-total"><?= number_format($subtotal, 0, '.', ' ') ?> so‘m</div>
                            <?php if ($item->status != 1): ?>
                                <?= Html::a('<i class="bi bi-trash"></i>', ['site/korzinkadelete', 'id' => $item->id], [
                                    'class' => 'remove-btn',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Mahsulotni savatdan o‘chirasizmi?'
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Jami xaridlar:</span>
                    <span id="end_count_success"><?= $item->countProductSuccess() ?> ta</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Umumiy xarid summa:</span>
                    <span id="grand-total-success"><?= number_format($item->priceProductSuccess(), 0, '.', ' ') ?> so‘m</span>
                </div>
            </div>
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Jami mahsulotlar:</span>
                    <span id="end_count"><?= $item->countProduct() ?> ta</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Umumiy summa:</span>
                    <span id="grand-total"><?= number_format($grandTotal, 0, '.', ' ')  ?> so‘m</span>
                </div>

                <!-- <?php if ($grandTotal > 0): ?>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleBolibTolash">Bo'lib to'lashga olish</button>
                        <span style="margin-left: 585px;">12 oyga: <?= number_format($grandTotal / 12, 0, '.', ' ') ?> so‘m</span>
                    </div>
                <?php endif; ?> -->
                <button class="btn-checkout" data-bs-toggle="modal" data-bs-target="#exampleModal">Buyurtma berish →</button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xarid qilish</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= Url::to(['site/transaction', 'id' => $item->id]) ?>" method="POST" onsubmit="return confirm('Xaridni tasdiqlaysizmi?')">
                                <div class="modal-body">
                                    <input type="hidden"
                                        name="<?= Yii::$app->request->csrfParam ?>"
                                        value="<?= Yii::$app->request->csrfToken ?>">
                                    <input type="hidden" value="<?= $item->id ?>" name="id">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Mahsulot soni:</label>
                                        <input type="text" class="form-control" value="<?= $korzinkas[0]->countProduct() ?>" id="recipient-name" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Buyurma summasi:</label>
                                        <input type="text" class="form-control" value="<?= number_format($korzinkas[0]->priceProduct(), 0, '.', ' ') ?>" id="recipient-name" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Yetkazish turi:</label>
                                        <select name="yetkazish" class="form-select" id="yetkazish_turi" required>
                                            <option value="olib_ketish">Olib ketish</option>
                                            <option value="kuryer">Kuryer orqali</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">To'lov turi:</label>
                                        <select name="tolov_turi" class="form-select" id="tolov_turi" required>
                                            <option value="naqd">Naqd</option>
                                            <option value="payme">Payme</option>
                                            <option value="click">Click</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="tolov_miqdori"></div>
                                    <div class="mb-3" id="kuryer_value">
                                        <strong> O'zingizga eng yaqin filialni kiriting: </strong>
                                    </div>
                                    <div class="mb-3" id="address">
                                        <label for="message-text" class="col-form-label">Manzil:</label>
                                        <textarea class="form-control" name="address" id="message-text" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Orqaga</button>
                                    <button type="submit" class="btn btn-primary">Buyurtma</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleBolibTolash" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xarid qilish</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= Url::to(['site/transaction']) ?>" method="POST" onsubmit="return confirm('Xaridni tasdiqlaysizmi?')">
                                <div class="modal-body">
                                    <input type="hidden"
                                        name="<?= Yii::$app->request->csrfParam ?>"
                                        value="<?= Yii::$app->request->csrfToken ?>">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Mahsulot soni:</label>
                                        <input type="text" class="form-control" value="<?= $item->countProduct() ?>" id="recipient-name" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Oylik to'lov:</label>
                                        <input type="text" class="form-control" name="bolib_tolash" value="<?= number_format($grandTotal / 12, 0, '.', ' ') ?>" id="recipient-name" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Yetkazish turi:</label>
                                        <select name="yetkazish" class="form-select" id="yetkazish_turi" required>
                                            <option value="olib_ketish">Olib ketish</option>
                                            <option value="kuryer">Kuryer orqali</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">To'lov turi:</label>
                                        <select name="tolov_turi" class="form-select" id="tolov_turi" required>
                                            <option value="naqd">Naqd</option>
                                            <option value="payme">Payme</option>
                                            <option value="click">Click</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="tolov_miqdori"></div>
                                    <div class="mb-3" id="kuryer_value">
                                        <strong> O'zingizga eng yaqin filialni kiriting: </strong>
                                    </div>
                                    <div class="mb-3" id="address">
                                        <label for="message-text" class="col-form-label">Manzil:</label>
                                        <textarea class="form-control" name="address" id="message-text" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Orqaga</button>
                                    <button type="submit" class="btn btn-primary">Buyurtma</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>

            <div class="empty-cart">
                <div class="empty-icon">🛒</div>
                <h3>Savat bo‘sh</h3>
                <p>Hozircha hech qanday mahsulot qo‘shilmagan</p>
                <a href="<?= Url::to(['site/index']) ?>" class="btn-browse">Xarid qilishni boshlash</a>
            </div>

        <?php endif; ?>

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

    <script>
        const yetkazish = document.getElementById('yetkazish_turi');
        const kuryer = document.getElementById('kuryer_value');
        const tolovTuri = document.getElementById('tolov_turi');
        const tolovMiqdori = document.getElementById('tolov_miqdori');

        yetkazish.addEventListener('change', (e) => {
            const select = e.target.value;
            if (select == 'kuryer') {
                kuryer.innerHTML = `<div class="mb-3 d-flex gap-4">
                                        <p>Kuryer xizmati</p><strong>30.000 so'm</strong>
                                    </div>
                                    <strong> Olib borish manzilini kiriting: </strong>
                                    `;
            } else if (select == 'olib_ketish') {
                kuryer.innerHTML = '<strong> O\'zingizga eng yaqin filialni kiriting: </strong>';
            }
        })

        tolovTuri.addEventListener('change', (e) => {
            const select = e.target.value;
            if (select == 'payme' || select == 'click') {
                tolovMiqdori.innerHTML = `<div class="mb-3 d-flex gap-2">
                                            <label class='form-label'>Kartani kirting
                                                <input type='text' maxlength="19" id='karta' placeholder='Karta raqami' class='form-control' required>
                                            </label>
                                            <label class='form-label' style=''>Amal qilish muddati
                                                <input type='text' maxlength="5" id='muddat' placeholder='10/30' class='form-control' required>
                                            </label>
                                        </div>`;
                document.getElementById('karta').addEventListener('input', (evt) => {
                    const karta = evt.target.value.replace(/\D/g, '').slice(0, 16);
                    evt.target.value = karta.replace(/(.{4})/g, '$1 ').trim();
                })
                document.getElementById('muddat').addEventListener('input', (evt) => {
                    const digits = evt.target.value.replace(/\D/g, '').slice(0, 4);
                    if (digits.length > 2) {
                        evt.target.value = digits.slice(0, 2) + '/' + digits.slice(2);
                    } else {
                        evt.target.value = digits;
                    }
                });
            } else if (select == 'naqd') {
                tolovMiqdori.innerHTML = ''
            }
        })
    </script>

    <script>
        const CSRF = '<?= Yii::$app->request->csrfToken ?>';

        function changeQty(btn, route) {
            const cartItem = btn.closest('.cart-item');
            const itemId = cartItem.dataset.itemId;
            const basePrice = parseFloat(cartItem.dataset.basePrice);
            const countInput = cartItem.querySelector('.quantity-input');
            const priceEl = cartItem.querySelector('.item-total');

            fetch('index.php?r=site/' + route, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': CSRF
                    },
                    body: JSON.stringify({
                        id: itemId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const newCount = parseInt(data.count);
                        countInput.value = newCount;
                        const subtotal = basePrice * newCount;
                        priceEl.textContent = subtotal.toLocaleString('ru-RU') + " so'm";

                        updateGrandTotal();
                    } else {
                        console.log(data.message);
                    }
                })
                .catch(err => console.error(err));
        }

        document.querySelectorAll('.incr-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                changeQty(btn, 'increment');
            });
        });

        document.querySelectorAll('.decr-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                changeQty(btn, 'decrement');
            });
        });

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(cartItem => {
                const removeBtn = cartItem.querySelector('.remove-btn');
                if (removeBtn) {
                    const priceEl = cartItem.querySelector('.item-total');
                    const raw = priceEl.textContent.replace(/[^0-9]/g, '');
                    total += parseInt(raw) || 0;
                }
            });

            const grandTotalEl = document.getElementById('grand-total');
            if (grandTotalEl) {
                grandTotalEl.textContent = total.toLocaleString('ru-RU') + " so'm";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>