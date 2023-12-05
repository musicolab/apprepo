<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script>
			function doit(){
				tag = document.getElementById("newtag").value;
				if(tag!=""){
					if(tag.length>3 && tag.match("^[A-Za-z0-9]+$")){
						if(confirm("please confirm the submission")){
							document.getElementById("newtagform").submit();
						}
					}else{
						alert("tags must be at least 4 characters long, containing only characters and numbers");
					}
				}
			}
		</script>
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
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Manage Tags</h3>	
				<hr style='background-color:#ddd'>
				<br>
				<form action='tags.php' method='post' id='newtagform' style='display:inline'>
					<input type='text' name='newtag' id='newtag' pattern="[A-Za-z0-0]{3,}" required> <input type='button' value='add new tag' onclick='doit();'>
				</form><br>
				<br>

				<?
				if(isset($_POST['newtag'])){
					$con = mysqli_connect("localhost", "", "", "");
					$sql = "select * from files2tags a where a.tag='".$_POST['newtag']."'";
					error_log($sql);
					$res = $con->query($sql);
					error_log($res->num_rows);
					if($res->num_rows!=0){
						echo "this tag already exists<br>";
					}else{
						$sql2 = "insert into files2tags values(NULL, NULL, '".$_POST['newtag']."')";
						$con->query($sql2);
						$sql2 = "insert into tags2users values(NULL, '".$_POST['newtag']."', '".$_SESSION["USER"]['username']."')";
						$con->query($sql2);

					}
				}
				?>

				<form action='' method=''>
					<table class="table table-hover table-sm">
						<tr>
							<th>#</th>
							<th>tag</th>
							<th>owner</th>
							<th># entries</th>
							<th>actions</th>
						</tr>
						<?
                                                        $con = mysqli_connect("localhost", "", "", "");
                                                        $sql = "select distinct(tag) from files2tags a order by a.tag";
                                                        $res = $con->query($sql);
                                                        if($res){
                                                                $count = 1;
                                                                while($row = mysqli_fetch_assoc($res)){
									$value = $row['tag'];
									#$sql2  = "select count(*) from files2tags where tag='".$row['tag']."' and fileId is not NULL";
									$sql2  = "select count(*) from files2tags a, metadata b where b.id=a.fileId and tag='".$row['tag']."' and a.fileId is not NULL";
									$res2  = $con->query($sql2);
									if($res2){
									}else{
										echo "<font color='red'> error: ".$con->error."</font>"."<br>";
									}
									$row2  = mysqli_fetch_assoc($res2);
									?>
									<tr>
									<td><?echo $count?></td>
									<td><?echo $value?></td>
									<td>
									<?
									$sql3 = "select user from tags2users where tagName='".$value."'";
									$res3 = $con->query($sql3);
									$row3 = mysqli_fetch_assoc($res3);
									echo $row3['user'];
									?>
									</td>
									<td><?echo $row2['count(*)']?></td>
									<td>
										<a href='tagsFilelist.php?t=<?echo $value?>'  title='filelist'><i class="fa fa-list"></i></a> 
										<?
										if($row3['user']==$_SESSION["USER"]['username']){
										?>
										<a href='tagsRename.php?t=<?echo $value?>'    title='rename'  ><i class="fa fa-edit"></i></a> 
										<a href='tagsDelete.php?t=<?echo $value?>'    title='delete'  ><i class="fa fa-trash"></i></a> 
										<?
										}
										?>
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

