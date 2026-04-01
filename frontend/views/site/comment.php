<?php

use yii\helpers\Url;

$this->title = 'Comment';
?>

<form action="<?= Url::to(['site/comment', 'product_id' => $product_id]) ?>" method="POST">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="box d-flex">
        <div class="w-100">
            <input type="text" name="Comment[comment]" class="form-control form-control-sm" id="send_input" placeholder="izoh..." required>
        </div>
        <div>
            <button class="btn btn-primary btn-sm"><i class="bi bi-send" id="send_btn"></i></button>
        </div>
    </div>
</form>

<script>
    const sendBtn = document.getElementById('send_btn');
    const sendInput = document.getElementById('send_input');
    const guest = "<?= Yii::$app->user->isGuest ?>";
    sendBtn.addEventListener('click', () => {
        if (guest) {
            alert("Iltimos login qiling");
            return;
        }
    })
    sendInput.addEventListener('input', () => {
        if (guest) {
            sendInput.value = '';
            alert("Iltimos login qiling");
            return;
        }
    })
</script>