<?php
include '../lib/generic_content.php';

$string = file_get_contents('wiki_content.json');
$json = json_decode($string,true);
if (isset($_GET['page'])){
    $page_handle = $_GET['page'];
} else {
    $page_handle = 'home';
}

function getTitleFromHandle($handle){
    global $json;
    foreach ($json as $page_handle => $page){
        if ($page_handle == $handle){
            return $page['title'];
        }
    }
    return $handle; // Fallback if title not found
}
function resolveLinks($section){
	preg_match_all("/\[(.*?)\]/", $section, $matches);
	foreach ($matches[0] as $match){
        $match_without_brackets = substr($match, 1, -1);
		$section = str_replace($match,'<button class="button-as-link" type="submit" name="page" value="'.$match_without_brackets.'">'.getTitleFromHandle($match_without_brackets).'</button>', $section);
	}
	return $section;
}
function renderCategoryList($category){
    global $json;
    echo '<h2>'.$category.'</h2>';
    echo '<ul>';
    foreach ($json as $page_handle => $page){
        if ($page['category'] == $category){
            echo '<li><button class="button-as-link" type="submit" name="page" value="'.$page_handle.'">'.getTitleFromHandle($page_handle).'</button></li>';
        }
    }
    echo '</ul>';
}
function renderWikiPage($page){
    echo '<p><a class="button-as-link" href="https://hogwild.uk">hogwild.uk</a> presents <a class="button-as-link" href="https://wiki.hogwild.uk">hogipedia</a> - the free hogipedia</p>';
    echo '<h1>'.$page['title'].'</h1>';
	echo '<form method="GET">';
    /*echo '<p>'.$page['category'].'</p>';*/
    foreach ($page['sections'] as $heading => $section){
        echo '<h2>'.$heading.'</h2>';
        echo resolveLinks($section).'<br>';
    }
	echo '</form>';
}
?>

<!DOCTYPE html>
<html>
    <head>
    <link rel="canonical" href="https://wiki.hogwild.uk" />
<?php echo $standard_header_content;?>
    </head>
    <body class="wiki-page">
<?php renderWikiPage($json[$page_handle]);
        if ($page_handle == 'home'){
            echo '<form method="GET">';
            $categories = ['People','Places','Vehicles'];
            foreach ($categories as $category){
                renderCategoryList($category);
            }
            echo '</form>';
        }
        ?>
    </body>
</html>
