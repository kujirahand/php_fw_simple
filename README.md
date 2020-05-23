# php_fw_simple

simple framework for php

# 想定するディレクトリレイアウト

```
<root>
+- index.php ... メインファイル
+ <static> ... CSSやJSファイルを配置
+ <action> ... アクションを配置
+ <template> ... テンプレートを配置
+ <cache> ... テンプレートのキャッシュが保存される
+ <php_fw_simple> ... 本ライブラリを丸ごとコピー
```

## 作成する項目

そして、php_fw_simple/lib/index.php にリンク

```file:index.php
<?php
// ディレクトリを指定
$DIR_ACTION = __DIR__.'/action';
$DIR_TEMPLATE = __DIR__.'/template';
$DIR_TEMPLATE_CACHE = __DIR__.'/cache';
// ライブラリを取り込む
require_once 'php_fw_simple/lib/index.php';
```

## アクションの作成

アクションは、上記で指定した $DIR_ACTION に 「(アクション名).action.php」という名前のファイルを作成します。
そして、そのファイルの中で、「action_(アクション名)_default」という関数を定義します。

## テンプレートの使用

アクションの中で以下のように書いて任意のテンプレートを表示するようにすると、MVCっぽくなります。

```
template_render('ファイル名', ["パラメータ" => 値]);
```

テンプレートで使える値は、[こちらのコード](./lib/fw_template_engine.lib.php) を確認してください。


