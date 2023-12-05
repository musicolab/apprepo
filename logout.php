<? session_start(); ?>
			<?
			if(isset($_POST['userToLogout'])){
				$_SESSION['USER']='';
				session_destroy();
				header("Location: https://musicolab.hmu.gr/apprepository/index.php");
			}
			?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script language='javascript'>
			function doit(){
				if(confirm('παρακαλώ επιβεβαιώστε την έξοδό σας από το σύστημα')){
					document.getElementById("theform").submit();
				}
			}
		</script>
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
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
					<h3>Logout</h3>
					<hr style='background-color:#ddd'>
					<br>
					<?
					if(!isset($_SESSION['USER'])){
	                        	}else{
		                        ?>
					<form action='logout.php' id='theform' method='post'>
						<input type='button' value='LOGOUT' onclick='doit();'>
						<input type='hidden' name='userToLogout' value='logout'/>
					</form>
					<br>
					<?
					}
					?>
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

