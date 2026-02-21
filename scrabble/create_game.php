<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'lib.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['players']) && isset($_POST['nickname'])){
    $game_id = uniqid();
    $game_path = gamePathFromId($game_id);
    $game_data = '{
	"players": '.$_POST['players'].',
	"users": ["'.$_POST['nickname'].'"],
	"turn": 0,
	"'.$_POST['nickname'].'": {
	    "rack": []
	},
	"tilebag":[
	    "E","E","E","E","E","E","E","E","E","E","E","E",
	    "A","A","A","A","A","A","A","A","A",
	    "I","I","I","I","I","I","I","I","I",
	    "O","O","O","O","O","O","O","O",
	    "N","N","N","N","N","N",
	    "T","T","T","T","T","T",
	    "L","L","L","L",
	    "S","S","S","S",
	    "U","U","U","U",
	    "D","D","D","D",
	    "G","G","G",
	    "B","B",
	    "C","C",
	    "M","M",
	    "P","P",
	    "F","F",
	    "H","H",
	    "V","V",
	    "W","W",
	    "Y","Y",
	    "K","J","X","Q","Z"],
"board_state":["","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","",""]
}';
    $game_data = json_encode(refillRack(json_decode($game_data,true), $_POST['nickname']));
    file_put_contents($game_path, $game_data);
    
    $_SESSION[$game_id] = $_POST['nickname'];
    echo 'send this link to your pals: <a href="https://scrabble.hogwild.uk?game='.$game_id.'">https://scrabble.hogwild.uk?game='.$game_id.'</a>';
}
?>
