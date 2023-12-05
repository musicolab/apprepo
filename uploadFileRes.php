<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<style>
			#zipSizeBar{
				background-color:red;
				width:100%;
				transition: width 2s;
				transition-timing-function: linear; 
				border: 1px solid black;
			}
			.loader {
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
			function runTransitions(){
				zipsizebar = document.getElementById("zipSizeBar");
				zipsizebar.width = '100%';
			}
			function stopLoader(){
				loader = document.getElementById("loader");
				setTimeout(loader.style.visibility='hidden', 4000);
				submitBtn = document.getElementById("submitButton");
				submitBtn.style.visibility='visible';
				runTransitions();
			}

			function upload(){
				form = document.getElementById("theform");
    				thefile = document.getElementById("f");
				folder = document.getElementById("ufolder");

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
     					loader = document.getElementById("loader");
     					loader.style.visibility='visible';
     					submitBtn = document.getElementById("submitButton");
     					submitBtn.style.visibility='hidden';
     					form.submit();
    				}
			}
		</script>
  </head>
  <body onload='stopLoader()'>
	<div class="container">

		<div class="row" style='background-image:url("Header2.jpeg");background-size:cover; height:100px; position:relative'>
			<?include 'header.php'?>
		</div>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<br>
				<?
                                if(isset($_SESSION["USER"]->username)){
                                ?>
				<h3>repository / file upload / result</h3>
				<?
				$err = "noerr";

				if(!isset($_POST['action'])){
					echo "invalid state, please contact the admins<br>";
                                }else{
					if($_POST['action']=="upload"){
						//echo "<font color='red'>starting the upload</font><br>";
						//echo "<font color='red'>uploading to <b>".$_POST['ufolder']."</b></font><br>";
						$targetDir = "/var/www/moodledata/repository/jsonFiles/".$_POST['ufolder'].'/';
						$targetFile = $targetDir . basename($_FILES["f"]["name"]);
						#echo "target = ".$targetFile."<br>";
						if(move_uploaded_file($_FILES['f']["tmp_name"], $targetFile)){
							echo "<font color='red'>uploaded ".basename($_FILES["f"]["name"])." in the ".$_POST['ufolder']." folder sucessfully</font><br>";
							$filetype = $_POST['ufolder'];
							if($filetype!="public") $filetype='private';
							$duration = "";
							$encoding = "";
							$size     = filesize($targetFile);
							$owner    = $_SESSION["USER"]->username;
							$ownergrp = $_SESSION["USER"]->username;

							$finfo    = finfo_open(FILEINFO_MIME_TYPE);
							$encoding = finfo_file($finfo, $targetFile);
							//echo "encoding = ".$encoding."<br>";
							if($encoding=='audio/mpeg'){
								require_once("getID3-master/getid3/getid3.php");
								$encoding = $encoding;
								$getid3   = new getID3;
								$data     = $getid3->analyze($targetFile);
								$duration = $data['playtime_seconds'];
								//echo $duration."<br>";
							}
							finfo_close($finfo);

							$con = mysqli_connect("localhost", "", "", "");
							#$sql = 'select * from metadata where filename="'.mysqli_real_escape_string($targetFile).'"';
							$stmt = $con->prepare('select * from metadata where filename=?');
							$stmt->bind_param("s",$targetFile);
							#echo $sql."<br>";
							#$res = $con->query($sql)->fetch_assoc();
							$stmt->execute();
	    						$res = $stmt->get_result()->fetch_assoc();
							if($res){
								//echo "file already exists in the database, done<br>";
								//$sql = "update metadata set filetype='".$filetype."', filename='".$targetFile."', duration='".$duration."', encoding='".$encoding."',size='".$size."',owner='".$owner."',ownergroup='".$ownergrp."' where id=".$res['id'];
								//echo $sql."<br>";
							}else{
								#$sql = "insert into metadata values('".$filetype."','".$targetFile."','".$duration."','".$encoding."','".$size."','".$owner."','".$ownergrp."', null, null, null, null, null, null, null, null, null, null, null)";
								$sql = "insert into metadata values(?,?,?,?,?,?,?,null,null,null,null,null,null,null,null,null,null,null)";
								$stmt = $con->prepare($sql);
								$stmt->bind_param('sssssss',$filetype,$targetFile,$duration,$encoding,$size,$owner,$ownergrp);
								#if($con->query($sql)===TRUE){
								if($stmt->execute()===TRUE){
									echo "<font color='red'>successfully added file in the db, done</font><br>";
								}else{
									echo "<font color='red'> error 1: ".$con->error."</font>"."<br>";
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
				}
				?>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

