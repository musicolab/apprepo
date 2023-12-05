<?php session_start(); ?>
<?php
    header('Content-Type: application/json');

    error_log("-------------------------- ");
    error_log("--- DELETE TEMP ANALYSIS FILES RESP", 0);
    error_log("-------------------------- ");

    // Define the folder where files are allowed to be deleted from
    $allowedFolder = "/var/www/html/jams/";

    // Check if file list is provided
    if (isset($_POST['files_to_delete'])) {
        $filesToDelete = json_decode($_POST['files_to_delete'], true);

        // Initialize response array
        $response = [];

        // Check if the array is empty
        if (empty($filesToDelete)) {
            error_log(" --- NO FILES TO DELETE ---");        
        }

        // Loop through each file and attempt to delete it
        foreach ($filesToDelete as $file) {
            // Construct full file path
            $filePath = $allowedFolder . basename($file);
            error_log(' - Now trying to delete filePath:'. $filePath);

            // Attempt to delete file
            if (file_exists($filePath) && unlink($filePath)) {
                $response[$file] = "Deleted successfully";
                error_log("Deleted successfully");
            } else {
                $response[$file] = "Failed to delete";
                error_log("Failed to delete");
            }
        }

        // Send JSON response back to JavaScript
        echo json_encode($response);
    }

    error_log("-------------------------- ");
    error_log("--- DELETE TEMP ANALYSIS FILES RESP FINISHED", 0);
    error_log("-------------------------- ");
?>

