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
                                if(isset($_SESSION["USER"]->username)){
                                ?>
				<h3>Private Files in LMS</h3>
					<?
					$con = mysqli_connect("localhost", "", "", "moodle");
                                       	?>
                                                <table class='table table-hover table-sm'>
                                                        <tr> <th>#</th> <th>filename</th> <th>path</th> <th>size (MB)</th> <th>type</th> <th>creation</th></tr>
							<?
							$sql = "select contenthash, pathnamehash, author, filename, filepath, filesize, timecreated, mimetype from files where filearea='private' and userid=".$_SESSION["USER"]->id." and filename <> '.'";
                                                	$res = $con->query($sql);
                                                	if($res){
								$cfiles = 1;
                                                        	while($row = mysqli_fetch_assoc($res)){
                                                                        ?>
                                                                        <tr>
                                                                        	<td><?echo $cfiles;?></td>
                                                                               	<td><?echo $row['filename']?></td>
                                                                               	<td><?echo $row['filepath']?></td>
                                                                               	<td><?echo round($row['filesize']/1000000,2)?></td>
                                                                               	<td><?echo $row['mimetype']?></td>
                                                                               	<td><?echo date('d-m-y', $row['timecreated'])?></td>
                                                                        </tr>
                                                                        <?
                                                                	$cfiles = $cfiles +1;
                                                       		}
                                                	}else{
                                                       		echo "ERROR: please contact the admins<br>";
							}
							?>
						</table>
				<? } ?>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

