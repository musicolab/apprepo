<?session_start();?>
<!DOCTYPE html>
<html>
  <head>
	<?include 'headerHtml.php'?>
  </head>
  <body>
	 <div class="container">
                        <?include 'header.php'?>
		<div class="row">
			<div class='cols-sm-12' style='padding:15px 15px 15px 15px'>

    <h3 id="page_header"><a href='index.php'>home</a> / live score demo</h3>

    <div id="live_score_main_panel">
      <div id="control_panel_top">
        <span id="quantization_panel">quantization:
          <select id="quantization_select">
            <option value="1">whole</option>
            <option value="2">half</option>
            <option value="4">quarter</option>
            <option value="8">eighth</option>
            <option value="16">sixteeth</option>
            <option value="32">thirty-second</option>
          </select> 
        </span>
        <span id="input_panel">note length:
           <select id="note_select"> 
            <option value="1">whole</option>
            <option value="2">half</option>
            <option value="4">quarter</option>
            <option value="8">eighth</option>
            <option value="16">sixteeth</option>
            <option value="32">thirty-second</option>
          </select> 
        </span>
      </div>
      <div id="middle_panel">
        <canvas id="score_panel"> </canvas>
      </div>
      <div id="control_panel_bottom">
        <span id="playback_panel">
          <button id="play_button"> play </button>
        </span>
        <span id="cursor_panel">
          <button id="insert_note"> draw </button>
          <button id="remove_note"> erase </button>
        </span>
      </div>
    </div>
    <div id="page_footer">
	<br>
      	email: <a href="john.b.bernier@gmail.com"> john.b.bernier@gmail.com </a>
        <a href="https://github.com/jbernie2/live_score"> https://github.com/jbernie2/live_score </a>
    </div>


			</div>
		</div>
	</div>
  </body>
  <script type="text/javascript">
    window.onload = function(){
      var score_editor = new live_score.Score_editor("live_score_main_panel");
    };
  </script>
    <script src='MIDI.js'></script>
    <script src='live_score-min3.js'></script>
</html>

