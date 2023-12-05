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
                                ?>
				<h3>Private Files</h3>
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
							$sql = "select * from metadata where filetype='private' and owner='".$_SESSION["USER"]["username"]."' order by filename asc";
                                                        $res = $con->query($sql);
                                                        if($res){
                                                                $count = 1;
								while($row = mysqli_fetch_assoc($res)){
									$value = $row['id'];
									$ulen  = strlen($_SESSION['USER']["id"]);
                                                                        ?>
                                                                        <tr>
									<!--td><?echo $row['filename']?></td-->
                                                                        <td><?echo $count?></td>
									<td><?echo substr($row['filename'], strrpos($row['filename'],"/")+1)?></td>
									<td><?
                                                                                $fn = substr($row['filename'], 48);
                                                                                $pos = strpos($fn, ".")+1;
                                                                                echo substr($fn,$pos);
                                                                             ?></td>
									<td><?echo round($row['size']/1000000, 2)?></td>
									<td><?echo date("d/m/y h:i:s", filemtime($row['filename']));?></td>
                                                                        <td>
                                                                                <a href='downloadPrivateFile.php?u=<?echo $_SESSION['USER']['id']?>&f=<?echo urlencode(substr($row['filename'], 48+$ulen))?>&user=<?echo $_SESSION['USER']["username"];?>' title='download'><i class="fa fa-download"></i></a>
                                                                                <?
                                                                                if(substr($value, -4)==='.txt'){
                                                                                ?>
                                                                                <a href='openPrivateFile.php?f=<?echo $value?>'    title='open file'      ><i class="fa fa-folder-open"></i></a>
                                                                                <?
                                                                                }
                                                                                ?>
										<a href='dataOfPrivateFile.php?f=<?echo $value?>'  title='metadata'       ><i class="fa fa-table"></i></a>
                                                                                <a href='copyPrivateFile.php?f=<?echo $value?>'    title='copy to public' ><i class="fa fa-copy"></i></a>
                                                                                <a href='exportPrivateFile.php?f=<?echo $value?>'  title='export to LMS'  ><i class="fa fa-save"></i></a>
										<a href='tagPrivateFile.php?f=<?echo $value?>'     title='tag file'       >#</a>
										 <?
                                                                                if(substr($row['filename'],-3)=='mp3' or substr($row['filename'],-3)=='wav'){
                                                                                ?>
											<a href='playalong3/index.html?type=private&id=<?echo $_SESSION['USER']['id']?>&collab=false&user=<?echo $_SESSION['USER']['username'];?>&f=<?echo urlencode(substr($row['filename'], 48+strlen($_SESSION["USER"]["id"])))?>'  title='play' target='_blank'><i class="fa fa-play"></i></a>
											<!--a href='playalong3/index.html?type=private&id=<?echo $_SESSION['USER']['id']?>&collab=true&user=<?echo $_SESSION['USER']['username'];?>&id=<?echo $_SESSION['USER']['id'];?>&f=<?echo urlencode(substr($row['filename'], 48+strlen($_SESSION["USER"]["id"])))?>'  title='play collab' target='_blank'><i class="fa fa-cloud"></i></a-->
										<?
										}else if(substr($row['filename'],-3)=='krn' or substr($row['filename'],-3)=='mei' or substr($row['filename'],-3)=='musicxml'){
											$fileUrl = base64_encode("https://musicolab.hmu.gr/apprepository/downloadPrivateFile.php?u=".$_SESSION['USER']['id']."&user=".$_SESSION['USER']['username']."&f=".urlencode(substr($row['filename'], 48+strlen($_SESSION["USER"]["id"]))));
                                                                                ?>
											<a href='vhvWs/index.html?type=private&id=<?echo $_SESSION['USER']['id']?>&file=<?echo $fileUrl?>&collab=false&user=<?echo $_SESSION['USER']['username'];?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a>
											<!--a href='vhvWs/index.html?type=private&id=<?echo $_SESSION['USER']['id']?>&file=<?echo $fileUrl?>&collab=true&user=<?echo $_SESSION['USER']['username'];?>&id=<?echo $_SESSION['USER']['id'];?>' target='_blank'  title='read score'><i class="fa fa-cloud"></i></a-->
                                                                                <?
										}
                                                                                ?>
                                                                                <a href='delPrivateFile.php?f=<?echo $value?>'     title='delete'         ><i class="fa fa-trash"></i></a>
                                                                        </tr>
                                                                        <?
                                                                        $count=$count+1;
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

