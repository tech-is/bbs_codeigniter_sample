
<body>
    <h1>ひと言掲示板 管理ページ</h1>
    <?php if (!empty($success_message)): ?>
        <p class="success_message">
            ・<?= html_escape($success_message); ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <ul class="error_message">
            <?php foreach ($error_message as $value): ?>
                <li>・<?= html_escape($value); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <section>
        <div class="form-wrapper" style="display: flex;">
            <form method="get" action="<?= base_url("admin/download_csv")  ?>">
                <select name="limit">
                    <option value="">全て</option>
                    <option value="10">10件</option>
                    <option value="30">30件</option>
                </select>
                <input type="submit" name="btn_download" value="csvダウンロード">
            </form>
            <div style="margin-left: auto;">
                <form id ="form" method="get" action="<?= base_url("admin/logout")?>">
                    <input type="submit" name="btn_logout" value="ログアウト">
                </form>
            </div>
        </div>
        <?php if (!empty($message_array)) : ?>
            <?php foreach ($message_array as $value) : ?>
            <article>
                <div class="info">
                    <h2>
                        <?= html_escape($value['view_name']); ?>
                    </h2>
                    <time>
                        <?= html_escape(date('Y年m月d日 H:i', strtotime($value['post_date']))); ?>
                    </time>
                    <p>
                        <a href="<?= base_url("admin/edit?message_id=" .html_escape($value['id'])); ?>">
                            編集
                        </a>
                        &nbsp;&nbsp;
                        <a href="<?= base_url("admin/delete?message_id=".$value['id']); ?>">
                            削除
                        </a>
                    </p>
                </div>
                <p><?= html_escape(nl2br($value['message'])); ?></p>
            </article>
            <?php endforeach ?>
        <?php endif; ?>
    </section>
</body>
<script>
    const form = document.getElementById("form");

    form.addEventListener("submit", function(e) {
        if (!window.confirm("ログアウトしますか?")) {
            e.stopPropagation();
            e.preventDefault();
        }
        return
    });
</script>
</html>
