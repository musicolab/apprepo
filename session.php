<? session_start(); ?>
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
				<h3>session</h3>
				<?
				print_r($_SESSION);
				?>
				<br>
				<br>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

