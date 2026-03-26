<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saqlangan productlar</title>
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

        /* Header */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 48px 48px 32px;
            border-bottom: 1px solid var(--border);
        }

        .page-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #fff 40%, var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header .count {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .page-header .count b {
            color: var(--accent2);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 10px 20px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            transition: color .2s, border-color .2s;
        }

        .back-btn:hover {
            color: var(--accent);
            border-color: var(--accent);
        }

        /* Grid */
        .saved-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            padding: 40px 48px;
        }

        @media (max-width: 768px) {
            .saved-grid {
                padding: 24px 20px;
            }

            .page-header {
                padding: 32px 20px 24px;
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }
        }

        /* Card */
        .saved-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: transform .25s, border-color .25s, box-shadow .25s;
            animation: fadeUp .4s ease both;
            position: relative;
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

        .saved-card:hover {
            transform: translateY(-6px);
            border-color: var(--accent2);
            box-shadow: 0 12px 40px rgba(255, 101, 132, .15);
        }

        /* Remove button */
        .btn-remove {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 10;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255, 101, 132, .15);
            border: 1px solid rgba(255, 101, 132, .3);
            color: var(--accent2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background .2s, transform .2s;
            text-decoration: none;
        }

        .btn-remove:hover {
            background: var(--accent2);
            color: #fff;
            transform: scale(1.1);
        }

        /* Image */
        .card-img-wrap {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .saved-card:hover .card-img-wrap img {
            transform: scale(1.05);
        }

        .no-img {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            background: var(--surface2);
        }

        /* Bookmark ribbon */
        .bookmark-ribbon {
            position: absolute;
            top: 0;
            left: 18px;
            width: 28px;
            height: 36px;
            background: var(--accent2);
            clip-path: polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.75rem;
        }

        /* Body */
        .card-body {
            padding: 18px 20px;
        }

        .card-meta {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
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
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-desc {
            font-size: 0.83rem;
            color: var(--muted);
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Footer */
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

        .btn-view {
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

        .btn-view:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* Empty */
        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 100px 20px;
            color: var(--muted);
        }

        .empty-state .icon {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: .4;
        }

        .empty-state h3 {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 0.9rem;
            margin-bottom: 28px;
        }

        .btn-browse {
            display: inline-block;
            background: var(--accent);
            color: #fff;
            padding: 12px 28px;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(108, 99, 255, .35);
            transition: transform .2s, box-shadow .2s;
        }

        .btn-browse:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(108, 99, 255, .5);
            color: #fff;
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
    </style>
</head>

<body>

    <?php

    use common\components\FileUploader;
    use yii\helpers\Html;
    use yii\helpers\Url;

    ?>

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>♥ Saqlangan</h1>
            <div class="count">Jami <b><?= count($saved) ?></b> ta product saqlangan</div>
        </div>
        <a href="<?= \yii\helpers\Url::to(['site/index']) ?>" class="back-btn">
            ← Bosh sahifa
        </a>
    </div>

    <!-- Grid -->
    <div class="saved-grid">
        <?php if (!empty($saved)): ?>
            <?php foreach ($saved as $i => $product): ?>
                <?php $images = $product->productImages; ?>
                <div class="saved-card" style="animation-delay: <?= $i * 0.06 ?>s">

                    <!-- Bookmark ribbon -->
                    <div class="bookmark-ribbon"><i class="bi bi-bookmark-fill"></i></div>

                    <!-- O'chirish tugmasi -->
                    <?= Html::a(
                        '<i class="bi bi-x"></i>',
                        ['site/remove-favourite', 'product_id' => $product->id],
                        [
                            'class' => 'btn-remove',
                            'encode' => false,
                            'data-confirm' => 'Saqlangandan o\'chirasizmi?',
                            'data-method' => 'post',
                            'title' => 'O\'chirish',
                        ]
                    ) ?>

                    <!-- Rasm -->
                    <div class="card-img-wrap">
                        <?php if (!empty($images)): ?>
                            <img src="<?= FileUploader::getUrl($images[0]->image) ?>"
                                alt="<?= Html::encode($product->name) ?>">
                        <?php else: ?>
                            <div class="no-img">📦</div>
                        <?php endif; ?>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="card-meta">
                            <span class="badge badge-cat"><?= Html::encode($product->category->name) ?></span>
                            <span class="badge badge-subcat"><?= Html::encode($product->subcategory->name) ?></span>
                        </div>
                        <div class="card-title"><?= Html::encode($product->name) ?></div>
                        <?php if ($product->description): ?>
                            <p class="card-desc"><?= Html::encode($product->description) ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Korzinka + Sevimlilar tugmalari -->
                    <div class="card-actions">

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

                        <!-- Sevimlilar tugmasi -->
                        <?php if ($product->isFavourite()): ?>
                            <!-- Allaqachon sevimli -->
                            <button class="btn-wishlist active favourite_btn" data-id="<?= $product->id ?>" data-fav="1" title="Sevimlilarda bor">
                                ♥
                            </button>
                        <?php else: ?>
                            <!-- Sevimlilarga qo'shish -->
                            <!-- <button class="btn-wishlist favourite_btn" data-id="<?= $product->id ?>" data-fav="0" title="Sevimlilarga qo'shish">
                            ♡
                        </button> -->
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
                        <?= Html::a('Ko\'rish →', ['site/shop', 'id' => $product->id], ['class' => 'btn-view']) ?>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="empty-state">
                <div class="icon">🔖</div>
                <h3>Hali hech narsa saqlanmagan</h3>
                <p>Yoqtirgan productlaringizni shu yerda saqlang</p>
                <?= Html::a('Productlarni ko\'rish', ['site/index'], ['class' => 'btn-browse']) ?>
            </div>
        <?php endif; ?>
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
                            // Sevimlilarga qo'shildi
                            btn.textContent = '♥';
                            btn.classList.add('active');
                            btn.dataset.fav = '1';
                            btn.title = 'Sevimlilarda bor';
                        } else {
                            // Sevimlillardan olib tashlandi
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
</body>

</html>