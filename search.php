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
var allFilesArr = publicFilesArr.concat(privateFilesArr);

var theArray = [];
</script>
		<?include 'headerHtml.php'?>
		<style>
* {
  box-sizing: border-box;
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
  </head>
  <body>
	<div class="container">

		<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
				<?
                                if(isset($_SESSION["USER"]['username'])){
                                ?>
				<h3>Search by metadata</h3>
				<hr style='background-color:#ddd'>
				<form action='searchResp.php' autocomplete='off' method=''>
					search in filename<br>
					<!--input type='text' name='terms'><br-->
					<!--div class=autocomplete" style='position:relative'-->
						<input type='text' name='terms' id='terms' pattern='[A-Za-z0-9\.\-\s]*' placeholder="type the filename"><br>
					<!--/div-->
					select folder<br>
                                        <select name='folder' id='folder' required>
                                                <option value=''></option>
                                                <option value='everywhere'>everywhere</option>
                                                <option value='public'>public</option>
                                                <option value='private'>private</option>
                                                <!--option value='courses'>courses</option-->
					</select><br>
					<br>
					<h4>metadata fields and values</h4>

					<div class='row'>
						<div class='col-sm-3'>
							title<br>
							<input type='text' name='title' value=''><br>
							composer<br>
							<input type='text' name='composer' value=''><br>
							performer<br>
							<input type='text' name='performer' value=''><br>
							file type (extension)<br>
							<input type='text' name='filetype' value=''><br>
						</div>
						<div class='col-sm-3'>
                                                        music content<br>
							<select name='musicContent' value='' style='width:100%; height:28px;'>
								<option value=''></option>
								<option value='voiced'>voiced</option>
								<option value='instrumental'>instrumental</option>
							</select><br>
                                                        tempo<br>
							<select type='text' name='tempo' value='' style='height:28px; width:100%'>
								<option></option>
								<option value='60-80'>60-80</option>
								<option value='80-100'>80-100</option>
								<option value='100-120'>100-120</option>
								<option value='120-160'>120-160</option>
								<option value='160-200'>160-200</option>
								<option value='200plus'>&gt; 200</option>
							</select><br>
                                                        key<br>
                                                        <select name='key' value='' style='height:28px; width:100%'>
                                                                <option></option>
                                                                <option value='M'>major</option>
                                                                <option value='m'>minor</option>
							</select><br>
							scale<br>
							<select name='scale' value='' style='height:28px; width:100%'>
								<option value=''></option>
								<option value='A'>A</option>
								<option value='B'>B</option>
								<option value='C'>C</option>
								<option value='D'>D</option>
								<option value='E'>E</option>
								<option value='F'>F</option>
								<option value='G'>G</option>
							</select>
                                                </div>
						<div class='col-sm-3'>
                                                        genre<br>
                                                        <select name='genre[]' multiple style='width:100%'>
                                                        	<?
                                                                $genres = array("rock", "pop", "alternative", "indie", "electronic", "female vocalists", "dance", "00s", "alternative rock", "jazz", "beautiful", "metal", "chillout", "male vocalists", "classic rock", "soul", "indie rock", "Mellow", "electronica", "80s", "folk", "90s", "chill", "instrumental", "punk", "oldies", "blues", "hard rock", "ambient", "acoustic", "experimental", "female vocalist", "guitar", "Hip-Hop", "70s", "party", "country", "easy listening", "sexy", "catchy", "funk", "electro", "heavy metal", "Progressive rock", "60s", "rnb", "indie pop", "sad", "House", "happy");
                                                                for($i=0; $i<count($genres); $i++){
                                                                	echo "<option value='".$genres[$i]."'>".$genres[$i]."</option>";
                                                                }
                                                                ?>
                                                        </select><br>
							instruments<br>
                                                                <select name='instruments[]' multiple style='width:100%'>
									<?
									$con = mysqli_connect("localhost", "", "", "");

                                                                        $instrDb = $con->query("select * from instruments");
                                                                        for($i=0; $i<$instrDb->num_rows; $i++){
                                                                                $instr = $instrDb->fetch_assoc();
                                                                                print_r($instrDbRow);
                                                                                echo "<option value='".$instr['id']."'>".$instr['iname']."</option>";
                                                                        }
                                                                        ?>
                                                                </select>
						</div>
						<div class='col-sm-3'>
					tags<br>
					<select name='thetags[]' size='10' style='width:100%' multiple>
							<option value=''></value>
					<?
					$con = mysqli_connect("localhost", "", "", "");
                                        $sql = "select distinct(tag) from files2tags order by tag";
                                        $res = $con->query($sql);
                                        if($res){
                                        	$count = 1;
						while($row = mysqli_fetch_assoc($res)){
						?>
							<option value='<? echo $row['tag'];?>'><? echo $row['tag'];?></option>
                                                <?
                                                }
                                        }else{
                                        	echo "<font color='red'> error: ".$con->error."</font>"."<br>";
					}
					?>
					</select><br>
					<br>
						</div>
					</div> 
					<input type='submit' value='Search the Repository'>
				</form>
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
								}else if(v.value=='everywhere'){
									arr = allFilesArr;
									console.log("searching everywhere");
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
							  
							  //autocomplete(document.getElementById("terms"), theArray, document.getElementById("folder"));
							  </script>
  </body>
</html>

