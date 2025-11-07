<?php
include 'lib/generic_content.php';
openSqlConnection('wildhog_analytics', 'sql_login_wildhog_analytics.php');

$original_info = getSongInfoFromLink(getNewestSongLink());
$info = $original_info;
while ($original_info != $info){
    sleep(0.5);
    $info = getSongInfoFromLink(getNewestSongLink());
}
$song_text = getSongTextFromInfo($info);
echo $song_text;
?>
