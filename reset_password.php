<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");

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

		if (isset($_GET["selector"]) && isset($_GET["token"])) {

			$query = "SELECT * FROM resetPassword WHERE selector = ? AND token = ?;";
			$stmt = $db->prepare($query);
			$selector = $_GET["selector"];
			$token = $_GET["token"];
			$stmt->bind_param("ss", $selector, $token);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {

				while ($row = $result->fetch_assoc()) {

					if ($currentTimeSinceUNIX <= $row["expiry"]) {

						echo '<h1 class="page_main_label" id="page_main_label_change_password">Reset Password</h1>

								<div class="main_outer_account_settings_div">
										
									<form action="" method="POST" class="log_in_form">

										<label for="new_password" class="form_input_label">New Password</label>

										' . emptyField($emptyNewPassword) . '

										<input type="password" name="new_password" class="form_input" maxlength="50" />

										<label for="new_confirm_password" class="form_input_label">Confirm New Password</label>

										' . emptyField($emptyConfirmNewPassword) . '

										<input type="password" name="new_confirm_password" class="form_input" maxlength="50" />

										<input type="submit" name="reset_password_confirmed" class="log_in_submit" value="Reset password" />

									</form>

								</div>';

					} else {

						echo '<div class="main_outer_activated_account_div_container">
		
									<p class="activated_account_label">This confirmation link has expired, please click the button below to send another confirmation email!</p>

									<form method="POST" action="" class="resend_confirmation_email_form">
										
										<input type="submit" class="resend_confirmation_email_button" name="resend_password_reset_email" value="Resend password reset email" />

									</form>

								</div>';

					}

				}

			} else {

				echo '<div class="email_not_activated_url_invalid_div">
		
						<span class="image_helper"><img src="./images/x.png" class="email_sent_tick_image" /></span>

						<p class="email_sent_failed_message">Invalid URL!</p>
						
					</div>';

			}

		} else {

			echo '<div class="email_not_activated_url_invalid_div">
		
					<span class="image_helper"><img src="./images/x.png" class="email_sent_tick_image" /></span>

					<p class="email_sent_failed_message">Invalid URL!</p>
					
				</div>';

		}

	?>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>