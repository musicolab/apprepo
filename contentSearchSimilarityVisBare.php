<? session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
                <?include 'headerHtml.php'?>
		<link rel="stylesheet" type="text/css" href="./inspector.css">
	</head>
	<body>
        <div class="container">

                <div class="row">
                        	<div class="row">
	                                <div class="col-sm-12">
	        	                        <br>
	                	                <div class="panel panel-default" style='border:1px solid #ddd;'>
       	                 	                <div class="panel-body" id='here'>
			                        <?
       	         		                if(isset($_SESSION["USER"]->username)){
       	                         		?>
							<script type="module">
								import define from "./index.js";
								import {Runtime, Library, Inspector} from "./runtime.js";
								const runtime = new Runtime();
								//const inspect = Inspector.into(document.body);
								const inspect = Inspector.into(document.getElementById("here"));
								const cells = new Set(["similarity","chart","style","info"]); // The cells that you want to display.
								const main = runtime.module(define, name => cells.has(name) ? inspect() : undefined, "<?echo $_SESSION["USER"]->username;?>");
							</script>
						<?
						}
						?>
						</div>
						</div>
					</div>
				</div>
                </div>
        </div>
  </body>
</html>

