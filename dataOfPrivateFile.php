<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<style>
			input{width:70%}
			fieldset{border:0px}
		</style>
		<script langauge='javascript'>
                        function doit(){
                                conf = confirm("please confirm the submission");
                                if(conf) {
                                        f = document.getElementById("theform");
                                        f.submit();
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

				if(isset($_GET['action'])){
					if($_GET['action']=="saveMetadata"){
						$saveMsg = " / sucessfully updated !";

						$f   = $_GET['f'];
						$genre = $_GET['genre'];
						$key = $_GET['key'];
                                                $scale = $_GET['scale'];
						//$tonality = $_GET['tonality'];
						$tonality = "";
						$title =$_GET['title']; 
						$composer =$_GET['composer']; 
						$compdate =$_GET['compositionDate']; 
						$performer =$_GET['performer']; 
						$musicalcontent =$_GET['musicContent']; 
						$unfoldedmusic =$_GET['unfoldedMusic']; 
						$tempo =$_GET['tempo']; 
						$originalMelody =$_GET['originalMelody']; 
						//$sql = "update metadata set genre='".$genre."', tonality='".$tonality."', title='".$title."', composer='".$composer."', compositiondate='".$compdate."', performer='".$performer."', musicContent='".$musicalcontent."', unfoldedMusic='".$unfoldedmusic."', tempo='".$tempo."', originalMelody='".$originalMelody."' where id=".$f;
						$stmt = $con->prepare("update metadata set genre=?, tonality=?, thekey=?, thescale=?, title=?, composer=?, compositiondate=?, performer=?, musicContent=?, unfoldedMusic=?, tempo=?, originalMelody=? where id=".$f);
                                                $stmt->bind_param('ssssssssssss',$genre,$tonality,$key,$scale,$title,$composer,$compdate,$performer,$musicalcontent,$unfoldedmusic,$tempo,$originalMelody);
						//echo $sql."<br>";
						//if($con->query($sql)){
						if($stmt->execute()){
                                                }else{
							echo "<font color='red'> error: ".$con->error."</font>"."<br>";
							$saveMsg = " / error: query failed";
						}
						if(isset($_GET["instruments"])){
                                                        $sqltmp = "delete from files2instruments where fileId=".$f;
                                                        if($con->query($sqltmp)==true){
                                                        }else{
                                                                echo $con->error;
                                                                $saveMsg = " / error updating instruments";
                                                        }
                                                        foreach($_GET["instruments"] as $inst){
                                                                $sqltmp = "insert into files2instruments values(".$f.",".$inst.")";
                                                                if($con->query($sqltmp)==true){
                                                                }else{
                                                                        echo $con->error;
                                                                        $saveMsg = " / error updating instruments";
                                                                }
                                                        }
                                                }else{
                                                        //echo "instruments is not set<br><br>";
                                                        //$saveMsg = " / error updating metadata";
                                                }
					}
				}

				$f    = $_GET['f'];
                                $sql  = "select * from metadata where filetype='private' and id=".$f;
				$res  = $con->query($sql)->fetch_assoc();
				$ulen = strlen($_SESSION['USER']['id'])-1;
			?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
                                <?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Private Files / Metadata / <?echo substr($res['filename'],49+$ulen)?></h3>
				<hr style='background-color:#ddd'>
				<form action='dataOfPrivateFile.php' method='get' id='theform'>
					<div class='row'>
						<div class='col-sm-6'>
							<fieldset>
								<label>file information</label><br>
                                                                path:       <?echo substr($res['filename'],43+6+$ulen)?><br>
                                                                owner:      <?echo $res['owner']?><br>
                                                                owner role: <?echo $res['ownergroup']?><br>
							</fieldset>
						</div>
						<div class='col-sm-6'>
							<fieldset>
                                                                <label>&nbsp;</label><br>
                                                                duration:   <?echo gmdate("H:i:s",$res['duration'])?><br>
                                                                encoding:   <?echo $res['encoding']?><br>
								size in KB: <?echo round($res['size']/1000,2) ?><br>
                                                        </fieldset>

						</div>
					</div>
					<div class='row'>
						<div class='col-sm-6'>
                                                        <fieldset>
							<label>music content description <font color='red'><? echo $saveMsg; ?></font></label><br>
								genre<br>
								<select name='genre' style='width:70%'>
									<?
									$genres = array("", "rock", "pop", "alternative", "indie", "electronic", "female vocalists", "dance", "00s", "alternative rock", "jazz", "beautiful", "metal", "chillout", "male vocalists", "classic rock", "soul", "indie rock", "Mellow", "electronica", "80s", "folk", "90s", "chill", "instrumental", "punk", "oldies", "blues", "hard rock", "ambient", "acoustic", "experimental", "female vocalist", "guitar", "Hip-Hop", "70s", "party", "country", "easy listening", "sexy", "catchy", "funk", "electro", "heavy metal", "Progressive rock", "60s", "rnb", "indie pop", "sad", "House", "happy");
									for($i=0; $i<count($genres); $i++){
										if($res['genre']==$genres[$i]){
											echo "<option value='".$genres[$i]."' selected>".$genres[$i]."</option>";
										}else{
											echo "<option value='".$genres[$i]."'>".$genres[$i]."</option>";
										}
									}
									?>
								</select><br>
								<!--input type='text' name='genre' value='<?echo $res['genre']?>'><br-->
                                                                title<br>
								<input type='text' name='title' value="<?echo $res['title']?>"><br>
                                                                composer<br>
								<input type='text' name='composer' value="<?echo $res['composer']?>"><br>
                                                                composition date<br>
								<input type='date' name='compositionDate' value="<?echo $res['compositiondate']?>"><br>
                                                                performer<br>
								<input type='text' name='performer' value="<?echo $res['performer']?>"><br>
								instruments<br>
								<select name='instruments[]' multiple style='width:70%'>
									<?
                                                                        $instrDb = $con->query("select * from instruments");
                                                                        for($i=0; $i<$instrDb->num_rows; $i++){
                                                                                $instr = $instrDb->fetch_assoc();
                                                                                //print_r($instrDbRow);
                                                                                $sqltmp  = "select * from files2instruments where fileId=".$f." and instrumentId=".$instr['id'];
                                                                                $f2instr = $con->query($sqltmp);
                                                                                echo $f2instr->num_rows."<br>";
                                                                                if(isset($f2instr)===true){
                                                                                        if($f2instr->num_rows==1){
                                                                                                echo "<option value='".$instr['id']."' selected>".$instr['iname']."</option>";
                                                                                        }else{
                                                                                                echo "<option value='".$instr['id']."'>".$instr['iname']."</option>";
                                                                                        }
                                                                                }else{
                                                                                        echo $f2instr->error;
                                                                                }
                                                                        }
                                                                        ?>
                                                                </select>
                                                        </fieldset>
						</div>
						<div class='col-sm-6'>
								<!--
								tonality<br>
								<input type='text' name='tonality' value='<?echo $res['tonality']?>'><br>
								-->
								<?
									//$tonality = $res['tonality'];
									$key   = $res['thekey'];
									$scale = $res['thescale'];
                                                                ?>
                                                                key<br>
                                                                <select name='key' style='height:28px'>
									<option value=''></option>
									<option value='A' <? if($key=="A") echo "selected"?>>A</option>
                                                                        <option value='Ac' <? if($key=="A#") echo "selected"?>>A&#9839; Β&#9837;</option>
                                                                        <option value='B' <? if($key=="B") echo "selected"?>>B</option>
                                                                        <option value='B#' <? if($key=="B#") echo "selected"?>>B&#9839; C&#9837;</option>
                                                                        <option value='C' <? if($key=="C") echo "selected"?>>C</option>
                                                                        <option value='C#' <? if($key=="C#") echo "selected"?>>C&#9839; D&#9837;</option>
                                                                        <option value='D' <? if($key=="D") echo "selected"?>>D</option>
                                                                        <option value='D#' <? if($key=="D#") echo "selected"?>>D&#9839; E&#9837;</option>
                                                                        <option value='E' <? if($key=="E") echo "selected"?>>E</option>
                                                                        <option value='E#' <? if($key=="E#") echo "selected"?>>E&#9839; F&#9837;</option>
                                                                        <option value='F' <? if($key=="F") echo "selected"?>>F</option>
                                                                        <option value='F#' <? if($key=="F#") echo "selected"?>>F&#9839; G&#9837;</option>
                                                                        <option value='G' <? if($key=="G") echo "selected"?>>G</option>
                                                                        <option value='G#' <? if($key=="G#") echo "selected"?>>G&#9839; A&#9837;</option>
                                                                </select><br>
                                                                scale<br>
                                                                <select name='scale' style='height:28px'>
                                                                        <option value=''></option>
                                                                        <option value='M' <? if($scale=="M") echo "selected"?>>major</option>
									<option value='m' <? if($scale=="m") echo "selected"?>>minor</option>
                                                                        <option value='mm' <? if($scale=="mm") echo "selected"?>>melodic minor</option>
                                                                        <option value='mh' <? if($scale=="mh") echo "selected"?>>harmonic minor</option>
                                                                </select><br>
								music content<br>
                                                                <!--input type='text' name='musicContent' value='<?echo $res['musicContent']?>'><br-->
                                                                <select name='musicContent'>
                                                                        <option value=''></option>
                                                                        <option value='voiced'       <?if($res['musicContent']=='voiced')       echo 'selected';?>>voiced</option>
                                                                        <option value='instrumental' <?if($res['musicContent']=='instrumental') echo 'selected';?>>instrumental</option>
                                                                </select><br>
                                                                tempo<br>
								<input type='text' name='tempo' value='<?echo $res['tempo']?>'><br>
								<!--
                                                                unfolded music<br>
								<input type='text' name='unfoldedMusic' value='<?echo $res['unfoldedMusic']?>'><br>
                                                                original melody<br>
								<input type='text' name='originalMelody' value='<?echo $res['originalMelody']?>'><br>
								-->
                                                </div>
					</div>
					<div class='row'>
						<div class='col-sm-12'>
						<fieldset>
							<input type='hidden' name='f' value='<?echo $f?>'>
							<input type='hidden' name='action' value='saveMetadata'>
							<input type='button' value='Submit'  onclick='javacsript:doit()' style='width:150px'> 
							<input type='button' name='suggestMetadata' value='Suggest Metadata' onclick='javascript:suggest()' style='width:150px'><br>
						</fieldset>
						</div>
					</div>
				</form>
				<br>
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

