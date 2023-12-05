<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<style>
			.loader {
				visibility:hidden;
				border: 10px solid #f3f3f3;
				border-radius: 50%;
				border-top: 10px solid #3498db;
				width: 30px;
				height: 30px;
				-webkit-animation: spin 2s linear infinite; /* Safari */
				animation: spin 2s linear infinite;
			}
			@keyframes spin{
				0% { transform:rotate(0deg); }
				100% { transform:rotate(360deg); }
			}
		</style>
		<script>
			function upload(){
				form = document.getElementById("theform");
    				thefile = document.getElementById("f");
				folder = document.getElementById("ufolder");
				pBar = document.getElementById("progressBar");

    				doit = true;
				if(folder.options[folder.selectedIndex].value=="") {
					alert("please select the section to upload to");
					doit = false;
				}else{
					if(thefile.value==""){
						alert("please select a local file to upload");
						doit = false;
					}
				}

    				if(doit){
     					conf = confirm("please confirm the submission");
     					//loader = document.getElementById("loader");
     					//loader.style.visibility='visible';
     					submitBtn = document.getElementById("submitButton");
					submitBtn.style.visibility='hidden';
					pBar.style.visibility="visible";
					form.submit();
					setInterval("updatePBarIn()", 1000);
					//pBarIn.style.width=count+"%";
				}
			}

			function updatePBarIn(){
				pBarIn = document.getElementById("progressBarInner");
				pct = pBarIn.innerHTML;
				pct = pct.substring(0, pct.length-1);
				pct = parseInt(pct) + 1;
				pBarIn.innerHTML=pct+"%";
				pBarIn.style.width=pct+"%";
			}

			function uploadAjax() {
				form = document.getElementById("theform");
                                thefile = document.getElementById("f");
                                folder = document.getElementById("ufolder");
				pBar = document.getElementById("progressBar");

				doit = true;
                                if(folder.options[folder.selectedIndex].value=="") {
                                        alert("please select the section to upload to");
                                        doit = false;
                                }else{
                                        if(thefile.value==""){
                                                alert("please select a local file to upload");
                                                doit = false;
                                        }
                                }

                                if(doit){
					var file = document.getElementById("f").files[0];
					var formdata = new FormData();
					formdata.append("f", file);
					formdata.append("ufolder", folder.value);
					formdata.append("action", "upload");
					var ajax = new XMLHttpRequest();
					ajax.upload.addEventListener("progress", progressHandler, false);
					ajax.addEventListener("load", completeHandler, false);
					//ajax.addEventListener("error", errorHandler, false);
					//ajax.addEventListener("abort", abortHandler, false);
					ajax.open("POST", "uploadFileResAjax.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
					ajax.send(formdata);
				}
			}
			
			function progressHandler(event) {
				var percent = (event.loaded / event.total) * 100;
				percent = Math.round(percent);
				pBarIn = document.getElementById("progressBarInner"); //.value = Math.round(percent);
				pBarIn.innerHTML   = percent+"%";
				pBarIn.style.width = percent+"%";
			}

			function completeHandler(event) {
				//document.getElementById("progressBar").value = 0; //wil clear progress bar after successful upload
				alert("DONE ! You may select another file to upload");
			}

			function errorHandler(event) {
				alert("ERROR !");
			}

			function abortHandler(event) {
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
				<h3>Upload Files</h3>
				<hr style='background-color:#ddd'>
				<?
				//require_once('getID3-master/getid3/getid3.php');

				$err = "noerr";

                                if(!isset($_POST['action'])){
                                }else{
					if($_POST['action']=="upload"){
						$targetDir = "/var/www/moodledata/repository/jsonFiles/".$_POST['ufolder'].'/';
						//$targetFile = $targetDir . basename($_FILES["f"]["name"]);
						echo "target file = ".$targetFile."<br>";
						if(move_uploaded_file($_FILES['f']["tmp_name"], $targetFile)){
							/*
							if(substr($targetFile,-3)=='mxl'){
								echo $targetFile."<br>";
								echo "it is an mxl file<br>";
								$zip = new ZipArchive;
								$res = $zip->open($targetFile);
								if ($res === TRUE) {
								  $zip->extractTo(substr($targetFile, 0, -3).".xml");
								  $zip->close();
								} else {
									echo "cannot unzip";
								}
							}
							*/
							//echo "<font color='red'>done ! Use the menus on the left to navigate</font>"."<br>";
							$filetype = $_POST['ufolder'];
							$duration = "";
							$encoding = "";
							$size     = filesize($targetFile);
							$owner    = $_SESSION["USER"]['username'];
							$ownergrp = $_SESSION["USER"]['role'];

							$finfo    = finfo_open(FILEINFO_MIME_TYPE);
							$encoding = finfo_file($finfo, $targetFile);
							//echo "encoding = ".$encoding."<br>";
							if($encoding=='audio/mpeg'){
								$encoding = $encoding;
								$getid3   = new getID3;
								$data     = $getid3->analyze($targetFile);
								$duration = $data['playtime_seconds'];
								//echo $duration."<br>";
							}
							finfo_close($finfo);

							$con = mysqli_connect("localhost", "", "", "");
							$sql = "select * from metadata where filename='".$targetFile."'";
							$res = $con->query($sql)->fetch_assoc();
							if($res){
								//echo "<font color='red'>done ! Use the menus on the left to navigate</font>"."<br>";
								//$sql = "update metadata set filetype='".$filetype."', filename='".$targetFile."', duration='".$duration."', encoding='".$encoding."',size='".$size."',owner='".$owner."',ownergroup='".$ownergrp."' where id=".$res['id'];
								//echo $sql."<br>";
							}else{
								$sql = "insert into metadata values('".$filetype."','".$targetFile."','".$duration."','".$encoding."','".$size."','".$owner."','".$ownergrp."', null, null, null, null, null, null, null, null, null, null, null)";
								echo "about to execute: ".$sql."<br>";
								if($con->query($sql)===TRUE){
								}else{
									echo "<font color='red'> error: ".$con->error."</font>"."<br>";
									$err = "error";
								}
							}
							//echo $sql;
						}else{
							echo "<font color='red'>upload error</font><br>";
							$err = "error";
						}
                                        }
                                }
                                ?>
				<form action='uploadFileResAjax.php' method='post' id='theform' enctype="multipart/form-data">
					<br>
					Select the section to upload to. The form accepts the following file types: mid, mei, json, wav, mp3, flac, avi, mkv, txt, krn, mxl, musicxml. Note that if the file name contains more than one dots, the extension will come from the string after the <i>first</i> one, and the filename will be returned from <a href='https://www.php.net/manual/en/function.basename.php' target='_blank'>basename() PHP function</a>.<br>
					<br>
					<select name='ufolder' id='ufolder' style='height:30px;' required>
						<option value=''></option>
						<option value='public'>upload a public file</option>
						<option value='users/<?echo $_SESSION['USER']['id']?>'>upload a private file</option>
						<?
                                                $sql  = "SELECT u.username, c.id, c.fullname, r.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category WHERE r.id > 0 and u.username='".$_SESSION["USER"]["username"]."' and r.shortname<>'student'";
                                                $con3 = mysqli_connect("localhost", "", "", "moodleLms");
                                                $res  = $con3->query($sql);
                                                if($res){
                                                        while($row=mysqli_fetch_array($res)){
								?>
								<option value='courses/<?echo $row['id']?>'>upload file for course: <?echo $row['fullname']?></option>
								<?
                                                        }
                                                }
                                                ?>
					</select> 
					<input type='file' name='f' id='f' accept='.mid,.mei,json,.wav,.mp3,.flac,.avi,.mkv,.txt,.krn,.mxl,.musicxml' style='display:inline' required></input><br>
					<br>
					<div class="progress" style='visibility:visible' id='progressBar'>
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id='progressBarInner'>0%</div>
					</div>
					<!--div class="loader" id="loader" style="visibility:hidden;"></div-->
					<?
					if(!isset($_POST['action'])){
					}else{
						if($_POST['action']=='upload' && $err=='noerr'){
							?><font color='red'>the upload was sucessful !</font><br><?
						}else{
							?><font color='red'>something went wrong, please try again or contact the admins</font><br><?
						}
					}
					?>
					<input type='button' value='SUBMIT' id='submitButton' onclick='uploadAjax()' style='display:inline;'>
					<input type='hidden' name='action' value='upload'/>
				</form>
				<?}?>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

