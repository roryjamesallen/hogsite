<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<style>
	 body {
	     background: black;
	 }
	 #template {
	     margin-left: -200vw;
	 }
	 .tube {
	     position: absolute;
	     background: black;
	     display: flex;
	     height: 7rem;
	     width: fit-content;
	     gap: 0.2rem;
	     transition: margin-left 10s;
	 }
	 .section {
	     display: flex;
	 }
	 .door, .carriage {
	     height: 80%;
	 }
	 .door {
	     background: red;
	     width: 2rem;
	 }
	 .carriage {
	     background: #f4f4f4;
	     width: 10rem;
	     position: relative;
	 }
	 .window, .stripe, .top {
	     position: absolute;
	     height: 20%;
	 }
	 .top, .stripe {
	     width: 100%;
	 }
	 .window {
	     background: black;
	     bottom: 40%;
	     width: 80%;
	 }
	 .right {
	     right: 0;
	 }
	 .full {
	     width: 100%;
	 }
	 .stripe {
	     background: blue;
	     bottom: 0;
	 }
	 .top {
	     background: #e8e8e8;
	 }
	</style>
    </head>
    <body>
	<div class="tube" id="template">
	    <div class="section">
		<div class="door"></div>
		<div class="carriage">
		    <div class="window right"></div>
		    <div class="stripe"></div>
		    <div class="top"></div>
		</div>
		<div class="door"></div>
	    </div>
	    <div class="section">
		<div class="door"></div>
		<div class="carriage">
		    <div class="window full"></div>
		    <div class="stripe"></div>
		    <div class="top"></div>
		</div>
		<div class="door"></div>
	    </div>
	    <div class="section">
		<div class="door"></div>
		<div class="carriage">
		    <div class="window"></div>
		    <div class="stripe"></div>
		    <div class="top"></div>
		</div>
		<div class="door"></div>
	    </div>
	    <div class="section">
		<div class="door"></div>
		<div class="carriage">
		    <div class="window right"></div>
		    <div class="stripe"></div>
		    <div class="top"></div>
		</div>
		<div class="door"></div>
	    </div>
	    <div class="section">
		<div class="door"></div>
		<div class="carriage">
		    <div class="window full"></div>
		    <div class="stripe"></div>
		    <div class="top"></div>
		</div>
		<div class="door"></div>
	    </div>
	    <div class="section">
		<div class="door"></div>
		<div class="carriage">
		    <div class="window"></div>
		    <div class="stripe"></div>
		    <div class="top"></div>
		</div>
		<div class="door"></div>
	    </div>
	</div>
    </body>
    <script>
     const tube_html = document.getElementById('template').innerHTML;
     function createTube(){
	 const new_tube = document.createElement("div");
	 new_tube.innerHTML = tube_html;
	 new_tube.classList.add('tube');
	 document.body.appendChild(new_tube);
	 new_tube.style.marginLeft = '-100vw';
	 const z_index = Math.floor(Math.random() * 100);
	 new_tube.style.zIndex = z_index;
	 new_tube.style.marginTop = Math.floor(Math.random() * 100) + 'vh';
	 new_tube.style.filter = 'brightness(' + z_index / 100 + ')';
	 const transition = 100 - z_index;
	 new_tube.style.transition = 'margin-left ' + transition + 's';
	 setTimeout(() => { new_tube.style.marginLeft = '100vw'; }, 50);
	 setTimeout(() => { document.body.removeChild(new_tube); }, z_index * 1000);
     }

     setInterval(function () {
	 if (Math.random() > 0.1){
	     createTube();
	 }
     }, 100);
	 
    </script>
</html>
