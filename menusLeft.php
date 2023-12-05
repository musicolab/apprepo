				<?
				/*
				*/
				?>
	
			<div class="col-sm-3">
				<?
				if(isset($_SESSION["USER"]["username"])){
				?>
					<!--div class="list-group" style='width:100%'>
                                        <a href='index.php' class='list-group-item active'><i class='fa fa-home'></i></a>
					</div-->

					<!--h4><a href='/apprepository'>MusicColab Repository</a></h4-->
					<div class="list-group" style='width:100%'>
						<a class='list-group-item active disabled'><?echo $_SESSION["USER"]["firstname"].' '.$_SESSION["USER"]["lastname"]. ' ('.$_SESSION["USER"]["username"].')'?></a>
						<!--a class='list-group-item'>role(s): <? //echo $_SESSION['USER']->role; ?>
						<?
						$con = mysqli_connect("localhost", "", "", "moodleLms");
						/*
						$sql = "select * from role_assignments a, role b where a.userid=".$_SESSION["USER"]->id." and a.roleid=b.id";
						$res = $con->query($sql);
						$cnt = 0;
						if($res){
							while($row = mysqli_fetch_assoc($res)){
								if($row['shortname']!="student"){
									$cnt++;
									//echo $cnt." ".$row['shortname']." ";
									//echo "<li>".$row['shortname']." (rid=".$row['roleid'].")<br> ";
								}
							}
							//echo "<br>";
                                	        }else{
                                        		echo "<font color='red'> role error: ".$con->error."</font>"."<br>";
						}
						*/
						?>
						</a-->
						<a href='sysanddev.php' class="list-group-item">DEVELOPMENT</a>
						<a href='logout.php' class="list-group-item">Logout</a>
					</div>

					<?
					$cntTotal = 0;
					$cntPub   = 0;
					$cntPri   = 0;
					$con2     = mysqli_connect("localhost", "", "", "");
					$resCnt   = $con2->query("select count(id) from metadata where filetype='public'");
					if($resCnt){
						$rowCnt = mysqli_fetch_assoc($resCnt);
						$cntPub = $rowCnt['count(id)'];
					}
					$resCnt   = $con2->query("select count(id) from metadata where filetype='private' and owner='".$_SESSION["USER"]["username"]."'");
                                        if($resCnt){
                                                $rowCnt = mysqli_fetch_assoc($resCnt);
                                                $cntPri = $rowCnt['count(id)'];
					}
					$cntTotal = $cntPri+$cntPub;


					?>
					<div class="list-group" style='width:100%'>
						<a class="list-group-item active disabled">REPOSITORY <span class='badge'><? echo $cntTotal?></span></a>
						<a href="publicFiles.php" class="list-group-item">Public Files <span class='badge'><? echo $cntPub; ?></span></a>
						<a href="privateFiles.php#" class="list-group-item">Private Files <span class='badge'><? echo $cntPri; ?></span></a>
						<!--a href='privateFilesMoodle.php' class="list-group-item">Private files in LMS</a-->
						<a href='uploadFileAjax.php' class="list-group-item">Upload Files</a>
						<a href='tags.php' class="list-group-item">Manage Tags</a>
					</div>

					<div class="list-group" style='width:100%'>
                                                <a class="list-group-item active disabled">Files for courses that I attend</a>
                                                <?
                                                $sql  = "SELECT u.username, c.id, c.fullname, r.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category WHERE r.id > 0 and u.username='".$_SESSION["USER"]["username"]."' and r.shortname='student'";
                                                $con3 = mysqli_connect("localhost", "", "", "moodleLms");
                                                $res  = $con3->query($sql);
                                                if($res){
                                                        while($row=mysqli_fetch_array($res)){
                                                                #echo "<a class='list-group-item' href='https://musicolab.hmu.gr/moodle/course/view.php?id=".$row['id']."' target='_blank'>";
                                                                echo "<a class='list-group-item' href='repoCourseFiles.php?id=".$row['id']."'>";
                                                                echo $row["fullname"];
                                                                echo "</a>";
                                                        }
                                                }
                                                ?>
					</div>

					<div class="list-group" style='width:100%'>
						<a class="list-group-item active disabled">Files for courses that I offer</a>
						<?
                                                $sql  = "SELECT u.username, c.id, c.fullname, r.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category WHERE r.id > 0 and u.username='".$_SESSION["USER"]["username"]."' and r.shortname<>'student'";
                                                $con3 = mysqli_connect("localhost", "", "", "moodleLms");
                                                $res  = $con3->query($sql);
                                                if($res){
                                                        while($row=mysqli_fetch_array($res)){
                                                                echo "<a class='list-group-item' href='repoCourseFiles.php?id=".$row['id']."'>";
                                                                echo $row["fullname"].' (' . $row['shortname'].')';
                                                                echo "</a>";
                                                        }
                                                }
                                                ?>
                                        </div>

					<!--div class="list-group" style='width:100%'>
						<a class="list-group-item active disabled">Moodle files / courses that I attend</a>
						<?
						$sql  = "SELECT u.username, c.id, c.fullname, r.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category WHERE r.id > 0 and u.username='".$_SESSION["USER"]["username"]."' and r.shortname='student'";
						$con3 = mysqli_connect("localhost", "", "", "moodleLms");						
						$res  = $con3->query($sql);
						if($res){
							while($row=mysqli_fetch_array($res)){
								#echo "<a class='list-group-item' href='https://musicolab.hmu.gr/moodle/course/view.php?id=".$row['id']."' target='_blank'>";
								echo "<a class='list-group-item' href='courseFiles.php?id=".$row['id']."'>";
								echo $row["fullname"];
								echo "</a>";
							}
						}
						?>
					</div>

					<div class="list-group" style='width:100%'>
						<a class="list-group-item active disabled">Moodle files / courses that I offer</a>
						<?
                                                $sql  = "SELECT u.username, c.id, c.fullname, r.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category WHERE r.id > 0 and u.username='".$_SESSION["USER"]["username"]."' and r.shortname<>'student'";
                                                $con3 = mysqli_connect("localhost", "", "", "moodleLms");                                               
                                                $res  = $con3->query($sql);
                                                if($res){
                                                        while($row=mysqli_fetch_array($res)){
								echo "<a class='list-group-item' href='courseFiles.php?id=".$row['id']."'>";
                                                                echo $row["fullname"].' (' . $row['shortname'].')';
                                                                echo "</a>";
                                                        }
                                                }
                                                ?>
					</div-->

					<!--div class="list-group" style='width:100%'>
						<a class="list-group-item active disabled" >UTILITIES</a>
						<a href='search.php' class="list-group-item">Search by metadata</a>
						<a href='contentSearch.php' class="list-group-item">Search by content (exact match)<sup><font color='red'></font></sup></a>
						<a href='contentSearchSimilarity.php' class="list-group-item">Search by content (similarity)<sup><font color='red'>TBA</font></sup></a>
						<a href='contentSearchMic.php' class="list-group-item">Search by recording<sup><font color='red'>new</font></sup></a>
						<a href='recordMicWebRTC.php' class="list-group-item">Record from mic <sup><font color='red'>new</font></sup></a>
						<a href='recordMicWebRTCMult.php' class="list-group-item">Record from mic multitrack<sup><font color='red'>new</font></sup></a>
						<a href='/vhv' class='list-group-item' target='_blank'>Verovio humdrum viewer</a>
						<a href='recordMic.php' class="list-group-item">Mic / waveform<sup><font color='red'>dev</font></sup></a>
					</div-->
					<!--div class="list-group" style='width:100%'>
                                                <a class="list-group-item active disabled" >Files in LMS courses</a>
						<?
						/*
                                                $mydirs = scandir("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']->id."/");
                                                foreach($mydirs as $key => $value){
                                                        if(is_dir("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']->id."/".DIRECTORY_SEPARATOR.$value)){
                                                                if($value!="." & $value!=".."){
                                                                        $sql = "select fullname, shortname from course where id=".$value;
                                                                        $res = $con->query($sql);
                                                                        if($res){
                                                                                while($row = mysqli_fetch_assoc($res)){
                                                                                        echo "<a href='courseFiles.php?c=".$value."'' class='list-group-item'>" . $row['fullname'] . "</a>";
                                                                                }
                                                                        }
                                                                }
                                                        }
						}
						 */
					?>
					</div>
					<div class="list-group" style='width:100%'>
                                                <a class="list-group-item active disabled">Courses that I attend</a>
					<?
					/*
					//$sql = "SELECT c.id FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category  where u.id=".$_SESSION["USER"]->id ;
					$sql = "SELECT c.id, ra.roleid, r.shortname, c.fullname, c.shortname FROM user u INNER JOIN role_assignments ra ON ra.userid = u.id INNER JOIN context ct ON ct.id = ra.contextid INNER JOIN course c ON c.id = ct.instanceid INNER JOIN role r ON r.id = ra.roleid INNER JOIN course_categories cc ON cc.id = c.category where u.id=".$_SESSION["USER"]->id." order by c.fullname" ;
					$res = $con->query($sql);
					//echo $sql;
        	                        if($res){
                	                        while($row = mysqli_fetch_assoc($res)){
                                	                $sql = "select * from course where id=".$row['id'];
                                        	        $resCourses = $con->query($sql);
                                                	if($resCourses){
								while($rowCourse = mysqli_fetch_assoc($resCourses)){
									//if($row["roleid"]!=5){
        	                                                        ?>
										<!--li><a href="courses.php?c=<?echo $rowCourse['id'];?>"><?echo $rowCourse['fullname']?></a> <?//echo "id=".$row['roleid']?><br-->
										<a href="https://musicolab.hmu.gr/moodle/course/view.php?id=<?echo $rowCourse['id'];?>" target="_blank" class='list-group-item'><?echo $rowCourse['fullname']?><br>
										<? 
										if($row['roleid']==1){
											echo "(role: manager)";	
										}else if($row['id']==2){
											echo "(role: course creator)";	
										}else if($row['id']==3){
											echo "(role: editing teacher)";	
										}else if($row['id']==4){
											echo "(role: teacher)";	
										}else if($row['id']==5){
											echo "(student)";	
										}else if($row['id']==6){
											echo "(role: guest)";	
										}else if($row['id']==7){
											echo "(role: user)";	
										}else if($row['id']==8){
											echo "(role: front page)";	
										}else{
											echo "(role: custom)";	
										}
										?></a>
									<?
									//}
	                                                        }
        	                                        }
	
        	                                }
                	                }
					//echo $sql."<br>";
					*/
					?>
					</div-->
				<?
				}else{
					error_log("sidemenu: no session found");
				?>
					<div class="list-group" style='width:100%'>
						<a class="list-group-item active disabled">Login</a>
                                        	<div class='list-group-item'>
		        	                        <form action='index.php' method='post'>
				                                username<br>
		                        		        <input type='text' name='user' style='width:100%' required><br>
				                                password<br>
				                                <input type='password' name='pass' style='width:100%' required><br>
			        	                        <br>
		        	        	                <input type='hidden' name='action' value='externalLogin'>
			                        	        <input type='submit' value='LOGIN'>
							</form>
						</div>
					</div>

					<div class="list-group" style='width:100%'>
						<a class="list-group-item active disabled">Registration</a>
						<div class='list-group-item'>
							<small>
							The MusiCoLab Repository is under ongoing research and development. If you wish to access this application, you are kindly requested to email to project  administrators (musicolab@hmu.gr), explaining your interest in accessing MusiCoLab tools and resources. 
							</small>
                                        	</div>
                                        </div>
					<!--a href='session.php'>print the LMS session</a><br-->
				<?
					echo "<font color='red'>".$loginResultMsg."</font><br>";
					echo "<br>";
					//header("Location: https://musicolab.hmu.gr/moodle/apprepository/nologin.php");							
				}
				?>
			</div>

