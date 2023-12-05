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
					<h3>Development / debugging by Alexandros (2203)</h3>
					<hr style='background-color:#ddd'>
				general issues:
					<ol>
                                        <li><del>δεν υπάρχει κουμπί αρχικής σελίδας (https://musicolab.hmu.gr/apprepository/index.php)</del>
                                        <ul>
                                                <li>δεν χρειάζεται και πολύ, δηλαδή αν δεν έχουμε να πούμε κάτι... έβαλα όμως αυτή τη σελίδα
                                        </ul>
                                        <li><del>ο αριθμός των αρχείων δίπλα στις κατηγορίες των files (public, private, LMS) και ο ολικός αριθμός των αρχείων (αυτός δίπλα στο πεδίο FILES) είναι λάθος και δεν αλλάζει με uploading καινούργιων αρχείων είτε στα private είτε στα public</del>
                                        <li>αν κατάλαβα σωστά στο πεδίο "Files in LMS courses" βλέπουμε τα αρχεία των courses του LMS? αν ναι δε λειτουργεί γιατί ας πούμε στο course "Πρώτο μάθημα πολυρυθμίας, σκάλες σε ΙΙ V I" στο οποίο έχω εγγραφεί υπάρχουν αρχεία (πχ "Τα 3 modes" που είναι μια jpeg στην πρώτη θεματική) που δεν εμφανίζονται
                                        <ul>
                                                <li>δεν ξέρω αν έχει νόημα αυτή η σελίδα... ψάχνοντας αρκετά στο Moodle δεν υπάρχει πουθενά κάτι τέτοιο... τα private files έχουν κάποιο νόημα αλλά τα αρχεία των μαθημάτων μάλλον όχι... ίσως αφαιρεθεί...
                                        </ul>
                                </ol>

                                Files:
                                <ol>
                                <li><del>το modification time είναι λάθος είτε στα uploaded στα privates είτε στα publics</del>
                                <li><del>το size είναι σε ΚΒ, όχι σε ΜΒ</del><br>
                                <li><del>πάτησα export to LMS σε ένα αρχείο που είχα ήδη ανεβάσει LMS και ενώ φαίνεται στο "Private files in LMS" του repository, στα "Private files" στο Moodle βγαίνει error (Cannot create file 657/user/draft/965703703/The Midas Touch (Hell Interface remix).mp3  /  Debug info: Duplicate entry 'cbd584087aa3d987d465ba50841a82251ec3a9aa' for key 'files.file_pat_uix' ). Μετά από αυτό νομίζω δεν μπορώ να ανεβάσω αρχεία απευθείας στο LMS ή να κάνω export άλλα αρχεία από το repository. Κάθε φορά που πατάω στα Private files (στο LMS) βγαίνει αυτό το error</del>
                                <ul>
                                        <li>table: files, type: draft, name='another.mid' &rArr; τα έσβησα και τώρα δείχνουν ΟΚ
                                </ul>
                                <li><del>στα metadata ενός αρχείου στο πεδίο "owner role" αντί για πχ. course creator βγαίνει το όνομα του user (πχ ta2238)</del>
                                <li><del>στο πεδίο genre στα metadata παίζει διπλή καταχώρηση για female vocalists</del>
                                </ol>

                                Upload Files:
                                <ol>
                                <li><del>παίζουν αναντιστοιχίες μεταξύ α) των επιτρεπτών τύπων αρχείων που αναφέρονται στο https://musicolab.hmu.gr/apprepository/uploadFileAjax.php (Select the section to upload to. The form accepts the following file types: midi, mei, json, wav, mp3, flac, avi, mkv) και β) των supported types που εμφανίζονται στο dialog box όταν πας να ανεβάσεις. Συγκεκριμένα στα supported υπάρχουν οι txt krn mxl musicxml τύποι που δεν αναφέρονται στην upload files σελίδα και αντίστροφα o json τύπος αναφέρεται στη σελίδα αλλά όχι στα supported.</del><br>
                                <li><del>τελικά μπορείς να ανεβάσεις ότι αρχείο θες ανεξάρτητα του ποιος τύπος επιτρέπεται</del>
                                <ul>
                                        <li>μόνο τα επιτρεπόμενα. Ενημερώθηκε η σελίδα
                                </ul>
                                </ol>

                                Search the Repository:
                                <ol>
                                        <li><del>η αναζήτηση είτε βάσει metadata είτε βάσει filename δε δουλεύει ούτε για private ούτε για public files</del><br>
                                        <ul>
                                                <li>απομένουν λίγα πεδία
                                        </ul>
                                        <li><del>μετά από μια αναζήτηση τα metadata αντί να εμφανίζονται κενά και έτοιμα για την επόμενη αναζήτηση παίρνουν αρίθμηση</del><br>
                                        <li><del>στα metadata της αναζήτησης υπάρχουν πεδία που δεν υπάρχουν όταν πατάς το κουμπί metadata ενός αρχείου (filetype, unfolded music, original melody)</del>
                                </ol>

                                Manage Tags:
                                <ol>
                                        <li><del>όταν προσθέτω tags σε private file, μετά το submit μου εμφανίζονται από πάνω σε ένα μπλε πλαίσιο (πχ #harmony). Ενώ σε public file δεν εμφανίζεται τέτοιο πλαίσιο</del>
                                </ol>
					</div>
				</div>
	
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

