<?php

/** @var yii\web\View $this */
/** @var common\models\Category[] $categories */
/** @var common\models\Category $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Kategoriyalar';
?>
<style>
    .cat-tree {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* === LEVEL 0: Kategoriya === */
    .l0-card {
        background: #fff;
        border-radius: 14px;
        border: 1.5px solid #e5e7eb;
        overflow: hidden;
    }

    .l0-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 16px;
        cursor: pointer;
        user-select: none;
        transition: background .15s;
    }

    .l0-header:hover {
        background: #f9fafb;
    }

    .l0-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #ede9fe;
        color: #7c3aed;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .l0-name {
        font-size: 15px;
        font-weight: 700;
        color: #111;
    }

    .badge-l0 {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .7px;
        text-transform: uppercase;
        color: #7c3aed;
        background: #ede9fe;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .l0-body {
        border-top: 1.5px solid #f0f0f0;
        padding: 12px 16px;
        background: #fafafa;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    /* === LEVEL 1: Subkategoriya === */
    .l1-card {
        background: #fff;
        border-radius: 10px;
        border: 1.5px solid #e0f2fe;
        overflow: hidden;
    }

    .l1-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 13px;
        cursor: pointer;
        transition: background .15s;
    }

    .l1-header:hover {
        background: #f0f9ff;
    }

    .l1-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: #e0f2fe;
        color: #0284c7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }

    .l1-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .badge-l1 {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .7px;
        text-transform: uppercase;
        color: #0284c7;
        background: #e0f2fe;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .l1-body {
        border-top: 1.5px solid #e0f2fe;
        padding: 10px 13px;
        background: #f8fbff;
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    /* === LEVEL 2: Sub-subkategoriya === */
    .l2-card {
        background: #fff;
        border-radius: 8px;
        border: 1.5px solid #d1fae5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 11px;
        transition: background .15s;
    }

    .l2-card:hover {
        background: #f0fdf4;
    }

    .l2-icon {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: #d1fae5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .l2-name {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }

    .badge-l2 {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .7px;
        text-transform: uppercase;
        color: #059669;
        background: #d1fae5;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* === ADD BUTTON === */
    .add-row {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 8px;
        border: 1.5px dashed #d1d5db;
        color: #9ca3af;
        font-size: 13px;
        cursor: pointer;
        transition: all .15s;
        background: transparent;
        width: 100%;
        text-align: left;
    }

    .add-row:hover {
        border-color: #7c3aed;
        color: #7c3aed;
        background: #faf5ff;
    }

    .add-row.blue:hover {
        border-color: #0284c7;
        color: #0284c7;
        background: #f0f9ff;
    }

    .add-row.green:hover {
        border-color: #059669;
        color: #059669;
        background: #f0fdf4;
    }

    /* === ACTION BUTTONS === */
    .btn-edit {
        padding: 4px 8px;
        border-radius: 6px;
        border: 1.5px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        font-size: 12px;
        cursor: pointer;
        transition: all .15s;
        line-height: 1;
    }

    .btn-edit:hover {
        border-color: #7c3aed;
        color: #7c3aed;
    }

    .btn-del {
        padding: 4px 8px;
        border-radius: 6px;
        border: 1.5px solid #fecaca;
        background: #fff;
        color: #ef4444;
        font-size: 12px;
        cursor: pointer;
        transition: all .15s;
        line-height: 1;
    }

    .btn-del:hover {
        background: #fef2f2;
    }

    /* === CHEVRON === */
    .chevron {
        font-size: 11px;
        color: #9ca3af;
        transition: transform .2s;
        display: inline-block;
    }

    .hdr-open .chevron {
        transform: rotate(180deg);
    }

    /* === MODAL === */
    .modal-content {
        border-radius: 16px !important;
        border: 0 !important;
    }

    /* === TOP BAR === */
    .page-topbar {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 16px;
    }

    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #111;
        margin: 0;
    }

    .page-sub {
        font-size: 13px;
        color: #6b7280;
        margin: 3px 0 6px;
    }

    .bc-trail {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
    }

    .bc-trail span {
        padding: 2px 9px;
        border-radius: 20px;
        font-weight: 600;
    }
</style>

<!-- TOP BAR -->
<div class="page-topbar">
    <div>
        <h1 class="page-title">Kategoriyalar</h1>
        <p class="page-sub">Mahsulotlar alohida bo'limdan qo'shiladi</p>
        <div class="bc-trail">
            <span style="background:#ede9fe;color:#7c3aed;">📂 Kategoriya</span>
            <span style="color:#d1d5db;">›</span>
            <span style="background:#e0f2fe;color:#0284c7;">📁 Subkategoriya</span>
            <span style="color:#d1d5db;">›</span>
            <span style="background:#d1fae5;color:#059669;">🗂️ Sub-subkategoriya</span>
            <span style="color:#d1d5db;">›</span>
            <span style="background:#fef3c7;color:#d97706;">📦 Mahsulot (alohida)</span>
        </div>
    </div>
    <button class="btn btn-primary fw-semibold px-4" style="border-radius:10px;white-space:nowrap;"
        data-bs-toggle="modal" data-bs-target="#modal_addCategory">
        + Kategoriya
    </button>
</div>

<?php if (empty($categories)): ?>
    <div class="text-center py-5 text-muted">
        <div style="font-size:48px;">📭</div>
        <p class="mt-2">Hali kategoriya qo'shilmagan</p>
    </div>
<?php else: ?>

    <div class="cat-tree">
        <?php foreach ($categories as $category):
            $subCategories = $category->subCategories ?? [];
        ?>

            <!-- ══ LEVEL 0: Kategoriya ══ -->
            <div class="l0-card">
                <div class="l0-header" data-bs-toggle="collapse"
                    data-bs-target="#collapse_category_<?= $category->id ?>">
                    <div class="d-flex align-items-center gap-3">
                        <div class="l0-icon">📂</div>
                        <div>
                            <div class="badge-l0 mb-1">Kategoriya</div>
                            <div class="l0-name"><?= Html::encode($category->name) ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted" style="font-size:12px;"><?= count($subCategories) ?> ta</span>
                        <button class="btn-edit"
                            data-bs-toggle="modal"
                            data-bs-target="#modal_editCategory_<?= $category->id ?>"
                            onclick="event.stopPropagation()">✏️</button>
                        <form method="post"
                            action="<?= Url::to(['category/delete', 'id' => $category->id]) ?>"
                            style="display:inline"
                            onclick="event.stopPropagation()">
                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                            <button type="submit" class="btn-del"
                                onclick="event.stopPropagation(); return confirm('O\'chirishni tasdiqlaysizmi?')">🗑️</button>
                        </form>
                        <span class="chevron">▼</span>
                    </div>
                </div>

                <div class="collapse" id="collapse_category_<?= $category->id ?>">
                    <div class="l0-body">

                        <?php foreach ($subCategories as $subCategory):
                            $subSubCategories = $subCategory->subSubCategories ?? [];
                        ?>
                            <!-- ── LEVEL 1: Subkategoriya ── -->
                            <div class="l1-card">
                                <div class="l1-header" data-bs-toggle="collapse"
                                    data-bs-target="#collapse_subCategory_<?= $subCategory->id ?>">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="l1-icon">📁</div>
                                        <div>
                                            <div class="badge-l1 mb-1">Subkategoriya</div>
                                            <div class="l1-name"><?= Html::encode($subCategory->name) ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted" style="font-size:12px;"><?= count($subSubCategories) ?> ta</span>
                                        <button class="btn-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal_editSubCategory_<?= $subCategory->id ?>"
                                            onclick="event.stopPropagation()">✏️</button>
                                        <form method="post"
                                            action="<?= Url::to(['sub-category/delete', 'id' => $subCategory->id]) ?>"
                                            style="display:inline"
                                            onclick="event.stopPropagation()">
                                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                                            <button type="submit" class="btn-del"
                                                onclick="event.stopPropagation(); return confirm('O\'chirishni tasdiqlaysizmi?')">🗑️</button>
                                        </form>
                                        <span class="chevron">▼</span>
                                    </div>
                                </div>

                                <div class="collapse" id="collapse_subCategory_<?= $subCategory->id ?>">
                                    <div class="l1-body">

                                        <?php foreach ($subSubCategories as $subSubCategory): ?>
                                            <!-- · LEVEL 2: Sub-subkategoriya · -->
                                            <div class="l2-card">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="l2-icon">🗂️</div>
                                                    <div>
                                                        <div class="badge-l2 mb-1">Sub-subkategoriya</div>
                                                        <div class="l2-name"><?= Html::encode($subSubCategory->name) ?></div>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn-edit"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_editSubSubCategory_<?= $subSubCategory->id ?>">✏️</button>
                                                    <form method="post"
                                                        action="<?= Url::to(['sub-category/sub-sub-delete', 'id' => $subSubCategory->id]) ?>"
                                                        style="display:inline">
                                                        <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                                                        <button type="submit" class="btn-del"
                                                            onclick="return confirm('O\'chirishni tasdiqlaysizmi?')">🗑️</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Edit Modal: subSubCategory -->
                                            <div class="modal fade" id="modal_editSubSubCategory_<?= $subSubCategory->id ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content shadow">
                                                        <div class="modal-header border-0 px-4 pt-4 pb-0">
                                                            <h5 class="modal-title fw-bold">🗂️ Sub-subkategoriyani tahrirlash</h5>
                                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="post" action="<?= Url::to(['sub-category/sub-sub-update', 'id' => $subSubCategory->id]) ?>">
                                                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                                                            <div class="modal-body px-4 py-3">
                                                                <div class="mb-0">
                                                                    <label class="form-label fw-semibold">Nomi</label>
                                                                    <input type="text" name="SubSubCategory[name]"
                                                                        value="<?= Html::encode($subSubCategory->name) ?>"
                                                                        class="form-control form-control-lg"
                                                                        style="border-radius:10px" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                                                                <button type="submit" class="btn btn-success px-4 fw-semibold">Saqlash</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <!-- Add sub-subkategoriya -->
                                        <button class="add-row green"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal_addSubSubCategory_<?= $subCategory->id ?>">
                                            <span>＋</span> Sub-subkategoriya qo'shish
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal: subCategory -->
                            <div class="modal fade" id="modal_editSubCategory_<?= $subCategory->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow">
                                        <div class="modal-header border-0 px-4 pt-4 pb-0">
                                            <h5 class="modal-title fw-bold">📁 Subkategoriyani tahrirlash</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="post" action="<?= Url::to(['sub-category/update', 'id' => $subCategory->id]) ?>">
                                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                                            <div class="modal-body px-4 py-3">
                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold">Nomi</label>
                                                    <input type="text" name="SubCategory[name]"
                                                        value="<?= Html::encode($subCategory->name) ?>"
                                                        class="form-control form-control-lg"
                                                        style="border-radius:10px" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                                                <button type="submit" class="btn btn-primary px-4 fw-semibold">Saqlash</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Modal: subSubCategory (parent = subCategory) -->
                            <div class="modal fade" id="modal_addSubSubCategory_<?= $subCategory->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow">
                                        <div class="modal-header border-0 px-4 pt-4 pb-0">
                                            <h5 class="modal-title fw-bold">🗂️ Yangi Sub-subkategoriya</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="post" action="<?= Url::to(['sub-category/sub-create']) ?>">
                                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                                            <div class="modal-body px-4 py-3">
                                                <input type="hidden" name="SubSubCategory[category_id]" value="<?= $subCategory->category_id ?>">
                                                <input type="hidden" name="SubSubCategory[sub_category_id]" value="<?= $subCategory->id ?>">
                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold">Nomi</label>
                                                    <input type="text" name="SubSubCategory[name]"
                                                        class="form-control form-control-lg"
                                                        style="border-radius:10px"
                                                        placeholder="Sub-subkategoriya nomi..." required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                                                <button type="submit" class="btn btn-success px-4 fw-semibold">Qo'shish</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Add subkategoriya -->
                        <button class="add-row blue"
                            data-bs-toggle="modal"
                            data-bs-target="#modal_addSubCategory_<?= $category->id ?>">
                            <span>＋</span> Subkategoriya qo'shish
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit Modal: category -->
            <div class="modal fade" id="modal_editCategory_<?= $category->id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow">
                        <div class="modal-header border-0 px-4 pt-4 pb-0">
                            <h5 class="modal-title fw-bold">📂 Kategoriyani tahrirlash</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="<?= Url::to(['category/update', 'id' => $category->id]) ?>">
                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                            <div class="modal-body px-4 py-3">
                                <div class="mb-0">
                                    <label class="form-label fw-semibold">Nomi</label>
                                    <input type="text" name="Category[name]"
                                        value="<?= Html::encode($category->name) ?>"
                                        class="form-control form-control-lg"
                                        style="border-radius:10px" required>
                                </div>
                            </div>
                            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Modal: subCategory (parent = category) -->
            <div class="modal fade" id="modal_addSubCategory_<?= $category->id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow">
                        <div class="modal-header border-0 px-4 pt-4 pb-0">
                            <h5 class="modal-title fw-bold">📁 Yangi Subkategoriya</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="<?= Url::to(['sub-category/create']) ?>">
                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                            <div class="modal-body px-4 py-3">
                                <input type="hidden" name="SubCategory[category_id]" value="<?= $category->id ?>">
                                <div class="mb-0">
                                    <label class="form-label fw-semibold">Nomi</label>
                                    <input type="text" name="SubCategory[name]"
                                        class="form-control form-control-lg"
                                        style="border-radius:10px"
                                        placeholder="Subkategoriya nomi..." required>
                                </div>
                            </div>
                            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">Qo'shish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Add Root Category Modal -->
<div class="modal fade" id="modal_addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold">📂 Yangi Kategoriya</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= Url::to(['site/index']) ?>">
                <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                <div class="modal-body px-4 py-3">
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Kategoriya nomi</label>
                        <input type="text" name="Category[name]"
                            class="form-control form-control-lg"
                            style="border-radius:10px"
                            placeholder="Masalan: Elektronika, Kiyim..." required>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">Qo'shish</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('show.bs.collapse', e => {
        const t = document.querySelector('[data-bs-target="#' + e.target.id + '"]');
        if (t) t.classList.add('hdr-open');
    });
    document.addEventListener('hide.bs.collapse', e => {
        const t = document.querySelector('[data-bs-target="#' + e.target.id + '"]');
        if (t) t.classList.remove('hdr-open');
    });
</script>