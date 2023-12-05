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
				<h3>repository / private files</h3>
				privated files are indexed in the files table and the pathname hash points to the actual location under filedir<br>
				select contenthash, pathnamehash from files where filename = input and filearea='private' and author='fistname lastname'
				<br>
				<form action='' method=''>
					<table class="table table-hover table-sm">
						<tr>
							<th>#</th>
							<th>filename</th>
							<th>size (kbytes)</th>
							<th>actions</th>
						</tr>
						<?
							$f = scandir('/var/www/html/apprepository/jsonFiles/');
							$count = 1;
							foreach($f as $key=>$value) {
								if($value!==".." and $value!=="."){
									$fs = filesize('/var/www/html/apprepository/jsonFiles/'.$value);
									?>
									<tr>
									<td><?echo $count?></td>
									<td><?echo $value?></td>
									<td><?echo $fs/1000?></td>
									<td><a href=''>open</a> <a href=''>metadata</a> <a href=''>copy</a> <a href=''>del</a></td>
									</tr>
									<?
									$count=$count+1;
								}
							}
						?>
					</table>
				</form>
				<br>
				<br>
			</div>
		</div>

		<?include 'footer.php'?>

	</div>
  </body>
</html>

