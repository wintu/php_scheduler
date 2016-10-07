<?php
session_start();
if (!isset($_SESSION["USERID"])) {
  header("Location: logout.php");
  exit;
}

require_once('config.php');
$db = new PDO('mysql:host=localhost;dbname=php;charset=utf8', DB_USER, DB_PASS);
$query = $db->query("select * from cr_data where user_id = '{$_SESSION["USERID"]}'");

$data = array();

while($row = $query->fetch(PDO::FETCH_ASSOC)){

  $data[] = array(
    'date'=>$row['date'],
    'badge'=>$row['badge'],
    'title'=>$row['title'],
    'body'=>$row['body'],
    'footer'=>'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> <button type="button" class="btn btn-primary" onclick="location.href='.$row['footer'].'">編集!</button>',
    'classname'=>$row['classname']
  );
}
header('Content-type: application/json');
echo json_encode($data);
?>
