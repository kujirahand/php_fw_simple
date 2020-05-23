# php_fw_simple

simple framework for php

# 想定するディレクトリレイアウト

```
- index.php ... メインファイル
+ <static> ... CSSやJSファイルを配置
+ <action> ... アクションを配置
+ <template> ... テンプレートを配置
+ <php_fw_simple> ... 本ライブラリを丸ごとコピー
```

## 作成する項目

```index.php
<?php
require_once 'php_fw_simple/lib/index.php';
```
