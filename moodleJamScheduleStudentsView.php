<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
	<?include 'headerHtml.php'?>
	<script language='javascript'>
                        var files = [<?
                                $con = mysqli_connect("localhost", "", "", "");
				$sql = "select * from metadata where filename like '%/courses/".$_GET['id']."/%'";
                                $res = $con->query($sql);
                                $count = 1;
                                while($row = mysqli_fetch_assoc($res)){
                                        $tmp = substr($row['filename'],strrpos($row['filename'],"/")+1);
                                        if($count < $res->num_rows){
                                                echo "\"".$tmp."\",";
                                        }else{
                                                echo "\"".$tmp."\"";
                                        }
                                        $count++;
                                }
		?>];		
	
		function submitDelForm(formId){
			var ans = confirm("please confirm the delettion");
			if(ans){
				var f = document.getElementById("delform"+formId);
				f.submit();
			}
		}
        </script>
  </head>
  <body style='background-color:white; font-size:; width:100%;'>
	<div class="container">

		<?
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
                        ?>

		<div class="row">

			<div class='col-sm-12'>
					<?
        	                        if(isset($_SESSION["USER"]["username"])){
						$con = mysqli_connect("localhost", "", "", "moodleLms");
						$sql = "select * from course where id=".$_GET['id']."";
						$res = $con->query($sql);
						$row = mysqli_fetch_assoc($res);
						$cname = $row['fullname'];
						$csname = $row['shortname'];
        	                        ?>
					<!--h3>Jam schedule for course: <i><?echo $row["fullname"]?></i></h3-->
                                        <table class="table table-hover table-sm" style='width:0%'>
                                                <tr>
                                                        <!--th>#</th-->
							<th>date</td>
							<th>from-to</th>
							<th>lesson</th>
                                                </tr>
                                                <?
							$con = mysqli_connect("localhost", "", "", "");
							$sql = "select * from jams where courseId=".$_GET['id']." order by start desc";
                                                        $res = $con->query($sql);
                                                        if($res){
                                                                $count = 1;
								while($row = mysqli_fetch_assoc($res)){
									$cid   = $row['courseId'];
									$start = $row['start'];
									$end   = $row['end'];
									$track = $row['track'];
									$lesson= $row['lesson'];
									$now   = date('Y-m-d H:i:s');
                                                                        ?>
                                                                        <tr>
                                                                        <!--td><?echo $count?></td--> 
									<td><small><?echo substr($start,0,10)?></small></td>
									<td><small><?echo substr($start,11, 5)?>-<?echo substr($end,11, 5)?></small></td>
									<td><small>
                                                                                <?
										if($track==""){
											if($now<=$end && $now>=$start){	
	                                                                                ?>
												<a href='https://musicolab.hmu.gr:8443/<?echo $csname;?>#config.prejonPageEnabled=true' target='_blank'><?echo $lesson?></a>
											<?
                                                                                        }else{
                                                                                        ?>
                                                                                                        <?echo $lesson;?>
                                                                                        <?
                                                                                        }
                                                                                }else{
											if($now<=$end && $now>=$start){	
	                                                                                        if(substr($track,-3)=="mp3" or substr($track,-3)=="wav"){
												?>
													<a href='https://musicolab.hmu.gr/apprepository/playalong3/index.html?type=course&courseid=<?echo $_GET['id']?>&f=<?echo $track;?>&collab=true&user=<?echo $_SESSION['USER']['username']?>&id=<?echo $_SESSION['USER']['id']?>&course=<?echo $csname;?>&lesson=<?echo $lesson;?>' target='_blank'><?echo $lesson;?></a>
               		                                                                        <?
                        	                                                                }else if(substr($track,-3)=="krn" or substr($track,-3)=="mei" or substr($track,-8)=="musicxml"){
													$fileUrl = "https://musicolab.hmu.gr/apprepository/downloadCourseFile.php?type=course&courseid=".$_GET['id']."&u=".$_SESSION['USER']['id']."&user=".$_SESSION['USER']['username']."&f=".urlencode($track);
													$fileUrl = base64_encode($fileUrl);
                                        	                                                ?>
                                                                                                	<a href='https://musicolab.hmu.gr/apprepository/vhvWs/index.html?file=<?echo $fileUrl;?>&collab=true&user=<?echo $_SESSION['USER']['username']?>&id=<?echo $_SESSION['USER']['id']?>&course=<?echo $csname;?>' target="_blank"><?echo $lesson;?></a>
                                                		                                <?
                                                                	                        }else{
                                                                        	                        echo "unknown extension (contact the admins)";
                                                                                	        }
											}else{
												if(substr($track,-3)=="mp3" or substr($track,-3)=="wav"){
                                                                                                ?>
                                                                                                        <?echo $lesson;?>
                                                                                                <?
                                                                                                }else if(substr($track,-3)=="krn" or substr($track,-3)=="mei" or substr($track,-8)=="musicxml"){
                                                                                                ?>
                                                                                                        <?echo $lesson;?>
                                                                                                <?
                                                                                                }else{
                                                                                                        echo "unknown extension (contact the admins)";
                                                                                                }

                                                                                        }
                                                                                }
                                                                                ?>
                                                                        </small></td>
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
		</div>
		</div>

	</div>
  </body>
</html>

