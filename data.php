<?php
require_once('config.php');
$db = new PDO('mysql:host=localhost;dbname=php;charset=utf8', DB_USER, DB_PASS);
$query = $db->prepare('select * from cr_data');

$data = array();

$res = $query->fetch(PDO::FETCH_ASSOC);
foreach($res as $row){
  $data[] = array(
    'date'=>$row['date'],
    'badge'=>$row['badge'],
    'title'=>$row['title'],
    'body'=>$row['body'],
    'footer'=>$row['footer'],
    'classname'=>$row['classname']
  );
}
header('Content-type: application/json');
echo json_encode($userData);
?>
