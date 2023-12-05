<? session_start(); ?>
<?
header("Access-Control-Allow-Origin:*");
?>
<?
	error_log(" ");
	error_log("-------------------------- ");
	error_log("--- BENDIR RESP",0);
	error_log("-------------------------- ");

	$action = $_POST['action'];
    error_log("POST = ".print_r($_POST, true));
    error_log("FILES = ".print_r($_FILES, true));
    error_log(" - action    = " . $action, 0);

	$numerator = isset($_POST['numerator']) ? $_POST['numerator'] : '';
	$denominator = isset($_POST['denominator']) ? $_POST['denominator'] : '';
	$tempo = isset($_POST['tempo']) ? $_POST['tempo'] : '';
	error_log(" - numerator = ".$numerator, 0);
	error_log(" - denominator = ".$denominator,0);
	error_log(" - tempo = ".$tempo,0);

	error_log(" - theaudio name = ".$_FILES['theaudio']['name'],0);  // FIXME? returns blob, NOT the filename
	error_log(" - theaudio size = ".$_FILES['theaudio']['size'],0);

	if(!isset($action)){
		error_log("invalid state, please contact the admins",0);
	}else{
		if($action=="convert2krn"){
			$targetDir = "/var/www/html/vhv/";
			$uploadedFile = $targetDir . 'bendir.wav'; 
			error_log(" - Uploaded file path= ".$uploadedFile,0);

			$data = $_FILES['theaudio']['tmp_name'];
			move_uploaded_file($data, $uploadedFile);
			error_log(" - uploaded the audio file");

			// $uploadedFile = "/home//virtualEnvs/bendir/BNDR_SAMPLE_KM184.wav"; // dummy file for testing
			// Basic script execution (without optional params)
			$cmd = "/home//virtualEnvs/bendir/bin/python3 /home//virtualEnvs/bendir/code.py " . $uploadedFile;

			// Handle optional params, if any
			if (!empty($numerator)) {
				$cmd .= " --top_number " . escapeshellarg($numerator);
			}
			if (!empty($denominator)) {
				$cmd .= " --bottom_number " . escapeshellarg($denominator);
			}
			if (!empty($tempo)) {
				$cmd .= " --approximate_tempo " . escapeshellarg($tempo);
			}

			error_log(" - starting python execution ");
			error_log($cmd);
			exec($cmd);

			error_log(" - executed python ");

			// The .krn file is generated from code.py, is located here:
			$krnFilePath = '/home//virtualEnvs/bendir/bendir_server.krn';

			// Check if the file exists
			if (file_exists($krnFilePath)) {
				// Read the contents of the file
				$krnContent = file_get_contents($krnFilePath);

				// Set the appropriate content type - plain text for .krn files
				header('Content-Type: text/plain');

				// Return the content of the .krn file
				echo $krnContent;

				error_log(" - .krn is included in response ");
			} else {
				// Handle the error if the file does not exist
				header("HTTP/1.0 404 Not Found");
				echo "Error: .krn file not found.";

				error_log(" - Error: .krn file not found ");
			}

		}else{
			error_log("error: invalid action, please contact the admins");
		}
	}
	error_log("--- BENDIR RESP FINISHED", 0);
?>
