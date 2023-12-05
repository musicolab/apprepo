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
					$fid  = $_GET['fid'];
					$action   = $_GET['action'];
					if($action==="dothedel"){
						$sql = "delete from metadata where filetype='course' and id=".$fid;
						#echo $sql . "<br>";
						$con1->query($sql);
						echo "<h3>Course Files / Delete / ".$_GET['fname']."</h3>";
						?>
						<hr style='background-color:#ddd'>
						<br>
						<font color='blue'>the file was deleted succesfully</font></br>
						<?
					}else{
						//$sql = "select * from metadata where filetype='private' and id=".$f;
						//$rowdel = $con1->query($sql)->fetch_assoc();
						//$len = strlen("/var/www/moodledata/repository/jsonFiles/courses/".$_GET['cid']."/");
                                ?>
						<h3><?echo $_GET['cname']?> / Delete / <?echo $_GET['fname']?></h3>
						<hr style='background-color:#ddd'>
						<form action='delCourseFile.php' id='theform' method='get'>
							<br>	
							<input type='button' value='PLEASE CONFIRM THE DELETION' onclick='doit()'>
							<input type='hidden' name='fname' value='<?echo $_GET['fname'];?>'>
							<input type='hidden' name='cid'   value='<?echo $_GET['cid'];?>'>
							<input type='hidden' name='fid'   value='<?echo $_GET['fid'];?>'>
							<input type='hidden' name='cname'   value='<?echo $_GET['cname'];?>'>
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

