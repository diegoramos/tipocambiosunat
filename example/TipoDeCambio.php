
<?php 

require '../vendor/autoload.php';

use Bitzua\Curl;

$refer  = 'https://www.sunat.gob.pe/';
$url 	= 'https://www.sunat.gob.pe/a/txt/tipoCambio.txt';
$curl 	= new cURL($refer, $url);
$getRes = $curl->getRequest();

$arr = explode('|', trim($getRes));

	$fecha  = \DateTime::createFromFormat("d/m/Y", trim($arr[0]));
	$result = [
		"fecha"  => trim($fecha->format("Y-m-d")),
		"compra" => trim($arr[1]),
		"venta"  => trim($arr[2]),
	];


echo "<pre>";
print_r ($result);
echo "</pre>";


?>

