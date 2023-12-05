<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script>
			function mvChanged(){
				cp = document.getElementById("cp");
				cpVal = cp.options[cp.selectedIndex].value;
				if(cpVal=='mv'){
					tar = document.getElementById("targ");
					targ.selectedIndex=1;
				}
			}
			function cpChanged(){
				cp = document.getElementById("cp");
				cpVal = cp.options[cp.selectedIndex].value;
				console.log(cpVal);
				if(cpVal=='mv'){
					tar = document.getElementById("targ");
					targ.selectedIndex=1;
				}
			}
			function doit(){
				cp = document.getElementById("cp");
				cpVal = cp.options[cp.selectedIndex].value;
				tar  = document.getElementById("targ");
				tarVal = tar.options[tar.selectedIndex].value;
				if(cpVal!=""){
					if(tarVal!=""){
						if(confirm("please confirm")){
							document.getElementById("theform").submit();
						}
					}else{
						alert("please select an option from the second drop down menu");
					}
				}else{
					alert("please select an option from the first drop down menu");

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
			$f    = $_GET['f'];
                        $con  = mysqli_connect("localhost", "", "", "");
			$res  = $con->query("select * from metadata where filetype='public' and id=".$f)->fetch_assoc();
			$done = false;
			$msg  = "";
			if(isset($_GET['cp'])){
				//echo "input: ".$res['filename'].'<br>';
				//echo "user: ".$_SESSION["USER"]->username.'<br>';
				//echo "output: ".$fname.'<br>';
				if($_GET['cp']=='cp'){
					if($_GET["targ"]=="private"){
						$fname = "/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']['id']."/".substr($res['filename'], 48);
						$stmt1 = $con->prepare("select * from metadata where filetype='private' and filename=?");
						$stmt1->bind_param("s",$fname);
						$stmt1->execute();
						$res1 = $stmt1->get_result();
						$data1 = $res1->fetch_assoc();

						if(isset($data1)){
						}else{
							$stmt = $con->prepare("insert into metadata values('private',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NULL)");
							$stmt->bind_param("ssssssssssssssssss",$fname,$res['duration'],$res['encoding'],$res['size'],$_SESSION['USER']['username'],$_SESSION['USER']['username'],$res['genre'],$res['tonality'],$res['thekey'],$res['thescale'],$res['title'],$res['composer'],$res['compositiondate'],$res['performer'],$res['musicContent'],$res['unfoldedMusic'],$res['tempo'],$res['originalMelody']);
							if($stmt->execute()){
								//$msg = $msg. "DONE !<br>";
							}else{
								//$msg = $msg. "the file already exists in the db that is, for private files<br>";
							}
						} 
						copy("/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'],48), $fname);
						$msg = $msg. "DONE !<br>";
					}else{
						$fname = "/var/www/moodledata/repository/jsonFiles/courses/".$_GET['targ']."/".substr($res['filename'], 48);
						$stmt1 = $con->prepare("select * from metadata where filetype='course' and filename=?");
                                                $stmt1->bind_param("s",$fname);
                                                $stmt1->execute();
                                                $res1 = $stmt1->get_result();
                                                $data1 = $res1->fetch_assoc();

                                                if(isset($data1)){
                                                }else{
                                                        $stmt = $con->prepare("insert into metadata values('course',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NULL)");
                                                        $stmt->bind_param("ssssssssssssssssss",$fname,$res['duration'],$res['encoding'],$res['size'],$_SESSION['USER']['username'],$_SESSION['USER']['username'],$res['genre'],$res['tonality'],$res['thekey'],$res['thescale'],$res['title'],$res['composer'],$res['compositiondate'],$res['performer'],$res['musicContent'],$res['unfoldedMusic'],$res['tempo'],$res['originalMelody']);
                                                        if($stmt->execute()){
                                                                //$msg = $msg. "DONE !<br>";
                                                        }else{
                                                                //$msg = $msg. "the file already exists in the db that is, for private files<br>";
                                                        }
                                                }
                                                copy("/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'],48), $fname);
                                                $msg = $msg. "DONE !<br>";
					}
				}else if($_GET['cp']=='mv'){
					$fname = "/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']['id']."/".substr($res['filename'], 48);
					error_log("moving public file -> private");
					error_log(" - filename = ".$fname);
					error_log(" - id = ".$f);
					$stmt = $con->prepare("update metadata set filename=?, filetype='private' where id=?");
					$stmt->bind_param("si", $fname, $f);
					try{
						if($stmt->execute()){
							error_log(" - changed the file from public to private in the db");
						}
					}catch(Exception $e){
						error_log(" - cannot change the file from public to private, because it already exists, only need to delete the public and overwrite the file");
						$sql = "delete from metadata where filetype='public' and id=".$f;
						$con->query($sql);
					}
					//if(file_exists("/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'],48))){
					//	$msg = $msg. "the file exists in the private files (filesystem)<br>";
					//}
					rename("/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'],48), $fname);
					$msg = $msg. "DONE !<br>";
				}
			}
			?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
                                <?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
                                <h3>Public Files / Copy or Move / <?echo substr($res['filename'], 48)?></h3>
				<hr style='background-color:#ddd'>
				<form action='copyPublicFile.php' id='theform'>
				the file will be <select name='cp' id='cp' onchange='cpChanged()' required>
					<option value=''></option>
					<option value='cp'>copied</option>
					<? if($res['owner']==$_SESSION["USER"]['username']){ ?>
						<option value='mv'>moved</option>
					<? } ?>
				</select>
				to 
				<select name='targ' id='targ' required onchange='mvChanged()' required>
						<option value=''></option>
						<option value='private'>PRIVATE FILES</option>
				<?
                                              	$sql  = "SELECT u.username, c.id, c.fullname, r.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category WHERE r.id > 0 and u.username='".$_SESSION["USER"]["username"]."' and r.shortname<>'student'";
                                                $con3 = mysqli_connect("localhost", "", "", "moodleLms");
                                                $res  = $con3->query($sql);
                                                if($res){
                                                        while($row=mysqli_fetch_array($res)){
                                                                echo "<option value='".$row['id']."'>";
                                                                echo $row["fullname"].' (' . $row['shortname'].')';
                                                                echo "</option>";
                                                        }
                                                }
					?>
				</select>
				<br>
				<input type='hidden' name='f' value='<?echo $_GET['f'];?>'>
				<input type='button' onclick='doit()' value='SUBMIT'>
				</form>
				<br>
				<?
				if($msg!=""){
				?>
					<div class="alert alert-info" style="margin-bottom:0px"><? echo $msg; ?></div>
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

