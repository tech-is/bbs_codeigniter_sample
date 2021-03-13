<body>
<h1>ひと言掲示板 管理ページ（投稿の削除）</h1>
<?php if( !empty($error_message) ): ?>
    <ul class="error_message">
        <?php foreach( $error_message as $value ): ?>
            <li>・<?= html_escape($value) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<p class="text-confirm">以下の投稿を削除します。<br>よろしければ「削除」ボタンを押してください。</p>
    <form method="post" action="<?= base_url("admin/delete_bbs") ?>">
        <div class="input-wrapper">
            <label for="view_name">表示名</label>
            <input id="view_name" type="text" name="view_name" value="<?= html_escape($message_data['view_name'] ?? "")?>" disabled>
        </div>
        <div class="input-wrapper">
            <label for="message">ひと言メッセージ</label>
            <textarea id="message" name="message" disabled><?= html_escape($message_data['message'] ?? "") ?></textarea>
        </div>
        <a class="btn_cancel" href="<?= base_url("admin") ?>">キャンセル</a>
        <input type="submit" name="btn_submit" value="削除">
        <input type="hidden" name="message_id" value="<?= html_escape($message_data['id'] ?? "") ?>">
    </form>
</body>
</html>