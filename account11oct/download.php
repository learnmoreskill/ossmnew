<?php 
if (isset($_GET['file'])) 
{
		$path = 'http://localhost:100/new_account/images/expenses_file/'.$_GET['file'];
		
		$size = filesize($path);
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.$size);
		header('Content-Disposition: attachment; filename="'.basename($path).'"');
		readfile($path);
}
?>