<?php header("HTTP/1.0 ".$errorno." ".$errorstatus); ?>
<!DOCTYPE html> 
<html> 
<head>
	<meta charset="utf-8">
	<title><?php echo $errorno; ?></title>
</head>
<body>
    <h1>Error - <?php echo $errorno; ?></h1>
    <p>
        <?php echo $errormessage; ?>
    </p>
</body>
</html>