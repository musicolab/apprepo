<?php session_start(); ?>
<?php
    header("Content-Type:application/json");

    // Check if user is logged in first
    if(!isset($_SESSION["USER"]["username"])){
        http_response_code(401);
        error_log("Script {$_SERVER["SCRIPT_NAME"]} unauthorized access attempt. {$_SESSION["USER"]}");
        die(json_encode([ "error" => "Unauthorized" ]));
    }

    $collabParam = false;
    if (isset($_GET["collab"]) && $_GET["collab"] === "true") {
        $collabParam = true;
    }

    $courseIdnumber = null;
    if (isset($_GET["courseIdnumber"])) {
        $courseIdnumber = $_GET["courseIdnumber"];
    }

    // 1. Public + course files when url params collab=true and course!=null
    // 2. Public + private + course files when url params collab=false and course!=null
    // 3. Public + private files when url params collab=false and course=null

    function createQueryArray($collabParam, $courseIdnumber) {
        $queryArray = [ "sql" => "", "binds" => "ss", "boundValues" => array() ];

        // Send kern files when queried by VHV app (url param type=krn)
        $kernFiles = isset($_GET["type"]) && $_GET["type"] === 'krn';
        $encodings = $kernFiles ? [null] : ['audio/wav', 'audio/x-wav', 'audio/mp3', 'audio/mpeg', 'audio/flac'];
        $fileExtensions = $kernFiles ? ['krn'] : ['mp3', 'wav', 'flac'];

        $encodingsBinds = str_repeat('?,', count($encodings) - 1) . '?';
        $fileExtensionsBinds = str_repeat('?,', count($fileExtensions) - 1) . '?';
        $encodingParams = str_repeat('s', count($encodings));
        $fileExtensionParams = str_repeat('s', count($fileExtensions));

        $queryArray["binds"] = $encodingParams . $fileExtensionParams;

        if ($collabParam && $courseIdnumber !== null) { // 1.
            $queryArray["binds"] = "ss" . $queryArray["binds"];
            $queryArray["boundValues"] = array($courseIdnumber, $courseIdnumber, ...$encodings, ...$fileExtensions);

            $queryArray["sql"] = <<<EOD
            SELECT m.id, m.filetype, SUBSTRING_INDEX(m.filename, "/", -1) as filenameShort, m.encoding, m.size, m.owner, IF(m.filetype = 'course', SUBSTRING_INDEX(SUBSTRING_INDEX(m.filename, "/", -2), "/", 1), NULL) as courseId 
            FROM (
                SELECT *
                FROM metadata
                WHERE filetype='public' 
                UNION
                SELECT *
                FROM metadata
                WHERE filetype='course' AND filename LIKE (SELECT CONCAT('%courses/', id, '/%') FROM `moodleLms`.course WHERE shortname = ? OR idnumber = ?)
            ) m
            WHERE (m.encoding IN ($encodingsBinds) OR SUBSTRING_INDEX(m.filename, ".", -1) IN ($fileExtensionsBinds))
            GROUP BY m.filetype, filenameShort
            EOD;

        } else if (!$collabParam && $courseIdnumber !== null) { // 2.
            $queryArray["binds"] = "sss" . $queryArray["binds"];
            $queryArray["boundValues"] = array($courseIdnumber, $courseIdnumber, $_SESSION["USER"]["username"], ...$encodings, ...$fileExtensions);
            
            $queryArray["sql"] = <<<EOD
            SELECT m.id, m.filetype, SUBSTRING_INDEX(m.filename, "/", -1) as filenameShort, m.encoding, m.size, m.owner, IF(m.filetype = 'course', SUBSTRING_INDEX(SUBSTRING_INDEX(m.filename, "/", -2), "/", 1), NULL) as courseId
            FROM (
                SELECT *
                FROM metadata
                WHERE filetype='public' 
                UNION
                SELECT *
                FROM metadata
                WHERE filetype='course' AND filename LIKE (SELECT CONCAT('%courses/', id, '/%') FROM `moodleLms`.course WHERE shortname = ? OR idnumber = ?)
                UNION
                SELECT *
                FROM metadata
                WHERE filetype='private' 
                AND owner = ?
            ) m
            WHERE (m.encoding IN ($encodingsBinds) OR SUBSTRING_INDEX(m.filename, ".", -1) IN ($fileExtensionsBinds))
            GROUP BY m.filetype, filenameShort
            EOD;

        } else if (!$collabParam && $courseIdnumber === null) { // 3.
            $queryArray["binds"] = "s" . $encodingParams . $fileExtensionParams;
            $queryArray["boundValues"] = array($_SESSION["USER"]["username"], ...$encodings, ...$fileExtensions);

            $queryArray["sql"] = <<<EOD
            SELECT m.id, m.filetype, SUBSTRING_INDEX(m.filename, "/", -1) as filenameShort, m.encoding, m.size, m.owner, NULL as courseId
            FROM (
                SELECT *
                FROM metadata
                WHERE filetype='public' 
                UNION
                SELECT *
                FROM metadata
                WHERE filetype='private' 
                AND owner = ?
            ) m
            WHERE (m.encoding IN ($encodingsBinds) OR SUBSTRING_INDEX(m.filename, ".", -1) IN ($fileExtensionsBinds))
            GROUP BY m.filetype, filenameShort
            EOD;
        }

        return $queryArray;
    }

    function executeQuery($con, $results, $collabParam, $courseIdnumber) {
        $queryArray = createQueryArray($collabParam, $courseIdnumber);

        error_log("Script " . $_SERVER["SCRIPT_NAME"] . " is executing query: " . json_encode($queryArray));
        $stmt = $con->prepare($queryArray["sql"]);
        $stmt->bind_param($queryArray["binds"], ...$queryArray["boundValues"]);
        $stmt->execute();
    
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            array_push($results[$row["filetype"]], [
                "filetype" => $row["filetype"],
                "filenameShort" => $row["filenameShort"],
                "encoding" => $row["encoding"],
                "size" => $row["size"],
                "owner" => $row["owner"],
            ]);
            if ($row["courseId"] !== null && $row["courseId"] !== "NULL") {
                $results["courseId"] = intval($row["courseId"]);
            }
        }
    
        $stmt->close();
        return $results;
    }

    $con = mysqli_connect("localhost", "", "", "") or die("Error " . mysqli_error($con));
    $con->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
    
    $results = [
        "public" => array(),
        "private" => array(),
        "course" => array(),
        "courseId" => null,
    ];
    
    $results = executeQuery($con, $results, $collabParam, $courseIdnumber);
    
    echo json_encode($results);
    mysqli_close($con);    
?>
