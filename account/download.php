<?php 
if (isset($_GET['file'])) 
{
		$path = 'schoolfile/'.$_GET['file'];
		
		$size = filesize($path);
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.$size);
		header('Content-Disposition: attachment; filename="'.basename($path).'"');
		readfile($path);
}
?>