<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");

	if (!isset($_SESSION["user"])) {

		header("Location: /" . basename(__DIR__) . "/log_in");

	}

?>

<!DOCTYPE html>

<html lang="en">

<head>

	<?php

		require_once realpath(dirname(__FILE__) . "/snippets/header.php");

	?>

</head>

<body>

	<?php

		require_once realpath(dirname(__FILE__) . "/snippets/nav_bar.php");

	?>

	<?php

		if (isset($_GET["shipping_details_edited"]) && isset($_GET["selector"]) && isset($_GET["token"])) {

			if ($_GET["shipping_details_edited"] === "successfully") {

				if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

					echo '<div class="email_sent_outer_div overlay_helper_drop_div">
		
							<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

							<p class="email_sent_successfully_message">Your shipping details have been successfully updated!</p>
							
						</div>';

				}

			}

		}

	?>

	<h1 class="page_main_label">Settings</h1>

	<div class="main_outer_account_settings_div">

		<div class="inner_outer_main_account_settings_buttons_div">
			
			<div class="account_settings_button_div">
			
				<button class="account_settings_div_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/change_password'">Change Password</button>

				<button class="account_settings_div_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/edit_shipping_details'">Edit Shipping Details</button>

				<button class="account_settings_div_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/delete_account'">Delete Account</button>

			</div>

		</div>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/profile'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>