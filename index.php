<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <title>スケジュール帳</title>
     <style type="text/css">
     .header { text-align: center;
               width: 60px;
               height : 30px;
     }
     .data { text-align: center;
             height : 40px;
      }
     </style>
</head>
<body>
<h4>スケジュール帳</h4>
<?php main(); ?>
<!-- カレンダーの表示 -->
<table border="1">
<tr>
<th class="header">日</th>
<th class="header">月</th>
<th class="header">火</th>
<th class="header">水</th>
<th class="header">木</th>
<th class="header">金</th>
<th class="header">土</th>
</tr>
<tr>
<?php calendar(); ?>
</tr>
</table>
</body>
</html>
<?php
include('config.php');
    function main() {
        global $y, $m;
        if (isset($_POST["y"])) {
            // 選択された年月を取得する
            $y = intval($_POST["y"]);
            $m = intval($_POST["m"]);
        } else if (isset($_GET["y"]) ) {
            // 予定登録後その年月にとどまる
            $y = $_GET["y"];
            $m = $_GET["m"];
        } else {
            // 現在の年月を取得する
            $ym_now = date("Ym");
            $y = substr($ym_now, 0, 4);
            $m = substr($ym_now, 4, 2);
        }
        // 年月選択リストを表示する
        echo "<form method='POST' action=''>";

        // 年
        echo "<select name='y'>";
        for ($i = $y - 2; $i <= $y + 2; $i++) {
            echo "<option";
            if ($i == $y) {
                echo " selected ";
            }
            echo ">$i</option>";
        }
        echo "</select>年";

        // 月
        echo "<select name='m'>";
        for ($i = 1; $i <= 12; $i++) {
            echo "<option";
            if ($i == $m) {
                echo " selected ";
            }
            echo ">$i</option>";
        }
        echo "</select>月";
        echo "<input type='submit' value='表示' name='sub1'>";
        echo "</form>";
    }

    function contents( $ymd ) {
        $s = "";
        $db = new PDO('mysql:host=localhost;dbname=php;charset=utf8', DB_USER, DB_PASS);
        $query = $db->query("select * from schedule where date = {$ymd}");

        if(!empty($query)){
          $res = $query->fetch(PDO::FETCH_ASSOC);
        } else {
          $res = null;
        }

        if (!empty($res)) {
            $s = $res['content'];
            $s = str_replace("\r", "", $s);
            $s = str_replace("\n", "<br>", $s);
        }
        return $s;
    }

    function calendar() {
        global $y, $m;
        // 1日の曜日まで移動
        $wd = date("w", mktime(0, 0, 0, $m, 1, $y));
        for ($i = 1; $i <= $wd; $i++) {
            echo '<td class="data">　</td>';
        }

        for ( $d=1 ; checkdate($m, $d, $y) ; ) {
            // 日付リンクの表示
            $ymd  = sprintf("%04d%02d%02d", $y, $m, $d);
            $link = "schedule.php?ymd=%04d%02d%02d";
            echo "<td class='data'><a href=\""
                . sprintf($link, $y, $m, $d)
                . "\">{$d}</a>"
                . "<br/><br/><font size='2'>"
                . contents( $ymd )
                . "</font></td>";

            // 今日が土曜日の場合の処理
            if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                // 週を終了
                echo "</tr>";

                // 次の週がある場合は新たな行を準備
                if (checkdate($m, $d + 1, $y)) {
                    echo "<tr>";
                }
            }

            // 日付を1つ進める
            $d++;
        }

        // 最後の週の土曜日まで移動
        $wd = date("w", mktime(0, 0, 0, $m + 1, 0, $y));
        for ($i = 1; $i < 7 - $wd; $i++) {
            echo "<td>　</td>";
        }
    }
?>
