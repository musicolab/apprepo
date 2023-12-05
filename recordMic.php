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

		<div class="row" style='background-image:url("Header2.jpeg");background-size:cover; height:100px; position:relative'>
			<?include 'header.php'?>
		</div>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<?
				if(isset($_SESSION["USER"]->username)){
				?>
				<br>
                                <div class="panel panel-default" style='border:1px solid #ddd;'>
                                <div class="panel-body">
				<h3>MusiCoLab Repository / Mic &amp; waveform <?echo $_GET['f']; ?></h3>
				<hr style='background-color:#ddd'>

					<center>
					<div id="waveform" style='width:r80%; background-color:#ddd;'></div>
					<br>
					<input type='button' value='RECORD' onclick='play()'> 
					<input type='button' value='STOP' onclick='stop()'><br>
					<small>
					</small>
					<br>
					<script>
						var wavesurfer = WaveSurfer.create({ 
							container: '#waveform', 
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
<script type="text/javascript">
    window.onload = function(){
	    var score_editor = new live_score.Score_editor("live_score_main_panel");
    };
    	function touchStarted() {
  		etAudioContext().resume();
	}
  </script>
    <script src='MIDI.js'></script>
    <script src='live_score-min.js'></script>
</html>

