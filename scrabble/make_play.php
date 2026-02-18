<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_state'])){

    // get game json
    // get user who just played from game json
    // check which user should be next based on number of users in json
    // compare new vs old board state to find tiles used by prev player
    // use tilebag to repopulate users rack if possible
    // write game json
    // return true
    
    echo var_dump(json_decode($_POST['board_state']));
}
?>
