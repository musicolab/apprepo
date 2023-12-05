<!DOCTYPE html>
<html>
  <head>
		<link rel="stylesheet" href="/repository/js/codemirror.css">
				<script src="js/codemirror.js"></script>
		<?include 'headerHtml.php'?>
  </head>
  <body>
	<div class="container">

		<div class="row" style='background-image:url("Header2.jpeg");background-size:cover; height:100px; position:relative'>
			<?include 'header.php'?>
		</div>

		<div class="row">
			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<br>
				<h3>repository / open public file / <?echo $_GET['f']?></h3>
				<textarea id='myTextarea' required><?
					$handle = fopen("/var/www/moodledata/repository/jsonFiles/".$_GET['f'], "r");
					if ($handle) {
						while (($line = fgets($handle)) !== false) {
							echo $line;
					    }
					    fclose($handle);
					} else {
					} 
				?></textarea>
				<script>
					var editor = CodeMirror.fromTextArea(myTextarea, {
					lineNumbers: true
					});
				</script>
				<br>
				<br>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

