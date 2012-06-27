<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html> 
	<head> 
	<title>Gongmaps v1.0</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include('parts\pagescripts.php');?>
</head> 

<body> 

<div data-role="page" id="menupage">

	<div data-role="header" data-theme="b">
		<h1>Gongmaps V1.0</h1>
	</div><!-- /header -->

	<div data-role="content">
        <ul data-role="listview" data-theme="c">
	        <?php genmaplinks(); ?>
        </ul>
	</div><!-- /content -->
    
    <div data-role="footer" data-theme="c">   
	</div><!-- /footer -->

</div><!-- /page -->

<div data-role="page" id="mappage">

<script type="text/javascript">
<?php genpolygons();?>
</script>

	<div data-role="header" data-theme="b">
    <a data-transition="flow" href="index.php" data-icon="home">Home</a>
		<h1 id="title">Map 1</h1>
	</div><!-- /header -->

	<div data-role="content">	
    <div id="location"></div>
		<div id="gmap_canvas"></div>
	</div><!-- /content -->
    
    <div data-role="footer" data-theme="c" class="ui-bar">
        <div class="ui-grid-a">
            <div class="ui-block-a">
                <label for="flip-dnc">Show DNC's</label>
                <select name="slider" id="flip-dnc" data-role="slider" data-mini="true" data-theme="c">
                    <option value="off">Off</option>
                    <option value="on">On</option>
                </select>
            </div>   
            <div class="ui-block-b">   
                <label for="flip-tracking">Tracking</label>
                <select name="slider" id="flip-tracking" data-role="slider" data-mini="true" data-theme="c">
                    <option value="off">Off</option>
                    <option value="on">On</option>
                </select>
            </div>
        </div>
	</div><!-- /footer -->

</div><!-- /page -->

</body>
</html>