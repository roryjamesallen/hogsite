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
	 .selector > * {
	     flex-basis: 100%;
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
	    echo '<h2><label for="'.$type.'-input">'.$type.'</label></h2>';
	    echo '<input list="'.$type.'-list" id="'.$type.'-input" class="list-input">';
	    echo '<datalist name="'.$type.'" id="'.$type.'-list">';
	    foreach ($products_json as $id => $product){
            if ($product['type'] == $type){
            echo '<option data-value="'.$id.'" value="'.$product['name'].'"></option>';
            }
	    }
	    echo '</datalist>';
	    echo '<img id="'.$type.'-image" src="" class="product-image"/>';
	    echo '</div>';
	    }
	    ?>
	</div>
    </body>
    <script>
     document.querySelectorAll(".list-input").forEach(element => { // For each Main, Snack, Drink dropdown
	 /*
         element.onchange= (event) => { // When a new item is picked from the dropdown
	     console.log('changes');
	     
	     const options = document.getElementById(element.id.replace('input','list')).childNodes;
	     for (var i = 0; i < options.length; i++) {
		 var option = options[i];
		 if(option.value === element.value) {
		     const product_id = option.getAttribute('data-value');
		     break;
		 }
	     }
	     document.getElementById(element.id.replace('input','image')).src = 'images/' + product_id + '.jpg'; // Update the dropdown's image src to the picked item
	     
         }*/
     });
    </script>
</html>
