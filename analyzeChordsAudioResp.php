<? session_start(); ?>
<?
header("Access-Control-Allow-Origin:*");
?>
<?    
    error_log(" ");
    error_log("-------------------------- ");
    error_log("--- CHORDS & BEATS ANALYSIS RESP", 0);
    error_log("-------------------------- ");

    $action = $_POST['action'];
    error_log("POST = ".print_r($_POST, true));
    error_log("FILES = ".print_r($_FILES, true));
    error_log(" - action    = " . $action, 0);

    // Handling optional params, if given (ATM, not params are sent from client)
    $alignmentPercent = isset($_POST['alignment_percent']) ? $_POST['alignment_percent'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $artist = isset($_POST['artist']) ? $_POST['artist'] : '';
    $method = isset($_POST['method']) ? $_POST['method'] : '';
    
    if (!isset($action))
    {
        http_response_code(400); // Bad Request
        error_log("invalid action, please contact the admins", 0); 
        $response['error'] = 'Action NOT set!';
    }
    else
    {
        if ($_POST['action'] == "chordBeatAnalysis")
        {
            $theurl = $_POST['theUrl'];
            error_log(" - the url is: " . $theurl);
            
            $audioExistsInRepo = $_POST['audioExistsInRepo'] === 'false' ? false : $_POST['audioExistsInRepo'];
            $response = [];      
            
            if ($audioExistsInRepo)
            {
                // 'theaudio' exists in the repository, execute specific logic here
                error_log(" --- This audio EXISTS in repo ---");        // 👌👌👌
                error_log($audioExistsInRepo);   

                // Parse the URL and retrieve the query string
                $queryString = parse_url($theurl, PHP_URL_QUERY);

                // Parse the query string into an array
                parse_str($queryString, $queryArray);

                $f = $queryArray['f'];          
                
                $targetDir = '';
                if ($audioExistsInRepo == 'private'){
                    $userID = $_POST['userID'];
                    $targetDir = "/var/www/moodledata/repository/jsonFiles/users/".$userID."/"; 
                } elseif ($audioExistsInRepo == 'course'){
                    $courseID = $_POST['courseID'];
                    $targetDir = "/var/www/moodledata/repository/jsonFiles/courses/".$courseID."/"; 
                } else{
                    $targetDir = "/var/www/moodledata/repository/jsonFiles/public/";
                }
               
                $targetFile = $targetDir . $f;  
                  
                // Return the file which will reside in temp folder
                $baseName = pathinfo($f, PATHINFO_FILENAME);
                $response['filename'] = [$baseName . ".jams"];
            }
            else            
            {
                // 'theaudio' does not exist in the repository, execute different logic here
                error_log(" - starting the upload");
                error_log(" - theaudio name = " . $_FILES['theaudio']['name'], 0);
                error_log(" - theaudio size = " . $_FILES['theaudio']['size'], 0);

                $targetDir = "/var/www/html/jams/";
                $targetFile = $targetDir . $_FILES['theaudio']['name'];                
                $data = $_FILES['theaudio']['tmp_name'];
                move_uploaded_file($data, $targetFile); // where the uploaded audio file will be saved
                error_log(" - uploaded the audio file");

                // Return the files which will reside in temp folder
                $baseName = pathinfo($_FILES['theaudio']['name'], PATHINFO_FILENAME);
                $response['filename'] = [$_FILES['theaudio']['name'], $baseName . ".jams"];
            }

            error_log("-------------------------- ");
            error_log(" --- AUDIO FILE FOLDER: " . $targetFile);

            $outputPath = "/var/www/html/jams/";   
            error_log(" --- ANNOTATION FOLDER: " . $outputPath); 
            error_log("On Permanent Export To MusiCoLab repository, move file in respective 'public' 'private' or 'course' folder");
            error_log("-------------------------- ");
        
            // TODO remove html tags

            $pyExecPath = "/home//virtualEnvs/chordBeatAnalysis/bin/python3 ";
            $pyScriptPath ="/home//virtualEnvs/chordBeatAnalysis/chordBeatAnalysis.py ";
            
            // Basic script execution (without optional params)               
            $cmd = $pyExecPath . $pyScriptPath . escapeshellarg($targetFile) . " --output_path " . $outputPath;

            // Handle optional params    
            if (!empty($alignmentPercent)) {
                $cmd .= " --alignment_percent " . escapeshellarg($alignmentPercent);
            }
            if (!empty($title)) {
                $cmd .= " --title " . escapeshellarg($title);
            }
            if (!empty($artist)) {
                $cmd .= " --artist " . escapeshellarg($artist);
            }
            if (!empty($method)) {
                $cmd .= " --method " . escapeshellarg($method);
            }

			error_log(" - starting python execution ");
			error_log($cmd);
			exec($cmd);

			error_log(" - executed python ");     
        }
        else
        {
            http_response_code(400); // Bad Request
            error_log("invalid action, please contact the admins", 0);
            $response['error'] = 'Action NOT set.';       
        }
    }

    echo json_encode($response); // Echo the JSON-encoded array at the client

    error_log("-------------------------- ");
    error_log("--- CHORDS & BEATS ANALYSIS RESP FINISHED", 0);
    error_log("-------------------------- ");
?>
