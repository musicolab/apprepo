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
			function progressHandler(event) {
				var percent = (event.loaded / event.total) * 100;
				percent = Math.round(percent);
				pBarIn = document.getElementById("progressBarInner"); //.value = Math.round(percent);
				pBarIn.innerHTML   = percent+"%";
				pBarIn.style.width = percent+"%";
			}

			function completeHandler(event) {
				//document.getElementById("progressBar").value = 0; //wil clear progress bar after successful upload
				thefile = document.getElementById("file2analyse").value;
				alert("DONE ! "+thefile);
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

			<?
                        if(isset($_SESSION["USER"]->username)){
                        ?>
			<?
			}
			?>

			<div class="row">
				<div class="col-sm-12">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
					<div class="panel-body">
						<h3>Search by content / upload recording</h3>
						<hr style='background-color:#ddd'>
						<div id="waveform" style='width:r80%; background-color:#ddd;'></div><br>
	                                        <script>
                                                var wavesurfer = WaveSurfer.create({ 
                                                        container: '#waveform', 
                                                        //barWidth:2, 
                                                        //barHeight:1, 
                                                        waveColor: '#337ab7', 
                                                        progressColor: '#f4b426',
                                                        plugins: [ 
                                                                WaveSurfer.microphone.create({ 
                                                                        bufferSize: 4096, 
                                                                        numberOfInputChannels: 1, 
                                                                        numberOfOutputChannels: 1, 
                                                                        constraints: { 
                                                                                video: false, 
                                                                                audio: true 
                                                                        } 
                                                                }) 
                                                        ]
                                                });
                                                wavesurfer.microphone.on('deviceReady', function(stream) {
                                                        console.log('Device ready!', stream);
                                                });
                                                wavesurfer.microphone.on('deviceError', function(code) {
                                                        console.warn('Device error: ' + code);
                                                });
                                                wavesurfer.microphone.start();

                                                function play(){
                                                        wavesurfer.microphone.start();
                                                }
                                                function record(){
                                                }
                                                function stop(){
                                                        wavesurfer.microphone.stop();
                                                }
						</script>
						start and stop the recording using the buttons below and then upload it to search the repository for similar audio<br>
						<br>
						<center>
                                        	<audio id="audio" controls style='vertical-align:middle'>
                                                	<source src="" type="audio/wav">
						</audio><br>
						<br>
                                        	<button id="start">START RECORDING</button>
						<button id="stop" disabled>STOP RECORDING</button><br>
						<br>
						<form action='contentSearchMicResp.php' method='post' id='micform'>
							<input type='text' id='fileCS' name='fileCS' value='myFirstBlob' required disabled style='display:inline-block'> <input type='button' name='upload' id="upload" value='UPLOAD' disabled>
							<input type='hidden' name='action' value='uploadFromMic'>
							<input type='file' name='data' value='' id='micformdata' style='visibility:hidden'>
							<input type='hidden' name='datablob' value='' id='micformdatablob' style='visibility:hidden'>
							<div class="progress" style="visibility:visible" id="progressBar">
						       		<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id="progressBarInner">0%</div>
							</div>
						</form>
						<form action="contentSearchMic.php" method="post" id="thesecondform">
                                    			<input type="hidden" name="action" value="recogniseFingerprint">
                                    			<input type="hidden" name="file2analyse" id='file2analyse' value="">
 						</form>

						<?
						if($_POST['action']=='recogniseFingerprint'){
                                                        ?>
                                                        <br>
                                                        <div class='alert alert-info' style='margin-bottom:0px'>
                                                        <?
                                                        $cmd = "/home//virtualEnvs/dejavuMaster2_moreResults/bin/python /home//virtualEnvs/dejavuMaster2_moreResults/bin/dejavuRcognise.py /var/www/moodledata/repository/jsonFiles/users/".$_SESSION["USER"]->id."/"+$_POST["file2analyse"];
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
						?>
						</center>
						<script>
                                        let constraints = {audio:true, video:false};

                                        if(navigator.mediaDevices===undefined){
                                                alert("ERROR: failed to access your media devices\n this code is compatible with WebRTC browsers that implement getUserMedia()");
                                        }else{
                                                navigator.mediaDevices.enumerateDevices().then(
                                                        devices => {
                                                                devices.forEach(
                                                                        device=>{
                                                                                console.log("device: ", device.kind.toUpperCase(), device.label);
                                                                        }
                                                                )
                                                        }
                                                ).catch(
                                                        err=>{
                                                                console.log("ERROR");
                                                                console.log(err.name, err.message);
                                                        }
                                                )
                                        }
                                        navigator.mediaDevices.getUserMedia(constraints).then(
                                                function(mediaStreamObj){
                                                        let start = document.getElementById("start");
                                                        let stop = document.getElementById("stop");
                                                        let save = document.getElementById("audio");    
                                                        let upload = document.getElementById("upload");    
                                                        let fname = document.getElementById("fileCS");    
                                                        let mediaRecorder = new MediaRecorder(mediaStreamObj);
                                                        let chunks = [];

                                                        start.addEventListener("click", (ev)=>{
                                                                start.disabled = true;
								stop.disabled  = false;
								upload.disabled = true;
								fname.disabled = true;
                                                                mediaRecorder.start()
								console.log("media recording starts");
								chunks = [];
                                                        });
                                                        stop.addEventListener("click", (ev)=>{
                                                                start.disabled = false;
								stop.disabled  = true;
								fname.disabled = false;
								upload.disabled = false;
                                                                mediaRecorder.stop()
                                                                console.log("media recording stops");
							});
							upload.addEventListener("click", (ev)=>{
								//alert('length of chunks ='+[chunks].length)
								console.log('clicked upload')
								if(fname.value==""){
									alert("please enter a valid filename containing only latin letters and numbers. No extension is necessary the form produces WAV files and appends the extenson");
								}else{
									//console.log("valid fname");
									//theform = document.getElementById("micform");
									//data = document.getElementById("micformdatablob");
									//theblob =  new Blob([chunks], {'type':'audio'});
									//data.value= theblob;
									//console.log(theblob);
									//theform.submit();
									//-------------------------
									//--- alternative with ajax
									//-------------------------
									pBar = document.getElementById("progressBar");
									fd = new FormData();
									fd.append('action','uploadFromMic'); 
									fd.append('filename', fname.value+".wav");
									document.getElementById("file2analyse").value=fname.value+".wav";
									theblob =  new Blob(chunks, {'type':'audio'});
									thefile =  new File(chunks, fname.value+".wav");
									fd.append('blob', theblob, 'blobname');
									fd.append('file', theblob, fname.value+".wav");
                	                        			var ajax = new XMLHttpRequest();
                                                                        ajax.upload.addEventListener("progress", progressHandler, false);
                                                                        ajax.addEventListener("load", completeHandler, false);
									ajax.open("post", "contentSearchMicResp.php", true); 
									//ajax.setRequestHeader("Content-Type", "multipart/form-data");
									ajax.send(fd);
									console.log("send the upload request for ajax");
								}
							});
                                                        mediaRecorder.ondataavailable = function(ev) {
                                                                chunks.push(ev.data);
                                                        };
                                                        mediaRecorder.onstop = (ev) => {
								console.log("creating the blob");
								console.log(chunks);
                                                                let blob = new Blob(chunks, {'type':'audio'});
                                                                //chunks = [];
								let audioURL = window.URL.createObjectURL(blob);
                                                                save.src = audioURL;
                                                                audio.play();
                                                        };
                        
                                                }
                                        ).catch(
                                                function(err){
                                                        console.log("ERROR");
                                                        console.log(err.name, err.message);
                                                }
                                        );
                                        </script>
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

