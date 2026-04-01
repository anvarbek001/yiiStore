<?php

use common\components\FileUploader;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Aksiyalar";
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
        margin-bottom: 10px;
    }

    /* Scroll tugmalar */
    .scroll-row {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 4px 2px 12px;
        scrollbar-width: none;
    }

    .scroll-row::-webkit-scrollbar {
        display: none;
    }

    .cat-btn {
        white-space: nowrap;
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        color: #333;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .cat-btn:hover {
        background: #1D9E75;
        border-color: #1D9E75;
        color: #fff;
    }

    .cat-btn:hover .cat-badge {
        background: rgba(255, 255, 255, 0.3);
    }

    .cat-badge {
        background: #D85A30;
        color: #fff;
        font-size: 11px;
        font-weight: 500;
        border-radius: 10px;
        padding: 1px 7px;
        min-width: 20px;
        text-align: center;
    }

    .divider {
        border: none;
        border-top: 1px solid #eee;
        margin: 1.2rem 0;
    }

    /* Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 16px;
    }

    /* Kartochka */
    .product-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #eee;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .product-card:hover {
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

    .discount-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #D85A30;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        border-radius: 6px;
        padding: 3px 9px;
        z-index: 10;
    }

    .no-image-box {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
        background: #f5f5f5;
    }

    .carousel-inner {
        height: 180px;
    }

    .carousel-item {
        height: 180px;
    }

    .carousel-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }

    .carousel-indicators {
        bottom: 6px;
        margin: 0;
    }

    .carousel-indicators button {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: none;
    }

    .carousel-indicators button.active {
        background: #fff;
    }

    /* Body */
    .card-body-inner {
        padding: 12px 14px 14px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
    }

    .card-name {
        font-size: 14px;
        font-weight: 500;
        color: #222;
        line-height: 1.35;
    }

    .card-prices {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .price-new {
        font-size: 16px;
        font-weight: 600;
        color: #0F6E56;
    }

    .price-old {
        font-size: 13px;
        color: #bbb;
        text-decoration: line-through;
    }

    .card-footer-row {
        margin-top: auto;
        padding-top: 8px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-cat-label {
        font-size: 12px;
        color: #aaa;
    }

    .foiz-pill {
        font-size: 12px;
        font-weight: 600;
        background: #fff3ee;
        color: #D85A30;
        border-radius: 20px;
        padding: 3px 10px;
    }

    /* Flash */
    .flash-success {
        background: #eafaf3;
        border: 1px solid #9FE1CB;
        color: #0F6E56;
        border-radius: 8px;
        padding: 10px 16px;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .flash-error {
        background: #fff0ed;
        border: 1px solid #F5C4B3;
        color: #993C1D;
        border-radius: 8px;
        padding: 10px 16px;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    /* Modal */
    .modal-content {
        border-radius: 12px;
        border: 1px solid #eee;
    }

    .modal-header {
        border-bottom: 1px solid #f0f0f0;
        padding: 14px 18px;
    }

    .modal-footer {
        border-top: 1px solid #f0f0f0;
        padding: 12px 18px;
    }

    .modal-title {
        font-size: 15px;
        font-weight: 500;
    }

    .preview-price {
        font-size: 18px;
        font-weight: 600;
        color: #0F6E56;
        margin-top: 6px;
    }

    .preview-label {
        font-size: 12px;
        color: #aaa;
        margin-bottom: 2px;
    }

    .btn-save-green {
        padding: 8px 20px;
        border-radius: 8px;
        border: none;
        background: #1D9E75;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-save-green:hover {
        background: #0F6E56;
    }

    /* Bo'sh holat */
    .empty-state {
        grid-column: 1 / -1;
        padding: 3rem;
        text-align: center;
        color: #bbb;
        font-size: 15px;
    }
</style>

<div class="page-wrap container">

    <!-- Kategoriya tugmalari -->
    <p class="section-label">Kategoriyalar bo'yicha chegirma berish</p>
    <div class="scroll-row">
        <?php foreach ($items as $item): ?>
            <?php
            $productCount = count($item->products);
            if ($productCount === 0) continue;
            ?>
            <button
                type="button"
                class="cat-btn"
                data-bs-toggle="modal"
                data-bs-target="#modal-cat-<?= $item->id ?>">
                <?= Html::encode($item->name) ?>
                <span class="cat-badge"><?= $productCount ?></span>
            </button>
        <?php endforeach; ?>
    </div>

    <hr class="divider">
    <?php if (count($blogs)): ?>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#modalEdit">Tahrirlash</button>
            <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#modalDelete">O'chirish</button>
        </div>
    <?php endif; ?>
    <!-- Chegirma edit modal -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Aksiyani tahrirlash</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= Url::to(['site/edit-chegirma']) ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                        <div class="mb-2">
                            <label class="form-label">Tahrirlanadigan aksiya kategoriyasi</label>
                            <select name="sub_sub_category_id" class="form-select">
                                <?php foreach ($items as $item): ?>
                                    <?php
                                    $productCount = count($item->products);
                                    if ($productCount === 0) continue;
                                    ?>
                                    <option value="<?= $item->id ?>"><?= Html::encode($item->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">
                                Chegirma foizi
                            </label>
                            <input type="number" class="form-control" name="chegirma_foiz" placeholder="%" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Orqaga</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Chegirma delete modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Aksiyani O'chirish</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= Url::to(['site/delete-chegirma']) ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                        <div class="mb-2">
                            <label class="form-label">O'chiriladigan aksiya kategoriyasi</label>
                            <select name="sub_sub_category_id" class="form-select">
                                <?php foreach ($items as $item): ?>
                                    <?php
                                    $productCount = count($item->products);
                                    if ($productCount === 0) continue;
                                    ?>
                                    <option value="<?= $item->id ?>"><?= Html::encode($item->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Orqaga</button>
                        <button type="submit" class="btn btn-primary">O'chirish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <hr class="divider">

    <!-- Chegirma berilgan mahsulotlar -->
    <p class="section-label">
        Aksiyalar
        <?php if (!empty($blogs)): ?>
            <span style="color:#1D9E75; font-size:11px; font-weight:500; margin-left:6px;">
                <?= count($blogs) ?> ta mahsulot
            </span>
        <?php endif; ?>
    </p>

    <div class="products-grid">
        <?php if (empty($blogs)): ?>
            <div class="empty-state">
                Hali hech qanday aksiya yo'q.<br>
                <span style="font-size:13px;">Kategoriyani tanlang va chegirma bering.</span>
            </div>
        <?php else: ?>
            <?php foreach ($blogs as $blog): ?>
                <?php
                $product  = $blog->product;
                if (!$product) continue;
                $discount = $blog->chegirma_foiz;
                $oldPrice = $product->price;
                $newPrice = $blog->discount_price; // bazadan tayyor
                $images   = $product->productImages;
                $catName  = $product->subSubCategory->name ?? '';
                ?>
                <div class="product-card">

                    <!-- Rasm -->
                    <div class="card-img-wrap">
                        <div class="discount-badge">-<?= $discount ?>%</div>

                        <?php if (!empty($images)): ?>
                            <div id="car-<?= $blog->id ?>" class="carousel slide" data-bs-ride="false">

                                <?php if (count($images) > 1): ?>
                                    <div class="carousel-indicators">
                                        <?php foreach ($images as $i => $img): ?>
                                            <button
                                                type="button"
                                                data-bs-target="#car-<?= $blog->id ?>"
                                                data-bs-slide-to="<?= $i ?>"
                                                <?= $i === 0 ? 'class="active"' : '' ?>>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="carousel-inner">
                                    <?php foreach ($images as $i => $img): ?>
                                        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                            <img
                                                src="<?= Html::encode(FileUploader::getUrl($img->image)) ?>"
                                                alt="<?= Html::encode($product->name) ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <?php if (count($images) > 1): ?>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#car-<?= $blog->id ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#car-<?= $blog->id ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                <?php endif; ?>

                            </div>
                        <?php else: ?>
                            <div class="no-image-box">📦</div>
                        <?php endif; ?>
                    </div>

                    <!-- Karta ma'lumotlari -->
                    <div class="card-body-inner">
                        <div class="card-name"><?= Html::encode($product->name) ?></div>

                        <div class="card-prices">
                            <span class="price-new">
                                <?= number_format($newPrice, 0, '.', ' ') ?> so'm
                            </span>
                            <span class="price-old">
                                <?= number_format($oldPrice, 0, '.', ' ') ?> so'm
                            </span>
                        </div>

                        <div class="card-footer-row">
                            <span class="card-cat-label"><?= Html::encode($catName) ?></span>
                            <span class="foiz-pill">-<?= $discount ?>%</span>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<!-- Kategoriya modallari -->
<?php foreach ($items as $item): ?>
    <?php if (count($item->products) === 0) continue; ?>
    <div class="modal fade" id="modal-cat-<?= $item->id ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width:360px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= Html::encode($item->name) ?>
                        <span style="font-size:13px; color:#aaa; font-weight:400;">
                            — <?= count($item->products) ?> ta mahsulot
                        </span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post" action="<?= Url::to(['site/chegirma']) ?>">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                    <?= Html::hiddenInput('sub_sub_category_id', $item->id) ?>

                    <div class="modal-body">
                        <label class="form-label" style="font-size:13px; color:#888;">
                            Chegirma foizi (%)
                        </label>
                        <input
                            type="number"
                            name="chegirma_foiz"
                            class="form-control"
                            min="0" max="100"
                            placeholder="Masalan: 15"
                            id="disc-input-<?= $item->id ?>"
                            oninput="previewPrices(this, <?= $item->id ?>)">

                        <!-- Narx preview -->
                        <?php if (!empty($item->products)): ?>
                            <div style="margin-top:14px; display:flex; flex-direction:column; gap:8px;" id="preview-<?= $item->id ?>">
                                <?php foreach (array_slice($item->products, 0, 3) as $p): ?>
                                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:13px;">
                                        <span style="color:#555; max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                            <?= Html::encode($p->name) ?>
                                        </span>
                                        <span>
                                            <span style="color:#bbb; text-decoration:line-through; margin-right:4px;"
                                                id="old-<?= $item->id ?>-<?= $p->id ?>">
                                                <?= number_format($p->price, 0, '.', ' ') ?>
                                            </span>
                                            <span style="color:#0F6E56; font-weight:600;"
                                                id="new-<?= $item->id ?>-<?= $p->id ?>"
                                                data-price="<?= $p->price ?>">
                                                <?= number_format($p->price, 0, '.', ' ') ?> so'm
                                            </span>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (count($item->products) > 3): ?>
                                    <div style="font-size:12px; color:#bbb;">
                                        va yana <?= count($item->products) - 3 ?> ta mahsulot...
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="modal-footer" style="justify-content:space-between;">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                            Bekor qilish
                        </button>
                        <button type="submit" class="btn-save-green">
                            <?= count($item->products) ?> ta mahsulotga saqlash
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function previewPrices(input, catId) {
        const disc = Math.min(100, Math.max(0, parseFloat(input.value) || 0));
        const newEls = document.querySelectorAll('[id^="new-' + catId + '-"]');
        newEls.forEach(function(el) {
            const base = parseFloat(el.dataset.price);
            const newP = Math.round(base * (1 - disc / 100));
            el.textContent = newP.toLocaleString('uz-UZ') + " so'm";
        });
    }
</script>