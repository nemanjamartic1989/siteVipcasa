<?php

error_reporting(0); // Set E_ALL for debuging

if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set('Europe/Moscow');
}

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';

/**
 * Simple example how to use logger with elFinder
 **/
class elFinderLogger implements elFinderILogger {
	
	public function log($cmd, $ok, $context, $err='', $errorData = array()) {
		if (false != ($fp = fopen('./log.txt', 'a'))) {
			if ($ok) {
				$str = "cmd: $cmd; OK; context: ".str_replace("\n", '', var_export($context, true))."; \n";
			} else {
				$str = "cmd: $cmd; FAILED; context: ".str_replace("\n", '', var_export($context, true))."; error: $err; errorData: ".str_replace("\n", '', var_export($errorData, true))."\n";
			}
			fwrite($fp, $str);
			fclose($fp);
		}
	}
	
}

$opts = array(
	'root'            => '../../../files',                       // path to root directory
	'URL'             => 'http://www.europlan-uk.eu/files/', // root directory URL. It is best to set this to an absolute path.
	'rootAlias'       => 'Home',       // display this instead of root directory name
	'mimeDetect'   => 'internal',       // files mimetypes detection method (finfo, mime_content_type, linux (file -ib), bsd (file -Ib), internal (by extensions))

);

$fm = new elFinder($opts); 
$fm->run();

?>
