<?php

use common\components\FileUploader;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($user->username) ?> — Profil</title>
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

        /* Cover */
        .profile-cover {
            height: 220px;
            background: linear-gradient(135deg, #1a1535, #0f0f13, #1a1f35);
            position: relative;
            overflow: hidden;
        }

        .profile-cover::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(108, 99, 255, .25) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 30%, rgba(255, 101, 132, .15) 0%, transparent 50%);
        }

        .cover-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(108, 99, 255, .05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(108, 99, 255, .05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Avatar area */
        .profile-head {
            padding: 0 48px;
            position: relative;
            margin-top: -60px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .avatar-wrap {
            position: relative;
        }

        .avatar {
            width: 110px;
            height: 110px;
            border-radius: 24px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2.8rem;
            color: #fff;
            border: 4px solid var(--bg);
            box-shadow: 0 8px 32px rgba(108, 99, 255, .3);
        }

        .status-dot {
            position: absolute;
            bottom: 8px;
            right: -4px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--success);
            border: 3px solid var(--bg);
        }

        .profile-actions {
            display: flex;
            gap: 10px;
            padding-bottom: 8px;
        }

        .btn-edit {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            transition: border-color .2s, color .2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* Edit modal */
        .edit-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .75);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .edit-modal-overlay.active {
            display: flex;
        }

        .edit-modal {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            width: 100%;
            max-width: 460px;
            padding: 36px;
            animation: modalIn .3s cubic-bezier(.34, 1.56, .64, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.92) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .edit-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .edit-modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .modal-close-btn {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, color .2s;
        }

        .modal-close-btn:hover {
            background: var(--accent2);
            color: #fff;
            border-color: var(--accent2);
        }

        .edit-form-group {
            margin-bottom: 18px;
        }

        .edit-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .edit-input {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .edit-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, .2);
        }

        .edit-input::placeholder {
            color: var(--muted);
        }

        .edit-modal-footer {
            display: flex;
            gap: 10px;
            margin-top: 28px;
        }

        .btn-cancel-edit {
            flex: 1;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 13px;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-cancel-edit:hover {
            background: var(--border);
        }

        .btn-save-edit {
            flex: 2;
            background: var(--accent);
            border: none;
            color: #fff;
            padding: 13px;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(108, 99, 255, .35);
            transition: transform .2s, box-shadow .2s;
        }

        .btn-save-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(108, 99, 255, .5);
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle .toggle-eye {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted);
            font-size: 1rem;
            transition: color .2s;
        }

        .password-toggle .toggle-eye:hover {
            color: var(--accent);
        }

        .btn-logout {
            background: rgba(255, 101, 132, .1);
            border: 1px solid rgba(255, 101, 132, .3);
            color: var(--accent2);
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background: var(--accent2);
            color: #fff;
        }

        /* Info */
        .profile-info {
            padding: 0 48px 40px;
        }

        .username {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .user-email {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 16px;
        }

        .user-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 8px;
        }

        .badge-role {
            background: rgba(108, 99, 255, .15);
            color: var(--accent);
        }

        .badge-active {
            background: rgba(67, 217, 162, .1);
            color: var(--success);
        }

        .badge-date {
            background: var(--surface2);
            color: var(--muted);
            border: 1px solid var(--border);
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 0 48px 40px;
        }

        /* Stats */
        .stats-section {
            padding: 0 48px 40px;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 16px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: border-color .2s, transform .2s;
        }

        .stat-card:hover {
            border-color: var(--accent);
            transform: translateY(-3px);
        }

        .stat-icon {
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.78rem;
            color: var(--muted);
        }

        /* Products */
        .products-section {
            padding: 0 48px 60px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn-see-all {
            font-size: 0.82rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .btn-see-all:hover {
            text-decoration: underline;
            color: var(--accent);
        }

        .mini-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
        }

        .mini-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: transform .2s, border-color .2s;
            text-decoration: none;
            color: var(--text);
            display: block;
            animation: fadeUp .4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mini-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent);
            color: var(--text);
        }

        .mini-img {
            width: 100%;
            height: 130px;
            object-fit: cover;
        }

        .mini-no-img {
            width: 100%;
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface2);
            font-size: 2.5rem;
        }

        .mini-body {
            padding: 14px;
        }

        .mini-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.92rem;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mini-price {
            font-size: 0.82rem;
            color: var(--success);
            font-weight: 600;
        }

        /* Favourites */
        .fav-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .fav-item {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: border-color .2s;
            text-decoration: none;
            color: var(--text);
            animation: fadeUp .3s ease both;
        }

        .fav-item:hover {
            border-color: var(--accent2);
            color: var(--text);
        }

        .fav-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(255, 101, 132, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent2);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .fav-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .fav-price {
            font-size: 0.8rem;
            color: var(--success);
            margin-top: 2px;
        }

        .fav-arrow {
            margin-left: auto;
            color: var(--muted);
            font-size: 0.9rem;
        }

        /* Empty */
        .empty-mini {
            color: var(--muted);
            font-size: 0.88rem;
            padding: 20px 0;
        }

        @media (max-width: 768px) {
            .profile-head {
                flex-direction: column;
                align-items: flex-start;
                padding: 0 20px;
                gap: 16px;
            }

            .profile-info,
            .stats-section,
            .products-section {
                padding-left: 20px;
                padding-right: 20px;
            }

            .divider {
                margin-left: 20px;
                margin-right: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .username {
                font-size: 1.6rem;
            }
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
    </style>
</head>

<body>

    <?php

    $products  = $user->products;
    $favourites = $user->favourite;
    ?>

    <!-- Cover -->
    <div class="profile-cover">
        <div class="cover-grid"></div>
    </div>

    <!-- Head -->
    <div class="profile-head">
        <div class="avatar-wrap">
            <div class="avatar"><?= mb_strtoupper(mb_substr($user->username, 0, 1)) ?></div>
            <div class="status-dot"></div>
        </div>
        <div class="profile-actions">
            <a href="<?= Url::to(['site/index']) ?>" class="btn-edit">
                <i class="bi bi-arrow-left"></i> Orqaga
            </a>
            <button class="btn-edit" onclick="document.getElementById('editProfileModal').classList.add('active')">
                <i class="bi bi-pencil-fill"></i> Tahrirlash
            </button>
            <a href="<?= Url::to(['site/logout']) ?>" class="btn-logout" data-method="post">
                <i class="bi bi-box-arrow-right"></i> Chiqish
            </a>
        </div>
    </div>

    <!-- Info -->
    <div class="profile-info">
        <div class="username"><?= Html::encode($user->username) ?></div>
        <div class="user-email">
            <i class="bi bi-envelope" style="margin-right:5px;"></i><?= Html::encode($user->email) ?>
        </div>
        <div class="user-badges">
            <span class="badge badge-role">
                <i class="bi bi-shield-fill" style="margin-right:4px;"></i>
                <?= $user->role ?? 'user' ?>
            </span>
            <span class="badge badge-active">
                <i class="bi bi-circle-fill" style="font-size:0.5rem; margin-right:4px;"></i>
                Faol
            </span>
            <span class="badge badge-date">
                <i class="bi bi-calendar3" style="margin-right:4px;"></i>
                <?= date('d.m.Y', $user->created_at) ?>
            </span>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Stats -->
    <div class="stats-section">
        <div class="section-title">Statistika</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📦</div>
                <div class="stat-value"><?= count($products) ?></div>
                <div class="stat-label">Productlar</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">♥</div>
                <div class="stat-value"><?= count($favourites) ?></div>
                <div class="stat-label">Saqlangan</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <div class="stat-value">
                    <?php
                    $total = array_sum(array_map(fn($p) => $p->price, $products));
                    echo $total >= 1000000
                        ? round($total / 1000000, 1) . 'M'
                        : ($total >= 1000 ? round($total / 1000) . 'K' : $total);
                    ?>
                </div>
                <div class="stat-label">Jami so'm</div>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Products -->
    <div class="products-section">
        <div class="section-header">
            <div class="section-title" style="margin-bottom:0;">Mening productlarim</div>
            <?php if (count($products) > 4): ?>
                <a href="<?= Url::to(['site/index']) ?>" class="btn-see-all">Barchasini ko'rish →</a>
            <?php endif; ?>
        </div>

        <?php if (!empty($products)): ?>
            <div class="mini-grid">
                <?php foreach (array_slice($products, 0, 4) as $i => $product): ?>
                    <?php $imgs = $product->productImages; ?>
                    <a href="<?= Url::to(['site/shop', 'id' => $product->id]) ?>"
                        class="mini-card" style="animation-delay: <?= $i * 0.07 ?>s">
                        <?php if (!empty($imgs)): ?>
                            <img class="mini-img"
                                src="<?= FileUploader::getUrl($imgs[0]->image) ?>"
                                alt="<?= Html::encode($product->name) ?>">
                        <?php else: ?>
                            <div class="mini-no-img">📦</div>
                        <?php endif; ?>
                        <div class="mini-body">
                            <div class="mini-name"><?= Html::encode($product->name) ?></div>
                            <div class="mini-price"><?= number_format($product->price, 0, '.', ' ') ?> so'm</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-mini">📭 Hali product qo'shilmagan</div>
        <?php endif; ?>
    </div>

    <div class="divider"></div>

    <!-- Favourites -->
    <div class="products-section">
        <div class="section-header">
            <div class="section-title" style="margin-bottom:0;">Saqlangan productlar</div>
            <?php if (count($favourites) > 5): ?>
                <a href="<?= Url::to(['site/saved']) ?>" class="btn-see-all">Barchasini ko'rish →</a>
            <?php endif; ?>
        </div>

        <?php if (!empty($favourites)): ?>
            <div class="fav-list">
                <?php foreach (array_slice($favourites, 0, 5) as $i => $fav): ?>
                    <?php $p = $fav->product ?? null;
                    if (!$p) continue; ?>
                    <a href="<?= Url::to(['site/shop', 'id' => $p->id]) ?>"
                        class="fav-item" style="animation-delay: <?= $i * 0.06 ?>s">
                        <div class="fav-icon"><i class="bi bi-bookmark-fill"></i></div>
                        <div>
                            <div class="fav-name"><?= Html::encode($p->name) ?></div>
                            <div class="fav-price"><?= number_format($p->price, 0, '.', ' ') ?> so'm</div>
                        </div>
                        <div class="fav-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-mini">🔖 Hali hech narsa saqlanmagan</div>
        <?php endif; ?>
    </div>

    <div class="divider"></div>

    <!-- Mening haridlarim -->
    <div class="products-section">
        <div class="section-header">
            <div class="section-title" style="margin-bottom:0;">Mening haridlarim</div>
            <?php if (count($haridlar) > 5): ?>
                <a href="<?= Url::to(['site/my-orders']) ?>" class="btn-see-all">Barchasini ko'rish →</a>
            <?php endif; ?>
        </div>

        <?php if (!empty($haridlar)): ?>
            <div class="fav-list">
                <?php foreach (array_slice($haridlar, 0, 5) as $i => $order): ?>
                    <?php
                    $product = $order->product;
                    if (!$product) continue;
                    $images = $product->productImages ?? [];
                    ?>
                    <a href="<?= Url::to(['site/shop', 'id' => $product->id]) ?>"
                        class="fav-item" style="animation-delay: <?= $i * 0.06 ?>s">
                        <div class="fav-icon">
                            <?php if (!empty($images)): ?>
                                <img src="<?= FileUploader::getUrl($images[0]->image) ?>"
                                    alt="" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                            <?php else: ?>
                                <i class="bi bi-bag-check-fill"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="fav-name"><?= Html::encode($product->name ?? 'Noma\'lum tovar') ?></div>
                            <div style="font-size:0.82rem; color:var(--muted); margin:4px 0;">
                                <?= $order->count ?> dona • <?= number_format($product->price ?? 0) ?> so'm
                            </div>
                            <div class="fav-price">
                                Jami: <?= number_format($order->summa ?? 0) ?> so'm
                            </div>
                            <div style="font-size:0.78rem; color:var(--muted); margin-top:6px;">
                                <?= Yii::$app->formatter->asDate($order->created_at, 'php:d.m.Y H:i') ?>
                                • <span style="color: var(--accent);"><?= Html::encode($order->status ?? '—') ?></span>
                            </div>
                        </div>
                        <div class="fav-arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-mini">🛍️ Hozircha hech narsa sotib olinmagan</div>
        <?php endif; ?>
    </div>


    <!-- Edit Profile Modal -->
    <div class="edit-modal-overlay" id="editProfileModal">
        <div class="edit-modal">
            <div class="edit-modal-header">
                <span class="edit-modal-title">Profilni tahrirlash</span>
                <button class="modal-close-btn" onclick="document.getElementById('editProfileModal').classList.remove('active')">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <?php
            $editForm = \yii\widgets\ActiveForm::begin([
                'action' => ['site/update-profile'],
                'method' => 'post',
                'options' => ['style' => 'margin:0'],
            ]); ?>

            <div class="edit-form-group">
                <label class="edit-label"><i class="bi bi-person" style="margin-right:5px;"></i>Foydalanuvchi nomi</label>
                <input type="text" name="User[username]" class="edit-input"
                    value="<?= Html::encode($user->username) ?>"
                    placeholder="Foydalanuvchi nomi...">
            </div>

            <div class="edit-form-group">
                <label class="edit-label"><i class="bi bi-envelope" style="margin-right:5px;"></i>Email</label>
                <input type="email" name="User[email]" class="edit-input"
                    value="<?= Html::encode($user->email) ?>"
                    placeholder="Email manzil...">
            </div>

            <div class="edit-form-group">
                <label class="edit-label">
                    <i class="bi bi-lock" style="margin-right:5px;"></i>Yangi parol
                    <span style="color:var(--muted); font-size:0.7rem; font-weight:400; text-transform:none;">
                        (o'zgartirmasangiz bo'sh qoldiring)
                    </span>
                </label>
                <div class="password-toggle">
                    <input type="password" id="newPassword" name="User[new_password]"
                        class="edit-input" placeholder="Yangi parol..." style="padding-right:44px;">
                    <i class="bi bi-eye toggle-eye" id="togglePass"></i>
                </div>
            </div>

            <div class="edit-form-group">
                <label class="edit-label"><i class="bi bi-lock-fill" style="margin-right:5px;"></i>Parolni tasdiqlash</label>
                <div class="password-toggle">
                    <input type="password" id="confirmPassword" name="User[confirm_password]"
                        class="edit-input" placeholder="Parolni takrorlang..." style="padding-right:44px;">
                    <i class="bi bi-eye toggle-eye" id="toggleConfirm"></i>
                </div>
            </div>

            <div class="edit-modal-footer">
                <button type="button" class="btn-cancel-edit"
                    onclick="document.getElementById('editProfileModal').classList.remove('active')">
                    Bekor
                </button>
                <?= Html::submitButton('<i class="bi bi-check-lg"></i> Saqlash', [
                    'class' => 'btn-save-edit',
                    'encode' => false,
                ]) ?>
            </div>

            <?php \yii\widgets\ActiveForm::end(); ?>
        </div>
    </div>

    <script>
        document.getElementById('editProfileModal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });

        document.getElementById('togglePass').addEventListener('click', function() {
            const input = document.getElementById('newPassword');
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            this.className = 'bi toggle-eye ' + (isText ? 'bi-eye' : 'bi-eye-slash');
        });

        document.getElementById('toggleConfirm').addEventListener('click', function() {
            const input = document.getElementById('confirmPassword');
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            this.className = 'bi toggle-eye ' + (isText ? 'bi-eye' : 'bi-eye-slash');
        });

        document.getElementById('confirmPassword').addEventListener('input', function() {
            const pass = document.getElementById('newPassword').value;
            this.style.borderColor = (this.value && this.value !== pass) ?
                '#ff6584' :
                (this.value === pass && this.value ? 'var(--success)' : 'var(--border)');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>