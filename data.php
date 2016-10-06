<?php
require_once('config.php');
$db = new PDO('mysql:host=localhost;dbname=php;charset=utf8', DB_USER, DB_PASS);
$query = $db->query('select * from cr_data');

$data = array();

while($row = $query->fetch(PDO::FETCH_ASSOC)){
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
echo json_encode($data);
?>