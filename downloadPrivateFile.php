<? session_start(); ?>
<?
error_log("download private file");
error_log("--------------------");
$loginResultMsg = "";
$roles          = "";
                                        if(isset($_GET["user"])){
                                                //error_log(" - external login");
                                                $con = mysqli_connect("localhost", "", "", "moodleLms");
						$sql = "select * from user where username='".$_GET["user"]."'";
						//error_log($sql);
                                                $res = $con->query($sql);

                                                if($res){
							$row = mysqli_fetch_assoc($res);
							//error_log(" - got this number of rows: ".$res->num_rows);
                                                        //error_log(" - user ".$_GET["user"]." has id = ".$row["id"]);
                                                        $sql2 = "select * from sessions where userid='".$row["id"]."'";
							//error_log($sql2);
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
                                                                //error_log(" - FOUND SESSION ".$sid. " modified on ".$max);
                                                                //error_log(" - session = ".print_r($_SESSION, true));
                                                                $ver = true;
                                                        }else{
                                                                error_log(" - DID NOT FIND A SESSION, authenticating ");
                                                        }
                                                        if($ver){
                                                                //error_log(" - ver = ".$ver);
                                                                $_SESSION['USER']['username'] = $_GET["user"];
                                                                $_SESSION['USER']['firstname'] = $row["firstname"];
                                                                $_SESSION['USER']['lastname'] = $row["lastname"];
                                                                $_SESSION['USER']['id'] = $row["id"];

                                                                $sql   = "select * from role_assignments a, role b where a.userid=".$_SESSION["USER"]['id']." and a.roleid=b.id";
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
                                                                        $_SESSION['USER']['role'] = $roles;
                                                                }
                                                        }else{
                                                                #echo "<font color='red'>it was not... </font><br>";
                                                                $loginResultMsg = "invalid credentials, please try again";
                                                        }
                                                }else{
                                                        #echo "<font color='red'> error: ".$con->error."</font>"."<br>";
                                                        $loginResultMsg = $con->error;
                                                }
                                        }else{
                                                error_log("ERROR: the user is not set");
                                        }

error_log("remote address: ".$_SERVER['REMOTE_ADDR']);
error_log("session -> username: ".$_SESSION['USER']['username']);

if(isset($_SESSION["USER"]['username'])){
	if(isset($_GET['f']) && isset($_GET['u'])) {
		error_log("--- DOWNLOADING PRIVATE FILE");
		$filename = '/var/www/moodledata/repository/jsonFiles/users/'.$_GET['u'].'/'.urldecode($_GET['f']);

		error_log("filename = ".$filename);
		error_log("basename = ".basename($filename));

		if(file_exists($filename)) {

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header("Cache-Control: no-cache, must-revalidate");
			header("Expires: 0");
			header('Content-Disposition: attachment; filename="'.basename($filename).'"');
			header('Content-Length: ' . filesize($filename));
			header('Pragma: public');

			flush();

			readfile($filename);

			die();
		}else{
			echo "File does not exist.";
		}
	}
} else echo "Filename is not defined, or invalid access rights"
?>
