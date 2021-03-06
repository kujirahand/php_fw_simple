<?php
// DATABASE
global $FW_DB_MAIN; // PDOオブジェクト
global $FW_DB_INFO; // 設定

function database_set($file_db, $file_sql) {
  global $FW_DB_INFO;
  $FW_DB_INFO = [];
  $FW_DB_INFO['file_db' ] = $file_db;
  $FW_DB_INFO['file_sql'] = $file_sql;
}

function database_get() {
  global $FW_DB_MAIN, $FW_DB_INFO;
  // 既にオープンしたか確認
  if ($FW_DB_MAIN) {
    return $FW_DB_MAIN;
  }
  // Check info
  if (!isset($FW_DB_INFO)) {
    echo "<h1>[ERROR] \$FW_DB_INFO not set.</h1>";
    echo '$FW_DB_INFO = ["file_db"=>"","file_sql"=>""];';
    exit;
  }
  extract($FW_DB_INFO);
  
  // Open
  $need_init = FALSE;
  if (!file_exists($file_db)) {
    $need_init = TRUE;
  }
  $pdo = $FW_DB_MAIN = new PDO("sqlite:$file_db");
  // エラーで例外を投げる
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // 連想配列を返す
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  // 生成
  if ($need_init) {
    $sql = file_get_contents($file_sql);
    $pdo->exec($sql);
  }
  return $pdo;
}

function db_exec($sql, $params = array()) {
  $db = database_get();
  $stmt = $db->prepare($sql);
  $stmt->execute($params);
  return $db;
}

function db_get($sql, $params = array()) {
  $db = database_get();
  $stmt = $db->prepare($sql);
  $stmt->execute($params);
  $r = $stmt->fetchAll();
  return $r;
}

function db_get1($sql, $params = array()) {
  $r = db_get($sql, $params);
  if ($r != null && count($r) > 0) {
    return $r[0];
  }
  return null;
}

function db_table_exists($table) {
  $r = db_get1(
    "SELECT * FROM sqlite_master ".
    "WHERE type='table' AND name=?",
    [$table]);
  return (isset($r['name']));
}

function db_insert($sql, $params = array()) {
  $db = database_get();
  $stmt = $db->prepare($sql);
  $stmt->execute($params);
  $id = $db->lastInsertId();
  return $id;
}

function db_insert_kv($table, $kv) {
  $sql = "INSERT INTO $table ";
  $params = [];
  $keys = [];
  $vals = [];
  foreach ($kv as $k => $v) {
    $keys[] = $k;
    $vals[] = "?";
    $params[] = $v;
  }
  $sql .= "(" . implode(",", $keys) . ")";
  $sql .= "VALUES(" . implode(",", $vals) . ")";
  return db_insert($sql, $params);
}

function db_update_kv($table, $kv, $where_kv) {
  $sql = "UPDATE $table SET ";
  $params = [];
  $upv = [];
  foreach ($kv as $k => $v) {
    $upv[] = "$k=?";
    $params[] = $v;
  }
  $cond = [];
  foreach ($where_kv as $k => $v) {
    $cond[] = "$k=?";
    $params[] = $v;
  }
  $sql .= implode(",", $upv)." WHERE ";
  $sql .= implode(" AND ", $cond);
  return db_exec($sql, $params);
}




