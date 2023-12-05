<? session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
                <?include '../headerHtml.php'?>
                <script src="https://unpkg.com/wavesurfer.js"></script>
                <script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.microphone.js"></script>
		<link rel="stylesheet" type="text/css" href="./inspector.css">
	</head>
	<body>
        <div class="container">

                <div class="row" style='background-image:url("Header2.jpeg");background-size:cover; height:100px; position:relative'>
                        <?include '../header.php'?>
                </div>

                <div class="row">
                        <?include '../menusLeft.php'?>
                        <div class="col-sm-9">
                        	<div class="row">
	                                <div class="col-sm-12">
        	                        <br>
                	                <div class="panel panel-default" style='border:1px solid #ddd;'>
                        	                <div class="panel-body">
		                                <?
                		                if(isset($_SESSION["USER"]->username)){
                                		?>
		                                <h3>Search by content / similarity searchi / results</h3>
		                                <hr style='background-color:#ddd'>
						<script type="module">
							import define from "./index.js";
							import {Runtime, Library, Inspector} from "./runtime.js";
							const runtime = new Runtime();
							const inspect = Inspector.into(document.body);
							const cells = new Set(["similarity","chart","style","info"]); // The cells that you want to display.
							const main = runtime.module(define, name => cells.has(name) ? inspect() : undefined);
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

                <?include '../footer.php'?>
        </div>
  </body>
</html>

