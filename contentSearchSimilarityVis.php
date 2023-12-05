<? session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
                <?include 'headerHtml.php'?>
		<link rel="stylesheet" type="text/css" href="./inspector.css">
	</head>
	<body>
        <div class="container">

		<?include 'header.php'?>

                <div class="row">
                        <?include 'menusLeft.php'?>
                        <div class="col-sm-9">
                        	<div class="row">
	                                <div class="col-sm-12">
	                	                <div class="panel panel-default" style='border:1px solid #ddd;'>
       	                 	                <div class="panel-body" id='here'>
			                        <?
       	         		                if(isset($_SESSION["USER"]->username)){
						?>
							<h3>Search by content / similarity search / results</h3>
							<?
							//echo $_POST["action"]."<br>";
							echo "user: ".$_SESSION["USER"]->username." ";
							echo "file: ".$_GET["file"]."<br>";
							?>
			                                <hr style='background-color:#ddd'>
							<script type="module">
								import define from "./index.js";
								import {Runtime, Library, Inspector} from "./runtime.js";
								const runtime = new Runtime();
								//const inspect = Inspector.into(document.body);
								const inspect = Inspector.into(document.getElementById("here"));
								const cells = new Set(["similarity","chart","style","info"]); 
								const main = runtime.module(define, name => cells.has(name) ? inspect() : undefined, "<?echo $_SESSION["USER"]->username;?>");
							</script>
						</div>
						</div>
	                	                <div class="panel panel-default" style='border:1px solid #ddd;'>
						<div class="panel-body" id='here'>
						<h3>network <a href='./files/distanceNetwork_<?echo $_SESSION["USER"]->username;?>.json' target='_blank'><i class='fa fa-download'></i></a></h3>
						<table class="table table-hover table-sm">
							<tr><th>id</th><th>track</th><th>weight</th></tr>
                                                <?      
							$data  = file_get_contents("/var/www/html/apprepository/files/distanceNetwork_".$_SESSION["USER"]->username.".json");
							$dataj = json_decode($data)->nodes;
							usort($dataj, fn($a, $b) => strcmp($b->weight, $a->weight));
							for($i=1; $i<count($dataj); $i++){
								echo "<tr>";
								echo "<td>".$i."</td>";
								echo "<td><a href='https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=".$dataj[$i]->id."&user=".$_SESSION["USER"]->username."'>".$dataj[$i]->id."</a></td>";
								echo "<td>".round($dataj[$i]->weight,3)."</td>";
								print("</tr>");
							}
                                                }
						?>
						</table>
                                                </div>
						</div>
						* ideally, all files in the results should exist in the repository
						<!--div class="panel panel-default" style='border:1px solid #ddd;'>
                                                <div class="panel-body" id='here'>
                                                <h3>links:</h3>
                                                <table class="table table-hover table-sm">
                                                        <tr><th>id</th><th>track</th><th>weight</th></tr>
                                                <?
                                                        $data = file_get_contents("/var/www/html/apprepository/files/distanceLinks_".$_SESSION["USER"]->username.".json");
                                                        $dataj = json_decode($data);
                                                        print_r($dataj);
                                                        /*
                                                        for($i=1; $i<count($dataj); $i++){
                                                                echo "<tr>";
                                                                echo "<td>".$i."</td>";
                                                                echo "<td>".$dataj[$i]->target."</td>";
                                                                echo "<td>".$dataj[$i]->weight."</td>";
                                                                print("</tr>");
                                                        }
                                                         */
                                                ?>
                                                </table>
                                                </div>
                                                </div-->
					</div>
				</div>
			</div>
                </div>
                <?include 'footer.php'?>
        </div>
  </body>
</html>

