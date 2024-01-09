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

	<h1 class="page_main_label" id="page_main_label_change_password">Delete Account</h1>

	<div class="main_outer_account_settings_div">
			
		<form action="" method="POST" class="log_in_form">

			<label for="email" class="form_input_label">Email</label>

			<?php

				if ($emptyEmail !== "") {

					echo $emptyEmail;

				}

			?>

			<input type="email" name="email" class="form_input" maxlength="50" />

			<label for="password" class="form_input_label">Password</label>

			<?php

				if ($emptyPassword !== "") {

					echo $emptyPassword;

				}

			?>

			<input type="password" name="password" class="form_input" maxlength="50" />

			<input type="submit" name="delete_account" class="log_in_submit" value="Delete account" />

		</form>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/account_settings'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>