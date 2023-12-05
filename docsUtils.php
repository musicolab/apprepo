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
					<h4>Documentation / services</h4>
					<hr style='background-color:#ddd'>
<b>Export and confirm metadata</b><br>
The system is able to suggest values for the basic metadata it stores. In particular, it uses the well-known Essentia library, and the YAMNET neural network model in order to suggest metadata values ​​related to the type of music, the key, the scale, whether it is orchestral or not, among others.<br>
<br>
The system implements an appropriate workflow so that
<ul>
<li>(a) the metadata extraction infrastructure per content segment can be executed once at any given time
<li> (b) the extracted values ​​are identifiable and verifiable at the presentation level by the user.
</ul>
Metadata extraction results are displayed in red for user editing and submission<br>
<br>

<b>Search by metadata and annotations</b><br>
Searching based on metadata and annotations is implemented by constructing a complex query to the database dynamically. Depending on the user's choices, the query can exhaust the file areas (public, private, etc.), metadata and annotations.<br>
<br>
<b>Search by content - fingerprints</b><br>
Content-based search is implemented using open source audio fingerprinting technologies, specifically the DejaVu program (github.com/worldveil/dejavu). This technique is used in many well-known music recognition systems such as Shazam, MusicRetrieval, Chomapring. The technology is based on the assumption that the maximum values ​​of the musical signal in the frequency domain are characteristic of each piece of music. A database is created that maintains this information which is likened to fingerprints and for each piece of music that the user uploads through the corresponding form the appropriate comparison is made which produces an appropriate numerical value that represents the certainty of the success of the comparison (fingerprint confidence, see results image below) according to what is specified by DejaVu.<br>
<br>

In order to protect the infrastructure from any unauthorized use of the service, which is quite demanding in computing resources, a basic mechanism for detecting its operation has been implemented so that the way in which it is used can be controlled, i.e. policies can be applied so that it can run once per input file at most or once per processor.<br>
<br>

The content search mechanism based on peaks of the power diagram in the frequency field (fingerprints) is also used for searching through sound recording. Users can record music, upload it via the form below and search the database for similar content.<br>
<br>

<b>Search for related content</b><br>
The content search function can be aimed at retrieving similar information or retrieving related information.<br>
[Panagiotis]<br>
<br>

<b>Recording</b><br>
The repository supports adding content through recordings to the system. Using WEBRTC and JAVAWCRIPT / AJAX technologies the system takes input from the microphone, gets the desired name of the content and then uploads it. The user can combine up to three tracks through the recording system and upload them separately if desired.<br>
<br>

<b>Integration with Verovio Humdrum Viewer</b><br>
[Dimitris]


					</div>
				</div>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

