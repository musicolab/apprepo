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
				<br>
				<?
                                if(isset($_SESSION["USER"]->username)){
                                ?>
				<h3>repository / ISSUES</h3>

					<h4>1st review cycle: tags 1.0 - 1.X: user input and simple interface enhancements</h4>
					<font color='red'>
					<ul>
						<li>input validation
						<li>pagination management in public / private folders (mysql q option maybe ?)
						<li>sorting lists of files (mysql order by)
						<li>copy files to LMS: 
						<ul>
							<li>define the mimetypes for each type of file in the repo
						</ul>
						<li>minor
						<ul>
							<li>config.php file to include params
						</ul>
					</ul>
					</font>

					<h4>alpha: functionality: tags 0.0 - 0.X</h4>

					220113: review by Chrisoula
					<ul>
						<li>upload: gif indicating the upload
						<li>public files: col with owner, actions such as del, tag, etc not permitted for non owners
						<li>file size unit of measure must be KB, not MB
					</ul>

					ISSUES
					<ul>
					<li>common context path
					<ul>
						<li><font color='red'>session sharing</font> methods
						<ul>
							<li><font color='blue'>SOLUTION (211208): password validation: blowfish algorithm with user specific cost and salt</font>
							<li><font color='blue'>session_set_save_handler in php, administration &rarr; session in LMS</font>
							<li>common context path: not very good
							
						</ul>
					</ul>

					<li>course files in LMS:
					<ul>
						<li>
					</ul>

					<li>uploading private files in LMS: 
					<ul>
						<li>files table where filearea='private'
						<li>folder management and file tree is very hard to use
						<li>adding private files: pathname has is the sha1 has of /contextid/component/filearea/itemid/path/filename.ext of the file
						<ul>
							<li>ref: https://docs.moodle.org/dev/File_API_internals
							<ul>
								<li><font color='red'>contextid</font>: defined in the context table, 5 for , but how do you get it?
								<ul>
									<li>if the contextlevel is 50 (course), then the instanceId is the course id (<font color'red'>like!</font>
									<li>if the contextlevel is 30 (user), then the instanceId is the user id (<font color'red'>like!</font>
									<li><font color='blue'>solution</font>: select * from context where instanceid=2 and contextlevel=30 // select with the userId and contextLevel=30 (user) &rArr; get the contextId and put it in a query to store to private files
								</ul>
								<li>component='user'
								<li>filearea='private'
								<li>itemid must be 0 ("plugin specific id" see ref, so zeor it is)
								<li>path is ignored (not ., not /, the whole field is ignored, this is tested)
								<li>mimetype: from LMS code, see system and development pages
							</ul>
						</ul>
					</ul>
	
					<li>servers configuration
					<ul>
						<li>jtisi should move to this server so that there is no need for another cert. Traffic is way too low
					</ul>
					</ul>

				</ul>
				<br>
				<?}?>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

