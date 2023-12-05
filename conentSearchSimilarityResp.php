<? session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
		<?include 'headerHtml.php'?>
		<style>
			#zipSizeBar{
				background-color:red;
				width:100%;
				transition: width 2s;
				transition-timing-function: linear; 
				border: 1px solid black;
			}
			.loader {
				border: 10px solid #f3f3f3;
				border-radius: 50%;
				border-top: 10px solid #3498db;
				width: 30px;
				height: 30px;
				-webkit-animation: spin 2s linear infinite; /* Safari */
				animation: spin 2s linear infinite;
			}
			@keyframes spin{
				0% { transform:rotate(0deg); }
				100% { transform:rotate(360deg); }
			}
		</style>
		<script>
			function runTransitions(){
				zipsizebar = document.getElementById("zipSizeBar");
				zipsizebar.width = '100%';
			}
			function stopLoader(){
				loader = document.getElementById("loader");
				setTimeout(loader.style.visibility='hidden', 4000);
				submitBtn = document.getElementById("submitButton");
				submitBtn.style.visibility='visible';
				runTransitions();
			}

			function upload(){
				form = document.getElementById("theform");
    				thefile = document.getElementById("f");
				folder = document.getElementById("ufolder");

    				doit = true;
				if(folder.options[folder.selectedIndex].value=="") {
					alert("please select the section to upload to");
					doit = false;
				}else{
					if(thefile.value==""){
						alert("please select a local file to upload");
						doit = false;
					}
				}

    				if(doit){
     					conf = confirm("please confirm the submission");
     					loader = document.getElementById("loader");
     					loader.style.visibility='visible';
     					submitBtn = document.getElementById("submitButton");
     					submitBtn.style.visibility='hidden';
     					form.submit();
    				}
			}
		</script>
  </head>
  <body onload='stopLoader()'>
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
				<h3>repository / file upload / result</h3>
				<?
				$err = "noerr";

				if(!isset($_POST['action'])){
					echo "invalid state, please contact the admins<br>";
                                }else{
					if($_POST['action']=="upload"){
						//echo "<font color='red'>starting the upload</font><br>";
						//echo "<font color='red'>uploading to <b>".$_POST['ufolder']."</b></font><br>";
						$targetDir = "/var/www/moodledata/repository/";
						$targetFile = $targetDir . $_SESSION["USER"]->username; //basename($_FILES["f"]["name"]);
						echo "target = ".$targetFile."<br>";
						if(move_uploaded_file($_FILES['f']["tmp_name"], $targetFile)){
							echo "<font color='red'>uploaded ".basename($_FILES["f"]["name"])." sucessfully</font><br>";
						}else{
							echo "<font color='red'>upload error</font><br>";
							$err = "error";
						}
                                        }
				}
				}
				?>
			</div>
		</div>

		<?include 'footer.php'?>
	</div>
  </body>
</html>

