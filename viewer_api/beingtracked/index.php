<?php

require_once 'Functions.php';

$fun = new Functions();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

echo $fun -> fetchData();

}

?>
