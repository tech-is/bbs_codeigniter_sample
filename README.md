# ひとこと掲示板 CodeIgniter SAMPLE

# 学習前に必ず読んでください

## 概要

>ひとこと掲示板を作る  
https://gray-code.com/php/make-the-board-vol1/  

をベースにCodeIgniterに改修したコードサンプルです  

>GItHub  
https://github.com/gray-code/make-the-board/tree/master/vol23


## 学習の目的

今まで学習してきたことを参考にしながらCodeIgniterでMVCモデルを学ぶと同時に、  
javascriptを使ったAjaxでの非同期通信でのログイン処理など
応用的なことも多いですが、まずは自力で頑張って作ってみてください。

## 機能要件
以下の機能を満たした掲示板とCMSを作成してください
>掲示板
- 名前とメッセージを投稿するフォーム
- 名前とメッセージ、投稿日の一覧を画面に出力

>CMS
- 管理者ログイン
- 管理トップページ
- 投稿されたメッセージの編集
- 投稿されたメッセージの削除
- 投稿されたメッセージのCSV出力 

## 参考文献
CodeIgniterの機能でどういったものがあるのか調べる必要が出てくると思いますので  
以下の公式リファレンスを参考にして見てください
>CodeIgniter公式リファレンス  
https://codeigniter.jp/user_guide/3/

## 開発環境

```
PHP >= 7.4.~
Apache >= 2.~
MariaDB >= 10.~ | MySQL >= 5.*
```

## DB設計

基本的にはgraycodeのひとこと掲示板と同じ設計でいいですが、  
消してしまっていたり最初からやりたい場合には/sql/bbs.dumpをリストアしてみてください。
```
$ mysql -u [user名] -p [パスワード] < bbs.dump
```

## Virtualhost設定

今まではlocalhostで色々なプログラムにアクセスしていたと思いますが  
CodeIgniterではindex.phpのrootにドメインを設定していたほうが後々楽なので、apacheの設定ファイルを編集して/srcに対してvirtualhostを設定してみてください。  

設定例
```
<VirtualHost *:80>
    DocumentRoot {DocumentRoot}/bbs_codeigniter_sample/src
    ServerName example.com
</VirtualHost>
```

上記の{DocumentRoot}は自分のApacheのDocumentRootを設定してください  
例： /var/www/html/bbs_codeigniter_sample/src

>参考サイト
https://www.adminweb.jp/apache/virtual/index2.html


## ファイルツリー
```
.
├─sql/bbs.dump ひとこと掲示板のdumpファイル
├─lib/CodeIgniter-3.1.11.zip CodeIgniterのオリジナルソース
└─src/ CodeIgniter本体
    ├─application/
    ├─system/
    └─index.php
```
