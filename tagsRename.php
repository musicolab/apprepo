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
				<h3><a href='tags.php'>Tags</a> / rename tag: #<?echo $_GET['t']?></h3>
				<hr style='background-color:#ddd'>
				<?
				if(isset($_POST['tagToRen'])){
					$con = mysqli_connect("localhost", "", "", "");
                                        $sql = "update files2tags set tag='".$_POST['newname']."' where tag='".$_POST['tagToRen']."'";
					$res = $con->query($sql);
                                        $sql = "update tags2users set tagName='".$_POST['newname']."' where tagName='".$_POST['tagToRen']."'";
					$res = $con->query($sql);
					if($res){
						?>
						success !<br>
						<br>
						<?
					}else{
						echo "<font color='red'>".$con->error."</font>";
					}

				}else{
				?>
				<form action='' method='post'>
					tag <b>#<?echo $_GET['t']?></b> will be renamed to <input type='text' name='newname' pattern='[A-Za-z0-9]{3,}' required><br>
					<br>
					<input type='hidden' name='tagToRen' value='<?echo $_GET['t']?>'>
					<input type='submit' value='rename'>
				</form>
				<br>
				<br>
				<?
				}
				?>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>

	</div>
  </body>
</html>

