<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script language='javascript'>
			function doit(){
				if(confirm('παρακαλώ επιβεβαιώστε την έξοδό σας από το σύστημα')){
					document.getElementById("theform").submit();
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
			<?
			?>

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<br>
				<?
				if(!isset($_SESSION['USER'])){
                        	}else{
					$con = mysqli_connect("localhost", "", "", "moodleLms");
                                        $sql = "select * from course where id=".$_GET['c'];
                                        $res = $con->query($sql);
					if($res){
						$row = mysqli_fetch_assoc($res);
					?>
						<h3>repository / courses / <?echo $row['fullname'];?></h3>
						<br>
						https://moodle.org/mod/forum/discuss.php?d=361667<br>
						<br>
						<table class='table table-hover table-sm'>
							<tr>
								<th>#</th> 
								<th>filename</th>
								<th>type</th>
								<th>size (MB)</th>
							</tr>
						<?
						$sql = "SELECT course.id AS CourseID, course.fullname AS CourseFullName, course.shortname AS CourseShortName, course.filename, course.filesize AS CourseSizeBytes FROM (
								SELECT c.id, c.fullname, c.shortname, cx.contextlevel,f.component, f.filearea, f.filename, f.filesize FROM context cx
									JOIN course c ON cx.instanceid=c.id
									JOIN files f ON cx.id=f.contextid
								WHERE f.filename <> '.' AND f.component NOT IN ('private', 'automated', 'backup','draft') AND f.filearea='course' 
								
								UNION
								
								SELECT cm.course, c.fullname, c.shortname, cx.contextlevel,f.component, f.filearea, f.filename, f.filesize FROM files f
									JOIN context cx ON f.contextid = cx.id
									JOIN course_modules cm ON cx.instanceid=cm.id
									JOIN course c ON cm.course=c.id
								WHERE filename <> '.'
								
							) AS course order by course.fullname asc;";
                                        	$res = $con->query($sql);
						if($res){	
							$cfiles = 1;
							while($row = mysqli_fetch_assoc($res)){
								if($_GET['c']==$row['CourseID']){
									?>
										<tr>
											<td><? echo $cfiles;?></td>
											<td><?echo $row['filename'].$row['filearea']?></td>
											<td><? 
                                                                                		$fn = $row['filename'];
												$pos = strpos($fn, ".")+1;
		                                                                                echo substr($fn,$pos);
												?></td>
											<td><?echo round($row['CourseSizeBytes']/1000000,1)?></td>

										</tr>
									<?
									$cfiles = $cfiles +1;
								}
							}
						}else{
							echo $con->error();
						}
						?>
						</table>
					<?
					}else{
						echo "eror: ".$con->error."<br>";
					}
				}
				?>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

