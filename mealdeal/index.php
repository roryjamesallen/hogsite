<?php
//$page = 2;
//$tesco_url = 'https://www.tesco.com/groceries/en-GB/shop/fresh-food/chilled-soup-sandwiches-and-salad-pots/lunch-meal-deals?sortBy=price-ascending&page='.$page.'&count=24#top';

//file_put_contents('tesco'.$page, $tesco_site);
//echo 'savd';
//die();


$tesco_site = file_get_contents('tesco1.html');

$regex = '/https:\/\/www\.tesco\.com\/groceries\/en-GB\/products\/(.*)">.\n(.*)<\/a>/gm';
//$regex = 'https:\/\/www.tesco.com\/groceries\/en-GB\/products\/(.*)">(.*)<\/a>';
preg_match($regex, $tesco_site, $matches);
echo var_dump($matches);
?>
