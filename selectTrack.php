<html>
	<head>
	 <script language='javascript'>
                var files = [<?
                                $con = mysqli_connect("localhost", "", "", "");
                                $sql = "select * from metadata where filename like '%/courses/".$_GET['id']."/%'";
                                $res = $con->query($sql);
                                $count = 1;
                                while($row = mysqli_fetch_assoc($res)){
                                        $tmp = substr($row['filename'],strrpos($row['filename'],"/")+1);
                                        if($count < $res->num_rows){
                                                echo "\"".$tmp."\",";
                                        }else{
                                                echo "\"".$tmp."\"";
                                        }
                                        $count++;
                                }
                ?>];

		function selectThisFile(fname){
			//var t = confirm("are you sure?");
			//if(t){
				window.opener.setTheValue(fname);
				//}
				//
			window.close();
		}
        </script>
	</head>
	<body>
		please select a single file from the list<br>
		<hr>
		<table class='table table-hover table-sm'>
			<tr>
			<th>#</th>
			<th>filename</th>
			</tr>
			<?
			$a = $_GET['a'];
			$b = $_GET['b'];
			$con = mysqli_connect("localhost", "", "", "");
                        $sql = "select * from metadata where filename like '%/courses/".$_GET['id']."/%' and filename not like '%jams' order by filename asc";
			if($a=="true"){
				$sql = "select * from metadata where filename like '%/courses/".$_GET['id']."/%' and filename like '%krn' and filename not like '%jams' order by filename asc";
			}else if($b=="true"){
				$sql = "select * from metadata where filename like '%/courses/".$_GET['id']."/%' and filename not like '%krn' and filename not like '%jams' order by filename asc";
			}
                        $res = $con->query($sql);
                        $count = 1;
                        while($row = mysqli_fetch_assoc($res)){
				$tmp = substr($row['filename'],strrpos($row['filename'],"/")+1);
			?>
				<tr>
				<td><?echo $count?></td>
				<td>
				<a href="javascript:selectThisFile('<?echo $tmp?>');"><?echo $tmp?></a><br>
				</td>
				</tr>
		<?
                                $count++;
                        }
		?>
		</table>
	</body>
</html>
