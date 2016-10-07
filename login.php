<?php
include('config.php');
  session_start();
  function FindUser($user_id){
    $db = new PDO('mysql:host=localhost;dbname=php;charset=utf8', DB_USER, DB_PASS);
    $query = $db->query("select * from users where name = '{$user_id}'");
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if(!empty($row)){
      return $row;
    }else{
      return false;
    }
  }

  // エラーメッセージ
  $errorMessage = "";
  // 画面に表示するため特殊文字をエスケープする
  $viewUserId = htmlspecialchars($_POST["userid"], ENT_QUOTES);

  // ログインボタンが押された場合
  if (isset($_POST["login"])) {
    $user_data = FindUser($_POST["userid"]);
    // 認証成功
    if ($_POST["userid"] == $user_data['name'] && password_verify($_POST["password"], $user_data['pass'])) {
      session_regenerate_id(TRUE);
      $_SESSION["USERID"] = $_POST["userid"];
      header("Location: index.php");
      exit;
    }
    else {
      $errorMessage = "ユーザIDあるいはパスワードに誤りがあります。";
    }
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
  <legend>ログインフォーム</legend>
  <div><?php echo $errorMessage ?></div>
  <label for="userid">ユーザID</label><input type="text" id="userid" name="userid" value="<?php echo $viewUserId ?>">
  <br>
  <label for="password">パスワード</label><input type="password" id="password" name="password" value="">
  <br>
  <label></label><input type="submit" id="login" name="login" value="ログイン">
  </fieldset>
  </form>
  </body>
</html>
