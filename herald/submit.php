<?php
$error = '';
if (isset($_POST['submitted'])){
    $missing_field = false;
    foreach (['heading','category','image','author','email'] as $input){
	if ($_POST[$input].trim() == ''){
	    $missing_field = true;
	}
    }
    if ($missing_field){
	$error = '<div style="color: red">Please fill in all fields</div>';
    } else {
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include 'html_head.php' ?>
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
	<div id="newspaper">
	    <div id="header" class="pad">
		<a id="hogwild-link" href="https://hogwild.uk">hogwild.uk</a>
		<div id="date">Last Updated: Monday 12th January 2026</div>
	    </div>
	    <h1 id="title" class="pad">The Hogwild Herald</h1>
	    
	    <form class="article pad submit-form" method="post">
		<?php echo $error;?>
		<label for="heading-input">Heading (article title)</label>
		<input name="heading" id="heading-input">
		<label for="category-input">Category</label>
		<input name="category" id="category-input">
		<label for="image-input">Image (optional, jpeg only)</label>
		<input type="file" name="image" id="image-input" accept="image/jpeg"/>
		<label for="article-input">Article</label>
		<textarea name="article" id="article-input"></textarea>
		<label for="author-input">Author (your real name/pen name)</label>
		<input name="author" id="author-input">
		<label for="email-input">Email (only used for feedback)</label>
		<input name="email" id="email-input">
		<input name="submitted" type="hidden" value="true">
		<input type="submit" value="Submit">
	    </form>
	</div>
    </body>
    <footer>
	A <a href="https://hogwild.uk">hogwild.uk</a> creation
    </footer>
</html>
