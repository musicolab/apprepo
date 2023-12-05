<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
  </head>
  <body>
	<div class="container">

		<div class="row" style='background-image:url("Header2.jpeg");background-size:cover; height:100px; position:relative'>
			<?include 'header.php'?>
		</div>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
				<?
				if(isset($_SESSION["USER"]->username)){
					$terms  = $_GET['terms']; 
                                        $folder = $_GET['folder'];
					$title  = $_GET['title'];
					$compo  = $_GET['composer'];
					$perfor = $_GET['performer'];
                                        $ftype  = $_GET['filetype'];
					$content= $_GET['musicContent'];
					$tempo  = $_GET['tempo'];
					$key    = $_GET['key'];
					$scale  = $_GET['scale'];
					$genre	= $_GET['genre'];
					$instr  = $_GET['instruments'];
					$tags   = $_GET['thetags'];

					$sqlw   = "where";
					$sqlf   = "from metadata a";
					if($terms!="")  {
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						$sqlw = $sqlw . " lower(a.filename) like lower('%" . $terms . "%')";
					}
                                        if($folder!="") {
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						if($folder=='everywhere'){
							$sqlw = $sqlw . " (a.owner='".$_SESSION["USER"]->username."' or a.filetype='public') ";
						}else if($folder=='public'){
							$sqlw = $sqlw . " a.filetype='public'";
						}else if($folder=='private'){
							$sqlw = $sqlw . " (a.owner='".$_SESSION["USER"]->username."' or a.filetype='private') ";
						}
					}else{
						$sqlw = $sqlw . " (a.owner='".$_SESSION["USER"]->username."' or a.filetype='public') ";
					}

                                        if($title!="")  {
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						$sqlw = $sqlw . " lower(a.title) like lower('%" . $title . "%')";
					}
                                        if($compo!="")  {
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						$sqlw = $sqlw . " lower(a.composer) like lower('%" . $compo . "%')";
					}
                                        if($perfor!="") {
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						$sqlw = $sqlw . " lower(a.performer) like lower('%" . $perfor . "%')";
					}
                                        if($ftype!="")  {
						if($sqlw!="where") $sqlw = $sqlw. " and  ";
						$sqlw = $sqlw . " lower(a.filename) like  lower('%" . $ftype. "')";
					}
                                        if($content!="") {
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						$sqlw = $sqlw . " lower(a.musicContent) like lower('%" . $content . "%')";
					}
                                        if($tempo!="")  {
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						$sqlw = $sqlw . " a.tempo='" . $tempo . "'";
					}
					/*
                                        if($key!=""){
						if($sqlw!="where") $sqlw = $sqlw. " and ";
						$sqlw = $sqlw . " key='" . $key . "'";
					}
					*/
					$sqlGenre = "";
					if($genre!="")  {
						for($i=0; $i<count($genre); $i++){
							if($i==0) {
								$sqlGenre = $sqlGenre . " a.genre='" . $genre[$i] . "'";
							}else{
								$sqlGenre = $sqlGenre . " or a.genre='" . $genre[$i] . "'";
							}
							//if($i<count($genre)-1) $sqlGenre = $sqlGenre . " or ";
						}
						if($sqlw!="where"){
							$sqlw = $sqlw . " and ( ". $sqlGenre . " ) ";
						}else{
							$sqlw =  " where " . $sqlGenre ;
						}
					}

					
					$sqlInstr = "";
					if($instr!="") {
						$sqlf = $sqlf . ", files2instruments c ";
						for($i=0; $i<count($instr); $i++){
							if($i==0){
								$sqlInstr = $sqlInstr . " c.instrumentId=" . $instr[$i] . "";
							}else{
								$sqlInstr = $sqlInstr . " or c.instrumentId=" . $instr[$i] . "";
							}
							//if($i < count($instr)-1) $sqlInstr = $sqlInstr . " or ";
						}
						if($sqlw!="where"){
							$sqlw = $sqlw . " and a.id=c.fileId and ( ". $sqlInstr . " ) ";
						}else{
							$sqlw =  " where " . $sqlInstr ;
						}
					}
					
					$sqlTag = "";
					if($tags!="") {
						$sqlf = $sqlf . ", files2tags b ";
						for($i=0; $i<count($tags); $i++){
							if($i==0) {
								$sqlTags = $sqlTags . " b.tag='" . $tags[$i] . "'";
							} else {
								$sqlTags = $sqlTags . " or b.tag='" . $tags[$i] . "'";
							}
                                                }
                                                if($sqlw!="where"){
                                                        $sqlw = $sqlw . " and a.id=b.fileId and ( ". $sqlTags . " ) ";
                                                }else{
                                                        $sqlw =  " where a.id=b.fileId and  " . $sqlTags ;
                                                }
					}

					/*
					if($sqlw!="where"){
						$sqlw = $sqlw . " and a.owner='".$_SESSION["USER"]->username."'";
					}else{
						$sqlw = $sqlw . " a.owner='".$_SESSION["USER"]->username."'";
					}
					*/

                                        $sql = "select * ". $sqlf . " " . $sqlw ;
					#echo "".$sql."<br>";
                                ?>
				<h3>repository / search / results</h3>
				<hr style='background-color:#ddd'>
				terms: 
				<small>
				<?
				if($terms!="")   echo "terms=".$terms."  ";
				if($folder!="")  echo "folder=".$folder."  ";
				if($title!="")   echo "title=".$title."  ";
				if($ftype!="")   echo "type=".$ftype."  ";
				if($compo!="")   echo "compo=".$compo."  ";
				if($perfor!="")  echo "perfor=".$perfor."  ";
				if($thetags!="") echo "tags=".$thetags."  ";
				if($content!="") echo "content=".$content."  ";
				if($tempo!="")   echo "tempo=".$tempo."  ";
				if($key!="")     echo "key=".$key."  ";
				if($scale!="")   echo "scale=".$scale."  ";
				if(isset($genre)){
                                        for($i=0; $i<count($genre); $i++) {
                                                echo "genre=".$genre[$i]." ";
                                        }
                                }
				if(isset($instr)){
					for($i=0; $i<count($instr); $i++) {
						echo "instrument="."";
                                                $con = mysqli_connect("localhost", "", "", "");
						$res = $con->query('select * from instruments where id='.$instr[$i]);
						if($res) {
							$row = mysqli_fetch_assoc($res);
							echo $row['iname'];
						}
					}
				}
				if(isset($tags)){
					for($i=0; $i<count($tags); $i++) {
						echo "tags=".$tags[$i]."";
					}
				}
				?>
				</small><br>
				<hr style='background-color:#ddd'>
				<br>
				<?}?>
				 <table class="table table-hover table-sm">
                                                <tr>
                                                        <th>#</th>
                                                        <th>filename</th>
                                                        <th>owner</th>
                                                        <th>folder</th>
                                                        <th>type</th>
                                                        <th>size (MB)</th>
							<th>modification time</th>
							<th>action</th>
                                                </tr>
						<?
							/*
                                                        $con = mysqli_connect("localhost", "", "", "");
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
                                                                        <td><?echo $row['filetype']?></td>
                                                                        <td><?
                                                                                $fn = substr($row['filename'], 48);
                                                                                $pos = strpos($fn, ".")+1;
                                                                                echo substr($fn,$pos);
                                                                             ?></td>
                                                                        <td><?echo round($row['size']/1000000,2)?></td>
                                                                        <td><?echo date("d/m/y h:i:s", filemtime($row['filename']))?></td>
                                                                        <?
                                                                        //}
                                                                        $count=$count+1;
                                                                }
                                                        }else{
                                                                echo "<font color='red'> error: ".$con->error."</font>"."<br>";
							}
							*/
						?>
						<?
                                                        $con = mysqli_connect("localhost", "", "", "");
                                                        $sql = "select * from metadata where filetype='public' order by filename asc";
                                                        $res = $con->query($sql);
                                                        if($res){
                                                                $count = (int)(1+$pagef);
                                                                while($row = mysqli_fetch_assoc($res)){
                                                                        //if($count>=$pagef && $count<$pagef+$resPerPage){
                                                                        $value = $row['id'];
                                                                        ?>
                                                                        <tr>
                                                                        <td><?echo $count?></td>
									<td><?
										//HERE
										if($row['filetype']=='public'){
											echo substr($row['filename'], 48);
										}else{
											echo substr($row['filename'], 49);
										}?></td>
									<td><?echo $row['owner']?></td>
									<td><?echo $row['filetype']?></td>
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
										<?if($_SESSION['USER']->username==$row['owner'] || $row['filetype']=='public'){?>
                                                                                <a href='downloadPublicFile.php?f=<?echo urlencode(substr($row['filename'], 48))?>&user=<?echo $_SESSION['USER']->username;?>' title='download'><i class="fa fa-download"></i></a>
                                                                                <?
                                                                                if(substr($value, -4)==='.txt'){
                                                                                ?>
                                                                                <a href='openPublicFile.php?f=<?echo $value?>'    title='open file'      ><i class="fa fa-folder-open"></i></a>
                                                                                <?
                                                                                }
                                                                                ?>
                                                                                <a href='dataOfPublicFile.php?f=<?echo $value?>'  title='metadata'       > <i class="fa fa-table"></i></a>
                                                                                <a href='copyPublicFile.php?f=<?echo $value?>'    title='copy to private'> <i class="fa fa-copy"></i></a>
                                                                                <!--a href='copyToCourse.php?f=<?echo $value?>'      title='send to course'>  <i class="fa fa-share-square"></i></a-->
                                                                                <a href='exportPublicFile.php?f=<?echo $value?>'  title='export to LMS'><i class="fa fa-save"></i></a>
                                                                                <?
                                                                                if(substr($row['filename'],-3)=='mp3' or substr($row['filename'],-3)=='wav'){
                                                                                ?>
                                                                                        <a href='playWithWaveform.php?id=<?echo $value?>&f=<?echo urlencode(substr($row['filename'], 48))?>'  title='play'><i class="fa fa-play"></i></a>
                                                                                <?
                                                                                }else if(substr($row['filename'],-3)=='krn' or substr($row['filename'],-3)=='mei' or substr($row['filename'],-3)=='musicxml'){
                                                                                ?>
                                                                                        <a href='https://musicolab.hmu.gr/vhv/index.html?file=https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=<?echo urlencode(substr($row['filename'], 48))?>&user=<?echo $_SESSION['USER']->username;?>&uid=<?echo uniqid();?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a>
                                                                                        <a href='https://musicolab.hmu.gr/apprepository/vhvWs/index.html?file=https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=<?echo urlencode(substr($row['filename'], 48))?>&user=<?echo $_SESSION['USER']->username;?>' target='_blank'  title='collab'><i class="fa fa-cloud"></i></a>
                                                                                <?
                                                                                }else if(substr($row['filename'],-3)=='mxl'){
                                                                                ?>
                                                                                        <a href='https://musicolab.hmu.gr/vhv/index.html?file=https://musicolab.hmu.gr/apprepository/downloadPublicFile.php?f=<?echo urlencode(substr(substr($row['filename'], 48),0,-3))."xml"?>' target='_blank'  title='read score'><i class="fa fa-book"></i></a>
                                                                                <?
                                                                                }
                                                                                ?>
                                                                                <a href='tagPublicFile.php?f=<?echo $value?>'     title='tag file'       >#</a>
                                                                                <?
                                                                                if($row['owner']==$_SESSION["USER"]->username){
                                                                                ?>
                                                                                        <a href='delPublicFile.php?f=<?echo $value?>'     title='delete'         ><i class="fa fa-trash"></i></a>
                                                                                <?
                                                                                }
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

			</div>
			</div>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

