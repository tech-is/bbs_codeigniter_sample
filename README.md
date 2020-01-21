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
JQueryを使ったAjaxでの非同期通信やコーディングの整形、エルビス演算子でのエラー処理など  
応用的なことも多いですが、頑張って作ってみてください。

## 開発環境

```
PHP >= 7.3.~
Apache >= 2.~
MariaDB >= 10.~
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

>参考サイト
https://www.adminweb.jp/apache/virtual/index2.html
>

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
