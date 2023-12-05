<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
  </head>
  <body>
	<div class="container">

			<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
					<div class="panel-body">
				<?
				$msg = "";
				if(isset($_POST['action']) && isset($_POST['theobj'])){
					if($_POST['action']=='doit'){
						$sql = "delete from files2tags where tag='".$_POST['theobj']."'";	
						$con = mysqli_connect("localhost", "", "", "");
						$con->query($sql);

						$sql = "delete from tags2users where tagName='".$_POST['theobj']."'";	
						$msg = "done";
					}
				}
				?>
				<h3><a href='tags.php'>Tags</a> / Delete tag <?echo $_GET['t']?></h3>
					<hr style='background-color:#ddd'>
				<font color='red'><? echo $msg; ?></font><br>
				<?
				if(isset($_GET['t'])){
				?>
				<form action='tagsDelete.php' method='post'>
					confirm the deletion: <input type='checkbox' name='confirm' required><br>
					<br>
					<input type='submit' value='DELETE !'>
					<input type='hidden' name='action' value='doit'>
					<input type='hidden' name='theobj' value='<?echo $_GET['t']?>'>
				</form>
				<?
				}
				?>
				<br>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>

	</div>
  </body>
</html>

