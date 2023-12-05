<? session_start(); ?>
<!DOCTYPE html>
<html lang="el" itemscope itemtype="http://schema.org/WebPage">
<head>
	<?include 'headerHtml2.php'?>
        <script language='javascript'>
        	function doit(){
                	if(confirm('παρακαλώ επιβεβαιώστε την έξοδό σας από το σύστημα')){
                        	document.getElementById("theform").submit();
                        }
        	}
        </script>

</head>
<body class="page-template-default page page-id-52 theme-kayo wolf-events kayo wolf-playlist-manager wolf-visual-composer wvc-3-6-4 wvc-not-edge wvc-is-firefox woocommerce-no-js mobile-menu-alt wolf session-loaded not-edge page-title-funding loading-animation-type-none site-layout-wide button-style-square global-skin-default menu-layout-top-right menu-style- menu-skin-light menu-width-boxed mega-menu-width-boxed menu-hover-style-opacity menu-sticky-hard submenu-bg-dark accent-color-dark accent-color-is-black no-menu-cta menu-items-visibility- no-hero hero-font-light body-font- heading-font- menu-font- submenu-font- transition-animation-type- logo-visibility- has-wvc hero-layout-none post-is-title-text post-is-hero footer-type- footer-skin-dark footer-widgets-layout-4-cols footer-layout-boxed bottom-bar-layout-centered bottom-bar-visible no-404-plugin wpb-js-composer js-comp-ver-6.4.1 vc_responsive &quot; data-hero-font-tone=&quot;light">

	<? include 'header2.php' ?>
	<?
                        if(isset($_POST['userToLogout'])){
                                $_SESSION['USER']='';
                                header("Location: https://musicolab.hmu.gr/apprepository/index.php");
                        }
                        ?>
                        <br>
                        <?
                        if(isset($_SESSION["USER"]->username)){
                        ?>
                        	<h3 style=''>MusiCoLab file repository / logout</h3>
				<br>
                                <?
                                if(!isset($_SESSION['USER'])){
                                }else{
                                ?>
                                        <form action='logout.php' id='theform' method='post'>
                                                <input type='button' value='LOGOUT' onclick='doit();'>
                                                <input type='hidden' name='userToLogout' value='logout'/>
                                        </form>
                                <br>
                                <?
                                }
                       }
         ?>

</div><!--.wvc-row-wrapper-->
</div>

<? include 'footer2.php'?>

</body>
</html>

