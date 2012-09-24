<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html> 
	<head>
  <meta charset="utf-8">
	<title><?php echo APPNAME; ?> <?php echo VERSION; ?></title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<link rel="stylesheet" href="/min/f=css/site.css" />    
    
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="/min/f=js/jquery.mobile-1.1.0.js"></script>
</head> 

<body> 

<div data-role="page" id="menupage">

	<div data-role="header" data-theme="b">
		<h1><?php echo APPNAME; ?> <?php echo VERSION; ?></h1>
	</div><!-- /header -->

	<div data-role="content">
        <ul data-role="listview" data-theme="c">
	        <?php gen_map_links(); ?>
        </ul>
	</div><!-- /content -->
    
    <div data-role="footer" data-theme="c">   
	</div><!-- /footer -->

</div><!-- /page -->

</body>
</html>