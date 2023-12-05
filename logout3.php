<? session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<? include 'headerHtml3.php' ?>
	</head>
		<? include 'header3.php' ?>
		<?
                        if(isset($_POST['userToLogout'])){
                                $_SESSION['USER']='';
                                header("Location: https://musicolab.hmu.gr/apprepository/index.php");
                        }
                        if(isset($_SESSION["USER"]->username)){
                        ?>
	                                <h3 style=''>MusiCoLab file repository / logout</h3>
        	                        <br>
                                        <form action='logout.php' id='theform' method='post'>
                                                <input type='button' value='LOGOUT' onclick='doit();'>
                                                <input type='hidden' name='userToLogout' value='logout'/>
                                        </form>
                       			<br>
                       <?
                       }
		?>
		<? include 'footer3.php' ?>

