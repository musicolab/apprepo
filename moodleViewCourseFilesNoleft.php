<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<style>
		</style>
  </head>
  <body style='background-color:white; font-size:12px;'>
	<div class="container">

		<div class="row">

			<div class="col-sm-12">
				<?
                                if(isset($_SESSION["USER"]["username"])){
					$con = mysqli_connect("localhost", "", "", "moodle");
					$sql = "select * from course where id=".$_GET['id'];
					$res = $con->query($sql);
					$row = mysqli_fetch_assoc($res);
					$cname = $row['fullname'];
                                ?>
				<h3>Files for course: <i><?echo $row["fullname"]?></i></h3>
				<form action='' method=''>
                                        <table class="table table-hover table-sm">
                                                <tr>
                                                        <th>#</th>
							<th>filename</th>
							<th>type</th>
							<th>size (MB)</th>
							<th>modification time</th>
                                                        <th>actions</th>
                                                </tr>
                                                <?
							$con = mysqli_connect("localhost", "", "", "");
							$sql = "select * from metadata where filetype='course' and filename like '%courses/".$_GET['id']."/%' and  owner='".$_SESSION["USER"]["username"]."' order by filename asc";
                                                        $res = $con->query($sql);
                                                        if($res){
                                                                $count = 1;
								while($row = mysqli_fetch_assoc($res)){
									$value = $row['id'];
									$ulen  = strlen($_SESSION['USER']["id"]);
									$filename = substr($row['filename'], 48+$ulen);
									$slashpos = strpos($filename, "/");
									$courseId = substr(substr($row['filename'], 48), $slashpos);
									$fname    = substr($filename, $slashpos+1);
									if($courseId==$_GET['id']){
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
									<td><?echo date("d/m/y h:i:s", filemtime($row['filename']));?></td>
                                                                        <td>
										<a href='downloadCourseFile.php?fileid=<?echo $_GET['id']?>&u=<?echo $_SESSION['USER']['id']?>&f=<?echo urlencode($fname)?>&user=<?echo $_SESSION['USER']["username"];?>' title='download'><i class="fa fa-download"></i></a>
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
											<a href='playalong3/index.html?collab=false&user=<?echo $_SESSION['USER']['username'];?>&f=<?echo urlencode(substr($row['filename'], 48+strlen($_SESSION["USER"]["id"])))?>'  title='play' target='_blank'><i class="fa fa-play"></i></a>
                                                                                        <a href='playalong3/index.html?collab=true&user=<?echo $_SESSION['USER']['username'];?>&id=<?echo $_SESSION['USER']['id'];?>&f=<?echo urlencode(substr($row['filename'], 48+strlen($_SESSION["USER"]["id"])))?>'  title='play collab' target='_blank'><i class="fa fa-cloud"></i></a>
										<?
										}else if(substr($row['filename'],-3)=='krn' or substr($row['filename'],-3)=='mei' or substr($row['filename'],-3)=='musicxml'){
											$fileUrl = base64_encode("https://musicolab.hmu.gr/apprepository/downloadPrivateFile.php?u=".$_SESSION['USER']['id']."&user=".$_SESSION['USER']['username']."&f=".urlencode(substr($row['filename'], 48+strlen($_SESSION["USER"]["id"]))));
                                                                                ?>
											<a href='vhvWs/index.html?file=<?echo $fileUrl?>&collab=false&user=<?echo $_SESSION['USER']['username'];?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a>
											<a href='vhvWs/index.html?file=<?echo $fileUrl?>&collab=true&user=<?echo $_SESSION['USER']['username'];?>&id=<?echo $_SESSION['USER']['id'];?>' target='_blank'  title='read score'><i class="fa fa-cloud"></i></a>
                                                                                <?
										}
                                                                                ?>
											<a href='delCourseFile.php?fid=<?echo $value?>&cid=<?echo $_GET['id']?>&fname=<?echo urlencode($fname)?>&cname=<?echo $cname;?>'     title='delete'         ><i class="fa fa-trash"></i></a>
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

	</div>
  </body>
</html>

