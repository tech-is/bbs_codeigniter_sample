<body>
<h1>ひと言掲示板 管理ページ（投稿の編集）</h1>
<?php if (!empty($error_message)): ?>
    <ul class="error_message">
        <?php foreach( $error_message as $value ): ?>
            <li>・<?= html_escape($value); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<form method="post" action="<?= base_url("admin/update") ?>">
    <div class="input-wrapper">
        <label for="view_name">表示名</label>
        <input id="view_name" type="text" name="view_name" value="<?= html_escape($message_data['view_name'] ?? "") ?>">
    </div>
    <div class="input-wrapper">
        <label for="message">ひと言メッセージ</label>
        <textarea id="message" name="message"><?= html_escape($message_data['message'] ?? "") ?></textarea>
    </div>
    <a class="btn_cancel" href="<?= base_url("admin") ?>">キャンセル</a>
    <input type="submit" name="btn_submit" value="書き込む">
    <input type="hidden" name="message_id" value="<?= html_escape($message_data['id'] ?? "")?>">
</form>
</body>
</html>