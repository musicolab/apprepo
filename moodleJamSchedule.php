<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
	<?include 'headerHtml.php'?>
	<script language='javascript'>
                var files = [<?
                                $con = mysqli_connect("localhost", "", "", "");
				$sql = "select * from metadata where filename like '%/courses/".$_GET['id']."/%'";
                                $res = $con->query($sql);
                                $count = 1;
                                while($row = mysqli_fetch_assoc($res)){
                                        $tmp = substr($row['filename'],strrpos($row['filename'],"/")+1);
                                        if($count < $res->num_rows){
                                                echo "\"".$tmp."\",";
                                        }else{
                                                echo "\"".$tmp."\"";
                                        }
                                        $count++;
                                }
		?>];		
	
		function submitDelForm(formId){
			var ans = confirm("please confirm the delettion");
			if(ans){
				var f = document.getElementById("delform"+formId);
				f.submit();
			}
		}

		function openTracks(){
			window.open("selectTrack.php?id=<?echo $_GET["id"]?>&username=<?echo $_GET["username"]?>","_blank", "width=600,height=600&status=yes, toolbar=no, menubar=no, location=no,addressbar=no")
		}

		function setTheValue(theval){
			document.getElementById("filter").value=theval;
		}
        </script>
	<style>

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
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
		</style>
  </head>
  <body style='background-color:white'>
  <?	
				if(isset($_GET['action'])){
  error_log("-------------------------");
  error_log("action = ".$_GET['action']);
	  if($_GET['action']=='addJam'){
		$cid   = $_GET['id'];
		$date  = $_GET['date'];
		$lesson= $_GET['lesson'];
		$start = $date." ".$_GET['start'];
		$end   = $date." ".$_GET['end'];
		$track = $_GET['filter'];

		if(!isset($track) || $track==""){
			//$track = "https://musicolab.hmu.gr:8443/moodle/course/view.php?id=".$cid.
		}

		$con = mysqli_connect("localhost", "", "", "");
		$sql = "insert into jams values(".$cid.", '".$start.":00', '".$end.":00', '".$track."', '".$lesson."', '')";
		$res = $con->query($sql);
	  }else if($_GET['action']=='delete'){
		$cid   = $_GET['id'];
		$lesson= $_GET['lesson'];
		$start = $date." ".$_GET['start'];
		$end   = $date." ".$_GET['end'];
		$track = $_GET['track'];
		error_log("deleting cid = ".$cid);
		error_log("deleting start = ".$start);
		error_log("deleting end = ".$end);
		//error_log("deleting lesson = ".$lesson);
		$con = mysqli_connect("localhost", "", "", "");
		$sql = "delete from jams where courseId=".$cid." and start='".$start."' and end='".$end."' and lesson='".$lesson."'";
		$con->query($sql);
        }else{
	}
  }	
  ?>	
	<div class="container">

			<?
				//echo "searching for session<br>";
                                $con = mysqli_connect("localhost", "", "", "moodleLms");
				$sql = "select * from user where username='".$_GET["username"]."'";
				$res = $con->query($sql);
				if($res){
                                        $row = mysqli_fetch_assoc($res);
                                        error_log("user ".$_GET["username"]." is authenticated");
                                        $_SESSION['USER']['username'] = $_GET["username"];
                                        $_SESSION['USER']['firstname'] = $row["firstname"];
                                        $_SESSION['USER']['lastname'] = $row["lastname"];
                                        $_SESSION['USER']['id'] = $row["id"];
				}
				//echo "the user id is: ".$_SESSION['USER']['id']. "<br>";
			?>

		<div class="row">

			<div class="col-sm-3">
				<div class="panel panel-default" style='border-width:0px; brder-style:none; border-color:white; border-radius:0px'>
					<div class="panel-body">
						<form action='moodleJamSchedule.php'>
							date<br>
							<input type='date' name='date'   id='date'   required style='width:100%' value='<? echo date("Y-m-d");?>'><br>
							start<br>
							<input type='time' name='start'  id='start'  required style='width:100%' value='09:00'><br>
							end<br>
							<input type='time' name='end'    id='end'    required style='width:100%' value='21:00'><br>
							lesson title<br>
							<input type='text' name='lesson' id='lesson' required style='width:100%' value='' pattern='[A-Za-zΑ-Ωα-ωάέόίύώή0-9 ]+' title='latin or greek characters and numbers are allowed, no special characters'><br>
							<a href='javascript:openTracks();'>select the track</a><br>
							<div class='autocomplete' style='position:relative; display:inline-block; width:100%'>
								<input type='text' name='filter' id='filter' style='width:100%' readonly><br>
							</div>
							<br>
							<br>
							<input type='submit' value='add to schedule'>
							<input type='hidden' name='id'     value='<?echo $_GET['id']?>'>
							<input type='hidden' name='action' value='addJam'>
							<input type='hidden' name='username' value='<?echo $_GET['id']?>'>
						</form>
					</div>
				</div>
			</div>
			<div class='col-sm-9'>
				<div class="panel panel-default" style='border:0px solid #ddd;'>
					<div class="panel-body">
					<?
					//print_r($_SESSION);
        	                        if(isset($_SESSION["USER"]["username"])){
						$con = mysqli_connect("localhost", "", "", "moodleLms");
						$sql = "select * from course where id=".$_GET['id'];
						$res = $con->query($sql);
						$row = mysqli_fetch_assoc($res);
						$cname  = $row['fullname'];
						$csname = $row['shortname'];
        	                        ?>
						<h3>Lesson schedule for course: <i><?echo $row["fullname"]?></i></h3>
                                        <table class="table table-hover table-sm">
                                                <tr>
                                                        <th>#</th>
							<th>date</th>
							<th>from / to</th>
							<th>lesson</th>
							<th>track</th>
                                                        <th>actions</th>
                                                </tr>
                                                <?
							$con = mysqli_connect("localhost", "", "", "");
							$sql = "select * from jams where courseId=".$_GET['id']." order by start desc";
							$res = $con->query($sql);

                                                        if($res){
								$count = 1;
								while($row = mysqli_fetch_assoc($res)){
									$cid   = $row['courseId'];
									$start = $row['start'];
									$end   = $row['end'];
									$track = $row['track'];
									$lesson= $row['lesson'];
									$now   = date('Y-m-d H:i:s');

                                                                        ?>
                                                                        <tr>
                                                                        <td><?echo $count?></td>
                                                                        <td><?echo substr($start,0,10)?></td>
                                                                        <td><?echo substr($start,11, 5)?> - <?echo substr($end,11, 5)?></td>
									<?
										if($track==""){
											if($now<=$end && $now>=$start){
											?>
													<td><a href='https://musicolab.hmu.gr:8443/<?echo $csname;?>#config.prejonPageEnabled=true' target='_blank'><?echo $lesson;?></a></td>
													<td></td>
											<?
											}else{
											?>
													<td><?echo $lesson;?></td>
													<td></td>
											<?
											}
										}else{
											if($now<=$end && $now>=$start){
												if(substr($track,-3)=="mp3" or substr($track,-3)=="wav"){
												?>
													<td><a href='https://.hmu.gr/apprepository/playalong3/index.html?type=course&courseid=<?echo $_GET['id']?>&f=<?echo $track;?>&collab=true&user=<?echo $_SESSION['USER']['username']?>&id=<?echo $_SESSION['USER']['id']?>&course=<?echo $csname;?>' target='_blank'><?echo $lesson;?></a></td>
													<td><?echo $track;?></td>
												<?
												}else if(substr($track,-3)=="krn" or substr($track,-3)=="mei" or substr($track,-8)=="musicxml"){
													$fileUrl = "https://musicolab.hmu.gr/apprepository/downloadCourseFile.php?course=".$csname."&courseid=".$_GET['id']."&u=".$_SESSION['USER']['id']."&user=".$_SESSION['USER']['username']."&f=".urlencode($track);
													//echo $fileUrl; //HERE
													$fileUrl = base64_encode($fileUrl);
												?>
													<td><a href='https://musicolab.hmu.gr/apprepository/vhvWs/index.html?file=<?echo $fileUrl;?>&collab=true&user=<?echo $_SESSION['USER']['username']?>&id=<?echo $_SESSION['USER']['id']?>&course=<?echo $csname;?>' target='_blank'><?echo $lesson;?></a></td>
													<td><?echo $track;?></td>
												<?
												}else{
													echo "unknown extension (contact the admins)";
												}
											}else{
												if(substr($track,-3)=="mp3" or substr($track,-3)=="wav"){
												?>
                                                                                                        <td><?echo $lesson;?></td>
                                                                                                        <td><?echo $track;?></td>
                                                                                                <?
                                                                                                }else if(substr($track,-3)=="krn" or substr($track,-3)=="mei" or substr($track,-8)=="musicxml"){
                                                                                                ?>
                                                                                                        <td><?echo $lesson;?></a></td>
                                                                                                        <td><?echo $track;?></td>
                                                                                                <?
                                                                                                }else{
                                                                                                        echo "unknown extension (contact the admins)";
                                                                                                }
											}
										}
										?>
										<td>
										<form action='' name='delform' id='delform<?echo $count?>'>
											<input type='hidden' name='id'     value='<?echo $cid;?>'>
											<input type='hidden' name='start'  value='<?echo $start;?>'>
											<input type='hidden' name='end'    value='<?echo $end;?>'>
											<input type='hidden' name='lesson' value='<?echo $lesson;?>'>
											<input type='hidden' name='track'  value='<?echo $track;?>'>
											<input type='hidden' name='username' value='<?echo $_GET['username'];?>'>
											<input type='hidden' name='track'  value=''>
											<input type='hidden' name='action' value='delete'>
										</form>
										<a href='javascript:submitDelForm(<?echo $count;?>)' title='delete'><i class="fa fa-trash"></i></a>
									</td>
                                                                        </tr>
                                                                        <?
										$count=$count+1;
								}
                                                        }
		  				  }else{
							?>	
							PLEASE LOGIN TO THE REPOSITORY !<br>
							<hr>
							so that your session information is shared between the two systems<br>
							you may use <a href='https://musicolab.hmu.gr/apprepository' target='_blank'>THIS LINK</a>
							<?
                                                  }
                                                ?>
					</table>
					<center>
					<input type='button' value='  DONE  ' onclick="alert('exiting, pease refresh your course page!');window.close();">
					</center>
			</div>
			</div>
		</div>
		</div>

	</div>
	<script language="javascript">
			function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
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
		autocomplete(document.getElementById("filter"), files);
	</script>
  </body>
</html>

