<!DOCTYPE html>
<html>
    <head>
	<title>Meal Deal Maker</title>
	<meta charset="UTF-8">
	<meta name="description" content="Create and name your favourite meal deals.">
	<meta property="og:title" content="Meal Deal Maker">
	<meta property="og:description" content="Create and name your favourite meal deals.">
	<meta property="og:image" content="https://hogwild.uk/mealdeal/images/logo.png">
	<meta property="og:url" content="https://hogwild.uk/mealdeal">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="icon" type="image/x-icon" href="favicon.ico"
	<link rel="shortcut icon" href="favicon.ico" />
	<style>
	 @font-face {
	     font-family: Tesco;
	     src: url('../fonts/Tesco.ttf');
	 }
	 @font-face {
	     font-family: Tesco Bold;
	     src: url('../fonts/TescoBold.ttf');
	 }
	 :root {
	     --dark-grey: rgb(51, 51, 51);
	     --medium-grey: rgb(102, 102, 102);
	     --link-blue: rgb(0, 83, 159);
	     --pale-grey: rgb(246, 246, 246);
	     --max-width: 800px;
	 }
	 body {
	     width: min(calc(100% - 2rem), var(--max-width));
	     margin: 1rem auto;
	     font-family: Tesco;
	     font-size: 20px;
	     color: var(--dark-grey);
	 }
	 h1, h2, h3 {
	     font-family: Tesco Bold;
	 }
	 h1 {
	     display: flex;
	     justify-content: center;
	 }
	 h2 {
	     margin: auto 0;
	     text-align: center;
	 }
	 h3 {
	     margin: 0 auto;
	     text-align: center;
	 }
	 a {
	     color: var(--link-blue);
	     text-decoration: none;
	 }
	 a:hover {
	     cursor: pointer;
	     text-decoration: underline;
	 }
	 #logo {
	     max-width: 100%;
	 }
	 #selectors {
	     display: flex;
	     gap: 1rem;
	     flex-wrap: wrap;
	 }
	 #selector-container {
	     margin: auto;
	     display: flex;
	     gap: 1rem;
	     flex-wrap: wrap;
	 }
	 .selector {
	     display: flex;
	     justify-content: center;
	     align-content: start;
	     gap: 0.5rem;
	     flex-wrap: wrap;
	     flex-basis: 100%;
	     flex-grow: 1;
	     padding: 1rem;
	     background: var(--pale-grey);
	 }
	 .selector > * {
	     flex-basis: 100%;
	 }
	 .selector > img {
	     max-width: min(255px, 100%);
	     mix-blend-mode: darken;
	 }
	 input {
	     font-size: 1rem;
	     font-family: inherit;
	     color: var(--medium-grey);
	 }
	 #combo-username {
	     color: var(--medium-grey);
	 }
	 #name-form-container, #name-set-container {
	     flex-basis: 100%;
	     display: flex;
	     flex-wrap: wrap;
	     gap: 0.5rem;
	     justify-content: center;
	     padding: 1rem;
	     background: var(--pale-grey);
	 }
	 #name-set-container {
	     gap: 0;
	 }
	 #name-form-container label, #name-set-container h2, #name-set-container h3 {
	     flex-basis: 100%;
	     text-align: center;
	 }
	 #name-form-container:empty {
	     display: none;
	 }
	 .hidden {
	     display: none;
	 }
	 #something-wrong {
	     font-size: 1rem;
	     text-align: center;
	     color: var(--medium-grey);
	     flex-basis: 100%;
	 }
	 @media screen and (min-width: 800px){
	     #selector-container {
		 flex-wrap: nowrap;
	     }
	     .selector {
		 flex-basis: 30%;
	     }
	 }
	</style>
    </head>
    <body>
	<h1><span class="hidden">Meal Deal Maker</span><img id="logo" src="images/logo.png" alt="Logo for Meal Deal Maker" /></h1>
	<form id="selectors">
	    <div id="selector-container">
		<?php
		$products_string = file_get_contents('products.json');
		$products_json = json_decode($products_string, true);
		$product_types = ['Main','Snack','Drink'];
		foreach ($product_types as $type){
		    echo '<div class="selector">';
		    echo '<h2><label for="'.$type.'-input">'.$type.'</label></h2>';
		    if (isset($_GET[strtolower($type)])){
			$value = $products_json[$_GET[strtolower($type)]]['name'];
		    } else {
			$value = '';
		    }
		    echo '<input name="'.$type.'-input" list="'.$type.'-list" id="'.$type.'-input" value="'.$value.'" class="list-input">';
		    echo '<datalist id="'.$type.'-list">';
		    foreach ($products_json as $id => $product){
			if ($product['type'] == $type){
			    echo '<option data-value="'.$id.'">'.$product['name'].'</option>';
			}
		    }
		    echo '</datalist>';
		    echo '<img id="'.$type.'-image" src="images/placeholder.png" alt="Thumbnail of meal deal item" class="product-image"/>';
		    echo '</div>';
		}
		?>
	    </div>
	    <div id="name-set-container">
		<h2 id="combo-name"></h2>
		<h3 id="combo-username"></h3>
		<span id="combo-id" class="hidden"></span>
		<a id="share-combo" onclick="copyShareLink()">Share</a>
	    </div>
	    <div id="name-form-container">
		<label for="name-input">Meal Deal Name</label>
		<input id="name-input" name="name">
		<label for="username-input">Your Name/Username</label>	    
		<input id="username-input" name="username">
		<input type="submit" value="Submit">
	    </div>
	    <span id="something-wrong">For bug reports and suggestions please email <a href="mailto:rory@hogwild.uk">rory@hogwild.uk</a></span>
	</form>
	<div class='footer' style='width: fit-content; margin: 6rem auto; font-family: Arial; font-size: 1rem; text-align: center;'>A <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a> creation</div>
    </body>
    <script>
     function getProductIdByInput(input){
	 const options = document.getElementById(input.id.replace('input','list')).childNodes;
	 var product_id = null;
	 for (var i = 0; i < options.length; i++) {
	     var option = options[i];
	     if(option.value === input.value) {
		 product_id = option.getAttribute('data-value');
		 break;
	     }
	 }
	 return product_id;
     }
     function updateInputImageByProductId(input, product_id){ // Update the dropdown's image src to the picked item
	 document.getElementById(input.id.replace('input','image')).src = 'images/' + product_id + '.jpg';
     }
     function getCurrentCombo(){ // Get the ID of each of the 3 products that makes up the meal deal
	 var product_ids = [];
	 document.querySelectorAll(".list-input").forEach(element => {
	     product_ids.push(getProductIdByInput(element));
	 });
	 return product_ids;
     }
     function showNameForm(){
	 document.getElementById('name-set-container').style.display = 'none';
	 document.getElementById('name-form-container').style.display = 'flex';
     }
     function showNameSet(){
	 document.getElementById('name-form-container').style.display = 'none';
	 document.getElementById('name-set-container').style.display = 'flex';
     }
     function updateComboName(id, name, username){
	 if (id!= null && name != null && username != null){
	     showNameSet();
	     document.getElementById("combo-name").innerHTML = decodeURI(name);
	     document.getElementById("combo-username").innerHTML = "Coined By: " + decodeURI(username);
	     document.getElementById("combo-id").innerHTML = id;
	 } else {
	     showNameForm();
	     document.getElementById("combo-name").innerHTML = '';
	     document.getElementById("combo-username").innerHTML = '';
	 }
     }
     function getComboData(combo){ // Get the user submitted name(s) for the combo of items
	 if (!combo.includes(null)){
	     xhttp = new XMLHttpRequest();
	     xhttp.onreadystatechange = function() {
		 if (this.readyState == 4 && this.status == 200) {
		     console.log(this.responseText);
		     response = JSON.parse(this.responseText);
		     updateComboName(response.id, response.name, response.username);
		 }
	     };
	     xhttp.open("GET", "get.php?main="+combo[0]+'&snack='+combo[1]+'&drink='+combo[2], true);
	     xhttp.send();
	 }
     }
     function updateURLParameter(parameter, value){
	 const url = new URL(location);
	 url.searchParams.set(parameter, value);
	 history.pushState({}, "", url);
     }
     function updateInputImage(input){
	 product_id = getProductIdByInput(input); // Get the ID of the product by its name (input.value)
	 if (product_id != null){ // As long as the input doesn't contain a random user inputted product that doesn't exist
	     updateInputImageByProductId(input, product_id); // Update the input's image src to the selected product
	     const combo = getCurrentCombo();
	     getComboData(combo);
	     updateURLParameter(input.id.replace('-input','').toLowerCase(), product_id);
	 }
     }
     function addEventListenersToInputs(){
	 document.querySelectorAll(".list-input").forEach(element => { // For each Main, Snack, Drink dropdown
	     updateInputImage(element); // On page load update images in case datalist option is stored in cache
             element.oninput = (event) => { updateInputImage(element) } // Update image every time the input changes
	 });
     }
     function submitName(){
	 const combo = getCurrentCombo();
	 const name = encodeURI(document.getElementById('name-input').value);
	 const username = encodeURI(document.getElementById('username-input').value);
	 if (!combo.includes(null) && name != '' && username != ''){
	     xhttp = new XMLHttpRequest();
	     xhttp.onreadystatechange = function() {
		 if (this.readyState == 4 && this.status == 200) {
		     location.reload();
		 }
	     };
	     xhttp.open("GET", "submit.php?main="+combo[0]+'&snack='+combo[1]+'&drink='+combo[2]+'&name='+name+'&username='+username, true);
	     xhttp.send();
	 }
     }
     function copyShareLink(){
	 const combo = getCurrentCombo();
	 if (!combo.includes(null)){
	     navigator.clipboard.writeText('https://hogwild.uk/mealdeal?main='+combo[0]+'&snack='+combo[1]+'&drink='+combo[2]);
	     document.getElementById('share-combo').innerHTML = 'Copied';
	 }
     }

     // On Page Load
     addEventListenersToInputs();
     document.getElementById('selectors').onsubmit = function() {
	 submitName();
	 return false;
     };
    </script>
</html>
