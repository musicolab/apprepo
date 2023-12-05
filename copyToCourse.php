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

		<div class="row" style='background-image:url("Header2.jpeg");background-size:cover; height:100px; position:relative'>
			<?include 'header.php'?>
		</div>

		<div class="row">

			<?include 'menusLeft.php'?>

			<?
			$f    = $_GET['f'];
                        $con  = mysqli_connect("localhost", "", "", "");
			$res  = $con->query("select * from metadata where filetype='public' and id=".$f)->fetch_assoc();
			$done = false;
			if(isset($_GET['cp'])){
				$course = $_GET['course'];
				$fname = "/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']->id."/".$course."/".substr($res['filename'], 48);
				mkdir("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']->id."/".$course."/");
				echo $fname."<br>";
				if($_GET['cp']=='cp'){
					echo "copying f=".$f." to c=".$course.'<br>';
					$sql = "insert into metadata values('".$course."','".$fname."','".$res['duration']."','".$res['encoding']."','".$res['size']."','".$res['owner']."','".$res['ownergroup']."', '".$res['genre']."', '".$res['tonality']."', '".$res['title']."', '".$res['composer']."', '".$res['compositiondate']."', '".$res['performer']."', '".$res['musicContent']."', '".$res['unfoldedMusic']."', '".$res['tempo']."', '".$res['originalMelod']."', NULL)";
					
					if($con->query($sql)){
						echo "DONE !<br>";
					}else{
						echo "the file already exists in the db<br>";
					}
					if(file_exists($fname)){
						echo "the file alredy exists in the course files, overwriting<br>";
					}
					copy("/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'],48), $fname);
				}else if($_GET['cp']=='mv'){
					echo "moving f=".$f." to c=".$course.'<br>';
					$sql = "update metadata set filename='".$fname."', filetype='".$course."' where id=".$f;
					if($con->query($sql)){
						echo "DONE: public -> private in DB<br>";
						$done = true;
					}else{
						echo "DONE: cannot set filetype to private, probably hit constrain, deleting from the db<br>";
						$sql = "delete from metadata where filetype='".$course."' and id=".$f;
						$con->query($sql);
					}
					if(file_exists("/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'],48))){
						echo "the file exists in the FS, moving to the private the filesystem<br>";
						rename("/var/www/moodledata/repository/jsonFiles/public/".substr($res['filename'],48), $fname);
					}
				}
			}
                        ?>

			<div class="col-sm-9">
				<br>
				<?
                                if(isset($_SESSION["USER"]->username)){
                                ?>
				<h3>repository / public files / copy file to course / <?echo substr($res['filename'], 48)?></h3>

				<form action='copyToCourse.php' id='theform'>
				operation<br>
				<select name='cp' id='cp' required>
					<option value=''></option>
					<option value='cp'>copy</option>
					<option value='mv'>move</option>
				</select><br>
				select course<br>
                                <select name='course' id='course' required>
                                        <option value=''></option>
                                        <?
                                        $con  = mysqli_connect("localhost", "", "", "moodle");
                                        $sql = "SELECT c.id, ra.roleid, r.shortname, c.fullname, c.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category where u.id=".$_SESSION["USER"]->id ;
                                        $res = $con->query($sql);
                                        if($res){
                                                while($row = mysqli_fetch_assoc($res)){
                                                        $sql = "select * from course where id=".$row['id'];
                                                        $resCourses = $con->query($sql);
                                                        if($resCourses){
                                                                while($rowCourse = mysqli_fetch_assoc($resCourses)){
                                                                        //roleid=5 student, roleid=3 editing teacher
                                                                        if($row["roleid"]!=5){
                                                                        ?>
                                                                                <option value='<?echo $rowCourse['id'];?>'><?echo $rowCourse['fullname']?></option>
                                                                        <?
                                                                        }
                                                                }
                                                        }

                                                }
                                        }else{
                                                echo "no result !<br>";
                                        }
                                        ?>
                                        </option>
                                </select><br>
				<br>
				<input type='hidden' name='f' value='<?echo $_GET['f'];?>'>
				<?
				if($done==true){
				}else{
				?>
				<!--input type='button' onclick='doit()' value='SUBMIT'-->
				<input type='submit'>
				<?
				}
				}
				?>
				</form>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

