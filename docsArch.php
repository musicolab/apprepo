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
					<h4>Documentation / architecture</h4>
					<hr style='background-color:#ddd'>
The implementation was based on flexible technologies and management methodologies to enable rapid adaptation to changes in specifications or operational requirements. Management decisions were made through frequent (typically weekly) meetings: details are included in the relevant governance deliverables for overall program management.<br>
<br>

The decisions that gave direction to the software were implemented in an immediate way, and the writing of the code was supported by a suitable leading version management system and notes (GIT) on which the most well-known related platforms are based throughout time (please refer to the documentation about development).<br>
<br>

<b>Infrastructure</b><br>
In order to achieve high speed in the development and installation (deployment) of all the required logic parts, the existing infrastructures were configured in an optimal network way. Specifically,
<ul>
	<li>an administrative domain was created with the nomenclature registration musicolab.hmu.gr and an appropriate digital encryption certificate was issued
	<li>the above domain was assigned to a public web interface that addressed an ideal service machine (virtual machine) which was granted to the program by the HMU Communications and Networks Center after a suitable application.
	<li>the above virtual service engine was connected via a network (gateway/routing) to a second private internet address, namely 10.0.0.70
	<li>an appropriate private internet address was also assigned to auxiliary workstations necessary for development testing
</ul>
The above configuration required the appropriate setup of central institutional services to enable the following
<ul>
	<li>the development and management of the online repository with the most direct, shortest, most efficient process, i.e. through direct and secure access through the private virtual network of HMU
	<li>the possibility of direct access of all participants in the program to the result of the development
</ul>
<br>
<b>Server based software</b><br>
The repository system was based on web technologies ie HTML/CSS for the user interface, PHP for the middle layer logic and MYSQL for the database. Libraries and programming interfaces were used to implement interoperability with the certification system of the well-known online asynchronous distance learning system LMS which supports the courses implemented within the program.<br>
<br>
					</div>
				</div>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

