<?php
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
      <td>
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
        global $disp_ymd, $schedule;
        $db = new PDO('mysql:host=localhost;dbname=php;charset=utf8','php',getenv('DB_PASS'));

        // 年月日を取得する
        if (isset($_GET["ymd"])) {
            // スケジュールの年月日を取得する
            $ymd = basename($_GET["ymd"]);
            $y = intval(substr($ymd, 0, 4));
            $m = intval(substr($ymd, 4, 2));
            $d = intval(substr($ymd, 6, 2));
            $disp_ymd = "{$y}年{$m}月{$d}日のスケジュール";

            // スケジュールデータを取得する
            $query = $db->query("select * from schedule where date = '{$y}-{$m}-{$d}'");
            if(!empty($query)){
              $res = $query->fetch(PDO::FETCH_ASSOC);
            } else {
              $res = null;
            }
            if (!empty($res['content')) {
                $schedule = $res['content'];
            } else {
                $schedule = "";
            }
        }

        if (isset($_POST["action"]) and $_POST["action"] == "更新する") {
            $stext = htmlspecialchars($_POST["schedule"], ENT_QUOTES, "UTF-8");

            // スケジュールが入力されたか調べて処理を分岐
            if (!empty($stext)) {
                // 入力された内容でスケジュールを更新
                $stext = str_replace("\r", "", $stext);
                $db->query("update schedule set content='{$stext}' where id = {$res['id']}")
            } else {
                // スケジュールが空の場合はファイルを削除
                if (!empty($res['content'])) {
                    $db->query("delete from schedule where id = {$res['id']}")
                }
            }
            // カレンダー画面の元の年月に移動する
            header("Location: index.php?y=${y}&m=${m}");
        }
    }
?>
