<?php

use common\components\FileUploader;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = "Ko'rilganlar";
?>

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

    /* ── Pagination ── */
    .pager-wrap {
        margin-top: 28px;
        display: flex;
        justify-content: center;
    }

    .pager-wrap .pagination {
        display: flex;
        list-style: none;
        gap: 4px;
        padding: 0;
        margin: 0;
    }

    .pager-wrap .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        font-size: 0.8rem;
        text-decoration: none;
        color: var(--text);
        border: 1px solid var(--border);
        background: var(--surface2);
        transition: .2s;
    }

    .pager-wrap .page-link:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    .pager-wrap .active .page-link {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    /* ═══════════════════════════════════════════════════════
           DROPDOWN STIL  — faqat shu qism qo'shildi, boshqa
           hech narsa o'zgartirilmagan
        ═══════════════════════════════════════════════════════ */

    /* Dropdown bo'lgan products-grid alohida nav satri */
    .products-grid:has(.dropdown) {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 24px 48px 0;
        background: transparent;
    }

    /* Trigger tugma */
    .products-grid .btn.btn-secondary.dropdown-toggle {
        background: var(--surface2) !important;
        border: 1px solid var(--border) !important;
        color: var(--muted) !important;
        box-shadow: none !important;

        font-family: 'Syne', sans-serif;
        font-weight: 600;
        font-size: 0.74rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 9px 18px;
        border-radius: 10px;
        transition: background .2s, border-color .2s, color .2s, transform .15s, box-shadow .2s;
        white-space: nowrap;
    }

    .products-grid .btn.btn-secondary.dropdown-toggle:hover,
    .products-grid .btn.btn-secondary.dropdown-toggle.show {
        background: var(--accent) !important;
        border-color: var(--accent) !important;
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 99, 255, .4) !important;
    }

    .products-grid .btn.btn-secondary.dropdown-toggle::after {
        border-top-color: currentColor;
        opacity: .55;
        margin-left: 8px;
        vertical-align: .2em;
    }

    /* Panel */
    .products-grid .dropdown-menu {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .55), 0 0 0 1px rgba(108, 99, 255, .08);
        padding: 8px;
        min-width: 220px;
        margin-top: 10px !important;
        animation: ddPanelIn .22s ease both;
    }

    @keyframes ddPanelIn {
        from {
            opacity: 0;
            transform: translateY(-8px) scale(.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* SubCategory li */
    .products-grid .dropdown-menu>li {
        display: flex;
        flex-direction: column;
        position: relative;
        background: rgba(255, 255, 255, .025);
        border-radius: 10px;
        margin-bottom: 4px;
        padding: 28px 6px 6px 12px;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.67rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        overflow: hidden;
    }

    .products-grid .dropdown-menu>li:last-child {
        margin-bottom: 0;
    }

    /* header strip */
    .products-grid .dropdown-menu>li::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 26px;
        background: rgba(108, 99, 255, .08);
        border-radius: 10px 10px 0 0;
    }

    /* accent dot */
    .products-grid .dropdown-menu>li::after {
        content: '';
        position: absolute;
        top: 10px;
        left: 12px;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--accent);
        box-shadow: 0 0 8px var(--accent);
    }

    /* SubSubCategory links */
    .products-grid .dropdown-menu .dropdown-item {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 400;
        color: var(--text);
        border-radius: 8px;
        padding: 8px 12px 8px 14px;
        background: transparent;
        position: relative;
        transition: background .15s, color .15s, padding-left .15s;
    }

    .products-grid .dropdown-menu .dropdown-item:hover,
    .products-grid .dropdown-menu .dropdown-item:focus {
        background: rgba(108, 99, 255, .15);
        color: var(--accent);
        padding-left: 22px;
    }

    .products-grid .dropdown-menu .dropdown-item::before {
        content: '›';
        position: absolute;
        left: 8px;
        font-size: 1.1rem;
        line-height: 1.4;
        color: var(--accent);
        opacity: 0;
        transition: opacity .15s;
    }

    .products-grid .dropdown-menu .dropdown-item:hover::before {
        opacity: 1;
    }
</style>

<div class="col-lg-10">
    <div class="products-grid">
        <?php foreach ($products as $i => $product): ?>
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
                    <?php if ($product->oneKorzinka()): ?>
                        <button class="btn-cart in-cart xarid_btn" data-id="<?= $product->id ?>" data-in-cart="1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                            </svg>
                            <?= Yii::t('app', 'basket') ?> ✓
                        </button>
                    <?php else: ?>
                        <button class="btn-cart btn_guest" data-id="<?= $product->id ?>" data-in-cart="0">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                            </svg>
                            Tez orada saytimizda
                        </button>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <button class="btn-wishlist favourite_btn btn-favourites" title="Sevimlilarga qo'shish">♡</button>
                    <?php else: ?>
                        <?php if ($product->isFavourite()): ?>
                            <button class="btn-wishlist active favourite_btn" data-id="<?= $product->id ?>" data-fav="1" title="Sevimlilarda bor">♥</button>
                        <?php else: ?>
                            <button class="btn-wishlist favourite_btn" data-id="<?= $product->id ?>" data-fav="0" title="Sevimlilarga qo'shish">♡</button>
                        <?php endif; ?>
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
                </div>

            </div>
        <?php endforeach; ?>

        <?php if (empty($products)): ?>
            <div class="empty-state">
                <div class="icon">📭</div>
                <p>Ko'rilgan mahsulotlar yo'q</p>
            </div>
        <?php endif; ?>
    </div>
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
                    btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> Savatda ✓`;
                    btn.classList.add('in-cart');
                    btn.dataset.inCart = '1';
                } else {
                    alert(data.message || 'Xatolik yuz berdi');
                }
            })
            .catch(() => alert('Server bilan bog\'lanishda xatolik'));
    });

    document.querySelectorAll('.btn_guest').forEach((guest) => {
        guest.addEventListener('click', () => {
            alert("Mahsulot sotuvda mavjud emas")
            return;
        })
    })

    document.querySelectorAll('.btn-favourites').forEach((guest) => {
        guest.addEventListener('click', () => {
            alert("Avval login qiling")
            return
        })
    })

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.favourite_btn');
        if (!btn) return;
        e.preventDefault();
        const productId = btn.dataset.id;
        if (!productId) {
            return;
        }
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