<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
	<?include 'headerHtml.php'?>
  </head>
  <body style='background-color:white'>
	<div class="container">

		<?//include 'header.php'?>

		<div class="row" style='padding:0px'>

			<?//include 'menusLeft.php'?>

			<div class="col-sm-12" style='padding:0px'>
				<?
                                //echo "searching for session<br>";
                                $con = mysqli_connect("localhost", "", "", "moodleLms");
                                $sql = "select * from user where username='".$_GET["username"]."'";
                                $res = $con->query($sql);
                                if($res){
                                        $row = mysqli_fetch_assoc($res);
                                        error_log("user ".$_GET["username"]." is authenticated");
                                        $_SESSION['USER']['username'] = $_GET["username"];
                                        $_SESSION['USER']['firstname'] = $row["firstname"];
                                        $_SESSION['USER']['lastname'] = $row["lastname"];
                                        $_SESSION['USER']['id'] = $row["id"];
                                }
                                //echo $_SESSION['USER']['username']. "<br>";

                                if(isset($_SESSION["USER"]["username"])){
					$con = mysqli_connect("localhost", "", "", "moodleLms");
					$sql = "select * from course where id=".$_GET['id'];
					$res = $con->query($sql);
					$row = mysqli_fetch_assoc($res);
					$cname = $row['fullname'];
					$cshortname = $row['shortname'];
                                ?>
				<form action='' method=''>
                                        <table class="table table-hover table-sm">
                                                <tr>
							<th># filename</th>
                                                </tr>
                                                <?
							$con = mysqli_connect("localhost", "", "", "");
							//$sql = "select * from metadata where filetype='course' and filename like '%courses/".$_GET['id']."%' and  owner='".$_SESSION["USER"]["username"]."' order by filename asc";
							$sql = "select * from metadata where filetype='course' and filename like '%courses/".$_GET['id']."/%' order by filename asc";
                                                        $res = $con->query($sql);
                                                        if($res){
								$count = 1;
								while($row = mysqli_fetch_assoc($res)){
									$value = $row['id'];
									$ulen  = strlen($_SESSION['USER']["id"]);
									$filename = substr($row['filename'], 48+$ulen);
									$slashpos = strpos($filename, "/");
									$courseId = substr(substr($row['filename'], 48), $slashpos);
									$courseId = $_GET['id'];
									$fname    = substr($filename, $slashpos+1);
									if($courseId==$_GET['id']){
                                                                        ?>
                                                                        <tr>
                                                                        <td><?echo $count?> 
									<!--td><?//echo substr($filename, $slashpos+1)?></td-->
										 <?
                                                                                if(substr($row['filename'],-3)=='mp3' or substr($row['filename'],-3)=='wav'){
                                                                                ?>
											<a href='playalong3/index.html?type=course&courseid=<?echo $_GET['id']?>&collab=false&user=<?echo $_SESSION['USER']['username'];?>&f=<?echo $fname?>&course=<?echo $cshortname?>&id=<?echo $_SESSION['USER']['id'];?>'  title='play' target='_blank'><?echo $fname;?></a>
										<?
										}else if(substr($row['filename'],-3)=='krn' or substr($row['filename'],-3)=='mei' or substr($row['filename'],-3)=='musicxml'){
											//$fileUrl = "https://musicolab.hmu.gr/apprepository/downloadPrivateFile.php?u=".$_SESSION['USER']['id']."&user=".$_SESSION['USER']['username']."&f=".urlencode(substr($row['filename'], 48+strlen($_SESSION["USER"]["id"])));
											$fileUrl = "https://musicolab.hmu.gr/apprepository/downloadCourseFile.php?collab=false&courseid=".$_GET['id']."&u=".$_SESSION['USER']['id']."&user=".$_SESSION['USER']['username']."&f=".urlencode($fname);
											$fileUrl = base64_encode($fileUrl);
                                                                                ?>
											<a href='https://musicolab.hmu.gr/apprepository/vhvWs/index.html?file=<?echo $fileUrl;?>&collab=false&user=<?echo $_SESSION['USER']['username']?>&id=<?echo $_SESSION['USER']['id']?>&course=<?echo $cshortname;?>' target='_blank'><?echo $fname;?></a>
                                                                                <?
										}else{
											echo $fname;
										}
										?>
									</td>	
                                                                        </tr>
                                                                        <?
									$count=$count+1;
									}
                                                                }
                                                        }else{
                                                                echo "<font color='red'> error: ".$con->error."</font>"."<br>";
                                                        }
                                                ?>
                                        </table>
				</form>
				<?}?>
		</div>
		</div>

		<?//include 'footer.php'?>

	</div>
  </body>
</html>

