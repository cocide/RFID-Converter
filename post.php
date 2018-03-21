<?php
$known['bits'] = 0;
$known['padding'] = 0;
$error = false;
$bin = 0;

if ($_POST['method'] == 'hex') {
	$bin = base_convert($_POST['rfid'], 16, 2);
	$known['bits'] = strlen(preg_replace("/[^0-9a-fA-F]/", "", $_POST['rfid'])) * 4;
} elseif ($_POST['method'] == 'dec') {
	$bin = base_convert($_POST['rfid'], 10, 2);
	$known['bits'] = strlen(base_convert(substr($_POST['rfid'], 0, 1).str_repeat('9', (strlen(preg_replace("/[^0-9]/", "", $_POST['rfid'])) - 1) ), 10, 2)) - 1;
}  elseif ($_POST['method'] == 'bin') {
	$bin = preg_replace("/[^0-1]/", "", $_POST['rfid']);
	$known['bits'] = strlen($bin);
} 
elseif ($_POST['method'] == 'id') {
	$bin = base_convert(substr($_POST['rfid'], -8), 10, 2);
	$known['bits'] = strlen(base_convert(substr($_POST['rfid'], 0, 1).str_repeat('9', (strlen(preg_replace("/[^0-9]/", "", $_POST['rfid'])) - 1) ), 10, 2)) - 1;
	if (preg_replace("/[^0-9]/", "", $_POST['rfid']) > 16777215) {
		$error = true;
	}
} elseif ($_POST['method'] == 'hid') {
	$parts = explode(',', preg_replace("/[^0-9]+/", ",", preg_replace("/^[^0-9]+/", "", $_POST['rfid'])));
	$bin = str_pad(base_convert($parts[0], 10, 2), 8, '0', STR_PAD_LEFT).str_pad(base_convert($parts[1], 10, 2), 16, '0', STR_PAD_LEFT);
	$known['bits'] = strlen($bin);
	if (count($parts) != 2 || $parts[0] == 0 || $parts[1] == 0 || $parts[0] > 255 || $parts[1] > 65535) {
		$error = true;
	}
}


if (strlen($bin) > 40) {
	$error = true;
} 

$dec = base_convert($bin, 2, 10); //convert it to decimal
$hex = strtoupper(base_convert($bin, 2, 16)); //convert it to hex too

$section = substr(str_pad($bin, 30, '0', STR_PAD_LEFT), -24); // we only care about the last 24 bits
$id = base_convert($section, 2, 10);

$facility = base_convert(substr($section, 0, 8), 2, 10);//the first 8 bits of the last 24 are the facility
$pin = base_convert(substr($section, 8, 16), 2, 10);//bits 9-24 of the last 24 are the pin


function format_output ($data, $chunk_size = 8, $length = 0, $known_characters = 0, $known_padding = 0) {
	$data = preg_replace("/[^0-9a-fA-F]/", "", $data);
	$output = '';
	
	$data = str_pad($data, $length, 0, STR_PAD_LEFT);
	if (strlen($data) >= $known_characters) {
		$data = substr($data, (0-$known_characters));
	}
	$data = str_pad($data, $length, 'X', STR_PAD_LEFT);

	if ($known_padding > 0) {
		$data = substr($data, 0, (0-$known_padding));
		$data = str_pad($data, $length, 'X', STR_PAD_RIGHT);
	}

	while (strlen($data) > 0) {
		$output = substr($data, (0-$chunk_size)).(strlen($output)?' ':null).$output;
		$data = substr($data, 0, (0-$chunk_size));
	}
	$output = str_replace('X', '&middot;', $output);
	return $output;
}

?>
