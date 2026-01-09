<!DOCTYPE html>
<html>
    <head>
	<title>Meal Deal Maker</title>
	<meta charset="UTF-8">
	<meta name="description" content="Create and name your favourite meal deals.">
	<meta property="og:title" content="Meal Deal Maker">
	<meta property="og:description" content="Create and name your favourite meal deals.">
	<meta property="og:image" content="https://hogwild.uk/mealdeal/sharing.png">
	<meta property="og:url" content="https://hogwild.uk/mealdeal">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="icon" type="image/x-icon" href="favicon.ico"
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="style.css">
    </head>
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
    <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
    </script>
	
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
			$value = trim($products_json[$_GET[strtolower($type)]]['name']);
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
		<a id="share-combo" onclick="copyShareLink()"></a>
	    </div>
	    <div id="name-form-container">
		<label for="name-input">Meal Deal Name</label>
		<input id="name-input" name="name">
		<label for="username-input">Your Name/Username</label>	    
		<input id="username-input" name="username">
		<input type="submit" value="Submit">
	    </div>
	    <h4><a href="https://hogwild.uk/mealdeal/all.php">View All Meal Deals</a> | <a id="randomise">Randomise</a></h4>
	</form>
	<div class='footer' style='width: fit-content; margin: 6rem auto; font-family: Arial; font-size: 1rem; text-align: center;'>
	    For bug reports and suggestions please email <a href="mailto:rory@hogwild.uk">rory@hogwild.uk</a><br><br>
	    A <a class='button-as-link' href='https://hogwild.uk'>hogwild.uk</a> creation
	</div>
    </body>
    <script>
     function getProductIdByInput(input){
	 const options = document.getElementById(input.id.replace('input','list')).childNodes;
	 var product_id = null;
	 for (var i = 0; i < options.length; i++) {
	     var option = options[i];
	     if(option.value.strip() === input.value) {
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
	     document.getElementById("combo-name").innerText = decodeURI(name);
	     document.getElementById("combo-username").innerText = "Coined By: " + decodeURI(username);
	     document.getElementById("combo-id").innerText = id;
	     document.getElementById("share-combo").innerText = 'Share';
	 } else {
	     showNameForm();
	     document.getElementById("combo-name").innerText = '';
	     document.getElementById("combo-username").innerText = '';
	     document.getElementById("share-combo").innerText = '';
	 }
     }
     function getComboData(combo){ // Get the user submitted name(s) for the combo of items
	 if (!combo.includes(null)){
	     xhttp = new XMLHttpRequest();
	     xhttp.onreadystatechange = function() {
		 if (this.readyState == 4 && this.status == 200) {
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
	     element.onclick = (event) => { element.select() }
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
	     document.getElementById('share-combo').innerText = 'Copied';
	 }
     }
     function randomiseCombo(){
	 var product_ids = [];
	 document.querySelectorAll("datalist").forEach(datalist => {
	     let random = Math.floor(1 + Math.random() * datalist.childElementCount);
	     child = datalist.querySelector('option:nth-child(' + random + ')');
	     product_ids.push(child.getAttribute('data-value'));
	     const input = document.getElementById(datalist.id.replace('-list','-input'));
	     input.value = child.innerText;
	     updateURLParameter(input.id.replace('-input','').toLowerCase(), getProductIdByInput(input));
	     updateInputImage(input);
	 });
	 const combo = getCurrentCombo();
	 getComboData(combo);
     }

     // On Page Load
     addEventListenersToInputs();
     if (document.getElementById('Main-input').value == ''){
	 randomiseCombo();
     }
     document.getElementById('selectors').onsubmit = function() {
	 submitName();
	 return false;
     };
     document.getElementById('randomise').onclick = function() {
	 randomiseCombo();
     };
    </script>
</html>
