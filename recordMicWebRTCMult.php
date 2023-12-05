<?session_start();?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script src="https://unpkg.com/wavesurfer.js"></script>
                <script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.microphone.js"></script>
  </head>
  <body>
	<div class="container">

		<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<?
				if(isset($_SESSION["USER"]['username'])){
				?>
                                <div class="panel panel-default" style='border:1px solid #ddd;'>
                                <div class="panel-body">
				<h3>MusiCoLab Repository / Multitrack record mic: <?echo $_GET['f']; ?></h3>
				<hr style='background-color:#ddd'>
					<div id="waveform" style='width:r80%; background-color:#ddd;'></div><br>
					start and stop the recording using the buttons bellow. Use the upload button to transfer the recording in your <i>private files</i> folder. After each recording the HTML audio player is updated with the new recoding. Use the download link on the player (three dots) to download your recording as a WAV file. Downloading from the audio player is currently supported for <i>the Chrome browser</i><br>
					<br>
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
                                                function record(){}
                                                function stop(){
                                                        wavesurfer.microphone.stop();
						}

						function playAll(){
							a1 = document.getElementById("audio");
							a2 = document.getElementById("audio1");
							a3 = document.getElementById("audio2");
							a1.play();
							a2.play();
							a3.play();
						}
						function stopAll(){
							a1 = document.getElementById("audio");
							a2 = document.getElementById("audio1");
							a3 = document.getElementById("audio2");
							a1.pause();
							a1.currentTime=0;
							a2.pause();
							a2.currentTime=0;
							a3.pause();
							a3.currentTime=0;
						}
						function upload(){
							var fname = document.getElementById("filename").value;
							if(fname!=""){
								var ans = confirm("this will upload your recording, named '"+fname+".wav'\nplease confirm")
							}
						}
						function upload1(){
                                                        var fname = document.getElementById("filename1").value;
                                                        if(fname!=""){
                                                                var ans = confirm("this will upload your recording, named '"+fname1+".wav'\nplease confirm")
                                                        }
						}
						function upload2(){
                                                        var fname = document.getElementById("filename2").value;
                                                        if(fname!=""){
                                                                var ans = confirm("this will upload your recording, named '"+fname2+".wav'\nplease confirm")
                                                        }
                                                }

						function progressHandler(event) {
			                                var percent = (event.loaded / event.total) * 100;
			                                percent = Math.round(percent);
			                                pBarIn = document.getElementById("progressBarInner"); //.value = Math.round(percent);
			                                pBarIn.innerHTML   = percent+"%";
			                                pBarIn.style.width = percent+"%";
						}

						function progressHandler1(event) {
                                                        var percent = (event.loaded / event.total) * 100;
                                                        percent = Math.round(percent);
                                                        pBarIn = document.getElementById("progressBarInner1"); //.value = Math.round(percent);
                                                        pBarIn.innerHTML   = percent+"%";
                                                        pBarIn.style.width = percent+"%";
						}

						function progressHandler2(event) {
                                                        var percent = (event.loaded / event.total) * 100;
                                                        percent = Math.round(percent);
                                                        pBarIn = document.getElementById("progressBarInner2"); //.value = Math.round(percent);
                                                        pBarIn.innerHTML   = percent+"%";
                                                        pBarIn.style.width = percent+"%";
                                                }

			                        function completeHandler(event) {
			                        }

			                        function errorHandler(event) {
			                                alert("ERROR !");
			                        }

			                        function abortHandler(event) {
						}

                                        </script>
					<center>
					<div class="row">
						<div class='col-sm=12' style='vertical-align:middle'>
							<center>
								<audio id="audio" controls style='vertical-align:middle'><source src="" type="audio/wav"></audio>
								<button id="start" style='vertical-align:middle'>START</button>
								<button id="stop" disabled>STOP</button>
								<button id="upload" disabled>UPLOAD</button>
								<input type='filename' id='filename' value='fileName' disabled>
								<input type='file' name='f' id='f' style='visibility:hidden;display:none'>
								<div class="progress" style="visibility:visible; width:80%" id="progressBar">
               								<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id="progressBarInner">0%</div>
								</div>
							</center>
						</div>
					</div>
					<div class="row">
						<div class='col-sm=12'>
							<center>
								<audio id="audio1" controls style='vertical-align:middle'><source src="" type="audio/wav"></audio>
								<button id="start1">START</button>
								<button id="stop1" disabled>STOP</button>
								<button id="upload1" disabled>UPLOAD</button>
								<input type='filename1' id='filename1' value='fileName1' disabled>
								<div class="progress" style="visibility:visible; width:80%" id="progressBar1">
               								<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id="progressBarInner1">0%</div>
								</div>
							</center>
						</div>
					</div>
					<div class="row">
						<div class='col-sm=12'>
							<center>
								<audio id="audio2" controls style='vertical-align:middle'><source src="" type="audio/wav"></audio>
								<button id="start2">START</button>
								<button id="stop2" disabled>STOP</button>
								<button id="upload2" disabled>UPLOAD</button>
								<input type='filename2' id='filename2' value='fileName2' disabled>
								<div class="progress" style="visibility:visible; width:80%" id="progressBar2">
               								<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id="progressBarInner2">0%</div>
								</div>
							</center>
						</div>
					</div>
					<div class="row">
                                                <div class='col-sm=12'>
							<center>
								<br>
								<input type='button' id="startAll" value='MIX &amp; PLAY' onclick='playAll()'>
                                                                <input type='button' id="stopAll" value='STOP ALL' onclick='stopAll()'>
                                                        </center>
                                                </div>
                                        </div>
					
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
							let start  = document.getElementById("start");
							let start1 = document.getElementById("start1");
							let start2 = document.getElementById("start2");
							let stop   = document.getElementById("stop");
							let stop1  = document.getElementById("stop1");
							let stop2  = document.getElementById("stop2");
							let save   = document.getElementById("audio");	
							let save1  = document.getElementById("audio1");	
							let save2  = document.getElementById("audio2");	
							let upload  = document.getElementById("upload");	
							let upload1 = document.getElementById("upload1");	
							let upload2 = document.getElementById("upload2");	
							let fname   = document.getElementById("filename");	
							let fname1  = document.getElementById("filename1");	
							let fname2  = document.getElementById("filename2");	

							let mediaRecorder = new MediaRecorder(mediaStreamObj);
							let mediaRecorder1 = new MediaRecorder(mediaStreamObj);
							let mediaRecorder2 = new MediaRecorder(mediaStreamObj);
							let chunks = [];
							let chunks1 = [];
							let chunks2 = [];
							let aliveId = 0;

							start.addEventListener("click", (ev)=>{
								console.log("pressed start");
								start.disabled = true;
								start1.disabled = true;
								start2.disabled = true;
								stop.disabled  = false;
								stop1.disabled  = true;
								stop2.disabled  = true;
								//upload.disabled  = true;
								//upload1.disabled  = true;
								//upload2.disabled  = true;
								//fname.disabled  = true;
								//fname1.disabled  = true;
								//fname2.disabled  = true;
								mediaRecorder.start()
								console.log("media recording starts");
							});
							stop.addEventListener("click", (ev)=>{
								start.disabled = false;
								start1.disabled = false;
								start2.disabled = false;
								stop.disabled  = true;
								stop1.disabled  = true;
								stop2.disabled  = true;
								upload.disabled  = false;
								//upload1.disabled  = true;
								//upload2.disabled  = true;
								fname.disabled  = false;
								//fname1.disabled  = true;
								//fname2.disabled  = true;
								mediaRecorder.stop()
								console.log("media recording stops");
							});

							start1.addEventListener("click", (ev)=>{
								start.disabled = true;
								start1.disabled = true;
								start2.disabled = true;
								stop.disabled  = true;
								stop1.disabled  = false;
								stop2.disabled  = true;
								//upload.disabled  = true;
								//upload1.disabled  = true;
								//upload2.disabled  = true;
                                                                mediaRecorder1.start()
                                                                console.log("media recording starts1");
                                                        });
                                                        stop1.addEventListener("click", (ev)=>{
								start.disabled = false;
								start1.disabled = false;
								start2.disabled = false;
								stop.disabled  = true;
								stop1.disabled  = true;
								stop2.disabled  = true;
								//upload.disabled  = true;
								upload1.disabled  = false;
								//upload2.disabled  = true;
								fname1.disabled  = false;
                                                                mediaRecorder1.stop()
                                                                console.log("media recording stops1");
							});

							start2.addEventListener("click", (ev)=>{
								start.disabled = true;
								start1.disabled = true;
								start2.disabled = true;
								stop.disabled  = true;
								stop1.disabled  = true;
								stop2.disabled  = false
								//upload.disabled  = true;
								//upload1.disabled  = true;
								//upload2.disabled  = true;
                                                                mediaRecorder2.start()
                                                                console.log("media recording starts2");
                                                        });
                                                        stop2.addEventListener("click", (ev)=>{
								start.disabled = false;
								start1.disabled = false;
								start2.disabled = false;
								stop.disabled  = true;
								stop1.disabled  = true;
								stop2.disabled  = true;
								//upload.disabled  = true;
								//upload1.disabled  = true;
								upload2.disabled  = false;
								fname2.disabled  = false;
                                                                mediaRecorder2.stop()
                                                                console.log("media recording stops2");
							});
							upload.addEventListener("click", (ev)=>{
                                                                //alert('length of chunks ='+[chunks].length)
                                                                console.log('clicked upload')
								var ans = confirm("this will upload your recording, named '"+fname.value+".wav'\nplease confirm")
								if(ans){
                                                                if(fname.value==""){
                                                                        alert("please enter a valid filename containing only latin letters and numbers. No extension is necessary the form produces WAV files and appends the extenson");
								}else{
									pBarIn = document.getElementById("progressBarInner"); //.value = Math.round(percent);
		                                                        pBarIn.innerHTML   = "0%";
                		                                        pBarIn.style.width = "0%";
                                                                        pBar = document.getElementById("progressBar");
                                                                        fd = new FormData();
                                                                        fd.append('action','uploadFromMic');
                                                                        fd.append('filename', fname.value+".wav");
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
                                                                        console.log("sent the upload request for ajax");
								}
								}
							});
							upload1.addEventListener("click", (ev)=>{
                                                                //alert('length of chunks ='+[chunks].length)
                                                                console.log('clicked upload1')
								var ans = confirm("this will upload your recording, named '"+fname1.value+".wav'\nplease confirm")
								if(ans){
                                                                if(fname1.value==""){
                                                                        alert("please enter a valid filename containing only latin letters and numbers. No extension is necessary the form produces WAV files and appends the extenson");
								}else{
									pBarIn = document.getElementById("progressBarInner1"); //.value = Math.round(percent);
		                                                        pBarIn.innerHTML   = "0%";
                		                                        pBarIn.style.width = "0%";
									console.log('uplading second file');
                                                                        pBar = document.getElementById("progressBar1");
									console.log('configuring the progress bar');
                                                                        fd = new FormData();
                                                                        fd.append('action','uploadFromMic');
									console.log('configuring the form data');
                                                                        fd.append('filename', fname1.value+".wav");
                                                                        theblob =  new Blob(chunks1, {'type':'audio'});
                                                                        thefile =  new File(chunks1, fname1.value+".wav");
                                                                        fd.append('blob', theblob, 'blobname');
                                                                        fd.append('file', theblob, fname1.value+".wav");
                                                                        var ajax = new XMLHttpRequest();
                                                                        ajax.upload.addEventListener("progress", progressHandler1, false);
                                                                        ajax.addEventListener("load", completeHandler, false);
                                                                        ajax.open("post", "contentSearchMicResp.php", true);
                                                                        //ajax.setRequestHeader("Content-Type", "multipart/form-data");
                                                                        ajax.send(fd);
                                                                        console.log("send the upload request for ajax");
								}
								}
							});
							upload2.addEventListener("click", (ev)=>{
                                                                //alert('length of chunks ='+[chunks].length)
                                                                console.log('clicked upload2')
								var ans = confirm("this will upload your recording, named '"+fname2.value+".wav'\nplease confirm")
								if(ans){
                                                                if(fname.value==""){
                                                                        alert("please enter a valid filename containing only latin letters and numbers. No extension is necessary the form produces WAV files and appends the extenson");
                                                                }else{
									pBarIn = document.getElementById("progressBarInner2"); //.value = Math.round(percent);
		                                                        pBarIn.innerHTML   = "0%";
                		                                        pBarIn.style.width = "0%";
                                                                        pBar = document.getElementById("progressBar2");
                                                                        fd = new FormData();
                                                                        fd.append('action','uploadFromMic'); 
                                                                        fd.append('filename', fname2.value+".wav");
                                                                        theblob =  new Blob(chunks2, {'type':'audio'});
                                                                        thefile =  new File(chunks2, fname2.value+".wav");
                                                                        fd.append('blob', theblob, 'blobname');
                                                                        fd.append('file', theblob, fname2.value+".wav");
                                                                        var ajax = new XMLHttpRequest();
                                                                        ajax.upload.addEventListener("progress", progressHandler2, false);
                                                                        ajax.addEventListener("load", completeHandler, false);
                                                                        ajax.open("post", "contentSearchMicResp.php", true); 
                                                                        //ajax.setRequestHeader("Content-Type", "multipart/form-data");
                                                                        ajax.send(fd);
                                                                        console.log("send the upload request for ajax");
								}
								}
                                                        });

							mediaRecorder.ondataavailable = function(ev) {
								chunks[0] = ev.data;
								console.log("chunks length is "+chunks.length);
								console.log("mediarecorder pushed env data to the chunks");
							};
							mediaRecorder.onstop = (ev) => {
								console.log("creating the blob");
								console.log(chunks);
								let blob = new Blob(chunks, {'type':'audio'});
								let audioURL = window.URL.createObjectURL(blob);
								save.src = audioURL;
								audio.play();
								//audio.play();
								console.log("mediarecorder create the blob and the objURL");

							};
							mediaRecorder1.ondataavailable = function(ev) {
								chunks1[0] = ev.data;
								console.log("mediarecorder1");
                                                        };
                                                        mediaRecorder1.onstop = (ev) => {
								console.log("creating the blob");
								console.log(chunks1);
                                                                let blob = new Blob(chunks1, {'type':'audio'});
                                                                let audioURL = window.URL.createObjectURL(blob);
                                                                save1.src = audioURL;
                                                                save1.play();
							};
							mediaRecorder2.ondataavailable = function(ev) {
                                                                chunks2.push(ev.data);
                                                        };
                                                        mediaRecorder2.onstop = (ev) => {
								console.log("creating the blob");
								console.log(chunks2)							
                                                                let blob = new Blob(chunks2, {'type':'audio'});
                                                                let audioURL = window.URL.createObjectURL(blob);
                                                                save2.src = audioURL;
                                                                save2.play();
                                                                //audio.play();
                                                        };
						}
					).catch(
						function(err){
							console.log("ERROR");
							console.log(err.name, err.message);
						}
					);
					</script>

					<!--img src='underConstruction.png' style='width:25%'-->
					</center>
					</div>
					</div>
				<? } ?>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

