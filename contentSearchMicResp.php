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
		</script>
  </head>
  <body>
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
				<h3>search by content / upload recording / result</h3>
				<?
				$err = "noerr";
				error_log("-------------------------- ");
				error_log("--- CONTENT SEARCH MIC RESP",0);
				error_log(print_r($_POST, true));
				error_log(print_r($_FILES, true));
				error_log(" - action    = ".$_REQUEST['action'],0);
				error_log(" - filename  = ".$_POST['filename'],0);
				error_log(" - blob name = ".$_FILES['blob']['name'],0);
				error_log(" - blob size = ".$_FILES['blob']['size'],0);
				error_log(" - file size = ".$_FILES['file']['name'],0);
				error_log(" - file size = ".$_FILES['file']['size'],0);

				if(!isset($_POST['action'])){
					echo "invalid state, please contact the admins<br>";
					error_log("invalid state, please contact the admins",0);
                                }else{
					if($_POST['action']=="uploadFromMic"){
						echo "<font color='red'>starting the upload</font><br>";
						echo "<font color='red'>uploading to <b>".$_SESSION['USER']->username."'s private files</b></font><br>";
						$targetDir = "/var/www/moodledata/repository/jsonFiles/users/";
						$targetFile = $targetDir . $_SESSION["USER"]->id . '/' . $_POST['filename']; //basename($_FILES["f"]["name"]);
						echo "target = ".$targetFile."<br>";
						echo "fname = ".$_POST['filename']."<br>";
						echo "saving at ".$targetFile."<br>";
						error_log(" - saving at ".$targetFile, 0);
						//file_put_contents($targetFile, $_POST['datablob']);
						//file_put_contents($targetFile, $_FILES['file']);
						$data = $_FILES['file']['tmp_name'];
						move_uploaded_file($data, $targetFile);
						error_log(" - movin uploade file ".$_FILES['file']['tmp_name']. " to " . $targetFile);
						echo "calling the db<br>";
						/*
						if(move_uploaded_file($_FILES['filename']["tmp_name"], $targetFile)){
							echo "<font color='red'>uploaded ".basename($_FILES["f"]["name"])." sucessfully</font><br>";
						}else{
							echo "<font color='red'>upload error</font><br>";
							$err = "error";
						}
						 */
                                                        $filetype = 'private';
                                                        $duration = '';
                                                        $encoding = "";
							$size     = filesize($targetFile);
							echo " - sise of targetfile: ".$size.'<br>';
                                                        $owner    = $_SESSION["USER"]->username;
                                                        $ownergrp = trim($_SESSION["USER"]->role);
                                                        //$finfo    = finfo_open(FILEINFO_MIME_TYPE);
							//$encoding = finfo_file($finfo, $targetFile);
							//echo $encoding."<br>";
                                                        //finfo_close($finfo);

							$con = mysqli_connect("localhost", "", "", "");
							/*
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
							*/
                                                                $sql = "insert into metadata values(?,?,?,?,?,?,?,null,null,null,null,null,null,null,null,null,null,null,null,null)";
								$stmt = $con->prepare($sql);
								$thefile = $targetFile;
                                                                $stmt->bind_param('sssssss',$filetype,$thefile,$duration, $encoding, $size,$owner,$ownergrp);
                                                                if($stmt->execute()===TRUE){
                                                                        echo "<font color='red'>successfully added file in the db, done</font><br>";
                                                                }else{
                                                                        echo "<font color='red'> error 1: ".$con->error."</font>"."<br>";
                                                                        $err = "error";
                                                                }
								//}
						echo "done with the db<br>";

					}else{
						echo "error: invalid action, please contact the admins<br>";
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

