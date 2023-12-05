<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
<script>
var publicFilesArr = [<?
$con = mysqli_connect("localhost", "", "", "");
$sql = "select * from metadata where filetype='public' order by filename asc";
$res = $con->query($sql);
if($res){
        $count = 0;
        while($row = mysqli_fetch_assoc($res)){
                $f   = $row['filename'];
                //echo "filename = ".$f."\n";
                $pos = strpos($f, "/jsonFiles/public/");
                //if($pos==false) echo "none found in ".$f."\n";
                //echo $pos;
                if($count==0){
                        echo "\"";
                }else{
                        echo ", \"";
                }
                echo substr($f, $pos+18, strlen($f));
                echo "\"";
                $count++;
        }
}
?>];
var privateFilesArr = [<?
$con = mysqli_connect("localhost", "", "", "");
$sql = "select * from metadata where filetype='private' and owner='".$_SESSION['USER']['username']."' order by filename asc";
$res = $con->query($sql);
if($res){
        $count = 0;
        while($row = mysqli_fetch_assoc($res)){
                $f   = $row['filename'];
                $pos = strpos($f, "/jsonFiles/users/".$_SESSSION['USER']['id']);
                //echo "\n".$f;
                if($count==0){
                        echo "\"";
                }else{
                        echo ",\"";
                }
                echo substr($f, $pos+strlen("/jsonFiles/users/".$_SESSSION['USER']['id'])+2, strlen($f));
                echo "\"";
                $count++;
        }
}
?>];
var theArray = [];
</script>
		<?include 'headerHtml.php'?>
	  	<link rel="stylesheet" type="text/css" href="./visualization_similarity/inspector.css">
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
/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  order-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9;
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important;
  color: #ffffff;
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
					ajax.open("POST", "contentSearchSimilarityResp.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
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
					error_log("--- SIMILARITY SEARCH");
					error_log("---------------------");
					//print_r($_SESSION["USER"]);
                                ?>
				<h3>Search by content / similarity search <font color='red'></font></h3>
				<hr style='background-color:#ddd'>
				<!--font color='red'>
				issues:
				<ul>
					<li>the results must be playable that is, the database of the system must be compatible with the public repo files
					<li>graph links must be weighted with respect to the similarity metric
				</ul>
				</font-->
				<?
				//require_once('getID3-master/getid3/getid3.php');
				$err = "noerr";
				?>
				<form action='' method='post' id='theform' enctype="multipart/form-data">
					Upload a file to be compared against the repository. The recognition will take 5-15 seconds <i>after</i> the file is upload. This form uses distance find similar songs<br>
					<?
					if(!isset($_POST['action'])){
					}else{
						if($_POST['action']=='recogniseFingerprint' or $_POST['action']=='existingFile'){
							?>
							<br>
							<div id='here'></div>
							<?
							if($_POST['action']=='recogniseFingerprint'){
								$cmd = "/home/pzervas/musRepoTools/source/similarity_bliss/bin/python3 /home/pzervas/musRepoTools/source/similarity_bliss/2-find_similar.py --fing_db /home/pzervas/musRepoTools/source/similarity_bliss/finger_mtGuitar_database_bliss_sim.pkl --audiofile /var/www/moodledata/repository/distance_".$_SESSION["USER"]['username'] . " --user ".$_SESSION["USER"]['username'];
								exec($cmd, $output);
								?>
								<iframe src='./contentSearchSimilarityVisBare.php?user=<?echo $_SESSION["USER"]['username'];?>' style='width:100%; height:700px; border-style:none'></iframe>
								<a href='./contentSearchSimilarityVis.php?user=<?echo $_SESSION["USER"]['username'];?>' target='_blank'>open in a new window</a><br>
								<script type="module">
									window.location.replace("https://musicolab.hmu.gr/apprepository/contentSearchSimilarityVis.php?user=<?echo $_SESSION["USER"]['username'];?>");
								</script>
								<?
							}else if($_POST['action']=='existingFile'){
								$path = "/var/www/moodledata/repository/jsonFiles/";
								if($_POST['folder']=='public'){
									$path = $path . "public/".$_POST['filename'] ;
								}else if($_POST['folder']=='private'){
									$path = $path . "users/".$_SESSION["USER"]['id']."/".$_POST['filename'];
								}
								error_log("path = ".$path);
								$cmd = "/home/pzervas/musRepoTools/source/similarity_bliss/bin/python3 /home/pzervas/musRepoTools/source/similarity_bliss/2-find_similar.py --fing_db /home/pzervas/musRepoTools/source/similarity_bliss/finger_mtGuitar_database_bliss_sim.pkl --audiofile ".$path. " --user ".$_SESSION["USER"]['username'];
								error_log($cmd);
								//exec($cmd, $output);
								?>
								<iframe src='./contentSearchSimilarityVisBare.php?file=<?echo $_POST["filename"];?>' style='width:100%; height:700px; border-style:none'></iframe>
								<a href='./contentSearchSimilarityVis.php?file=<?echo $_POST["filename"];?>' target='_blank'>open in a new window</a><br>
								<script type="module">
									window.location.replace("https://musicolab.hmu.gr/apprepository/contentSearchSimilarityVis.php?file=<?echo $_POST["filename"];?>&user=<?echo $_SESSION["USER"]['username'];?>");
								</script>
								<?
							}
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

				<form action="contentSearchSimilarity.php" method="post" id="thesecondform">
					<input type="hidden" name="action" value="recogniseFingerprint">
					<input type="hidden" name='user' value='<?echo $_SESSION["USER"]['username'];?>'>
					<input type="hidden" name="filetoanalyze" value="">
				</form>

			<br>
			</div>
				</div>
                                        <div class="panel panel-default" style='border:1px solid #ddd;'>
                                                <div class="panel-body">
                                                <?
                                                if(isset($_SESSION["USER"]['username'])){
                                                ?>
                                                <h3>Search by content / select existing file <font color='red'></font></h3>
                                                <hr style='background-color:#ddd'>
                                                Select the repository folder and any desired file and recover similar content<br>
                                                <br>
                                                <form method='post' autocomplete='off' action='contentSearchSimilarity.php'>
                                                <span style='width:25%'>folder</span> <select name='folder' id='folder' required>
                                                        <option value=''></option>
                                                        <option value='public'>public</option>
                                                        <option value='private'>private</option>
						</select><br>
						<div class='autocomplete'>
						<span style='width:25%'>music title</span> <input type='text' name='filename' id='filename' pattern='[A-Za-z0-9\.\-\s]*' placeholder='type repo file name' required>
						</div>
                                                <input type='submit' value='SUBMIT'>
                                                <input type='hidden' name='action' value='existingFile'>
						<input type="hidden" name='user' value='<?echo $_SESSION["USER"]['username'];?>'>
                                                <form>

                                                <?
                                                $err = "noerr";
                                                }
                                                ?>
                                                </div>
					</div>

					<!--div class="panel panel-default" style='border:1px solid #ddd;'>
                                                <div class="panel-body">
                                                <h3>Search by content / upload a recording / <font color='red'>under construction</font></h3>
                                                <hr style='background-color:#ddd'>
      						<div id="waveform" style="width:r80%; background-color:#ddd;"><wave style="display: block; position: relative; user-select: none; height: 128px; width: 100%; cursor: auto; overflow: auto hidden;"><wave style="position: absolute; z-index: 3; left: 0px; top: 0px; bottom: 0px; overflow: hidden; width: 0px; display: none; box-sizing: border-box; border-right: 1px solid rgb(51, 51, 51); pointer-events: none;"><canvas style="position: absolute; left: 0px; top: 0px; bottom: 0px; height: 100%;"></canvas></wave><canvas style="position: absolute; z-index: 2; left: 0px; top: 0px; bottom: 0px; height: 100%; pointer-events: none;"></canvas></wave></div><br>
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
						start and stop the recording using the buttons bellow. Use the upload button to transfer the recording in your <i>private files</i> folder. After each recording the HTML audio player is updated with the new recoding. Use the download link on the player (three dots) to download your recording as a WAV file. Downloading from the audio player is currently supported for the Chrome browser<br>
						<br>
						<center>
						<audio id="audio" controls="" style="vertical-align:middle">
						<source src="" type="audio/wav">
						</audio><br>
						<br>
						<button id="start">START RECORDING</button>
						<button id="stop" disabled="">STOP RECORDING</button><br>
						<br>
						<form action="recordMicWebRTCResp.php" method="post" id="micform">
							<input type="text" id="fileCS" name="fileCS" value="myFirstBlob" required="" disabled="" style="display:inline-block"> 
							<input type="button" name="upload" id="upload" value="UPLOAD" disabled="">
							<input type="hidden" name="action" value="uploadFromMic">
							<input type="file" name="data" value="" id="micformdata" style="visibility:hidden">
							<input type="hidden" name="datablob" value="" id="micformdatablob" style="visibility:hidden">
							<div class="progress" style="visibility:visible" id="progressBar">
								<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id="progressBarInner">0%</div>
							</div>
						</form>
						</center>
                                                </div>
                                        </div-->


				<?}?>
				</div>
			</div>

		</div>
		</div>

		<?include 'footer.php'?>
	</div>
					<script>
						function folderChanged(){
							var v = document.getElementById("folder");
							if(v.value=='public'){
								theArray = publicFilesArr;
								console.log("switching autocomplete to public");
							}else if(v.value=='private'){
								theArray = privateFilesArr;
								console.log("switching autocomplete to private");
							}else{
								alert('please select the folder');
							}
						}
						function autocomplete(inp, arr, fold) {
  							var currentFocus;
  							inp.addEventListener("input", function(e) {
								var v = document.getElementById("folder");
	                                                        if(v.value=='public'){
	                                                                arr = publicFilesArr;
	                                                                console.log("searching public");
	                                                        }else if(v.value=='private'){
	                                                                arr = privateFilesArr;
	                                                                console.log("searching private");
	                                                        }else{
	                                                                alert('please select the folder');
								}
      								var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      //console.log(arr)
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("filename"), theArray, document.getElementById("folder"));
</script>
  </body>
</html>

