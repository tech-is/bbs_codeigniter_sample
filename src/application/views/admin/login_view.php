<body>
    <form id="form">
        <div class="input-wrapper">
            <label for="admin_password">ログインパスワード</label>
            <input id="admin_password" type="password" name="admin_password" value="">
        </div>
        <input type="submit" name="btn_submit" value="ログイン">
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $('#form').on('submit', function() {
            event.preventDefault();
            $.ajax({
                url: '<?= base_url('admin/attempt_login') ?>',
                type: 'POST',
                data: {
                    'admin_password':$('#admin_password').val()
                },
                datatype: 'json'
            }).then(
            function (data) {
                window.location.href = "<?= base_url('admin') ?>";
            },
            function (error) {
                let err_msg = JSON.parse(error.responseText);
                alert(err_msg.message);
            })
        });
    </script>
</body>
</html>
