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
			$f    = $_GET['f'];
                        $con  = mysqli_connect("localhost", "", "", "");
			$res  = $con->query("select * from metadata where filetype='private' and id=".$f)->fetch_assoc();
			$ulen = strlen($_SESSION['USER']['id']);
			$done = false;
			$msg  = "";
	
			if(file_exists("/var/www/moodledata/repository/jsonFiles/courses/".$_GET['targ'])){
			}else{
				mkdir("/var/www/moodledata/repository/jsonFiles/courses/".$_GET['targ'], 0777, true);
			}

			if(isset($_GET['cp'])){
			if($_GET['cp']=='cp'){
				if($_GET['targ']=='public'){
					#echo $res['filename'].'<br>';
					$fname = "/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'], 48+$ulen);
					#$fname = "/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']['id']."/".substr($res['filename'], 48+$ulen);
					echo $fname.'<br>';
						//$sql = "insert into metadata values('public','".$fname."','".$res['duration']."','".$res['encoding']."','".$res['size']."','".$res['owner']."','".$res['ownergroup']."', '".$res['genre']."', '".$res['tonality']."', '".$res['title']."', '".$res['composer']."', '".$res['compositiondate']."', '".$res['performer']."', '".$res['musicContent']."', '".$res['unfoldedMusic']."', '".$res['tempo']."', '".$res['originalMelod']."', NULL)";
						$stmt = $con->prepare("insert into metadata values('public',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NULL)");
                	                        $stmt->bind_param("ssssssssssssssssss",$fname,$res['duration'],$res['encoding'],$res['size'],$_SESSION['USER']['username'],$_SESSION['USER']['username'],$res['genre'],$res['tonality'],$res['thekey'],$res['thescale'],$res['title'],$res['composer'],$res['compositiondate'],$res['performer'],$res['musicContent'],$res['unfoldedMusic'],$res['tempo'],$res['originalMelody']);
						//if($con->query($sql)){
						try{
							$stmt->execute();
						}catch(Exception $e){
							$sql = "delete from metadata where filetype='private' and id=".$f;
                        	                        $con->query($sql);
						}
						#echo "copying ".$res['filename']." to ". $fname."<br>";
						copy($res['filename'], $fname);
						$msg = $msg . "DONE !<br>";
				}else{
					 $fname = "/var/www/moodledata/repository/jsonFiles/courses/".$_GET['targ']."/".substr($res['filename'], 49);
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
					 copy("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']['id']."/".substr($res['filename'],48), $fname);
					 #echo "copying: /var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']['id']."/".substr($res['filename'],48). " to ".$fname;
                                         $msg = $msg. "DONE !<br>";
				}
			}else if($_GET['cp']=='mv'){
				if($_GET['targ']=='public'){
                                        #echo $res['filename'].'<br>';
                                        $fname = "/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'], 48+$ulen);
                                        #echo $fname.'<br>';
                                        //$sql = "insert into metadata values('public','".$fname."','".$res['duration']."','".$res['encoding']."','".$res['size']."','".$res['owner']."','".$res['ownergroup']."', '".$res['genre']."', '".$res['tonality']."', '".$res['title']."', '".$res['composer']."', '".$res['compositiondate']."', '".$res['performer']."', '".$res['musicContent']."', '".$res['unfoldedMusic']."', '".$res['tempo']."', '".$res['originalMelod']."', NULL)";
                                        $stmt = $con->prepare("insert into metadata values('public',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NULL)");
                                        $stmt->bind_param("ssssssssssssssssss",$fname,$res['duration'],$res['encoding'],$res['size'],$_SESSION['USER']['username'],$_SESSION['USER']['username'],$res['genre'],$res['tonality'],$res['thekey'],$res['thescale'],$res['title'],$res['composer'],$res['compositiondate'],$res['performer'],$res['musicContent'],$res['unfoldedMusic'],$res['tempo'],$res['originalMelody']);
                                        //if($con->query($sql)){
                                        try{
                                                $stmt->execute();
                                        }catch(Exception $e){
                                        	$sql = "delete from metadata where filetype='private' and id=".$f;
                                                $con->query($sql);
                                        }
                                        copy($res['filename'], $fname);
                                        $msg = $msg . "DONE !<br>";
                                }else{
                                         $fname = "/var/www/moodledata/repository/jsonFiles/courses/".$_GET['targ']."/".substr($res['filename'], 49);
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
				#echo "deleting file ".$f;
				$sql = "delete from metadata where filetype='private' and id=".$f;
				$con->query($sql);
				//console_log($sql);
				//rename($res['filename'], $fname);
				//$msg = $msg . "DONE !<br>";
			}
			}
                        ?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">

                                <?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Private Files / Copy / <?echo substr($res['filename'], 48+$ulen)?></h3>
				<hr style='background-color:#ddd'>
				<br>
				<form action='copyPrivateFile.php' id='theform'>
				<select name='cp' id='cp' required>
					<option value=''></option>
					<option value='cp'>copy</option>
					<option value='mv'>move</option>
				</select>
				to the <select name='targ' id='targ' required>
						<option value=''></option>				
						<option value='public'>PUBLIC FILES</option>				
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
					</select><br>

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

