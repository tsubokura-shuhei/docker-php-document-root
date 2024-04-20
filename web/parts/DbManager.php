<?php
$dsn = 'mysql:dbname=selfphp; host=db; charset=utf8';
$usr = 'root';
$passwd = 'myrootpassword';
try {
  $db = new PDO($dsn, $usr, $passwd);
  print '接続に成功しました。';
} catch (PDOException $e) {
  die("接続エラー:{$e->getMessage()}");
} finally {
  $db = null;
}
