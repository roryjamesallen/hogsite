<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getTileDifference($old_state, $new_state){
    $tiles_different = [];
    for ($slot=0; $slot<count($old_state); ++$slot){
        if ($old_state[$slot] != $new_state[$slot]){
            $tiles_different[] = $new_state[$slot];
        }
    }
    return $tiles_different;
}
function removeTiles($rack, $tiles_to_remove){
    return array_diff($rack, $tiles_to_remove);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_state']) && isset($_POST['game_path'])){
    $game_path = $_POST['game_path'];
    $board_state = json_decode($_POST['board_state']);
    $game_data = json_decode(file_get_contents($game_path),true);
    $user_played = $game_data['turn'];

    $user_next = ($user_played + 1) % $game_data['players']; // increment user and wrap around

    $user_object_key = $game_data['users'][$user_played]; // e.g. 0 (first user)
    $users_old_rack = $game_data[$user_object_key]['rack']; // array of the users old rack letters
    $users_new_rack = removeTiles($users_old_rack, getTileDifference($game_data['board_state'], $board_state));

    //update actual json
    $game_data['turn'] = $user_next;
    $game_data['board_state'] = $board_state;
    $game_data[$user_object_key]['rack'] = json_encode($users_new_rack);
    file_put_contents($game_path, json_encode($game_data));
    return true;
} else {
    return false;
}
?>
