<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$users = $dataProvider->getModels();
?>

<link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Fraunces:opsz,wght@9..144,300;400;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ink: #0d0d12;
        --paper: #f5f4f0;
        --paper2: #eceae4;
        --line: #d8d5cd;
        --muted: #9a9589;
        --accent: #2a2aff;
        --accent-dim: rgba(42, 42, 255, .1);
        --success: #1ab87a;
        --success-dim: rgba(26, 184, 122, .1);
        --danger: #e8365d;
        --danger-dim: rgba(232, 54, 93, .1);
        --warn: #f59e0b;
        --warn-dim: rgba(245, 158, 11, .1);
        --mono: 'DM Mono', monospace;
        --serif: 'Fraunces', serif;
    }

    .uw {
        padding: 48px 52px;
        font-family: var(--mono);
        color: var(--ink);
        min-height: 100vh;
        background: var(--paper);
    }

    /* ── Header ── */
    .uw-header {
        display: flex;
        align-items: baseline;
        gap: 16px;
        margin-bottom: 36px;
    }

    .uw-title {
        font-family: var(--serif);
        font-size: 2.4rem;
        font-weight: 700;
        font-style: italic;
        letter-spacing: -1px;
        line-height: 1;
    }

    .uw-count {
        font-family: var(--mono);
        font-size: 0.78rem;
        color: var(--muted);
        background: var(--paper2);
        border: 1px solid var(--line);
        padding: 4px 10px;
        border-radius: 100px;
        letter-spacing: .5px;
    }

    /* ── Table Shell ── */
    .uw-table-wrap {
        border: 1px solid var(--line);
        border-radius: 14px;
        overflow: hidden;
    }

    .uw-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    .uw-table thead {
        background: var(--paper2);
        border-bottom: 1px solid var(--line);
    }

    .uw-table th {
        padding: 12px 20px;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--muted);
        font-weight: 500;
        text-align: left;
    }

    .uw-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--line);
        font-size: 0.82rem;
        vertical-align: middle;
    }

    .uw-table tbody tr:last-child td {
        border-bottom: none;
    }

    .uw-table tbody tr {
        transition: background .15s;
    }

    .uw-table tbody tr:hover {
        background: var(--paper);
    }

    /* ── ID ── */
    .cell-id {
        color: var(--muted);
        font-size: 0.75rem;
    }

    /* ── Username ── */
    .cell-username {
        font-weight: 500;
        letter-spacing: -.2px;
    }

    /* ── Email ── */
    .cell-email {
        color: var(--muted);
        font-size: 0.78rem;
    }

    /* ── Inline Dropdown ── */
    .inline-select {
        appearance: none;
        -webkit-appearance: none;
        border: 1px solid var(--line);
        border-radius: 7px;
        padding: 5px 28px 5px 10px;
        font-family: var(--mono);
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 12px;
        transition: border-color .2s, box-shadow .2s, opacity .2s;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239a9589' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    }

    .inline-select:focus {
        outline: none;
        box-shadow: 0 0 0 3px var(--accent-dim);
        border-color: var(--accent);
    }

    .inline-select:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    /* Role select colors */
    .sel-role-admin {
        background-color: var(--danger-dim);
        border-color: rgba(232, 54, 93, .25);
        color: var(--danger);
    }

    .sel-role-user {
        background-color: var(--success-dim);
        border-color: rgba(26, 184, 122, .25);
        color: var(--success);
    }

    /* Status select colors */
    .sel-status-active {
        background-color: var(--success-dim);
        border-color: rgba(26, 184, 122, .25);
        color: var(--success);
    }

    .sel-status-inactive {
        background-color: var(--danger-dim);
        border-color: rgba(232, 54, 93, .25);
        color: var(--danger);
    }

    /* ── Save indicator ── */
    .save-indicator {
        font-size: 0.68rem;
        color: var(--muted);
        margin-left: 6px;
        opacity: 0;
        transition: opacity .3s;
        vertical-align: middle;
    }

    .save-indicator.saving {
        opacity: 1;
        color: var(--warn);
    }

    .save-indicator.saved {
        opacity: 1;
        color: var(--success);
    }

    .save-indicator.error {
        opacity: 1;
        color: var(--danger);
    }

    /* ── Action btn ── */
    .btn-view {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        border: 1px solid var(--line);
        padding: 6px 14px;
        border-radius: 8px;
        font-family: var(--mono);
        font-size: 0.75rem;
        color: var(--ink);
        text-decoration: none;
        transition: border-color .2s, background .2s;
        white-space: nowrap;
    }

    .btn-view:hover {
        background: var(--ink);
        border-color: var(--ink);
        color: #fff;
    }

    .btn-view svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
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
        font-family: var(--mono);
        font-size: 0.8rem;
        text-decoration: none;
        color: var(--ink);
        border: 1px solid var(--line);
        background: #fff;
        transition: .2s;
    }

    .pager-wrap .page-link:hover {
        background: var(--ink);
        border-color: var(--ink);
        color: #fff;
    }

    .pager-wrap .active .page-link {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    /* ── Toast ── */
    #uw-toast {
        position: fixed;
        bottom: 28px;
        right: 28px;
        background: var(--ink);
        color: #fff;
        font-family: var(--mono);
        font-size: 0.78rem;
        padding: 12px 18px;
        border-radius: 10px;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity .25s, transform .25s;
        pointer-events: none;
        z-index: 999;
        max-width: 280px;
    }

    #uw-toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    #uw-toast.toast-success {
        border-left: 3px solid var(--success);
    }

    #uw-toast.toast-error {
        border-left: 3px solid var(--danger);
    }
