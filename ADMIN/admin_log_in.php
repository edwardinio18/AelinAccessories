<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");

	if (isset($_SESSION["user"])) {

		if (!isset($_SESSION["admin"])) {

			$query = "SELECT * FROM users WHERE email = ? AND privilege = ?;";
			$stmt = $db->prepare($query);
			$email = $_SESSION["user"];
			$privilege = 1;
			$stmt->bind_param("si", $email, $privilege);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 0) {

				header("Location: /" . basename(__DIR__) . "/");

			}

		}

	} else {

		header("Location: /" . basename(__DIR__) . "/");

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

	<h1 class="page_main_label" id="password_reset_label">Admin Login</h1>

	<div class="main_outer_form_log_in_div_container">
		
		<form class="log_in_form" method="POST" action="">

			<label for="email" class="form_input_label">Email</label>

			<?php

				if ($emptyEmail !== "") {

					echo $emptyEmail;

				}

			?>

			<input type="email" name="email" class="form_input" />

			<label for="password" class="form_input_label">Password</label>

			<?php

				if ($emptyPassword !== "") {

					echo $emptyPassword;

				}

			?>

			<input type="password" name="password" class="form_input" />

			<input type="submit" name="admin_log_in" class="log_in_submit" value="Log in" />

		</form>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/profile'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>