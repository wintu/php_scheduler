<?php
session_start();
if (!isset($_SESSION["USERID"])) {
  header("Location: logout.php");
  exit;
}
schedule();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>スケジュール帳</title>
</head>
<body>
<h4>スケジュール登録</h4>
<form method="POST" action="">
  <table>
    <tr>
      <td><?php echo $disp_ymd; ?></td>
    </tr>
    <tr>
      <td>タイトル<br><input type="text" name="title" size="40" value="<?php echo $title ?>"></input></td>
    </tr>
    <tr>
      <td>
        メモ<br>
      <textarea rows="10" cols="50" name="schedule"><?php echo $schedule; ?></textarea>
      </td>
    </tr>
    <tr>
      <td>
      <input type="submit" name="action" value="更新する">
      <input type="button" name="back" onClick="history.back()" value="戻る">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
    function schedule() {
      include('config.php');
        global $disp_ymd, $schedule, $title;
        $db = new PDO('mysql:host=localhost;dbname=php;charset=utf8', DB_USER, DB_PASS);
        $query = $db->query("select * from users where name = '{$_SESSION["USERID"]}'");
        $db_data = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $db_data['id'];

        // 年月日を取得する
        if (isset($_GET["ymd"])) {
            // スケジュールの年月日を取得する
            $ymd = date('Ymd', strtotime($_GET["ymd"]));
            $y = intval(substr($ymd, 0, 4));
            $m = intval(substr($ymd, 4, 2));
            $d = intval(substr($ymd, 6, 2));
            $disp_ymd = "{$y}年{$m}月{$d}日のスケジュール";

            // スケジュールデータを取得する
            $query = $db->query("select * from cr_data where date = {$ymd} and user_id = {$user_id}");
            if(!empty($query)){
              $res = $query->fetch(PDO::FETCH_ASSOC);
            } else {
              $res = null;
            }
            if (!empty($res['body'])) {
                $schedule = $res['body'];
                $title = $res['title'];
            } else {
                $schedule = "";
            }
        }

        if (isset($_POST["action"]) and $_POST["action"] == "更新する") {
            $stext = htmlspecialchars($_POST["schedule"], ENT_QUOTES, "UTF-8");
            $title = htmlspecialchars($_POST["title"], ENT_QUOTES, "UTF-8");

            // スケジュールが入力されたか調べて処理を分岐
            if (!empty($stext)) {
                // 入力された内容でスケジュールを更新
                $stext = str_replace("\r", "", $stext);
                if (empty($res)){
                  $db->query("insert into cr_data(date, body, title, user_id, footer) values({$ymd}, '{$stext}', '{$title}', {$user_id}, 'schedule.php?ymd={$_GET["ymd"]}')");
                } else {
                  $db->query("update cr_data set body='{$stext}', title='{$title}' where id = {$res['id']}");
                }

            } else {
                // スケジュールが空の場合はファイルを削除
                if (!empty($res['body']) && !empty($res['title'])) {
                    $db->query("delete from cr_data where id = {$res['id']}");
                }
            }
            // カレンダー画面の元の年月に移動する
            header("Location: index.php");
        }
    }
?>
