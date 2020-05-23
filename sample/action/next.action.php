<?php
function action_next_default() {
  template_render('next.html', [
    "title" => "テスト",
    "name" => "鈴木さん",
  ]);
}

