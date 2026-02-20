<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../lib.php';

if (isset($_GET['game'])){
    $game_id = $_GET['game'];
} else if (isset($_POST['game'])){
    $game_id = $_POST['game'];
}

$game_path = '../'.gamePathFromId($game_id);
$game_data = json_decode(file_get_contents($game_path),true);

if (isset($_POST['new-nickname'])){ // new nickname posted from select-player
    if (in_array($_POST['new-nickname'], $game_data['users'])){
        echo 'someone in this game already has that username!!';
    } else {
        $game_data['users'][] = $_POST['new-nickname'];
        $game_data[$_POST['new-nickname']] = json_decode('{"rack":[]}',true);
        $game_data = refillRack($game_data, $_POST['new-nickname']);
        $_SESSION['nickname'] = $_POST['new-nickname'];
        file_put_contents($game_path, json_encode($game_data));
        header('Location: ../?game='.$game_id);
    }
} else if (isset($_POST['nickname'])){ // chosen nickname posted
    $_SESSION['nickname'] = $_POST['nickname'];
    header('Location: ../?game='.$game_id);
}

renderHeading('../');
echo '<br><br><h2>Who are you..?</h2>';
echo '<form action="index.php" method="POST"><p>If you\'ve already set your nickname, choose it below and then click Rejoin Game.</p>';
for ($user=0; $user<count($game_data['users']); ++$user){
    echo '<label for="radio-'.$user.'">'.$game_data['users'][$user].'</label><input type="radio" name="nickname" autocomplete="off" id="radio-'.$user.'" value="'.$game_data['users'][$user].'"><br>';
}
echo '<input type="hidden" name="game" value="'.$game_id.'"><input type="submit" value="Rejoin Game"></form>';

if (count($game_data['users']) < $game_data['players']){
    echo '<form action="index.php" method="POST"><p>If you are trying to join this game for the first time, please enter the nickname you\'d like and then click Join Game</p><label for="nickname-input"></label><input id="nickname-input" name="new-nickname"><input type="hidden" name="game" value="'.$game_id.'"><input type="submit" value="Join Game"></form>';
}
?>
