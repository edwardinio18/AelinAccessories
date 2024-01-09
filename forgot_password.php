<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");

	if (!isset($_SESSION["user"])) {

		header("Location: /" . basename(__DIR__) . "/profile");

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

	<h1 class="page_main_label" id="password_reset_label">Password Reset</h1>

	<div class="main_outer_form_log_in_div_container">
		
		<form class="reset_password_form" method="POST" action="">

			<label for="email" class="form_input_label">Email</label>

			<?php

				if ($emptyEmail !== "") {

					echo $emptyEmail;

				}

			?>

			<input type="email" name="email" class="form_input" maxlength="50" />

			<input type="submit" name="reset_password" class="log_in_submit" value="Reset password" />

		</form>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/log_in'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>