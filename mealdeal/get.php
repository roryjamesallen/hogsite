<?php
include '../lib/generic_content.php';
openSqlConnection('wildhog_mealdeal', '../sql_login_wildhog_mealdeal.php');

$main = $_GET['main'];
$snack = $_GET['snack'];
$drink = $_GET['drink'];

$name = null;
$username = null;

$combo_id = sqlQuery('SELECT * FROM combos WHERE main="'.$main.'" AND snack="'.$snack.'" AND drink="'.$drink.'"');
if ($combo_id != null){
    $combo_id = $combo_id[0]['combo_id'];
    $combo_name = sqlQuery('SELECT * FROM names WHERE combo_id="'.$combo_id.'"');
    if ($combo_name != null){
	$name = $combo_name[0]['name'];
	$username = $combo_name[0]['username'];
    }
}

header('Content-Type: application/json');
echo json_encode(array(
    "name" => $name,
    "username" => $username
));
?>
