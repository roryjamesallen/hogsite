<html>
    <head>
	<style>
	 @font-face {
	     font-family: Google Sans Code;
	     src: url('../fonts/GoogleSansCode.ttf');
	 }
	 body {
	     margin: 1rem;
	     font-family: Google Sans Code;
	     font-size: 20px;
	 }
	 h1 {
	     display: flex;
	     justify-content: center;
	 }
	 h2 {
	     margin: 0;
	 }
	 #selectors {
	     width: calc(100% - 2rem);
	     margin: auto;
	     display: flex;
	     gap: 1rem;
	 }
	 .selector {
	     display: flex;
	     justify-content: center;
	     align-content: start;
	     gap: 1rem;
	     flex-wrap: wrap;
	     flex-basis: 30%;
	     flex-grow: 1;
	 }
	 .selector select {
	     width: 100%;
	     height: 3rem;
	     font-size: 1rem;
	     font-family: inherit;
	 }
	 .hidden {
	     display: none;
	 }
	</style>
    </head>
    <body>
	<h1><span class="hidden">Meal Deal Maker</span><img src="images/logo.png"/></h1>
	<div id="selectors">
	    <?php
	    $products_string = file_get_contents('products.json');
	    $products_json = json_decode($products_string, true);
	    $product_types = ['Main','Snack','Drink'];
	    foreach ($product_types as $type){
		echo '<div class="selector">';
		echo '<h2><label for="'.$type.'">'.$type.'</label></h2>';
		echo '<select name="'.$type.'" id="'.$type.'" class="selector-dropdown">';
		foreach ($products_json as $id => $product){
		    if ($product['type'] == $type){
			echo '<option value="'.$id.'"><h3>'.$product['name'].'</h3></option>';
		    }
		}
		echo '</select>';
		foreach ($products_json as $id => $product){
		    if ($product['type'] == $type){
			echo '<img id="'.$id.'" src="images/'.$id.'.jpg" class="product-image hidden"/>';
		    }
		}
		echo '</div>';
	    }
	    ?>
	</div>
    </body>
    <script>
     document.querySelectorAll(".selector-dropdown").forEach(element => {
	 element.onchange = (event) => { // When a new item is picked from the dropdown
	     event.target.parentElement.querySelectorAll(".product-image").forEach(element => { element.style.display = 'none' }); // Clear all images
	     document.getElementById(event.target.value).style.display = 'block'; // Show the one that got selected
	 }
     });
    </script>
</html>
