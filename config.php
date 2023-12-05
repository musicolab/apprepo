<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
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
				<?
                                if(isset($_SESSION["USER"]->username)){
                                ?>
				<h3>repository / config &amp; system params</h3>

				context root: /var/www/moodledata/repository/jsonFiles/<br>
				session sharing method: no session sharing<br>
				allowed files: midi, mp3, flac, ...<br>
				allowed roleids: not 5 (student)<br>
				DB schema: <!--a href='schema.sql'--><i class="fa fa-database"></i></a><br>
				<?}?>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

