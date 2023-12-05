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
			function suggest(){
                                conf = confirm("You are about to run the analysis engine, which may take a few minutes to complete. The engine will run asynchronously and the results will fill in any empty fields in red.\n\n Please confirm in order to proceed !");
                                if(conf) {
                                        f = document.getElementById("theformsuggest");
					thebutton = document.getElementById("suggestMetadata");
					//thebutton.disabled=true;
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
				$con     = mysqli_connect("localhost", "", "", "");
				$saveMsg = "";

				if(isset($_GET['action'])){
					if($_GET['action']=="saveMetadata"){
						$saveMsg = " Sucessfully updated !";

						$f   = $_GET['f'];
						$genre = $_GET['genre'];
						$key = $_GET['key'];
						$scale = $_GET['scale'];
						$title =$_GET['title']; 
						$tonality = "";
						$composer =$_GET['composer']; 
						$compdate =$_GET['compositionDate']; 
						$performer =$_GET['performer']; 
						$musicalcontent =$_GET['musicContent']; 
						$unfoldedmusic =$_GET['unfoldedMusic']; 
						$tempo =$_GET['tempo']; 
						$originalMelody =$_GET['originalMelody']; 
						$sql = "update metadata set genre='".$genre."', tonality='".$tonality."', thekey='".$key."', thescale='".$scale."', title='".$title."', composer='".$composer."', compositiondate='".$compdate."', performer='".$performer."', musicContent='".$musicalcontent."', unfoldedMusic='".$unfoldedmusic."', tempo='".$tempo."', originalMelody='".$originalMelody."' where id=".$f;
						$stmt = $con->prepare("update metadata set genre=?, tonality=?, thekey=?, thescale=?, title=?, composer=?, compositiondate=?, performer=?, musicContent=?, unfoldedMusic=?, tempo=?, originalMelody=? where id=".$f);
						$stmt->bind_param('ssssssssssss',$genre,$tonality,$key,$scale,$title,$composer,$compdate,$performer,$musicalcontent,$unfoldedmusic,$tempo,$originalMelody);
						//echo $sql."<br>";
						//if($con->query($sql)===TRUE){
						if($stmt->execute()){
                                                }else{
							echo "<font color='red'> error: ".$con->error."</font>"."<br>";
							$saveMsg = "Error: query failed";
                                                }
						//$instruments = $_GET['instrument'];
						if(isset($_GET["instruments"])){
							$sqltmp = "delete from files2instruments where fileId=".$f;
							if($con->query($sqltmp)==true){
							}else{
								echo $con->error;
								$saveMsg = "Error updating instruments";
							}
							foreach($_GET["instruments"] as $inst){
								$sqltmp = "insert into files2instruments values(".$f.",".$inst.")";
								if($con->query($sqltmp)==true){
								}else{
									echo $con->error;
									$saveMsg = "Error updating instruments";
								}
							}
						}else{
							//echo "instruments is not set<br><br>";
							//$saveMsg = " / error: instruments are not set";
						}
					}
				}

				$f   = $_GET['f'];
                                $sql = "select * from metadata where filetype='public' and id=".$f;
				$res = $con->query($sql)->fetch_assoc();

				$jsonExists = false;
				$filename =  substr($res['filename'],48);
				$jsonFile = '/var/www/moodledata/repository/jsonFiles/public/'.substr($filename,0,strlen($filename)-4).'.json';
				$jsonKey  = "";
				$jsonScale= "";
				$jsonVoice= "";
				$jsonGenre= "";
				$color    = "";
				if(isset($_GET['color'])){
					if(file_exists($jsonFile) and $_GET['color']=="red"){
						unlink($jsonFile);
					}
				}
				if(file_exists($jsonFile)){
					$json_a = json_decode(file_get_contents($jsonFile),true);
                                        //echo("<small><pre>");
                                        //var_dump($json_a["root"]["mir"]);
                                        //var_dump($json_a["root"]["tonal"]);
                                        //var_dump($json_a["root"]["metadata"]);
                                        //echo("</pre></small>");
					//$tonal    = $json_a["root"]["mir"]["tonal"];
					//$accoustic= $json_a["root"]["mir"]["acousticness"];
					$jsonKey  = $json_a["root"]["tonal"]["key_key"];
					$jsonScale= $json_a["root"]["tonal"]["key_scale"];
					$jsonVoice= $json_a["root"]["mir"]["isVoiced"];
					$jsonGenre= $json_a["root"]["mir"]["genre_1"];
					if($jsonScale=="major") $jsonScale="M";
					if($jsonScale=="minor") $jsonScale="m";
					if($jsonVoice=="voice") $jsonVoice="voiced";
					

					//echo $jsonKey;
					//echo $jsonScale;
					$jsonExists = true;
					$color="red";
				}
			?>

			 <div class="col-sm-9">
                                <div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
                                <?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Public files / Metadata / <?echo substr($res['filename'],48)?></h3>
				<hr style='background-color:#ddd'>
				<? if($saveMsg!=""){ ?>
					<div class="alert alert-info" style="margin-bottom:0px"><? echo $saveMsg; ?></div>
				<? } ?>
				<form action='dataOfPublicFile.php' method='get' id='theform'>
					<div class='row'><div class='col-sm-12'><br><b>File information</b></div></div>
					<div class='row'>
						<div class='col-sm-6'>
                                                                <span style='display:inline-block;width:25%'>path:</span>       <b><?echo substr($res['filename'],41)?></b><br>
                                                                <span style='display:inline-block;width:25%'>owner:</span>      <b><?echo $res['owner']?></b><br>
                                                                <span style='display:inline-block;width:25%'>owner role:</span> <b><?echo $res['ownergroup']?></b><br>
						</div>
						<div class='col-sm-6'>
                                                                <span style='display:inline-block;width:25%'>duration:</span>   <b><?echo gmdate("H:i:s",$res['duration'])?></b><br>
                                                                <span style='display:inline-block;width:25%'>encoding:</span>   <b><?echo $res['encoding']?></b><br>
                                                                <span style='display:inline-block;width:25%'>size (KB):</span> <b><?echo round($res['size']/1000,2) ?></b><br>

						</div>
					</div>
					<div class='row'><div class='col-sm-12'><br><b>Music content description </b></div></div>
					<div class='row'>
						<div class='col-sm-6'>
								 <?
                                                                        //$tonality = $res['tonality'];
                                                                        $genre   = $res['genre'];
                                                                        if($jsonExists){
                                                                                $genre = $jsonGenre;
                                                                        }
                                                                ?>
								genre<br>
								<select name='genre' style='width:100%; height:30px; color:<?echo $color?>'>
                                                                        <?
                                                                        $genres = array("", "rock", "pop", "alternative", "indie", "electronic", "female vocalists", "dance", "00s", "alternative rock", "jazz", "beautiful", "metal", "chillout", "male vocalists", "classic rock", "soul", "indie rock", "Mellow", "electronica", "80s", "folk", "90s", "chill", "instrumental", "punk", "oldies", "blues", "hard rock", "ambient", "acoustic", "experimental", "guitar", "Hip-Hop", "70s", "party", "country", "easy listening", "sexy", "catchy", "funk", "electro", "heavy metal", "Progressive rock", "60s", "rnb", "indie pop", "sad", "House", "happy");
                                                                        for($i=0; $i<count($genres); $i++){
                                                                                if($genre==$genres[$i]){
                                                                                        echo "<option value='".$genres[$i]."' selected>".$genres[$i]."</option>";
                                                                                }else{
                                                                                        echo "<option value='".$genres[$i]."'>".$genres[$i]."</option>";
                                                                                }
                                                                        }
                                                                        ?>
                                                                </select><br>
                                                                title<br>
								<input type='text' name='title' style='width:100%' value="<?echo $res['title']?>"><br>
                                                                composer<br>
								<input type='text' name='composer' style='width:100%' value="<?echo $res['composer']?>"><br>
                                                                composition date<br>
								<input type='date' name='compositionDate' style='width:100%' value='<?echo $res['compositiondate']?>'><br>
                                                                performer<br>
								<input type='text' name='performer' style='width:100%' value="<?echo $res['performer']?>"><br>
								instruments<br>
                                                                <select name='instruments[]' style='width:100%;' multiple style='width:70%'>
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
						</div>
						<div class='col-sm-6'>
								<!--
                                                                tonality<br>
								<input type='text' name='tonality' style='width:100%' value='<?echo $res['tonality']?>'><br>
								-->
								<?
									//$tonality = $res['tonality'];
									$key   = $res['thekey'];
									$scale = $res['thescale'];
									if($jsonExists){
										$key = $jsonKey;
										$scale = $jsonScale;
									}
								?>
								key<br>
								<select name='key' style='height:28px; color:<?echo $color;?>'>
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
								<select name='scale' style='height:28px; color:<?echo $color;?>'>
									<option value=''></option>
									<option value='M' <? if($scale=="M") echo "selected"?>>major</option>
									<option value='m' <? if($scale=="m") echo "selected"?>>minor</option>
									<option value='mm' <? if($scale=="mm") echo "selected"?>>melodic minor</option>
									<option value='mh' <? if($scale=="mh") echo "selected"?>>harmonic minor</option>
								</select><br>
								<?
                                                                        $musCont = $res['musicContent'];
									if($jsonExists){
                                                                                $musCont = $jsonVoice;
                                                                        }
                                                                ?>
								music content<br>
								<!--input type='text' name='musicContent' value='<?echo $res['musicContent']?>'><br-->
								<select name='musicContent' style='width:100%; height:30px; color:<?echo $color?>'>
									<option value=''></option>
									<option value='voiced'       <?if($musCont=='voiced')       echo 'selected';?>>voiced</option>
									<option value='instrumental' <?if($musCont=='instrumental') echo 'selected';?>>instrumental</option>
								</select><br>
								tempo<br>
								<input name='tempo' name='tempo' value='<?echo $res['tempo'];?>' style=''><br>
                                                                <!--unfolded music<br>
								<input type='text' name='unfoldedMusic' value='<?echo $res['unfoldedMusic']?>'><br>
                                                                original melody<br>
								<input type='text' name='originalMelody' value='<?echo $res['originalMelody']?>'><br-->
                                                </div>
					</div>
					<div class='row'>
						<div class='col-sm-3'></div>
						<div class='col-sm-6'>
							<center>
						<br>
							<input type='hidden' name='f' value='<?echo $f?>'>
							<input type='hidden' name='action' value='saveMetadata'>
							<input type='hidden' name='color' value='<?echo $color?>'>
							<input type='button' name='submitbtn' value='Submit' onclick='javascript:doit()' style='width:150px'> 
							</form>
							<?
 		                                       	if(isset($_GET['action'])){
								if($_GET['action']=="suggestMetadata"){
									echo "<br>Waiting for metadata retrieval<br>";
								}else{
									if(!$jsonExists){

							?>
										<form action='dataOfPublicFile.php' method='get' id='theformsuggest' style='display:inline'>
										<input type='hidden' name='f' value='<?echo $f?>'>
										<input type='hidden' name='action' value='suggestMetadata'>
										<input type='button' name='suggestMetadata' id='suggestMetadata' value='Suggest Metadata' onclick='javascript:suggest()' style='width:150px'><br>	
							<?
									}else{
										echo "<br>please review any metadata colored in red and submit<br>";
									}
								}
							}else{
								if(!$jsonExists){
							?>
									<form action='dataOfPublicFile.php' method='get' id='theformsuggest' style='display:inline'>
									<input type='hidden' name='f' value='<?echo $f?>'>
									<input type='hidden' name='action' value='suggestMetadata'>
									<input type='button' name='suggestMetadata' id='suggestMetadata' value='Suggest Metadata' onclick='javascript:suggest()' style='width:150px'><br>	
								<?
								}else{
									echo "<br>please review any metadata colored in red and submit<br>";
								}
							}
							?>
							</center>
						</div>
						<div class='col-sm-3'></div>
					</div>

					<?
					if(isset($_GET['action'])){
						if($_GET['action']=="suggestMetadata"){
							$f   = $_GET['f'];
	        	        	                $sql = "select * from metadata where filetype='public' and id=".$f;
							$res = $con->query($sql)->fetch_assoc();
							$filename =  substr($res['filename'],48);
							$jsonFile = '/var/www/moodledata/repository/jsonFiles/public/'.substr($filename,0,strlen($filename)-4).'.json';
							//echo "filename = ".$filename."<br>";
							//echo "jsonFile = '".$jsonFile."'<br>";

							$output = null;
							exec('ps -ef | grep python3', $output);
							$executePython = "true";
							foreach($output as $entry){
								if(strpos($entry,substr($filename,0,strlen($filename)-4))){
									$executePython="false";
									break;
								}else{
								}
							}
							//print_r($output);

							$ret    = -1;
							if($executePython=="true"){
								$cmd    = "/home/pzervas/musRepoTools/bin/python3 /home/pzervas/musRepoTools/source/1-autoTagger-perFile.py /var/www/moodledata/repository/jsonFiles/public/ '".$filename."' > /dev/null &";
								exec($cmd);
							}else{
								//echo "already running";
							}
							//$ret    = 0;
							//exec($cmd, $output, $ret);
							/*
							if($ret==0){
								//print_r($output);
								$json_a = json_decode(file_get_contents($jsonFile),true);
								echo("<small><pre>");
								var_dump($json_a["root"]["mir"]);
								var_dump($json_a["root"]["tonal"]);
								var_dump($json_a["root"]["metadata"]);
								//var_dump($json_a["root"]["metadata"]);
								//var_dump($json_a); // just to see the structure. It will help you for future cases
								echo("</pre></small>");
								//echo "done";
							}else{
								//echo "execution result = ".$ret."<br>";
							}
							*/
						}
					}
					?>
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

