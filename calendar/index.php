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
      <div id="result">
  </body>

  <script>
   const form = document.getElementById('form');
   const checkbox = form.firstElementChild;
   checkbox.addEventListener('change',calculateResult);
   const result = document.getElementById('result');
   
   function calculateResult(){
       let total = 0;
       for (const box of form.children) {
	   bit = parseInt(box.id.replace('box',''));
	   bit_mult = 2 ** bit;
	   total += bit_mult * parseInt(box.checked ? '1' : '0');
       }
       result.innerText = total;
   }

   for (let box=1; box<365; ++box){
       let new_box = checkbox.cloneNode(true);
       new_box.id = 'box' + box;
       new_box.addEventListener('change',calculateResult);
       form.appendChild(new_box);
   }
  </script>
</html>
