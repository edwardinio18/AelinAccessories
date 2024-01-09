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

	<h1 class="page_main_label" id="page_main_label_change_password">Change Password</h1>

	<div class="main_outer_account_settings_div">
			
		<form action="" method="POST" class="log_in_form">

			<label for="old_password" class="form_input_label">Old Password</label>

			<?php

				if ($emptyOldPassword !== "") {

					echo $emptyOldPassword;

				}

			?>

			<input type="password" name="old_password" class="form_input" maxlength="50" />

			<label for="new_password" class="form_input_label">New Password</label>

			<?php

				if ($emptyNewPassword !== "") {

					echo $emptyNewPassword;

				}

			?>

			<input type="password" name="new_password" class="form_input" maxlength="50" />

			<label for="new_confirm_password" class="form_input_label">Confirm New Password</label>

			<?php

				if ($emptyConfirmNewPassword !== "") {

					echo $emptyConfirmNewPassword;

				}

			?>

			<input type="password" name="new_confirm_password" class="form_input" maxlength="50" />

			<input type="submit" name="change_password" class="log_in_submit" value="Change password" />

		</form>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/account_settings'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>