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
					<h4>Documentation / authentication</h4>
					<hr style='background-color:#ddd'>
The system authentication leverages the infrastructure of the LMS asynchronous distance learning system. In particular, it uses its database which stores the user accounts for which it stores passwords using an appropriate cryptographic algorithm (CRYPT / BLOWFISH) which is supported by the encryption libraries of the middleware used by the repository (PHP libcrypt). The implementation of the repository included:
<ul>
	<li>reading the LMS user table
	<li>implementing the password verification mechanism for the authentication process
</ul>
The authentication mechanism is accompanied by standard session management to control access and appropriate destruction upon exit.
					</div>
				</div>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

