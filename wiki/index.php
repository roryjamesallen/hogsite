<?php
include '../lib/generic_content.php';

function renderWikiPage($schema){
    echo '<h1>'.$schema['title'].'</h1>';
    echo '<h2>'.$schema['category'].'</h2>';
    foreach ($schema['sections'] as $heading => $section){
        echo '<h3>'.$heading.'</h3>';
        echo $section.'<br>';
    }
}

$string = file_get_contents('wiki_content.json');
$json = json_decode($string,true);

renderWikiPage($json['the-wrangler']);
?>
