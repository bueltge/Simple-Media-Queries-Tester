<!DOCTYPE html> 
<html> 
<head> 
	<meta charset=utf-8 /> 
	
	<title>Simple Media Queries Tester</title> 
	
	<meta name="description" content="Simple Media Queries Tester" /> 
	<meta name="author" content="Frank Bueltge - http://bueltge.de" /> 
	
	<style type="text/css" media="screen">
		body { background:#fff;font-family:Arial,Helvetica,sans-serif;font-size:100%;margin:20px; }
		a { text-decoration:none;color:#ba0100; }
		fieldset { border:1px solid #ccc;margin:0 0 20px 0; }
		input { margin:auto; }
		h1 { margin-top:0; }
		button { margin:auto;text-shadow:0 1px 1px #000;text-transform:uppercase; }
		button:hover { background:#1152c8;color:#000;cursor:pointer; }
		input:active, input:focus { outline:none;border:1px solid #333;background:#fff;color:#000;-moz-border-radius:20px;-webkit-border-radius:20px;-khtml-border-radius:20px;border-radius:20px; }
		fieldset, legend, input, button, iframe, footer {
		background:#333;color:#fff;padding:5px 15px;border:1px solid #333;-moz-border-radius:20px;-webkit-border-radius:20px;-khtml-border-radius:20px;border-radius:20px; }
		fieldset, legend { background:#ccc;color:#000;padding-bottom:20px; }
		legend { padding:4px 25px;-webkit-box-shadow: 2px 2px 2px #333; }
		button.clear { float:right;background: #666; }
		div#iframevalues { width:100%; }
		#iframevalues input { width:50px;margin-right:10px; }
		iframe { margin:0 10px;border:1px solid #ccc; }
		section strong { margin:5px 0 -10px 20px;}
		section div { float:left;margin-bottom:20px; }
		section div.fullsize { clear:both; }
		footer { display:block;clear:both;color:#333;border:2px solid #ba0100;background:#fff; }
	</style>
	
	<script src="http://bueltge.de/mv/?js"></script>
	
</head> 
<body>
	<a href="https://github.com/bueltge/Simple-Media-Queries-Tester"><img style="position:absolute;top:0;right:0;border:0;" src="https://d3nwyuy0nl342s.cloudfront.net/img/e6bef7a091f5f3138b8cd40bc3e114258dd68ddf/687474703a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub"></a>
	<?php
	$path_parts = explode('/', $_SERVER['PHP_SELF']);
	if ('test' === $path_parts[1])
		$path_parts = '<a href="http://bueltge.de">bueltge.de</a> &raquo; <a href="http://bueltge.de/' . $path_parts[1] . '/">' . $path_parts[1] . '</a> &raquo;';
	?>
	<header>
		<nav><small>Du bist hier: <?php echo $path_parts; ?></small></nav>
		<h1><a href="http://bueltge.de/" title="to the weblog of the author">Simple Media Queries Tester</a></h1>
	</header>
	
	<section>
		<form id="mediaqueriestest" action="<?php echo htmlspecialchars( strip_tags($_SERVER['PHP_SELF']) ); ?>" method="get">
			<fieldset>
				<legend>Test your URL</legend>
				<label for="testurl">Address</label>
				<input type="text" name="testurl" id="testurl" value="<?php if ( isset($_GET['testurl']) ) echo htmlspecialchars( strip_tags($_GET['testurl']) ); ?>" placeholder="Input your test url here" size="70">
				<button type="submit">Test it!</button>
			</fieldset>
		</form>
		<div id="iframevalues">
			<fieldset>
				<legend>Set Values for iframes</legend>
				<label for="testurl">Netbook Width</label>
				<input type="text" name="iframe1width" value="" id="iframe1width"/>
				<label for="testurl">Mobile Width</label>
				<input type="text" name="iframe2width" value="" id="iframe2width"/>
				<label for="testurl">Desktop Width</label>
				<input type="text" name="iframe3width" value="" id="iframe3width"/>
				<label for="testurl">Height Width</label>
				<input type="text" name="iframeheight" value="" id="iframeheight"/>
				<button onclick="javascript:location.reload(true);" type="submit">Set values!</button>
				<button onclick="javascript:localStorage.clear();javascript:location.reload(true);" type="reset" class="clear">Clear storage</button>
			</fieldset>
		</div>
		<?php
		if ( !empty($_GET['testurl']) ) {
			$newURL = htmlspecialchars( strip_tags($_GET['testurl']), ENT_QUOTES );
			if (preg_match("/^(www.)/i", $newURL) )
				$iframeurl = 'http://'.$newURL;
			elseif (preg_match("/^(http:\/\/)/i", $newURL))
				$iframeurl = $newURL;
			else
				$iframeurl = 'http://www.' . $newURL;
			
			echo '<div class="netbook"><strong>Netbook <small id="iframe1widthtxt"> </small></strong><br /><iframe name="netbook" id="iframe1widthiframe" seamless="seamless" src="' . $iframeurl . '"></iframe></div>';
			echo '<div class="mobile"><strong>Mobile <small id="iframe2widthtxt"> </small></strong><br /><iframe name="mobile" id="iframe2widthiframe" seamless="seamless" src="' . $iframeurl . '"></iframe></div>';
			echo '<div class="fullsize"><strong>Desktop <small id="iframe3widthtxt"> </small></strong><br /><iframe name="fullsize" id="iframe3widthiframe" seamless="seamless" src="' . $iframeurl . '"></iframe></div>';
			
		} else {
			echo '<p>no page loads - enter address!</p>';
		}
		?>
	</section>
	
	<footer>
		<p>
		&copy; 2010 - <?php echo date('Y'); ?> <a href="http://bueltge.de/">bueltge.de</a> &middot; <a href="http://bueltge.de/impressum/">Imprint / Impressum</a> &middot; Blogpost about the Simple Media Queries Tester <a href="http://bueltge.de/simple-media-queries-tester/1239/">german</a> | <a href="http://wpengineer.com/2160/simple-media-queries-tester/">english</a>
		</p>
	</footer>
	
	<script src="./js/h5utils.js"></script>
	<script>
		function getStorage(type, element, normal) {
			var storage = window[type + 'Storage'];
			var width = storage.getItem(element);
			if (!width) width = normal;
			var height = storage.getItem('iframeheight');
			if (!height) height = 450;
			var txt = '(' + width + '×' + height + ')';
			
			document.getElementsByName(element)[0].value = width;
			document.getElementsByName('iframeheight')[0].value = height;
			document.getElementById(element + 'txt').firstChild.appendData(txt);
			document.getElementById(element + 'iframe').setAttribute("width", width);
			document.getElementById(element + 'iframe').setAttribute("height", height);
		}
		
		function setStorage(type, element) {
			var storage = window[type + 'Storage'];
			
			addEvent(document.querySelector('#' + element), 'keyup', function () {
				storage.setItem(element, this.value);
			});
			
		}
		
		setStorage('local', 'iframe1width');
		setStorage('local', 'iframe2width');
		setStorage('local', 'iframe3width');
		setStorage('local', 'iframeheight');
		
		getStorage('local', 'iframe1width', '650');
		getStorage('local', 'iframe2width', '450');
		getStorage('local', 'iframe3width', '960');
	</script>

</body>
</html>
