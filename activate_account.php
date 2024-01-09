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

			$query = "SELECT * FROM activateAccount WHERE selector = ? AND token = ?;";
			$stmt = $db->prepare($query);
			$selector = $_GET["selector"];
			$token = $_GET["token"];
			$stmt->bind_param("ss", $selector, $token);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {

				while ($row = $result->fetch_assoc()) {

					if ($currentTimeSinceUNIX <= $row["expiry"]) {

						$query2 = "UPDATE users SET activated = ? WHERE email = ?;";
						$stmt2 = $db->prepare($query2);
						$activated = 1;
						$email = $row["userEmail"];
						$stmt2->bind_param("is", $activated, $email);
						$stmt2->execute();

						$query3 = "DELETE FROM activateAccount WHERE selector = ? AND token = ?;";
						$stmt3 = $db->prepare($query3);
						$stmt3->bind_param("ss", $selector, $token);
						$stmt3->execute();

						echo '<div class="main_outer_activated_account_div_container">
		
									<p class="activated_account_label">Your account has been successfully activated!</p>

									<a href="/' . basename(__DIR__) . '/log_in" class="activated_account_log_in_button_link"><button class="activated_account_log_in_button">Log in</button></a>

								</div>';

					} else {

						echo '<div class="main_outer_activated_account_div_container">
		
									<p class="activated_account_label">This confirmation link has expired, please click the button below to send another confirmation email!</p>

									<form method="POST" action="" class="resend_confirmation_email_form">
										
										<input type="submit" class="resend_confirmation_email_button" name="resend_confirmation_email" value="Resend confirmation email" />

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