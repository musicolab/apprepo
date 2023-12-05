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
					$courseId   = $_GET['id'];
					$courseName = "";
					$coursePath = "/var/www/moodledata/repository/jsonFiles/courses/".$courseId.'/';
					$con = mysqli_connect("localhost", "", "", "moodleLms");
					$sql = "select fullname from course where id=".$courseId;
                                	$res = $con->query($sql);
					if($res){
						$row = mysqli_fetch_assoc($res);
						$courseName = $row['fullname'];
					}else{
						echo "could not find course<br>";
					}
                                        ?>
					<h3>Files in LMS courses / '<?echo $courseName;?>'</h3>
					<table class="table table-hover table-sm">
						<tr>
							<th>#</th>
							<th>filename</th>
							<th>owner</th>
							<th>type</th>
							<th>size (KB)</th>
							<th>modification time</th>
						</tr>
						<?
							$con = mysqli_connect("localhost", "", "", "moodleLms");
							$sql = "SELECT files.source, files.filename, files.author, files.filesize, files.contenthash, context.path, resource.course, resource.name, course.fullname, course.shortname FROM files INNER JOIN context ON files.contextid = context.id INNER JOIN resource ON context.instanceid = resource.id INNER JOIN course ON resource.course = course.id WHERE (course.fullname = '".$courseName."')";
							//$sql = "select filename file, instanceid course, filesize from files join context on files.contextid = context.id where instanceid = XXXX and contextlevel=50 union all select filename file, course, filesize from files inner join context on files.contextid = context.id join resource on instanceid = resource.id where course=XXXX and contextlevel = 70"

							#$sql = "select * from metadata where filetype='".$courseId."' and owner='".$_SESSION['USER']->username."' order by filename asc";
							$res = $con->query($sql);
							if($res){
								$count = 1;
								while($row = mysqli_fetch_assoc($res)){
									error_log("listing files", 0);
									$value = $row['filename'];
									?>
									<tr>
									<td><?echo $count?></td>
									<?
									$thefilename = $row['filename'];
									#$thefilename = substr($row['files.filename'], strpos($row['files.filename'],'/users/',0)+7);
									#$thefilename = substr($thefilename, strpos($thefilename, '/',0)+1);
									#$thefilename = substr($thefilename, strpos($thefilename, '/',0)+1);
									?>
									<td><?echo $thefilename?></td>
									<td><?echo $row['author']?></td>
									<td><? 
										$fn = substr($row['filename'], 48);
										$pos = strpos($fn, ".")+1;
										echo substr($fn,$pos);
									     ?></td>
									<td><?echo round($row['filesize']/1000,1)?></td>
									<td><?echo date("d/m/y h:m:s", filemtime($row['filename']))?></td>
										<!--
									<td>
										<a href='downloadPublicFile.php?f=<?echo substr($row['filename'], 48)?>' title='download'       ><i class="fa fa-download"></i></a> 
										<?
										if(substr($value, -4)==='.txt'){
										?>
										<a href='openPublicFile.php?f=<?echo $value?>'    title='open file'      ><i class="fa fa-folder-open"></i></a> 
										<?
										}
										?>
										<a href='dataOfPublicFile.php?f=<?echo $value?>'  title='metadata'       > <i class="fa fa-table"></i></a> 
										<a href='copyPublicFile.php?f=<?echo $value?>'    title='copy to private'> <i class="fa fa-copy"></i></a> 
										<a href='copyToCourse.php?f=<?echo $value?>'      title='copy to course'>  <i class="fa fa-share-square"></i></a> 
										<a href='exportPublicFile.php?f=<?echo $value?>'  title='export to LMS'><i class="fa fa-save"></i></a> 
										<?
										if($row['author']==$_SESSION["USER"]["username"]){
										?>
											<a href='tagPublicFile.php?f=<?echo $value?>'     title='tag file'       >#</a>
											<a href='delPublicFile.php?f=<?echo $value?>'     title='delete'         ><i class="fa fa-trash"></i></a> 
										<?
										}
										?>
									</tr>
									-->
									<?
									$count=$count+1;
								}
							}else{
								echo "<font color='red'> error: ".$con->error."</font>"."<br>";
        	                                        }
						?>
					</table>
				<?}?>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>

	</div>
  </body>
</html>

