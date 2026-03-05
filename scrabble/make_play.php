<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'lib.php';

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['board_state']) && isset($_POST['game_path']) && isset($_POST['points'])){
    // Get POST values and game data from file
    $board_state = json_decode($_POST['board_state']);
    $game_path = $_POST['game_path'];
    $points = $_POST['points'];
    $game_data = json_decode(file_get_contents($game_path),true);

    // Increment which user's turn it is
    $user_played = $game_data['turn'];
    $user_next = ($user_played + 1) % $game_data['players'];
    
    // Refill rack & update tilebag
    $user_object_key = $game_data['users'][$user_played]; // e.g. 0 (first user)
    $users_old_rack = $game_data[$user_object_key]['rack']; // array of the users old rack letters
    $users_new_rack = removeTiles($users_old_rack, getTileDifference($game_data['board_state'], $board_state));
    $game_data[$user_object_key]['rack'] = $users_new_rack;
    $game_data = refillRack($game_data, $game_data['users'][$user_played]);

    // Add the turn's points to the user's points array
    $game_data[$user_object_key]['points'][] = $points;
    
    // Check if game is over
    if (count($game_data[$user_object_key]['rack']) == 0){
        $game_data['turn'] = -1; // game over, one user used all their tiles
    } else {
        $game_data['turn'] = $user_next;
    }
    
    $game_data['board_state'] = $board_state;
    
    file_put_contents($game_path, json_encode($game_data));
    return true;
} else {
    return false;
}
?>
