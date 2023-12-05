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
				<br>
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
				<h3><a href='tags.php'>Tags</a> / files / <?echo $_GET['t']?></h3>
				<form action='' method=''>
					<table class="table table-hover table-sm">
						<tr>
							<th>#</th>
							<th>file name</th>
							<th>file type</th>
							<th>actions</th>
						</tr>
						<?
							$con = mysqli_connect("localhost", "", "", "musicolabRepository");
							$sql = "select * from files2tags a, metadata b where a.tag='".$_GET['t']."' and a.fileid=b.id";
							//echo ($sql);
                                                        $res = $con->query($sql);
                                                        if($res){
                                                                $count = 1;
								while($row = mysqli_fetch_assoc($res)){
									$filename = $row['filename'];
									$filetype = $row['filetype'];
									$owner    = $row['owner'];
									/*
									//$check = 0;
									//$len = strlen("/var/www/moodledata/repository/jsonFiles/public/");
									//if(substr($filename, 0, $len)==="/var/www/moodledata/repository/jsonFiles/public/"){
									if($filetype=='public'){
									       	$check=1;
										$filename = substr($filename, $len);
									}else{
										$curruser = 0;
										$len2 = strlen("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION["USER"]['id']."/");
										if(substr($filename, 0, $len2)==="/var/www/moodledata/repository/jsonFiles/users/".$_SESSION["USER"]['id']."/") $curruser=1;
										$len2 = strlen("/var/www/moodledata/repository/jsonFiles/users/");
										$filename = substr($filename, $len2);
										$filename = substr($filename, strpos($filename, "/")+1);
										if($curruser==0) $filename = "*******";
									}
									*/
									?>
									<tr>
									<td><?echo $count?></td>
									<td><?
										if($row['owner']==$_SESSION['USER']['username'] or $filetype=='public'){
											echo substr($filename, strrpos($filename, "/")+1);
										}else{
											echo "[ filename non owned or non public]";
										}
									     ?>
									</td>
									<td>
									<?  
										if($row['owner']==$_SESSION['USER']['username'] or $filetype=='public'){
											if($filetype=='course'){
												$len1 = strlen("/var/www/moodledata/repository/jsonFiles/courses/");
												$cid = substr($filename, $len1);
												$len2 = strpos($cid, '/');
												$cid = substr($cid, 0, $len2);
												$con = mysqli_connect("localhost", '', '', 'moodle');
												$sql = 'select * from course where id='.$cid;
												$res = $con->query($sql);
												$row = mysqli_fetch_assoc($res);
												echo "course: ".$row['fullname'];
											}else{
												echo $filetype;
											}
                                                                                }else{  
                                                                                        echo "";
                                                                                }
                                                                        ?> 
									</td>
									<td>
										<!-- href='tagsRename.php?t=<?//echo $value?>'    title='rename'  ><i class="fa fa-edit"></i></a> 
										<a href='tagsDelete.php?t=<?//echo $value?>'    title='delete'  ><i class="fa fa-trash"></i></a--> 
									</tr>
									<?
									$count=$count+1;
								}
							}else{
								echo $con->error;
							}
						?>
					</table>
				</form>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>

	</div>
  </body>
</html>

