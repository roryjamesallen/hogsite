<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_state'])){
    echo var_dump(json_decode($_POST['board_state']));
}
?>
