<?php
include '../lib/generic_content.php';
openSqlConnection('wildhog_mealdeal', '../sql_login_wildhog_mealdeal.php');

if (!isset($_GET['combo_id'])){ // Get combo_id from main/snack/drink if not set
    $main = $_GET['main'];
    $snack = $_GET['snack'];
    $drink = $_GET['drink'];
    $combo_id = sqlQuery('SELECT * FROM combos WHERE main="'.urlencode($main).'" AND snack="'.urlencode($snack).'" AND drink="'.urlencode($drink).'"');
} else {
    $combo_id = $_GET['combo_id'];
}

$name = null;
$username = null;

if ($combo_id != null){
    $combo_id = $combo_id[0]['combo_id'];
    $combo_name = sqlQuery('SELECT * FROM names WHERE combo_id="'.$combo_id.'"');
    if ($combo_name != null){
	$name = urldecode($combo_name[0]['name']);
	$username = urldecode($combo_name[0]['username']);
    }
}

header('Content-Type: application/json');
echo json_encode(array(
    "id" => $combo_id,
    "name" => $name,
    "username" => $username
));
?>
