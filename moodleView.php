<?session_start();?>
				<?
                                error_log("--- LOGGING IN", 0);
				error_log("-------------");
				$theip = getenv("REMOTE_ADDR");
				error_log("connecting from the ip = ".$theip);
				error_log(print_r($_SESSION, true));
                                $loginResultMsg = "";
                                $roles          = "";
                                if(isset($_POST["action"])){
					if($_POST["action"]=="externalLogin"){
						error_log("external login");
                                                $con = mysqli_connect("localhost", "", "", "moodle");
                                                $sql = "select * from user where username='".$_POST["user"]."'";
						$res = $con->query($sql);

						if($res){
							error_log("getting the moodle session, if there is any, for this user");
                                                        $row = mysqli_fetch_assoc($res);
							error_log("user ".$_POST["user"]." has id = ".$row["id"]);
							$sql2 = "select * from sessions where userid='".$row["id"]."'"; // and lastip='".$theip."'";
							$res2 = $con->query($sql2);
							$ver  = false;
							if($res2->num_rows>0){
								$max = -1;
								$sid = -1;
								while($row2 = mysqli_fetch_assoc($res2)){
									if($max<$row2["timemodified"]){
										$max = $row2["timemodified"];
										$sid = $row2["sid"];
									}
								}
								$dateEnd = date('H:i:s d-M-Y', $max+36000);
								error_log(" - FOUND SESSION ".$sid. " modified on ".$max);
								error_log(" - session = ".print_r($_SESSION, true));
								$ver = true;
							}else{
								error_log(" - DID NOT FIND A SESSION, authenticating ");
								$ver = password_verify($_POST['pass'], $row['password']);
                	                                	error_log(" - user ".$_POST["user"]." is authenticated sucessfully");
							}
							if($ver){
								//$_SESSION['USER'] = array("username"=>"a", "firstname"=>"a", "lastname"=>"a", "id"=>"a");
								error_log(" - session = ".print_r($_SESSION, true));
								error_log(" - session->username = ".$_SESSION['USER']["username"]);
                        	                               	$_SESSION['USER']["username"] = $_POST["user"];
                                	                       	$_SESSION['USER']["firstname"] = $row["firstname"];
                                        	               	$_SESSION['USER']["lastname"] = $row["lastname"];
                                                	       	$_SESSION['USER']["id"] = $row["id"];

                                                        	$sql   = "select * from role_assignments a, role b where a.userid=".$_SESSION["USER"]["id"]." and a.roleid=b.id";
                                                               	$res   = $con->query($sql);
	                                                       	$cnt   = 0;
        	                                               	if($res){
                	                                                while($row = mysqli_fetch_assoc($res)){
                        	                                               if($row['shortname']!="student"){
                                	                                       		$cnt++;
                                        	                                        //echo $cnt." ".$row['shortname']." ";
                                                	                                if(strpos($roles, $row['shortname'])==false){
                                                        	                        	$roles = $roles . " " . $row['shortname'];
                                                                	                }else{
                                                                        	        }
	                                                                	}
        	                                                       	}
                	                                        	$_SESSION['USER']["role"] = $roles;
                        	                               	}
                                	                }else{
                                        	               	#echo "<font color='red'>it was not... </font><br>";
                                                	       	$loginResultMsg = "invalid credentials, please try again";
                                                        }
                                                }else{
                                                        #echo "<font color='red'> error: ".$con->error."</font>"."<br>";
                                                        $loginResultMsg = $con->error;
                                                }
                                        }
                                }else{
					error_log("no external login (no action set)");
					error_log(" - searching for the moodle session, if there is any, for this ip address");
                                        $con = mysqli_connect("localhost", "", "", "moodle");
                                        $sql2 = "select * from sessions where lastip='".$theip."'";
                                        $res2 = $con->query($sql2);
					if($res2->num_rows>0){
						error_log(" - found #".$res2->num_rows." records in the session from ".$theip." proceeding to get the users");
                                               	$max = -1;
                                               	$sid = -1;
                                               	while($row2 = mysqli_fetch_assoc($res2)){
                                                	if($max<$row2["timemodified"]){
                                                                $max = $row2["timemodified"];
								$sid = $row2["sid"];
								$uid = $row2["userid"];
                                                		$sql3 = "select * from user where id='".$uid."'";
								error_log(" - sql = ".$sql3);
								$res3 = $con->query($sql3);
								$row3 = mysqli_fetch_assoc($res3);
								error_log(" - user = ".$row3['username']);
								$_SESSION['USER']["username"] = $row3['username'];
        	                                	        $_SESSION['USER']["firstname"] = $row3["firstname"];
                	                	                $_SESSION['USER']["lastname"] = $row3["lastname"];
								$_SESSION['USER']["id"] = $row3["id"];

								if(isset($_SESSION['USER']["username"])){
									error_log("test1");

									$sql   = "select * from role_assignments a, role b where a.userid=".$_SESSION["USER"]["id"]." and a.roleid=b.id";
									error_log(" - sql = ".$sql);
                	                                                $res   = $con->query($sql);
		        	                                        $cnt   = 0;
                			                                if($res){
                                			                	while($row = mysqli_fetch_assoc($res)){
	                                                			        if($row['shortname']!="student"){
        	                                                	        		$cnt++;
                			                                	                if(strpos($roles, $row['shortname'])==false){
                        	        		                       				$roles = $roles . " " . $row['shortname'];
                                	                		                	}else{
			                	                                         	}
        		        		                                	}
	                	                		                }
        	                	                        		$_SESSION['USER']["role"] = $roles;
	                                	               			$dateEnd = date('H:i:s d-M-Y', $max+36000);
		                        	                       		error_log(" - FOUND SESSION ".$sid. " for user ".$_SESSION['USER']['username']." modified on ".$max);
										error_log(" - session = ".print_r($_SESSION, true));
										error_log("end of no external login");
										break;
									}
		                                        	}
                                                       	}
                                               	}
                                        }else{  
                                               	error_log(" - DID NOT FIND A SESSION, authenticating ");
                                              	$ver = password_verify($_POST['pass'], $row['password']);
                                        	error_log(" - user ".$_POST["user"]." is authenticated sucessfully");
                                        }       
				}
				error_log("out of the login block");
                                ?>

