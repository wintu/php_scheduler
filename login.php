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

  $errorMessage = "";
  $viewUserId = htmlspecialchars($_POST["userid"], ENT_QUOTES);

  if (isset($_POST["login"])) {
    $user_data = FindUser($_POST["userid"]);
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
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
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
