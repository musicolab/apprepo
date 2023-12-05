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
						$sql = "delete from metadata where filetype='private' and id=".$f;
						#echo $sql . "<br>";
						$con1->query($sql);
						echo "<h3>Private Files / Delete</h3>";
						?>
						<hr style='background-color:#ddd'>
						<font color='red'>the file was deleted succesfully</font></br>
						<?
					}else{
						$sql = "select * from metadata where filetype='private' and id=".$f;
						$rowdel = $con1->query($sql)->fetch_assoc();
						$len = strlen("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION["USER"]->id."/");
                                ?>
						<h3>Private Files / Delete / <?echo substr($rowdel['filename'],$len+1)?></h3>
						<hr style='background-color:#ddd'>
						<form action='delPrivateFile.php' id='theform' method='get'>
							<br>	
							<input type='button' value='PLEASE CONFIRM THE DELETION' onclick='doit()'>
							<input type='hidden' name='f' value='<?echo $_GET['f'];?>'>
							<input type='hidden' name='action' value='dothedel'>
						</form>
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

