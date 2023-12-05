<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<style>
			fieldset{border:0px}
		</style>
		<script>
			function doit(){
				ex = document.getElementById("selected");
				for(i=0; i<ex.options.length; i++){
					ex.options[i].selected="selected";
				}
				theform = document.getElementById("theform");
				theform.submit();
			}
			function remTag(){
				sel  = document.getElementById("existing");
                                ex = document.getElementById("selected");
			
				sel.options.defaultSelected='selected';

                                for(i=0; i<ex.options.length; i++){
                                        if(ex.options[i].selected){
                                                val = ex.options[i].value;
						nam = ex.options[i].innerHTML;
						newOne = new Option(nam, val, true);
						sel.add(newOne);
                                                ex.remove(i);
                                        }       
                                }
                        }
			function addTag(){
				ex  = document.getElementById("existing");
				sel = document.getElementById("selected");

				for(i=0; i<ex.options.length; i++){
					if(ex.options[i].selected){
						val = ex.options[i].value;
						nam = ex.options[i].innerHTML;
						newOne = new Option(nam, val);
						//newOne.setAttribute("selected", "selected");
						sel.add(newOne);
						ex.remove(i);
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

			<?
                        $con = mysqli_connect("localhost", "", "", "");
			if(isset($_GET["action"]) && isset($_GET['selectedtags'])){
				if($_GET["action"]=='addnewtags'){
					//for($i=0; $i<count($_GET['selectedtags']); $i=$i+1){
                                        	//$sel = $_GET['selectedtags'][$i];
                                               	//if($sel!="") {
                                               		//echo "- ".$sel."<br>";
                                               	//}
                                        //}

					$res = $con->query("select * from files2tags where fileId=".$_GET['f']);
					//$row = mysqli_fetch_assoc($res);
					if(!$res){
						#THERE IS NO ENTRY IN THE DB FOR THIS FILE, INSERTING ALL SELECTIONS
						//echo "no tag in the db for this file, adding all the selected tags<br>";
						for($i=0; $i<count($_GET['selectedtags']); $i=$i+1){
							$sel = $_GET['selectedtags'][$i];
							if($sel!="") {
								//echo "- insert into files2tags values(NULL, ".$_GET['f'].", '".$sel."')<br>";
								$con->query("insert into files2tags values(NULL, ".$_GET['f'].", '".$sel."')");
							}
						}
					}else{
						#THERE ARE ENTRIES FOR THIS FILE IN THE DB
						# (1) removing tags from the db if they are not in the selections
						//echo "there are entries in the db for this file<br>";
						while($row = mysqli_fetch_assoc($res)){
							//echo "- tag = ".$row['tag']."<br>";
							//echo "--- searching in selections, #".count($_GET['selectedtags'])."<br>";
							$found = false;
							for($i=0; $i<count($_GET['selectedtags']); $i=$i+1){
								$sel = $_GET['selectedtags'][$i];
								//echo "--- next selection is ".$sel."<br>";
								if($row['tag']==$sel){ 
									//echo "--- FOUND<br>";
									$found = true;
									break;
								}
							}
							if($found==false){ # row[tag] in not in the list of selected, it has to go
								//echo "- tag ".$row['tag']." is not selected, must be removed from the db<br>";
								//echo "- delete from files2tags where fileId=".$_GET['f']." and tag='".$row['tag']."'<br>";
								//$check  = $con->query("select from files2tags where fileId=".$_GET['f']." and tag='".$row['tag']."'");
								$resDel = $con->query("delete from files2tags where fileId=".$_GET['f']." and tag='".$row['tag']."'");
								//echo $resDel."<br>";
								//echo "delete from files2tags where fileId=".$_GET['f']." and tag='".$row['tag']."'";
								//echo "done";
								if($resDel){
								}else{
									 echo "<font color='red'> error: ".$con->error."</font>"."<br>";
								}
							}
						}

						#adding selected tags
						//echo "adding selected tags<br>";
						for($i=0; $i<count($_GET['selectedtags']); $i=$i+1){
							$sel = $_GET['selectedtags'][$i];
							$found = false;
		                                        $res = $con->query("select * from files2tags where fileId=".$_GET['f']);
							while($row = mysqli_fetch_assoc($res)){
		                                                if($row['tag']==$sel){
									$found = true;
									break; 
       	                                                 	}
							}
							if($found==false){ #the selected tag is not in the db
								if($sel!="") $con->query("insert into files2tags values(NULL, '".$_GET['f']."','".$sel."')");
							}
						}
					}
				}
			}
                        $f    = $_GET['f'];
                        $sql  = "select * from metadata where filetype='private' and id=".$f;
			$res  = $con->query($sql)->fetch_assoc();
			$ulen = strlen($_SESSION['USER']['id']);
                        ?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
				                                <?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Private Files / Tags / <?echo substr($res['filename'], 48+$ulen)?></h3>
				<hr style='background-color:#ddd'>
				<form action='tagPrivateFile.php' method='' id='theform'>
					<?
					if($error!=""){
                                        }else{
                                                if(isset($_GET["action"])){
                                                        if($_GET["action"]=='addnewtags'){
                                                        ?>
                                                                <div class="alert alert-info">The list of tags was updated successfully !</div>
                                                        <?
                                                        }
                                                }
                                        }
	
					//$sql = "select * from files2tags where fileId=".$f;
					//$res = $con->query($sql);
					//while($row = mysqli_fetch_assoc($res)){
					//	echo "<span style='color:white; background-color:blue; border-radius:8px; border-color:red; padding:2px 8px 2px 8px;'>#".$row['tag']."</span>";
					//}
					?>
					<div class='row'>
						<div class='col-sm-5'>
							<center>
							list of tags<br>
							<select name='existingtags' id='existing' size='10' style='width:100%' multiple readonly>
								<?
								$seltagsres = $con->query("select distinct(tag) from files2tags where tag not in ( select tag from files2tags where fileId=".$_GET['f'].") ");
								echo "select distinct(tag) from files2tags where fileId!=".$_GET['f']."<br>";
								while($seltags = mysqli_fetch_assoc($seltagsres)){
									echo "<option value='".$seltags['tag']."'>".$seltags['tag']."</option>";
		                                        	}
								?>
							</select><br>
							</center>
						</div>
						<div class='col-sm-2'>
							<center>
							<br>
							<input type='button' onclick='addTag()' value='&gt'><br>
							<input type='button' onclick='remTag()' value='&lt'><br>
							</center>
						</div>
						<div class='col-sm-5'>
							<center>
							selected tags<br>
							<select name='selectedtags[]' id='selected' size='10' style='width:100%' multiple readonly>
		                                                <?
		                                                $sql = "select * from files2tags where fileId=".$f;
		                                                $res = $con->query($sql);
		                                                while($row = mysqli_fetch_assoc($res)){
		                                                       	echo "<option value='".$row['tag']."'>".$row['tag']."</option>";
		                                                }
		                                                ?>
							</select><br>
							</center>
						</div>
					</div>
					<br>
					<center>
					<input type='hidden' name='action' value='addnewtags'>
					<input type='hidden' name='f' value='<?echo $_GET['f'];?>'/>
					<input type='button' style='width:150px' onclick='doit();' value='submit'>
					</center>
				</form>
				<br>
				<?}?>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>

	</div>
  </body>
</html>

