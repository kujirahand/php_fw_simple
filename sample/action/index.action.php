<?php
// file: action/index.action.php

// (1) ファイル「action/（アクション名）.action.php」を作る
// (2) ファイルの中で「action_(アクション名)_default」という関数を定義する

function action_index_default() {
  
  // テンプレートを表示するコード
  template_render('index.html', [
    // テンプレート中に埋め込みたい値を指定
    'title' => 'php_fw_simple のテスト',
    'msg' => 'テスト',
    'next_link' => app_url('next', ''),
    'fruits' => ['Apple', 'Banana', 'Orange'],
  ]);
}

