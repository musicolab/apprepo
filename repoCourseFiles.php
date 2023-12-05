<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
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
                                if(isset($_SESSION["USER"]["username"])){
					$con = mysqli_connect("localhost", "", "", "moodleLms");
					$sql = "select * from course where id=".$_GET['id'];
					$res = $con->query($sql);
					$row = mysqli_fetch_assoc($res);
					$cname = $row['fullname'];
					$cshortname = $row['shortname'];
                                ?>
					<h3>Files for course: <i><?echo $cname?></i></h3>
				<form action='' method=''>
                                        <table class="table table-hover table-sm">
                                                <tr>
                                                        <th>#</th>
							<th>filename</th>
							<th>type</th>
							<th>size (MB)</th>
							<th>owner</th>
							<th>modification time</th>
                                                        <th>actions</th>
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
									//echo $ulen."<br>";
									$filename = substr($row['filename'], 48+$ulen);
									//echo $filename."<br>";
									$slashpos = strpos($filename, "/");
									//echo $slashpos."<br>";
									$courseId = substr(substr($row['filename'], 48), $slashpos);
									//echo $courseId."<br>";
									$fname    = substr($filename, $slashpos+1);
									//echo $fname."<br>";
									//if($courseId==$_GET['id']){
									//	echo $count."<br>";
                                                                        ?>
                                                                        <tr>
                                                                        <td><?echo $count?></td>
									<td><?echo substr($filename, $slashpos+1)?></td>
									<td><?
                                                                                $fn = substr($row['filename'], 48);
                                                                                $pos = strpos($fn, ".")+1;
                                                                                echo substr($fn,$pos);
                                                                             ?></td>
									<td><?echo round($row['size']/1000000, 2)?></td>
									<td><?echo $row['owner']?></td>
									<td><?echo date("d/m/y h:i:s", filemtime($row['filename']));?></td>
                                                                        <td>
										<a href='downloadCourseFile.php?course=<?echo $cshortname?>&courseid=<?echo $_GET['id']?>&u=<?echo $_SESSION['USER']['id']?>&f=<?echo urlencode($fname)?>&user=<?echo $_SESSION['USER']["username"];?>' title='download'><i class="fa fa-download"></i></a>
                                                                                <?
                                                                                if(substr($value, -4)==='.txt'){
                                                                                ?>
                                                                                <a href='openPrivateFile.php?f=<?echo $value?>'    title='open file'      ><i class="fa fa-folder-open"></i></a>
                                                                                <?
                                                                                }
                                                                                ?>
										<a href='dataOfCourseFile.php?fname=<?echo urlencode($fname)?>&fid=<?echo $value?>&cname=<?echo $cname;?>'  title='metadata'       ><i class="fa fa-table"></i></a>
										<a href='copyCourseFile.php?fid=<?echo $value?>&fname=<?echo urlencode($fname)?>&cname=<?echo $cname;?>&cid=<?echo $_GET['id']?>'    title='copy to public or private area' ><i class="fa fa-copy"></i></a>
                                                                                <a href='exportPrivateFile.php?f=<?echo $value?>'  title='export to LMS'  ><i class="fa fa-save"></i></a>
										<a href='tagCourseFile.php?fname=<?echo urlencode($fname)?>&fid=<?echo $value?>&cname=<?echo $cname;?>'     title='tag file'       >#</a>
										 <?
                                                                                if(substr($row['filename'],-3)=='mp3' or substr($row['filename'],-3)=='wav'){
                                                                                ?>
											<a href='playalong3/index.html?type=course&courseid=<?echo $_GET['id']?>&course=<?echo $cshortname?>&collab=false&user=<?echo $_SESSION['USER']['username'];?>&f=<?echo $fname?>&id=<?echo $_SESSION['USER']['id'];?>'  title='play' target='_blank'><i class="fa fa-play"></i></a>
											<a href='playalong3/index.html?type=course&courseid=<?echo $_GET['id']?>&course=<?echo $cshortname?>&collab=true&user=<?echo $_SESSION['USER']['username'];?>&id=<?echo $_SESSION['USER']['id'];?>&f=<?echo $fname?>'  title='play collab' target='_blank'><i class="fa fa-cloud"></i></a>
										<?
										}else if(substr($row['filename'],-3)=='krn' or substr($row['filename'],-3)=='mei' or substr($row['filename'],-3)=='musicxml'){
											#$fileUrl = base64_encode("https://musicolab.hmu.gr/apprepository/downloadPrivateFile.php?u=".$_SESSION['USER']['id']."&user=".$_SESSION['USER']['username']."&f=".$fname);
											$fileUrl = base64_encode("https://musicolab.hmu.gr/apprepository/downloadCourseFile.php?course=".$cshortname."&u=".$_SESSION['USER']['id']."&courseid=".$_GET["id"]."&user=".$_SESSION['USER']['username']."&f=".urlencode($fname));
                                                                                ?>
											<a href='vhvWs/index.html?type=course&courseid=<?echo $_GET['id']?>&course=<?echo $cshortname?>&file=<?echo $fileUrl?>&collab=false&user=<?echo $_SESSION['USER']['username'];?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a>
											<a href='vhvWs/index.html?type=course&courseid=<?echo $_GET['id']?>&course=<?echo $cshortname?>&file=<?echo $fileUrl?>&collab=true&user=<?echo $_SESSION['USER']['username'];?>&id=<?echo $_SESSION['USER']['id'];?>' target='_blank'  title='read score'><i class="fa fa-cloud"></i></a>
                                                                                <?
										}
                                                                                ?>
											<a href='delCourseFile.php?fid=<?echo $value?>&cid=<?echo $_GET['id']?>&fname=<?echo urlencode($fname)?>&cname=<?echo $cname;?>'     title='delete'         ><i class="fa fa-trash"></i></a>
                                                                        </tr>
                                                                        <?
									$count=$count+1;
									//}
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
		</div>
		</div>

		<?include 'footer.php'?>

	</div>
  </body>
</html>