<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script src="https://unpkg.com/wavesurfer.js">
			var wavesurfer = WaveSurfer.create({container:'#waveform'});
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
				if(isset($_SESSION["USER"]["username"])){
				?>
						<h3>MusiCoLab Repository</h3>
						<hr style='background-color:#ddd'>
						<?
						//print_r($_SESSION);
						?>
						MusiCoLab's Digital Repository is an online software system that manages digital files for music. It hosts audio, video, score files as well as alternative / non-conventional formats of digital documents. The content can be used through a learning management system and its applications that is, for sharing, collaborative synthesis and / or editing. The repository will be used by students and teachers and will be enriched with content that will come from the lessons conducted through the platform.<br>
						<br>
						In summary, the repository currently offers pieces of functionality such as the following:
						<ul>
							<li>Uploading and saving files
							<li>File annotation and the ability to edit annotations (metadata and hashtags)
							<li>Controlled access to its content and possibility of sharing within a course
							<li>File search and retrieval mechanisms
							<li>File copying and editing mechanism
							<li>Some of the <font color='red'>new</font> features as of March
							<ul>
								<li>content base search (fingerprinting and music recognition)
								<li>player in public files also lists metadata 
								<li>recording from mic plus multiple files recording
								<li>metadata suggestions from auto tagger
								<ul>
									<li>the autotagger is run if there is no other instance in the memory
								</ul>
							</ul>
							<li>embedded waveform viewer for mp3, wav files
							<li>file counters in the side menu
							<li>uploads: real time progress bar
						</ul>
						for more info about the development and the features you may visit DEVELOPMENT
					</div>
				</div>


				<!--img src='underConstruction.png'>
					</ul>
					dev notes
					<ul>
                                        	<li><a href='devlog.php'>ISSUES</a>
                                        	<li><a href='specs.php'>specs</a>
                                        	<li><a href='config.php'>config &amp; system params</a>
						<li><a href='codestats' target='_blank'>code stats</a>
					</ul>

					<?
					/*
					$f = "/var/www/html/apprepository/a19f5e6eec6fa406d987d18668f885c51538e2d6";
					echo hash_file("sha1", $f)."<br>";
					$f = "/5/user/private/0/intervals.png";
					echo hash("sha1", $f)."<br>";
					print_r($_SESSION);
					*/
					?>
				<br>
				<br-->
				<? }else{ ?>		
                                	<div class="panel panel-default" style='border:1px solid #ddd;'>
					<div class="panel-body">
					<h3>MusiCoLab Repository</h3>
					<hr style='background-color:#ddd'>

					<center>
					<div id="waveform" style='width:r80%; background-color:#ddd;'></div>
					<br>
					<input type='button' value='PLAY' onclick='play()'> 
					<input type='button' value='STOP' onclick='stop()'><br>
					<small>
					<!--* examples come form the public domain, eg: <a href='https://www.freemusicpublicdomain.com/'>Images - Lost European</a-->
					</small>
					<br>
					<script>
						var wavesurfer = WaveSurfer.create({ container: '#waveform', waveColor: '#337ab7', progressColor: '#f4b426' });
						//wavesurfer.load('images_lostEuropean.wav');
						wavesurfer.load('song_cjrg_teasdale_64kb.mp3');

			                        function play(){
			                                wavesurfer.play();
			                        }
			                        function stop(){
			                                wavesurfer.stop();
			                        }
					</script>
					<!--img src='underConstruction.png' style='width:25%'-->
					</center>
					<!--small>
					<pre>
// Read file into memory.
$fileHandle = fopen('02 Impulse Crush.mp3', 'rb');
$binary = fread($fileHandle, 5);

// Detect presence of ID3 information.
if (substr($binary, 0, 3) == "ID3") {
  // ID3 tags detected.
  $tags['FileName'] = $file;
  $tags['TAG'] = substr($binary, 0, 3);
  $tags['Version'] = hexdec(bin2hex(substr($binary, 3, 1))) . "." . hexdec(bin2hex(substr($binary, 4, 1)));
}					</pre-->
					</small>
				<? } ?>
				</div>
				</div>
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

