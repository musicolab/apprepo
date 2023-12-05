<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<script language='javascript'>
			var files = [<?
				$con = mysqli_connect("localhost", "", "", "");
				$sql = "select * from metadata where filetype='public'";
				$res = $con->query($sql);
				$count = 1;
				while($row = mysqli_fetch_assoc($res)){
					$tmp = substr($row['filename'],48);
					if($count < $res->num_rows){
						echo "\"".$tmp."\",";
					}else{
						echo "\"".$tmp."\"";
					}
					$count++;
				}
			?>];
		</script>
		<style>

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

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
  <body>
	<div class="container">

		<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
					<?
					if(isset($_SESSION["USER"]["username"])){
						$resPerPage = 20;
						$pagef      = 0;
						if(isset($_GET['pagef'])) $pagef = $_GET['pagef'];
						$orderby    = "filename";
						if(isset($_GET['or']))    $orderby = $_GET['or'];
						$sort       = "asc";
						$sortNew    = "desc";
						if(isset($_GET['s'])){
							$sort  = $_GET['s'];
						}

						$sql = "";
						if(isset($_GET['action'])){
							if($_GET['action']=='applyfilter'){
								$sql = "select * from metadata where filetype='public' and filename like '%".$_GET["filter"]."%'order by ".$orderby." ".$sort." limit ".$resPerPage." offset ".$pagef;
							}else{
								$sql = "select * from metadata where filetype='public' order by ".$orderby." ".$sort." limit ".$resPerPage." offset ".$pagef;
							}
						}else{
							$sql = "select * from metadata where filetype='public' order by ".$orderby." ".$sort." limit ".$resPerPage." offset ".$pagef;
						}
						//echo $sql."<br>";
						if(isset($_GET['orPrev'])){
							if($_GET['orPrev']!=$orderby){
								$sortNew = "asc";
							}else{
								if($sort=="asc") {
									$sortNew = "desc";
								}else if($sort=="desc"){
									$sortNew = "asc";
								}
							}
						}else{
							$sortNew = "desc";
						}
        	                        ?>
					<h3>Public Files</h3>
					<form action='publicFiles.php'>
					<div class='autocomplete' style='position:relative; display:inline-block'>
						<input type='text' name='filter' id='filter' placeholder='search for a filename' required>
					</div>
					<input type='submit' value='apply' pattern='[A-Za-zΑ-Ωα-ω]{3,}'><br>
					<input type='hidden' name='action' value='applyfilter'>
					</form>
					<br>
					<!--
					file name like <input type='text' name='like' id='like' style='border-style:none none solid none; border-width:1px;' patten='[A-Za-z]'> and ext is <select name='ext' id='ext'>
						<option value=''></option>
						<option value='mid'>mid</option>
						<option value='krn'>krn</option>
						<option value='txt'>txt</option>
					</select>
					<br-->
					<table class="table table-hover table-sm">
						<tr>
							<th>#</th>
							<th>filename          <a href='publicFiles.php?or=filename&orPrev=<?echo        $orderby;?>&s=<?echo $sortNew;?>'><i class="fa fa-sort<?if($orderby=="filename")        {if($sortNew=="desc") echo "-down"; else echo "-up";}else{ echo "";}?>"></i></a></th>
							<th>owner             <a href='publicFiles.php?or=owner&orPrev=<?echo           $orderby;?>&s=<?echo $sortNew;?>'><i class="fa fa-sort<?if($orderby=="owner")           {if($sortNew=="desc") echo "-down"; else echo "-up";}else{ echo "";}?>"></i></a></th>
							<th>type              <a href='publicFiles.php?or=encoding&orPrev=<?echo        $orderby;?>&s=<?echo $sortNew;?>'><i class="fa fa-sort<?if($orderby=="type")            {if($sortNew=="desc") echo "-down"; else echo "-up";}else{ echo "";}?>"></i></a></th>
							<th>size (MB)         <a href='publicFiles.php?or=size&orPrev=<?echo            $orderby;?>&s=<?echo $sortNew;?>'><i class="fa fa-sort<?if($orderby=="size")            {if($sortNew=="desc") echo "-down"; else echo "-up";}else{ echo "";}?>"></i></a></th>
							<th>modification time <!--a href='publicFiles.php?or=compositiondate&orPrev=<?echo $orderby;?>&s=<?echo $sortNew;?>'><i class="fa fa-sort<?if($orderby=="compositiondate") {if($sortNew=="desc") echo "-down"; else echo "-up";}else{ echo "";}?>"></i></a--></th>
							<th>actions</th>
						</tr>
						<?
							$con = mysqli_connect("localhost", "", "", "");
                                                	//$sql = "select * from metadata where filetype='public' order by filename asc";
							$res = $con->query($sql);
							if($res){
								$count = (int)(1+$pagef);
								while($row = mysqli_fetch_assoc($res)){
									//if($count>=$pagef && $count<$pagef+$resPerPage){
									$value = $row['id'];
									?>
									<tr>
									<td><?echo $count?></td>
									<td><?echo substr($row['filename'], 48)?></td>
									<td><?echo $row['owner']?></td>
									<td><? 
										$fn = substr($row['filename'], 48);
										$pos = strpos($fn, ".")+1;
										echo substr($fn,$pos);
									     ?></td>
									<td><?echo round($row['size']/1000000,2)?></td>
									<td><?echo date("d/m/y h:i:s", filemtime($row['filename']))?></td>
									<td>
										<?//error_log(" - username = ".print_r($_SESSION['username'], true));?>
										<?//error_log(" - session  = ".print_r($_SESSION, true));?>
										<a href='downloadPublicFile.php?f=<?echo urlencode(substr($row['filename'], 48))?>&user=<?echo $_SESSION['USER']["username"];?>' title='download'><i class="fa fa-download"></i></a> 
										<?
										if(substr($value, -4)==='.txt'){
										?>
										<a href='openPublicFile.php?f=<?echo $value?>'    title='open file'      ><i class="fa fa-folder-open"></i></a> 
										<?
										}
										?>
										<a href='dataOfPublicFile.php?f=<?echo $value?>'  title='metadata'       > <i class="fa fa-table"></i></a> 
										<a href='copyPublicFile.php?f=<?echo $value?>'    title='copy to private / course'> <i class="fa fa-copy"></i></a> 
										<!--a href='copyToCourse.php?f=<?echo $value?>'      title='send to course'>  <i class="fa fa-share-square"></i></a--> 
										<a href='exportPublicFile.php?f=<?echo $value?>'  title='export to LMS'><i class="fa fa-save"></i></a> 
										<?
										if(substr($row['filename'],-3)=='mp3' or substr($row['filename'],-3)=='wav'){
										?>
											<a href='./playalong3/index.html?type=public&f=<?echo urlencode(substr($row['filename'], 48))?>&user=<?echo $_SESSION['USER']["username"];?>&id=<?echo $_SESSION['USER']["id"];?>'  title='play' target='_blank'><i class="fa fa-play"></i></a> 
											<a href='./playalong3/index.html?type=public&f=<?echo urlencode(substr($row['filename'], 48))?>&collab=true&user=<?echo $_SESSION['USER']["username"];?>&id=<?echo $_SESSION['USER']["id"];?>' title='play' target='_blank'><i class="fa fa-cloud"></i></a> 
										<?
										}else if(substr($row['filename'],-3)=='krn' or substr($row['filename'],-3)=='mei' or substr($row['filename'],-3)=='musicxml'){
											$fileUrl = base64_encode("https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=".urlencode(substr($row['filename'], 48)));
										?>	
											<a href='https://musicolab.hmu.gr/apprepository/vhvWs/index.html?type=public&file=<?echo $fileUrl?>&collab=false&user=<?echo $_SESSION['USER']["username"];?>>&id=<?echo $_SESSION['USER']["id"];?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a> 
											<!--a href='https://musicolab.hmu.gr/vhv/index.html?file=https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=<?echo urlencode(substr($row['filename'], 48))?>&user=<?echo $_SESSION['USER']["username"];?>&uid=<?echo uniqid();?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a--> 
											<a href='https://musicolab.hmu.gr/apprepository/vhvWs/index.html?type=public&file=<?echo $fileUrl?>&collab=true&user=<?echo $_SESSION['USER']["username"];?>&id=<?echo $_SESSION['USER']["id"];?>' target='_blank'  title='collab'><i class="fa fa-cloud"></i></a> 
										<?
										}else if(substr($row['filename'],-3)=='mxl'){
										?>
											<a href='https://musicolab.hmu.gr/vhv/index.html?type=public&file=https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=<?echo urlencode(substr(substr($row['filename'], 48),0,-3))."xml"?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a> 
										<?
										}
										?>
										<a href='tagPublicFile.php?f=<?echo $value?>'     title='tag file'       >#</a>
										<?
										if($row['owner']==$_SESSION["USER"]["username"]){
										?>
											<a href='delPublicFile.php?f=<?echo $value?>'     title='delete'         ><i class="fa fa-trash"></i></a> 
										<?
										}
										?>
									</tr>
									<?
									//}
									$count=$count+1;
								}
							}else{
								echo "<font color='red'> error: ".$con->error."</font>"."<br>";
        	                                        }
						?>
					</table>
					<center>
					pages: <? 
						if(isset($_GET['action'])){
							if($_GET['action']=='applyfilter'){
								$sql = "select * from metadata where filetype='public' and filename like '%".$_GET['filter']."%'order by filename asc";
							}else{
								$sql = "select * from metadata where filetype='public' order by filename asc";
							}
						}else{
							$sql = "select * from metadata where filetype='public' order by filename asc";
						}
						$res = $con->query($sql);
						$pcount     = 1;
						for($pag=0; $pag<($res->num_rows); $pag=$pag+$resPerPage){
							if($pcount==(($pagef)/$resPerPage)+1){
								echo "[ ".$pcount. " ] ";
							}else{
								echo "[ <a href='publicFiles.php?pagef=".$pag."&or=".$orderby."&orPrev=".$orderby."&s=".$sort."'>".$pcount."</a> ] ";
							}
							$pcount++;
						}
					?><br>
					</center>
				<?}?>
			</div>
			</div>
		</div>
		</div>

		<?include 'footer.php'?>
	</div>
	<script language='javascript'>
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