</style>

<div class="uw">

    <div class="uw-header">
        <h1 class="uw-title">Foydalanuvchilar</h1>
        <span class="uw-count"><?= $dataProvider->totalCount ?> ta</span>
    </div>

    <div class="uw-table-wrap">
        <table class="uw-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foydalanuvchi</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Status</th>
                    <th>Sana</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr data-user-id="<?= $user->id ?>">

                        <td class="cell-id"><?= $user->id ?></td>

                        <td class="cell-username"><?= Html::encode($user->username) ?></td>

                        <td class="cell-email"><?= Html::encode($user->email) ?></td>

                        <!-- Role dropdown -->
                        <td>
                            <select
                                class="inline-select sel-role-<?= $user->role ?>"
                                data-field="role"
                                data-user-id="<?= $user->id ?>"
                                onchange="updateUser(this)">
                                <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>admin</option>
                                <option value="user" <?= $user->role === 'user'  ? 'selected' : '' ?>>user</option>
                            </select>
                            <span class="save-indicator" id="ind-role-<?= $user->id ?>"></span>
                        </td>

                        <!-- Status dropdown -->
                        <td>
                            <select
                                class="inline-select sel-status-<?= $user->status == 10 ? 'active' : 'inactive' ?>"
                                data-field="status"
                                data-user-id="<?= $user->id ?>"
                                onchange="updateUser(this)">
                                <option value="10" <?= $user->status == 10 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $user->status != 10 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <span class="save-indicator" id="ind-status-<?= $user->id ?>"></span>
                        </td>

                        <td><?= date('d.m.Y', $user->created_at) ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="pager-wrap">
        <?= LinkPager::widget([
            'pagination'     => $dataProvider->pagination,
            'maxButtonCount' => 5,
            'options'        => ['class' => 'pagination'],
            'linkOptions'    => ['class' => 'page-link'],
        ]) ?>
    </div>

</div>

<div id="uw-toast"></div>

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    async function updateUser(select) {
        const userId = select.dataset.userId;
        const field = select.dataset.field;
        const value = select.value;
        const indId = `ind-${field}-${userId}`;
        const ind = document.getElementById(indId);

        /* Style select while saving */
        select.disabled = true;
        ind.textContent = '↻ saqlanmoqda…';
        ind.className = 'save-indicator saving';

        try {
            const res = await fetch('<?= \yii\helpers\Url::to(['/site/update-user']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': CSRF,
                },
                body: JSON.stringify({
                    id: userId,
                    field,
                    value
                }),
            });

            const data = await res.json();

            if (!res.ok || data.success === false) throw new Error(data.message || 'Xatolik');

            if (field === 'role') {
                select.className = `inline-select sel-role-${value}`;
            } else {
                const statusKey = value == 10 ? 'active' : 'inactive';
                select.className = `inline-select sel-status-${statusKey}`;
            }

            ind.textContent = '✓ saqlandi';
            ind.className = 'save-indicator saved';
            showToast(`✓ #${userId} yangilandi`, 'success');

        } catch (err) {
            ind.textContent = '✕ xatolik';
            ind.className = 'save-indicator error';
            showToast(`✕ ${err.message}`, 'error');
        } finally {
            select.disabled = false;
            setTimeout(() => {
                ind.className = 'save-indicator';
            }, 2500);
        }
    }

    let toastTimer;

    function showToast(msg, type = 'success') {
        const toast = document.getElementById('uw-toast');
        toast.textContent = msg;
        toast.className = `show toast-${type}`;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.className = '';
        }, 2800);
    }
</script>