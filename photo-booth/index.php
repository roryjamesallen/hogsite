<html>
    <head>
	<style>
	 @font-face {
	     font-family: Melodica;
	     src: url('../fonts/Melodica.otf');
	 }
	 body {
	     margin-top: 2rem;
	     font-family: Melodica;
	 }
	 #booth-container {
	     width: 90vw;
	     display: flex;
	     gap: 20px;
	     margin: 50px auto;
	 }
	 #booth-container > * {
	     margin: 0 auto;
	     flex-grow: 1;
	 }
	 #wardrobe {
	     background: brown;
	     min-width: 50px;
	     padding: 20px;
	     display: flex;
	     flex-wrap: wrap;
	     gap: 20px;
	     flex: 1;
	 }
	 #wardrobe > * {
	     width: 50px;
	 }
	 #body-container {
	     flex: 2;
	     height: 70vh;
	     display: flex;
	     gap: 2px;
	     background: #777;
	     flex-wrap: wrap;
	 }
	 #body-container > * {
	     background: #eee;
	     flex-basis: 100%;
	     height: 20%;
	     display: flex;
	     justify-content: center;
	     align-items: center;
	 }
	 h1, h2 {
	     text-align: center;
	     margin: 0 auto;
	 }
	</style>
    </head>
    <body>
	<h1>Gentleman's Outfitters</h1>
	<h2>Of Tinsel Town</h2>
	<div id="booth-container">
	    <div id="wardrobe">
		<img id="wrangler-hat" class="hat" src="images/wrangler-hat.png" worn-width="150px">
		<img id="wrangler-pants" class="trousers" src="images/wrangler-pants.png" worn-width="50px">
	    </div>
	    <div id="body-container">
		<div id="hat-container"></div>
		<div id="head-container"></div>
		<div id="torso-container"></div>
		<div id="trousers-container"></div>
		<div id="feet-container"></div>
	    </div>
	</div>
    </body>
    
    <script>
     const wardrobe = document.getElementById('wardrobe');
     const wardrobe_items = wardrobe.getElementsByTagName('*');
     const body_container = document.getElementById('body-container');
     const body_slots = body_container.getElementsByTagName('div');
     const body_slot_reference = {
	 'hat': 0,
	 'head': 1,
	 'torso': 2,
	 'trousers': 3,
	 'feet': 4
     }

     function removeItem(item_type){
	 const item = body_slots[body_slot_reference[item_type]].getElementsByTagName('*')[0];
	 const body_slot = body_slots[body_slot_reference[item_type]];
	 body_slot.removeChild(item);
	 item.style.width = item.getAttribute('original-width');
	 wardrobe.appendChild(item);
     }

     function wearItem(event){
	 const item = event.target;
	 const item_type = item.classList[0];
	 if (item.parentNode.id != 'wardrobe'){ // item is already on
	     removeItem(item_type); // take it off
	 } else {
	     const body_slot = body_slots[body_slot_reference[item_type]];
	     if (body_slot.getElementsByTagName('*').length != 0){
		 removeItem(item_type);
	     }
	     item.setAttribute('original-width', item.style.width);
	     item.style.width = item.getAttribute('worn-width');
	     body_slot.appendChild(item);
	 }
     }
     
     window.onload = (event) => {
	 for (i=0; i<wardrobe_items.length; ++i){
	     const item = wardrobe_items[i];
	     item.addEventListener('click',wearItem);
	     item.style.imageRendering = 'pixelated';
	     item.style.height = 'fit-content';
	 }
     }
    </script>
</html>
