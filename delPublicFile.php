<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<style>
			fieldset{border:0px}
		</style>
		<script>
			function doit(){
				if(confirm("please confirm")){
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
					$con1 = mysqli_connect("localhost", "", "", "");
					$f   = $_GET['f'];
					$action   = $_GET['action'];
					if($action==="dothedel"){
						$sql = "delete from metadata where filetype='public' and id=".$f;
						$con1->query($sql);
						echo "<h3>Public Files / Delete / done !!</h3>";
						?>
						<hr style='background-color:#ddd'>
						<div class="alert alert-info">Done: The file was deleted succesfully !</div>
                                                <?
					}else{
						$sql = "select * from metadata where filetype='public' and id=".$f;
						$rowdel = $con1->query($sql)->fetch_assoc();
                                ?>
						<h3>Public Files / Delete / <?echo substr($rowdel['filename'],48)?></h3>
						<hr style='background-color:#ddd'>
						<form action='delPublicFile.php' id='theform' method='get'>
							<br>	
							<input type='button' value='PLEASE CONFIRM THE DELETION' onclick='doit()'>
							<input type='hidden' name='f' value='<?echo $_GET['f'];?>'>
							<input type='hidden' name='action' value='dothedel'>
						</form>
						<br>
				<?
					}
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

