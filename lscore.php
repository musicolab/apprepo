
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <h1 id="page_header"> Live Score v0.4.0 Demo </h1>

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
      <span id="email"> email: 
        <a href="john.b.bernier@gmail.com">
          john.b.bernier@gmail.com
        </a>
      </span>
      <span id="github"> github: 
        <a href="https://github.com/jbernie2/live_score">
          https://github.com/jbernie2/live_score
        </a>
      </span>
    </div>
  
  </body>
  <script type="text/javascript">
    window.onload = function(){
      var score_editor = new live_score.Score_editor("live_score_main_panel");
    };
  </script>
    <script src='MIDI.js'></script>
    <script src='live_score-min.js'></script>
</html>

