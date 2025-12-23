<?php
include '../lib/generic_content.php';
openSqlConnection('wildhog_mealdeal', '../sql_login_wildhog_mealdeal.php');

$main = $_GET['main'];
$snack = $_GET['snack'];
$drink = $_GET['drink'];
$name = $_GET['name']; // Already urlencoded because it's using GET
$username = $_GET['username']; // Ditto

$combo_id = sqlQuery('SELECT * FROM combos WHERE main="'.$main.'" AND snack="'.$snack.'" AND drink="'.$drink.'"');
if ($combo_id != null){ // Combo already exists in combos table
    $combo_id = $combo_id[0]['combo_id']; // Get the ID
} else {
    $combo_id = uniqid();
    sqlQuery('INSERT INTO combos (combo_id, main, snack, drink, ip, time) VALUES ("'.$combo_id.'", "'.$main.'", "'.$snack.'", "'.$drink.'", "'.$ip_address.'", "'.time().'")'); // Insert the combo
}
$combo_name = sqlQuery('SELECT * FROM names WHERE combo_id="'.$combo_id.'"'); // Check if it also already has a name
if ($combo_name == null){ // As long as it doesn't already have a name
    sqlQuery('INSERT INTO names (name_id, combo_id, name, username, ip, time) VALUES ("'.uniqid().'", "'.$combo_id.'", "'.$name.'", "'.$username.'", "'.$ip_address.'", "'.time().'")'); // Insert the name
} // Already has a name so don't do anything (must be someone trying to hack)
?>
