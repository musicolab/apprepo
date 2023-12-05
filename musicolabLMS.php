<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
  </head>
  <body>
	<div class="container">

		<?include 'header.php'?>

		<div class="row">

			<?include 'menusLeft.php'?>

			<div class="col-sm-9">
				<!--div class="panel panel-default" style='border:1px solid #ddd;'>
					<div class="panel-body">
					<h3>Musicolab LMS / files in the courses that I offer</h3>
					<hr style='background-color:#ddd'>
					<?
                                                $mydirs = scandir("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']->id."/");
                                                foreach($mydirs as $key => $value){
                                                        if(is_dir("/var/www/moodledata/repository/jsonFiles/users/".$_SESSION['USER']->id."/".DIRECTORY_SEPARATOR.$value)){
                                                                if($value!="." & $value!=".."){
                                                                        $sql = "select fullname, shortname from course where id=".$value;
                                                                        $res = $con->query($sql);
                                                                        if($res){
                                                                                while($row = mysqli_fetch_assoc($res)){
                                                                                        echo "<a href='courseFiles.php?c=".$value."''>" . $row['fullname'] . "</a><br>";
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                        ?>
					</div>
				</div-->
	
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
						<h3>LMS Courses that I attend</h3>
						<hr style='background-color:#ddd'>
						<?
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
                                                                                <a href="https://musicolab.hmu.gr/moodle/course/view.php?id=<?echo $rowCourse['id'];?>" target="_blank"><?echo $rowCourse['fullname']?> 
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
                                                                                ?></a><br>
                                                                        <?
                                                                        //}
                                                                }
                                                        }

                                                }
                                        }
                                        //echo $sql."<br>";
                                        ?>

					</div>
				</div>

				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
						<h3>My private files in the LMS</h3>
						<hr style="background-color:#ddd">

                                <?
                                if(isset($_SESSION["USER"]->username)){
                                ?>
                                        <?
                                        $con = mysqli_connect("localhost", "", "", "");
                                        ?>
                                                <table class='table table-hover table-sm'>
                                                        <tr> <th>#</th> <th>filename</th> <th>path</th> <th>size (MB)</th> <th>type</th> <th>creation</th></tr>
                                                        <?
                                                        $sql = "select contenthash, pathnamehash, author, filename, filepath, filesize, timecreated, mimetype from files where filearea='private' and userid=".$_SESSION["USER"]->id." and filename <> '.'";
                                                        $res = $con->query($sql);
                                                        if($res){
                                                                $cfiles = 1;
                                                                while($row = mysqli_fetch_assoc($res)){
                                                                        ?>
                                                                        <tr>
                                                                                <td><?echo $cfiles;?></td>
                                                                                <td><?echo $row['filename']?></td>
                                                                                <td><?echo $row['filepath']?></td>
                                                                                <td><?echo round($row['filesize']/1000000,2)?></td>
                                                                                <td><?echo $row['mimetype']?></td>
                                                                                <td><?echo date('d-m-y', $row['timecreated'])?></td>
                                                                        </tr>
                                                                        <?
                                                                        $cfiles = $cfiles +1;
                                                                }
                                                        }else{
                                                                echo "ERROR: please contact the admins<br>";
                                                        }
                                                        ?>
                                                </table>
                                <? } ?>


					</div>
				</div>

			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

