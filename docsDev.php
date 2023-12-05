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
				<div class="panel panel-default" style='border:1px solid #ddd;'>
					<div class="panel-body">
					<h3>Development / Logs, Misc Notes</h3>
					<hr style='background-color:#ddd'>
					<ul>
                                                <!--li><a href='devlog.php'>ISSUES</a>
                                                <li><a href='specs.php'>specs</a>
                                                <li><a href='mimetypes.php'>mimetypes</a>
                                                <li><a href='config.php'>config &amp; system params</a-->
						<li><a href='codestats' target='_blank'>Code Stats</a>
						<li><a href='lscore2.php'>Live Score Example</a>
						<li><a href='newDesign.php' target='_blank'>New Template</a>
						<li><a href='debug2203.php'>debugging by Alexandros (2203)</a>
					</ul>
					</div>
				</div>
	
				<div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
						<h4>code state</h4>
						<hr style='background-color:#ddd'>
						<ul>
							<li>search
							<ul>
								<li>logic for individual cases
								<li>flying characters
								<li>more fields: templ, key, scale
							</ul>
							<li>private files: copy functionality from public files
							<ul>
								<li>player: add metadata
							</ul>
							<li>multitrack: 
							<ul>
								<li>recorded file must be shown on wavesurfer
								<li>each player plays the same track !!!
							</ul>
							<li>session sharing
							<ul>
								<li>site administration - server - session sharing
								<ul>
									<li>maybe the best option would be to use the first option: use database session information
									<li>default value for session cookie path: /moodle
								</ul>
							</ul>
						</ul>
					</div>
				</div>

				<!--div class="panel panel-default" style='border:1px solid #ddd;'>
                                        <div class="panel-body">
                                        <center>
                                        <img src='https://musicolab.hmu.gr/apprepository/codestats/commits_by_author.png' style='width:45%'>
                                        <img src='https://musicolab.hmu.gr/apprepository/codestats/month_of_year.png' style='width:45%'>
                                        <img src='https://musicolab.hmu.gr/apprepository/codestats/hour_of_day.png' style='width:45%'>
                                        </center>
                                        </div>
                                </div-->

				<div class="panel panel-default" style='border:1px solid #ddd;'>
					<div class="panel-body">
					<h4>Development / code management / tags</h4>
					<table class='table table-hover table-sm'>
					<tr><th>tag</th><th style='width:100px'>date</th><th>description</th></tr>
					<?
					exec("cd /var/www/html/apprepository; /usr/bin/git tag -ln --format='%(tag) %(taggerdate:short) %(subject)'", $output, $retval);
					foreach($output as $key=>$val){
						$i = strpos($val, " ");
						$tag = substr($val, 0, $i);
						$val = substr($val, $i+1);

						$i = strpos($val, " ");
						$dat = substr($val, 0, $i);
						$val = substr($val, $i);
						echo "<tr><td>". $tag."</td><td>".$dat."</td><td>".$val."</td></tr>";
					}
					?>
					</table>
					</ul>
					<br>
					</div>
				</div>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

