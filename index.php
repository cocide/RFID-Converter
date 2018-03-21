<?php
require_once ('post.php');
if(!@include_once ('parsedown/Parsedown.php')) {
	$error = 'Unable to include Parsedown!<br>Please pull submodules.<br><code>git submodule update --init</code>';
} else {
	$parsedown = new Parsedown();
	$readme = $parsedown->text(file_get_contents('README.md'));
}
?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="favicon/favicon.ico">
	<link rel="icon" sizes="16x16 32x32 64x64" href="favicon/favicon.ico">
	<link rel="icon" type="image/png" sizes="196x196" href="favicon/favicon-192.png">
	<link rel="icon" type="image/png" sizes="160x160" href="favicon/favicon-160.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96.png">
	<link rel="icon" type="image/png" sizes="64x64" href="favicon/favicon-64.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16.png">
	<link rel="apple-touch-icon" href="favicon/favicon-57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/favicon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/favicon-72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/favicon-144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/favicon-60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/favicon-120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/favicon-76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/favicon-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon-180.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="favicon/favicon-144.png">
	<meta name="msapplication-config" content="favicon/browserconfig.xml">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Space+Mono" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	
	<title>RFID Converter</title>
	<style>
		html, body {
			height: 100%;
		}

		body {
			display: -ms-flexbox;
			display: -webkit-box;
			display: flex;
			-ms-flex-align: center;
			-ms-flex-pack: center;
			-webkit-box-align: center;
			align-items: center;
			-webkit-box-pack: center;
			justify-content: center;
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #343a40;
			font-family: 'Space Mono', monospace;
		}

		a:link, a:visited, a:hover, a:active {
			color: inherit;
		}

		.container {
			width: 100%;
			max-width: 470px;
			padding: 15px;
			margin: 0 auto;
		}

		.container .checkbox {
			font-weight: 400;
		}

		.container .form-control {
			position: relative;
			box-sizing: border-box;
			height: auto;
			padding: 10px;
			font-size: 16px;
		}

		.card-footer {
			font-size: 70%;
			padding: .25rem .50rem;
		}

		.table {
			margin-bottom: 0;
		}

		.table td {
			vertical-align: text-bottom;
		}

		td.data {
			width: 255px;
			font-size: 80%;
			font-weight: 400;
		}

		#method {
			width: 80px;
			flex: none;
		}

		#rfid {
			flex: auto;
		}

		#help .modal-body h3 {
			font-size: 1.5em;
		}

		#help .modal-body h4 {
			font-size: 1.24em;
		}

		.small-icon {
			font-size: 1em;
			margin-top: 4px;
		}

	</style>
	<script>
		$(document).ready(function () {
			$("input").on('input', function() {
				convert_card();
			});
			$("select").on('change', function() {
				convert_card();
			});
			$('#rfid').keydown(function (e) {
				if (e.keyCode == 13) {
					e.preventDefault();
					convert_card();
					return false;
				}
			})
		});
		function convert_card() {
			$.ajax({
				type: "POST",
				url: "/ajax.php",
				data: $('form#RFID').serialize(),
				success: function(data){
					console.log(data);
					if (data.success) {
						$('span.data').each(function(){
							$("#"+this.id).html(data[this.id]);
						});
						$("#results").removeClass("d-none");
						$("#error-results").addClass("d-none");
						$("#error-data").addClass("d-none");
					} else {
						$("#results").addClass("d-none");
						$("#error-data").addClass("d-none");
						$("#error-results").removeClass("d-none");
					}
				},
				error: function(){
					$("#results").addClass("d-none");
					$("#error-data").removeClass("d-none");
					$("#error-results").addClass("d-none");
				}
			});
		}
	</script>
</head>
<body>
	<div class="container">
		<?php
		if (strlen($error)) {
			echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
		}
		?>
		<div class="card" >
			<div class="card-header text-center">
				RFID Converter
				<?php
				if (strlen($readme)) {
					echo '<i class="fas fa-info-circle close small-icon" data-toggle="modal" data-target="#help"></i>';
				}
				?>
			</div>
	 		<div class="card-body">
				<form method="POST" id="RFID">

					<div class="input-group">
						<select class="custom-select" id="method" name="method" >
							<option value="id" <?php echo ($_POST['method'] == 'id'?'selected':null)?>>ID#</option>
							<option value="hid" <?php echo ($_POST['method'] == 'hid'?'selected':null)?>>HID</option>
							<option value="hex" <?php echo ($_POST['method'] == 'hex'?'selected':null)?>>Hex</option>
							<option value="dec" <?php echo ($_POST['method'] == 'dec'?'selected':null)?>>Dec</option>
							<option value="bin" <?php echo ($_POST['method'] == 'bin'?'selected':null)?>>Bin</option>
						</select>
						<input type='text' name='rfid' id="rfid" value='<?php echo $_POST['rfid'];?>' autofocus>
					</div>
				</form>
				<table id="results" class="table">
					<tr><td class="text-right">ID Number:</td><td class="data"><span class="data" id="id"><?php echo format_output($id, 10, 10);?></span></td></tr>
					<tr><td class="text-right">HID Format:</td><td class="data"><?php echo 'Facility:&nbsp;<span class="data" id="facility">'.$facility.'</span>, PIN:&nbsp;<span class="data" id="pin">'.$pin.'</span>';?></td></tr>
					<tr><td class="text-right">Hexadecimal:</td><td class="data"><span class="data" id="hex"><?php echo format_output($hex, 2, 10, ($known['bits']/4), ($known['padding']/4));?></span></td></tr>
					<tr><td class="text-right">Decimal:</td><td class="data"><span class="data" id="dec"><?php echo ($method == 'id' || $method == 'hid'?'Not Available':format_output($dec, 4, 12));?></span></td></tr>
					<tr><td class="text-right">Binary:</td><td class="data"><span class="data" id="bin"><?php echo format_output($bin, 8, 40, $known['bits'], $known['padding']);?></span></td></tr>
				</table>
				<div id="error-results" class="alert alert-danger d-none" role="alert">
					Invalid Data Entered.
				</div>
				<div id="error-data" class="alert alert-danger d-none" role="alert">
					Server Error.
				</div>
			</div>
			<div class="card-footer text-muted text-center">
				version 2018.03.21 <a href="https://github.com/cocide/RFID-Converter" target="_blank"><i class="fas fa-code-branch"></i></a>
			</div>
		</div>
	</div>
	<!-- Help Modal -->
	<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center">Help</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body small">
					<?php echo $readme ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

