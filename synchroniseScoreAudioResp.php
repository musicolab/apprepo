<? session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?
header("Access-Control-Allow-Origin:*");
?>
</head>
<body>
<?
			error_log(" ");
			error_log("-------------------------- ");
			error_log("--- SYNCHRONIZATION RESP",0);
			error_log("-------------------------- ");

			//if(isset($_SESSION["USER"]->username)){
				$THEUSER = "";
				$THEUSERID = "2";
				error_log("POST = ");
				error_log(print_r($_POST, true));
				error_log("FILES = ");
				error_log(print_r($_FILES, true));
				//error_log(" - action    = ".$_POST['action'],0);
				//error_log(" - filename  = ".$_POST['filename'],0);
				error_log(" - midi name = ".$_FILES['themid']['name'],0);
				error_log(" - midi size = ".$_FILES['themid']['size'],0);
				error_log(" - theaudio name = ".$_FILES['theaudio']['name'],0);
				error_log(" - theaudio size = ".$_FILES['theaudio']['size'],0);

				if(!isset($_POST['action'])){
					error_log("invalid state, please contact the admins",0);
				}else{
					if($_POST['action']=="synchronization"){
						$theurl = $_POST['theUrl'];
						//error_log(" - the url is: ". $theurl);
						//error_log(" - starting the upload");
						//error_log(" - uploading to ".$THEUSER."'s private files");
						//$targetDir = "/var/www/moodledata/repository/jsonFiles/";
						
						$targetDir = "/var/www/html/vhv/";
						$targetFileA = $targetDir . 'syncWav.wav'; //. $_FILES['blob']['name'];
						$targetFileM = $targetDir . 'syncMidi.mid'; //. $_FILES['file']['name'];

						error_log(" - targetFileA = ".$targetFileA);
						error_log(" - targetFileM = ".$targetFileM);

						$data = $_FILES['themid']['tmp_name'];
						move_uploaded_file($data, $targetFileM);
						error_log(" - uploaded the midi file");

						$data = $_FILES['theaudio']['tmp_name'];
						move_uploaded_file($data, $targetFileA);
						error_log(" - uploaded the audio file");

						//decode the mid
						error_log(" - decoding the midi file");
						$mid = fopen($targetDir.'/syncMidi.mid', 'r') or die('unabled to open midi file');
						$data = fread($mid, filesize($targetDir.'/syncMidi.mid'));
						fclose($mid);
						$mid = fopen($targetDir.'/syncMidi2.mid', 'w') or die('unabled to open midi file');
						// error_log(" - ".$data);
						$data2 = base64_decode(strval($data));
						fwrite($mid, $data2);
						fclose($mid);
						error_log(" - midi decoding is done");
						
						$cmd = "/home//virtualEnvs/wavMidiSync/bin/python /home//virtualEnvs/wavMidiSync/code.py";
						exec($cmd);
						//exec($cmd, $output);
						error_log(" - executed python ");
						error_log("done with the db");

					}else{
						error_log("error: invalid action, please contact the admins");
					}
				}
?>
</body>
</html>
