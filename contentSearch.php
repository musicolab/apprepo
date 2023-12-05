<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script src="https://unpkg.com/wavesurfer.js"></script>
                <script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.microphone.js"></script>
		<style>
			.loader {
				visibility:hidden;
				border: 10px solid #f3f3f3;
				border-radius: 50%;
				border-top: 10px solid #3498db;
				width: 30px;
				height: 30px;
				-webkit-animation: spin 2s linear infinite; /* Safari */
				animation: spin 2s linear infinite;
			}
			@keyframes spin{
				0% { transform:rotate(0deg); }
				100% { transform:rotate(360deg); }
			}
		</style>
		<script>
			function upload(){
				form = document.getElementById("theform");
    				thefile = document.getElementById("f");
				pBar = document.getElementById("progressBar");

    				doit = true;

    				if(doit){
     					conf = confirm("please confirm the submission");
     					//loader = document.getElementById("loader");
     					//loader.style.visibility='visible';
     					submitBtn = document.getElementById("submitButton");
					submitBtn.style.visibility='hidden';
					pBar.style.visibility="visible";
					form.submit();
					setInterval("updatePBarIn()", 1000);
					//pBarIn.style.width=count+"%";
				}
			}

			function updatePBarIn(){
				pBarIn = document.getElementById("progressBarInner");
				pct = pBarIn.innerHTML;
				pct = pct.substring(0, pct.length-1);
				pct = parseInt(pct) + 1;
				pBarIn.innerHTML=pct+"%";
				pBarIn.style.width=pct+"%";
			}

			function uploadAjax() {
				form = document.getElementById("theform");
                                thefile = document.getElementById("f");
				pBar = document.getElementById("progressBar");

				doit = true;

                                if(doit){
					var file = document.getElementById("f").files[0];
					var formdata = new FormData();
					formdata.append("f", file);
					formdata.append("action", "upload");
					var ajax = new XMLHttpRequest();
					ajax.upload.addEventListener("progress", progressHandler, false);
					ajax.addEventListener("load", completeHandler, false);
					//ajax.addEventListener("error", errorHandler, false);
					//ajax.addEventListener("abort", abortHandler, false);
					ajax.open("POST", "contentSearchResp.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
					ajax.send(formdata);
				}
			}
			
			function progressHandler(event) {
				var percent = (event.loaded / event.total) * 100;
				percent = Math.round(percent);
				pBarIn = document.getElementById("progressBarInner"); //.value = Math.round(percent);
				pBarIn.innerHTML   = percent+"%";
				pBarIn.style.width = percent+"%";
			}

			function completeHandler(event) {
				//document.getElementById("progressBar").value = 0; //wil clear progress bar after successful upload
				//alert("DONE ! You may select another file to upload");
				form2 = document.getElementById("thesecondform");
				form2.submit();
			}

			function errorHandler(event) {
				alert("ERROR !");
			}

			function abortHandler(event) {
			}
		</script>
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
                                        <div class="panel-body">
				<?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Search by content / exact match</h3>
				<hr style='background-color:#ddd'>
				<?
				//require_once('getID3-master/getid3/getid3.php');
				$err = "noerr";
				?>
				<form action='contentSearchResp.php' method='post' id='theform' enctype="multipart/form-data">
					Upload a file to be compared against the repository. The recognition will take 5-15 seconds <i>after</i> the file is upload. This form uses <a href='https://github.com/worldveil/dejavu' target='_blank'>spectrogram fignerprinting</a> to find an exact match.<br>
					<?
					if(!isset($_POST['action'])){
					}else{
						if($_POST['action']=='recogniseFingerprint'){
							?>
							<br>
							<div class='alert alert-info' style='margin-bottom:0px'>
							<?
							$cmd = "/home//virtualEnvs/dejavuMaster2_moreResults/bin/python /home//virtualEnvs/dejavuMaster2_moreResults/bin/dejavuRcognise.py /var/www/moodledata/repository/".$_SESSION["USER"]['username'];
							exec($cmd, $output);
							//echo "<br>";
							echo "<b>result:</b> <br>";
							for($c=0; $c<count($output); $c++){
								$theout = array($output[$c]);
								foreach($theout as $val){
									$val = trim($val, "}{[] ,");

									$len = strlen("{");
									if(substr($val, 0, $len) === "{"){
										$val = substr($val,1);
										echo "--";
									}else{
									}

									$len = strlen("'results':");
									if(substr($val, 0, $len) === "'results':"){
										$val = substr($val, 13);
									}

									$len = strlen("'file_sha1':");
									if(substr($val, 0, $len) === "'file_sha1':"){
										echo "<br>";
									}

									$len = strlen("'total_time':");
									if(substr($val, 0, $len) === "'total_time':"){
										echo "<br>";
									}

									$len = strlen("'song_name':");
									if(substr($val, 0, $len) === "'song_name':"){
										echo "<b><u>".$val."</u></b><br>";
									}else if(substr($val, 0, strlen("'fingerprinted_confidence':")) == "'fingerprinted_confidence':"){
										echo "<b><u>".$val."</u></b><br>";
									}else{
										//$len = strlen("'total_time':");
										//if(substr($val, 0, $len) === "'total_time':"){
										//}else{
											echo $val."<br>";
										//}
									}
								}
							}
							echo "</div>";
						}
					}
					?>
					<br>
					<input type='file' name='f' id='f' accept='.mid,.mei,.wav,.mp3,.flac,.avi,.mkv,' style='display:inline' required></input><br>
					<br>
					<div class="progress" style='visibility:visible' id='progressBar'>
						<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id='progressBarInner'>0%</div>
					</div>
					<input type='button' value='SUBMIT' id='submitButton' onclick='uploadAjax()' style='display:inline;'>
					<input type='hidden' name='action' value='upload'/>
				</form>

				<form action="contentSearch.php" method="post" id="thesecondform">
					<input type="hidden" name="action" value="recogniseFingerprint">
					<input type="hidden" name="filetoanalyze" value="">
				</form>
				<?}?>
			</div>
			</div>
			</div>
			</div>

			<div class="row">
                                <div class="col-sm-12">
                              		<br>
                                	<div class="panel panel-default" style='border:1px solid #ddd;'>
	                                        <div class="panel-body">
		                                <?
        		                        if(isset($_SESSION["USER"]['username'])){
                		                ?>
                        		        <h3>Search by content / select existing file / <font color='red'>under construction</font></h3>
						<hr style='background-color:#ddd'>
						Select the repository folder and any desired file and recover similar content<br> 
						<br>
						<form method='post' action=''>
						folder: <select name='folder' required>
							<option value=''></option>
							<option value='public'>public</option>
							<option value='private'>private</option>
						</select><br>
						music title: <input type='text' name='filename' id='filename' pattern='[A-Za-z0-9]*' required><br>
						<br>
						<input type='submit' value='SUBMIT'>
						<input type='hidden' name='action' value='searchContent'>
						<form>
						
		                                <?
						$err = "noerr";
						}
						?>
						</div>
					</div>
				</div>
			</div>

				
		</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

