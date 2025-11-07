<?php
include 'lib/generic_content.php';
openSqlConnection('wildhog_analytics', 'sql_login_wildhog_analytics.php');

$data = [];

// Song Link
$original_values = getInteractiveElementStates();
$current_values = $original_values;
while ($original_values == $current_values){
    sleep(0.5);
    $current_values = getInteractiveElementStates();
}
// Something has changed
echo json_encode($current_values);
?>
