<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="utf-8">
     <title>Stupid Calendar</title>

     <style>
      #form {
	  display: flex;
	  flex-wrap: wrap;
	  /*width: 150px;*/
      }
      input {
      }
     </style>
  </head>
  
    <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-6BQYQMEP06"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-6BQYQMEP06');
  </script>
  
  <body>
      <div id="form">
	  <input type="checkbox" id="box0">
      </div>
      <input id="result">
  </body>

  <script>
   const form = document.getElementById('form');
   const checkbox = form.firstElementChild;
   checkbox.addEventListener('change',calculateResult);
   const result = document.getElementById('result');
   result.addEventListener('change', updateBoxes);

   function dec2bin(dec) {
       return (dec >>> 0).toString(2).padStart(365, '0').split("").reverse().join("");
   }
   
   function updateBoxes(){
       const decimal = result.value;
       const binary = dec2bin(decimal);
       console.log(decimal);
       console.log(binary);
       for (const box of form.children) {
	   bit = parseInt(box.id.replace('box',''));
	   if (binary[bit] == 1){
	       box.checked = true;
	   } else {
	       box.checked = false;
	   }
       }
   }
   
   function calculateResult(){
       let total = 0;
       for (const box of form.children) {
	   bit = parseInt(box.id.replace('box',''));
	   bit_mult = 2 ** bit;
	   total += bit_mult * parseInt(box.checked ? '1' : '0');
       }
       result.value = total;
   }

   for (let box=1; box<365; ++box){
       let new_box = checkbox.cloneNode(true);
       new_box.id = 'box' + box;
       new_box.addEventListener('change',calculateResult);
       form.appendChild(new_box);
   }
  </script>
</html>
