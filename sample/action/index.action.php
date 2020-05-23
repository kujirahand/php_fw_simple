<?php
function action_index_default() {
  template_render('index.html',[
    'title' => 'php_fw_simple のテスト',
    'msg' => 'テスト',
    'next_link' => app_url('next', ''),
    'fruits' => ['Apple', 'Banana', 'Orange'],
  ]);
}

