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

        // 年月日を取得する
        if (isset($_GET["ymd"])) {
            // スケジュールの年月日を取得する
            $ymd = basename($_GET["ymd"]);
            $y = intval(substr($ymd, 0, 4));
            $m = intval(substr($ymd, 4, 2));
            $d = intval(substr($ymd, 6, 2));
            $disp_ymd = "{$y}年{$m}月{$d}日のスケジュール";

            // スケジュールデータを取得する
            $file_name = "data/{$ymd}.txt";
            if (file_exists($file_name)) {
                $schedule = file_get_contents($file_name);
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
                file_put_contents($file_name, $stext);
            } else {
                // スケジュールが空の場合はファイルを削除
                if (file_exists($file_name)) {
                    unlink($file_name);
                }
            }
            // カレンダー画面の元の年月に移動する
            header("Location: index.php?y=${y}&m=${m}");
        }
    }
?>
