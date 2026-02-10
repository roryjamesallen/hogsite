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
	     height: 70vh;
	 }
	 #booth-container > * {
	     margin: 0 auto;
	     flex-grow: 1;
	 }
	 #wardrobe {
	     min-width: 50px;
	     display: flex;
	     flex-wrap: wrap;
	     gap: 2px;
	     flex: 1;
	 }
	 #wardrobe > * {
	     background: beige;
	     flex-basis: 100%;
	     overflow-x: scroll;
	     overflow-y: hidden;
	 }
	 #wardrobe img {
	     height: 100%;
	 }
	 #body-container {
	     flex: 2;
	     display: flex;
	     gap: 2px;
	     background: #777;
	     flex-wrap: wrap;
	 }
	 #body-container > * {
	     background: #eee;
	     flex-basis: 100%;
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
		<div id="hats" class="wardrobe-type" style="height: 10%">
		    <img id="wrangler-hat" class="hat" src="images/wrangler-hat.png">
		</div>
		<div id="heads" class="wardrobe-type" style="height: 20%">
		    
		</div>
		<div id="torsos" class="wardrobe-type" style="height: 30%">
		    
		</div>
		<div id="trousers" class="wardrobe-type" style="height: 30%">
		    <img id="wrangler-pants" class="trouser" src="images/wrangler-pants.png">
		</div>
		<div id="feet" class="wardrobe-type" style="height: 10%">
		    
		</div>
	    </div>
	    <div id="body-container">
		<div id="hat-container" style="height: 10%"></div>
		<div id="head-container" style="height: 20%"></div>
		<div id="torso-container" style="height: 30%"></div>
		<div id="trouser-container" style="height: 30%"></div>
		<div id="feet-container" style="height: 10%;"></div>
	    </div>
	</div>
    </body>
    
    <script>
     const wardrobe = document.getElementById('wardrobe');
     const wardrobe_items = wardrobe.getElementsByTagName('img');
     const body_container = document.getElementById('body-container');
     const body_slots = body_container.getElementsByTagName('div');
     const body_slot_reference = {
	 'hat': 0,
	 'head': 1,
	 'torso': 2,
	 'trouser': 3,
	 'feet': 4
     }

     function removeItem(item_type){
	 const item = body_slots[body_slot_reference[item_type]].getElementsByTagName('*')[0];
	 const body_slot = body_slots[body_slot_reference[item_type]];
	 body_slot.removeChild(item);
	 item.style.width = item.getAttribute('original-width');
	 console.log(item.classList[0]+'s');
	 document.getElementById(item.classList[0]+'s').appendChild(item);
     }

     function wearItem(event){
	 const item = event.target;
	 const item_type = item.classList[0];
	 if (!item.parentNode.classList.contains('wardrobe-type')){ // item is already on
	     removeItem(item_type); // take it off
	 } else {
	     const body_slot = body_slots[body_slot_reference[item_type]];
	     if (body_slot.getElementsByTagName('*').length != 0){
		 removeItem(item_type);
	     }
	     item.setAttribute('original-width', item.style.width);
	     item.style.height = '100%';
	     body_slot.appendChild(item);
	 }
     }
     
     window.onload = (event) => {
	 for (i=0; i<wardrobe_items.length; ++i){
	     const item = wardrobe_items[i];
	     item.addEventListener('click',wearItem);
	     item.style.imageRendering = 'pixelated';
	     //item.style.height = 'fit-content';
	 }
     }
    </script>
</html>
