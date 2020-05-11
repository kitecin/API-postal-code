<?php 
	include_once("functions.php");
	if ($_POST){
		$code = $_POST['code'];
	}
	else{
		$code= "";
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
		<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
		<meta charset="UTF-8">
		<style>
			.map { 
				height: 500px;
				width: 500px;
			}
			.maping{
			display: inline-block;
			padding: 20;
			}
		</style>
	</head>
	<body>
		<form action="index.php" method="post">
			Post code: <input type="text" name="code" id="zipcode" placeholder="162-0041" value="<?php echo $code; ?>"> <input type="submit" value="Submit">
		</form>
		<?php include_once("update.php"); ?>
	</body>
</html>