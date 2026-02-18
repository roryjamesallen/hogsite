<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_state']) && isset($_POST['game_path'])){
    $game_path = $_POST['game_path'];
    $board_state = $_POST['board_state'];
    $game_data = json_decode(file_get_contents($game_path),true);
    $user_played = $game_data['turn'];
    $user_next = ($user_played + 1) % $game_data['players']; // increment user and wrap around

    //update actual json
    $game_data['turn'] = $user_next;
    file_put_contents($game_path, json_encode($game_data));
    return true;
    
    // get game json
    // get user who just played from game json
    // check which user should be next based on number of users in json
    // compare new vs old board state to find tiles used by prev player
    // use tilebag to repopulate users rack if possible
    // write game json
    // return true
    
    //echo var_dump(json_decode($_POST['board_state']));
}
?>
