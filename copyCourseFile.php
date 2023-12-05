<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script>
			function doit(){
				cp = document.getElementById("cp");
				cpVal = cp.options[cp.selectedIndex].value;
				if(cpVal!=""){
					if(confirm("please confirm")){
						document.getElementById("theform").submit();
					}
				}else{
					alert("please select an option from the drop down ");
				}
			}
		</script>
  </head>
  <body>
	<div class="container">

		<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<?
			$fid    = $_GET['fid'];
			$fname  = $_GET['fname'];
			$cid    = $_GET['cid'];
			$cname  = $_GET['cname'];
			$cp     = $_GET['cp'];
			$dst    = $_GET['dst'];

                        $con  = mysqli_connect("localhost", "", "", "");
			$res  = $con->query("select * from metadata where filetype='course' and id=".$fid)->fetch_assoc();
			$ulen = strlen($_SESSION['USER']['id']);
			$done = false;
			$msg  = "";
			if(isset($_GET['cp'])){
				if($_GET['cp']=='cp'){
					if($dst=='public'){
						$fname = "/var/www/moodledata/repository/jsonFiles/public/".$fname;
						$stmt = $con->prepare("insert into metadata values('public',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NULL)");
        	                                $stmt->bind_param("ssssssssssssssssss",$fname,$res['duration'],$res['encoding'],$res['size'],$_SESSION['USER']['username'],$_SESSION['USER']['username'],$res['genre'],$res['tonality'],$res['thekey'],$res['thescale'],$res['title'],$res['composer'],$res['compositiondate'],$res['performer'],$res['musicContent'],$res['unfoldedMusic'],$res['tempo'],$res['originalMelody']);
						try{
							$stmt->execute();
						}catch(Exception $e){
							$sql = "delete from metadata where filetype='public' and id=".$fid;
                        	                        $con->query($sql);
						}
						copy($res['filename'], $fname);
						$msg = $msg . "DONE !<br>";
					}else if($dst=='private'){
						$fname = "/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']['id']."/".$fname;
						$stmt = $con->prepare("insert into metadata values('private',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NULL)");
                                                $stmt->bind_param("ssssssssssssssssss",$fname,$res['duration'],$res['encoding'],$res['size'],$_SESSION['USER']['username'],$_SESSION['USER']['username'],$res['genre'],$res['tonality'],$res['thekey'],$res['thescale'],$res['title'],$res['composer'],$res['compositiondate'],$res['performer'],$res['musicContent'],$res['unfoldedMusic'],$res['tempo'],$res['originalMelody']);
                                                try{
                                                        $stmt->execute();
                                                }catch(Exception $e){
                                                        $sql = "delete from metadata where filetype='private' and id=".$fid;
                                                        $con->query($sql);
                                                }
                                                copy($res['filename'], $fname);
                                                $msg = $msg . "DONE !<br>";
					}
				}else if($_GET['cp']=='mv'){
					if($dst=='public'){
						$fname = "/var/www/moodledata/repository/jsonFiles/public/".$fname;
						$stmt = $con->prepare("update metadata set filename=?, filetype='public' where id=?");
        	                                $stmt->bind_param("si", $fname, $fid);
						try{
							$stmt->execute();
						}catch(Exception $e){
							$sql = "delete from metadata where filetype='course' and id=".$fid;
							$con->query($sql);
						}
						rename($res['filename'], $fname);
						$msg = $msg . "DONE !<br>";
					}else if($dst=='private'){
						$fname = "/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']['id']."/".$fname;
						$stmt = $con->prepare("update metadata set filename=?, filetype='private' where id=?");
                                                $stmt->bind_param("si", $fname, $fid);
                                                try{
                                                        $stmt->execute();
                                                }catch(Exception $e){
                                                        $sql = "delete from metadata where filetype='course' and id=".$fid;
                                                        $con->query($sql);
                                                }
                                                rename($res['filename'], $fname);
                                                $msg = $msg . "DONE !<br>";
					}
				}
			}
                        ?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
                                <?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Course <?echo $_GET['cname']?> / Copy or move / <?echo $_GET['fname']?></h3>
				<hr style='background-color:#ddd'>
				<br>
				<form action='copyCourseFile.php' id='theform'>
				<select name='cp' id='cp' required>
					<option value=''></option>
					<option value='cp'>copy</option>
					<option value='mv'>move</option>
				</select>
				to the 
				<select name='dst' id='dst' required>
                                        <option value=''></option>
                                        <option value='public'>public files</option>
                                        <option value='private'>private files</option>
                                </select>
				<input type='button' onclick='doit()' value='SUBMIT'>
				<input type='hidden' name='fid' value='<?echo $_GET['fid'];?>'>
				<input type='hidden' name='fname' value='<?echo $_GET['fname'];?>'>
				<input type='hidden' name='cname' value='<?echo $_GET['cname'];?>'>
				<input type='hidden' name='cid' value='<?echo $_GET['cid'];?>'>
				</form>
				<br>
				<?
				if($msg!=""){
				?>
					<div class="alert alert-info" style="margin-bottom:0px"><? echo $msg; ?></div>
				<?
				}
				if($done==true){
				}else{
				?>
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

