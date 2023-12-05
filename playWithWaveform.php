<?session_start();?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script src="https://unpkg.com/wavesurfer.js"></script>
		<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.cursor.js"></script>
		<script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.timeline.js"></script>
  </head>
  <body>
	<div class="container">

		<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<?
				if(isset($_SESSION["USER"]['username'])){
				?>
                                <div class="panel panel-default" style='border:1px solid #ddd;'>
                                <div class="panel-body">
				<h3>MusiCoLab Repository / Public Files / Play file: <?echo $_GET['f']; ?></h3>
				<hr style='background-color:#ddd'>
					<center>
					<div id="waveform" style='width:r80%; background-color:#ddd;'></div>
					<div id="wavetimeline" style='width:r80%; background-color:white;'></div>
					<br>
					<input type='button' value='PLAY' onclick='play()'> 
					<input type='button' value='STOP' onclick='stop()'>
					 playback rate (in tenths): <input type='number' value='10' min='1' max='20' id='playbackrate' onchange='changeRate()'><br>
					</small>
					<br>
					<script>
						var wavesurfer = WaveSurfer.create({ 
							container: '#waveform', 
							waveColor: '#337ab7', 
							progressColor: '#f4b426', 
							plugins: [
								WaveSurfer.cursor.create({
									showTime: true,
									opacity: 1,
									customShowTimeStyle: { 'background-color': '#000', color: '#fff', padding: '2px', 'font-size': '10px' }
								}),
								WaveSurfer.timeline.create({ container: '#wavetimeline' }) 
    							]
						});
						//wavesurfer.load('images_lostEuropean.wav');
						//wavesurfer.load('song_cjrg_teasdale_64kb.mp3');
						//wavesurfer.load('/var/www/moodledata/repository/jsonFiles<? //echo $_GET["p"];?>');
						//	https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=clarinet.mp3
						wavesurfer.load('https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=<? echo $_GET["f"];?>');
						console.log('/var/www/moodledata/repository/jsonFiles<? echo $_GET["f"]; ?>');

			                        function play(){
			                                wavesurfer.play();
			                        }
			                        function stop(){
			                                wavesurfer.stop();
						}
						function changeRate(){
							rate = document.getElementById("playbackrate").value;
							wavesurfer.setPlaybackRate(rate/10);
						}
					</script>
					</center>
					<?
					$con = mysqli_connect("localhost", "", "", "");
					$f   = $_GET['id'];
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
				 <div class='row'>
					<div class='col-sm-12'>
						<b>File information</b>
						<hr style='background-color:#ddd'>
					</div>
				</div>
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
				 <div class='row'>
					<div class='col-sm-12'>
						<br>
						<b>Music content description </b>
						<hr style='background-color:#ddd'>
					</div>
				</div>
                                        <div class='row'>
                                                <div class='col-sm-6'>
                                                                 <?
                                                                        //$tonality = $res['tonality'];
                                                                        $genre   = $res['genre'];
                                                                        if($jsonExists){
                                                                                $genre = $jsonGenre;
                                                                        }
                                                                ?>
								<span style='display:inline-block;width:25%'>genre: </span><b><?echo $genre; ?></b><br>
                                                                <span style='display:inline-block;width:25%'>title: </span><b><?echo $res['title']?></b><br>
                                                                <span style='display:inline-block;width:25%'>composer: </span><b><?echo $res['composer']?></b><br>
                                                                <span style='display:inline-block;width:25%'>composition date: </span><b><?echo $res['compositiondate']?></b><br>
								<span style='display:inline-block;width:25%'>performer: </span><b><?echo $res['performer']?></b><br>
                                                                <span style='display:inline-block;width:25%'>instruments: </span><b>
                                                                        <?
                                                                        $instrDb = $con->query("select * from instruments");
                                                                        for($i=0; $i<$instrDb->num_rows; $i++){
                                                                                $instr = $instrDb->fetch_assoc();
                                                                                //print_r($instrDbRow);
                                                                                $sqltmp  = "select * from files2instruments where fileId=".$f." and instrumentId=".$instr['id'];
                                                                                $f2instr = $con->query($sqltmp);
                                                                                if(isset($f2instr)===true){
                                                                                        if($f2instr->num_rows==1){
                                                                                                echo "".$instr['iname']." ";
                                                                                        }else{
                                                                                        }
                                                                                }else{
                                                                                        echo $f2instr->error;
                                                                                }
                                                                        }
                                                                        ?></b>
                                                </div>
						<div class='col-sm-6'>
                                                                <?
                                                                        //$tonality = $res['tonality'];
                                                                        $key   = $res['thekey'];
                                                                        $scale = $res['thescale'];
                                                                        if($jsonExists){
                                                                                $key = $jsonKey;
                                                                                $scale = $jsonScale;
                                                                        }
                                                                ?>
								<span style='display:inline-block;width:25%'>key:</span> <b><? echo $key; ?><br></b>
								<span style='display:inline-block;width:25%'>scale:</span> <b>
									<? if($scale=="M") echo "major"; ?>
									<? if($scale=="m") echo "minor"; ?>
									<? if($scale=="mm") echo "melodic minor"; ?>
									<? if($scale=="mh") echo "harmonic minor"; ?></b>
								<br>
                                                                <?
                                                                        $musCont = $res['musicContent'];
                                                                        if($jsonExists){
                                                                                $musCont = $jsonVoice;
                                                                        }
                                                                ?>
                                                                <span style='display:inline-block;width:25%'>music content:</span> <b>
									<?
									if($musCont=='voiced'){
										echo 'voiced';
									}else if($musCont=='instrumental'){
										echo 'instrumental';
									}
								?></b>
								<br>
                                                                <span style='display:inline-block;width:25%'>tempo:</span> <b><?echo $res['tempo'];?><br></b>
                                                </div>
                                        </div>

			</div>
			</div>

				<? } ?>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
<script type="text/javascript">
    window.onload = function(){
	    var score_editor = new live_score.Score_editor("live_score_main_panel");
    };
    	function touchStarted() {
  		etAudioContext().resume();
	}
  </script>
    <script src='MIDI.js'></script>
    <script src='live_score-min.js'></script>
</html>

