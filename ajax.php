<?php
header('Content-Type: application/json');
require_once('post.php');

$result = array();

if (!$error) {
	$result['success'] = true;
} else {
	$result['success'] = false;
}

$result['id'] = format_output($id, 10, 10);
$result['facility'] = $facility;
$result['pin'] = $pin;
$result['hex'] = format_output($hex, 2, 10, ($known['bits']/4), ($known['padding']/4));
if ($_POST['method'] == 'id' || $_POST['method'] == 'hid') {
	$result['dec'] = 'Not Available';
} else {
	$result['dec'] = format_output($dec, 4, 12);
}
$result['bin'] = format_output($bin, 8, 40, $known['bits'], $known['padding']);

$result['bin_size'] = $bin_size;

echo json_encode($result);
?>