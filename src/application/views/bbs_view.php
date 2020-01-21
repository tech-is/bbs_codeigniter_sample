<body>
    <h1>ひと言掲示板</h1>
    <form action="/bbs/add_bbs" method="post">
        <div>
            <?php if (!empty($success_message)): ?>
                <p class="success_message">
                    ・<?= $success_message; ?>
                </p>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
            <ul class="error_message">
                <?php foreach ($error_message as $message): ?>
                    <li>・<?= $message; ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <label for="view_name">表示名</label>
            <input id="view_name" type="text" name="view_name" value="">
        </div>
        <div>
            <label for="message">ひと言メッセージ</label>
            <textarea id="message" name="message"></textarea>
        </div>
        <input type="submit" name="btn_submit" value="書き込む">
    </form>
    <hr>
    <section>
    <!-- ここに投稿されたメッセージを表示 -->
        <?php if (!empty($message_array)): ?>
            <?php foreach( $message_array as $value ): ?>
            <article>
                <div class="info">
                    <h2><?php echo $value['view_name']; ?></h2>
                    <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
                </div>
                <p><?php echo $value['message']; ?></p>
            </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>
</html>