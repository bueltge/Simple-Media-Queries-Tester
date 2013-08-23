<!DOCTYPE html> 
<html> 
<head> 
	<meta charset=utf-8 /> 
	
	<title>Simple Media Queries Tester</title> 
	
	<meta name="description" content="Simple Media Queries Tester" /> 
	<meta name="author" content="Frank Bueltge - http://bueltge.de" /> 
	<link rel="stylesheet" href="css/style.css" media="screen" />
	
</head> 
<body>
	<a id="github" href="https://github.com/bueltge/Simple-Media-Queries-Tester">
		<span>Fork me on GitHub!</span>
		<span>Get free lemonade!</span>
	</a>
	<?php
	$path_parts = explode('/', $_SERVER['PHP_SELF']);
	if ('test' === $path_parts[1])
		$path_parts = '<a href="http://bueltge.de">bueltge.de</a> &raquo; <a href="http://bueltge.de/' . $path_parts[1] . '/">' . $path_parts[1] . '</a> &raquo;';
	else
		$path_parts = $path_parts[0];
	?>
	<header>
		<?php if ( ! empty( $path_parts ) ) { ?>
		<nav><small>You are here: <?php echo $path_parts; ?></small></nav>
		<?php } ?>
		<h1><a href="http://bueltge.de/" title="to the weblog of the author">Simple Media Queries Tester</a></h1>
	</header>
	
	<section>
		<form id="mediaqueriestest" action="<?php echo htmlspecialchars( strip_tags($_SERVER['PHP_SELF']) ); ?>" method="get">
			<fieldset>
				<legend>Test your URL</legend>
				<p><label for="testurl">Address</label>
				<input type="text" name="testurl" id="testurl" value="<?php if ( isset($_GET['testurl']) ) echo htmlspecialchars( strip_tags($_GET['testurl']) ); ?>" placeholder="Input your test url here" size="70" /></p>
				<button class="button" type="submit">Test it!</button>
			</fieldset>
		</form>
		<div id="iframevalues">
			<fieldset>
				<legend>Set Values for iframes</legend>
				<p><label for="testurl">Mobile Width</label>
				<input type="text" name="iframe1width" value="" id="iframe1width"/></p>
				<p><label for="testurl">Tablet Width</label>
				<input type="text" name="iframe2width" value="" id="iframe2width"/></p>
				<p><label for="testurl">Notebook Width</label>
				<input type="text" name="iframe3width" value="1280" id="iframe3width"/></p>
				<p><label for="testurl">Desktop Width</label>
				<input type="text" name="iframe4width" value="1600" id="iframe4width"/></p>
				<p><label for="testurl">Height</label>
				<input type="text" name="iframeheight" value="450" id="iframeheight"/></p>
				<button class="button" onclick="javascript:location.reload(true);" type="submit">Set values!</button>
				<button class="button" onclick="javascript:localStorage.clear();javascript:location.reload(true);" type="reset" class="clear">Clear storage</button>
			</fieldset>
		</div>
		<?php
		if ( !empty($_GET['testurl']) ) {
			$newURL = htmlspecialchars( strip_tags($_GET['testurl']), ENT_QUOTES );
			if ( preg_match( "/^(www.)/i", $newURL ) )
				$iframeurl = 'http://'.$newURL;
			elseif ( preg_match( "/^(http:\/\/)/i", $newURL ) )
				$iframeurl = $newURL;
			else
				$iframeurl = 'http://www.' . $newURL;
			
		?>
		<div class="flex">
			<div>
			<strong>Flex <small id="iframe0widthtxt">(width&#x00D7;height)</small></strong><br>
			<a href="#" class="button" onclick="resize_iframe( 'flexframe', 240, 500 )">S 240&#x00D7;500px</a> 
			<a href="#" class="button" onclick="resize_iframe( 'flexframe', 500, 800 )">M 500&#x00D7;800px</a> 
			<a href="#" class="button" onclick="resize_iframe( 'flexframe', 800, 1200 )">L 800&#x00D7;1200px</a> 
			<a href="#" class="button" onclick="resize_iframe( 'flexframe', 1200, 1920 )">XL 1200&#x00D7;1920px</a>
			<a href="#" class="button" onclick="set_disco_mode( 'flexframe' )">Disco</a>
			</div>
			<iframe name="flex" id="flexframe" seamless="seamless" width="240" height="300" src="<?php echo $iframeurl; ?>"></iframe>
		</div>
		<hr>
		<?php
			echo '<div class="mobile"><strong>Mobile <small id="iframe1widthtxt"> </small></strong><br><iframe name="mobile" id="iframe1widthiframe" seamless="seamless" src="' . $iframeurl . '"></iframe></div>';
			echo '<div class="tablet"><strong>Tablet <small id="iframe2widthtxt"> </small></strong><br><iframe name="tablet" id="iframe2widthiframe" seamless="seamless" src="' . $iframeurl . '"></iframe></div>';
			echo '<div class="notebook"><strong>Notebook <small id="iframe3widthtxt"> </small></strong><br><iframe name="notebook" id="iframe3widthiframe" seamless="seamless" src="' . $iframeurl . '"></iframe></div>';
			echo '<div class="desktop"><strong>Desktop <small id="iframe4widthtxt"> </small></strong><br><iframe name="desktop" id="iframe4widthiframe" seamless="seamless" src="' . $iframeurl . '"></iframe></div>';
			
		} else {
			echo '<p class="empty">No page loads - Enter address!</p>';
		}
		?>
		<aside>
			<p>i: See also my <a href="http://bueltge.de/test/media-query-debugger.php" title="see the Media Queries Debugger live">Simple Media Queries Debugger</a></p>
		</aside>
	</section>
	
	<footer>
		<p>
		&copy; 2010 - <?php echo date('Y'); ?> <a href="http://bueltge.de/">bueltge.de</a> &middot; <a href="http://bueltge.de/impressum/">Imprint / Impressum</a> &middot; Blogpost about the Simple Media Queries Tester <a href="http://bueltge.de/simple-media-queries-tester/1239/">german</a> | <a href="http://wpengineer.com/2160/simple-media-queries-tester/">english</a>
		</p>
	</footer>
	
	<script src="./js/h5utils.js"></script>
	<script>
		var id,
		    height = 800,
		    width,
		    min = 240,
		    max = 1900,
		    rwidth,
		    renew,
		    intm;
		
		function resize_iframe( id, width, height ) {
			
			kill_disco_mode( renew );
			
			document.getElementById( id ).height = height + "px";
			document.getElementById( id ).width  = width + "px";
		}
		
		// disco mode id a idea from Brad Frost
		// @see http://bradfrostweb.com/demo/ish/
		function set_disco_mode( id ) {
			
			renew = setInterval( function() {
				
				rwidth = Math.floor( Math.random() * ( max - min + 1 ) ) + min;
				
				document.getElementById( id ).width = rwidth + "px";
				document.getElementById(id).height  = height + "px";
				
			}, 500 );
		}
		
		function kill_disco_mode( intm ) {
			
			clearInterval( intm );
			intm = false;
		}
		
		// get storage
		function getStorage( type, element, normal ) {
			
			var storage = window[type + 'Storage'];
			var width = storage.getItem(element);
			if (! width) width = normal;
			var height = storage.getItem('iframeheight');
			if (! height) height = 450;
			var txt = '(' + width + '×' + height + ')';
			
			document.getElementsByName(element)[0].value = width;
			document.getElementsByName('iframeheight')[0].value = height;
			//alert(document.getElementById(element+'txt'));
			if ( document.getElementById(element+'txt') !== null ) {
			document.getElementById(element + 'txt').firstChild.appendData(txt);
			document.getElementById(element + 'iframe').setAttribute("width", width);
			document.getElementById(element + 'iframe').setAttribute("height", height);
			}
		}
		// set storage
		function setStorage(type, element) {
			var storage = window[type + 'Storage'];
			
			addEvent(document.querySelector('#' + element), 'keyup', function () {
				storage.setItem(element, this.value);
			});
			
		}
		
		setStorage('local', 'iframe1width');
		setStorage('local', 'iframe2width');
		setStorage('local', 'iframe3width');
		setStorage('local', 'iframe4width');
		setStorage('local', 'iframeheight');
		
		getStorage('local', 'iframe1width', '320');
		getStorage('local', 'iframe2width', '768');
		getStorage('local', 'iframe3width', '1280');
		getStorage('local', 'iframe4width', '1600');
	</script>
	<script src="http://bueltge.de/mv/?js"></script>
	
</body>
</html>
