<?php
require_once('config.php');
  if (isset($_POST["login"])) {
    $db = new PDO('mysql:host=localhost;dbname=php;charset=utf8', DB_USER, DB_PASS);
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $db->query("insert into users(name, pass) values('{$_POST["userid"]}', '{$pass}')");
    header("Location: login.php");
  }

?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>スケジュール帳</title>
  </head>
  <body>
  <form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">
  <fieldset>
  <legend>ユーザー作成</legend>
  <label for="userid">ユーザID</label><input type="text" id="userid" name="userid" value="<?php echo $viewUserId ?>">
  <br>
  <label for="password">パスワード</label><input type="password" id="password" name="password" value="">
  <br>
  <label></label><input type="submit" id="login" name="login" value="登録">
  </fieldset>
  </form>
  </body>
</html>
