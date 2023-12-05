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

			<div class="col-sm-3">
				<br>
				<hr>
				Please use our <a href='https://musicolab.hmu.gr/moodle'>Learning Management System</a> to login<br>
				<hr>
				<form action='index.php' method='post'>
				username<br>
				<input type='text' name='user' required><br>
				password<br>
				<input type='password' name='pass' required><br>
				<br>
				<input type='hidden' name='action' value='externalLogin'>
				<input type='submit'>
				</form>
			</div>
			<div class="col-sm-9">
				<br>
				<h3>repository</h3>
				<img src='underConstruction.png'>
				<br>
				<br>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

