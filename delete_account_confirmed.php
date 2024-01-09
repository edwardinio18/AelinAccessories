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

			$query = "SELECT * FROM deleteAccount WHERE selector = ? AND token = ?;";
			$stmt = $db->prepare($query);
			$selector = $_GET["selector"];
			$token = $_GET["token"];
			$stmt->bind_param("ss", $selector, $token);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {

				while ($row = $result->fetch_assoc()) {

					if ($currentTimeSinceUNIX <= $row["expiry"]) {

						$email = $row["userEmail"];

						$query3 = "DELETE FROM deleteAccount WHERE userEmail = ?;";
						$stmt3 = $db->prepare($query3);
						$stmt3->bind_param("s", $email);
						$stmt3->execute();

						$query5 = "DELETE FROM activateAccount WHERE userEmail = ?;";
						$stmt5 = $db->prepare($query5);
						$stmt5->bind_param("s", $email);
						$stmt5->execute();

						$query8 = "DELETE FROM resetPassword WHERE userEmail = ?;";
						$stmt8 = $db->prepare($query8);
						$stmt8->bind_param("s", $email);
						$stmt8->execute();

						$query6 = "SELECT * FROM users WHERE email = ?;";
						$stmt6 = $db->prepare($query6);
						$stmt6->bind_param("s", $email);
						$stmt6->execute();
						$result6 = $stmt6->get_result();

						if ($result6->num_rows >= 1) {

							while ($row6 = $result6->fetch_assoc()) {

								$query10 = "SELECT * FROM messages WHERE fromUserId = ? OR toUserId = ?;";
								$stmt10 = $db->prepare($query10);
								$stmt10->bind_param("ii", $row6["id"], $row6["id"]);
								$stmt10->execute();
								$result10 = $stmt10->get_result();

								$targetImagePath = __DIR__ . "/message_images/";

								if ($result10->num_rows >= 1) {

									while ($row10 = $result10->fetch_assoc()) {

										if ($row10["contentText"] == "") {

											unlink($targetImagePath . $row10["contentImage"]);

										}

									}

								}

							}

							$query9 = "DELETE FROM messages WHERE fromUserId = ? OR toUserId = ?;";
							$stmt9 = $db->prepare($query9);
							$stmt9->bind_param("ii", $row6["id"], $row6["id"]);
							$stmt9->execute();

							$query7 = "DELETE FROM conversations WHERE fromUserIdConvo = ?;";
							$stmt7 = $db->prepare($query7);
							$stmt7->bind_param("i", $row6["id"]);
							$stmt7->execute();

							$query11 = "DELETE FROM orders WHERE userId = ?;";
							$stmt11 = $db->prepare($query11);
							$stmt11->bind_param("i", $row6["id"]);
							$stmt11->execute();

							$query4 = "DELETE FROM users WHERE email = ?;";
							$stmt4 = $db->prepare($query4);
							$stmt4->bind_param("s", $email);
							$stmt4->execute();

						}

						echo '<div class="main_outer_activated_account_div_container">
		
									<p class="activated_account_label">Your account has been successfully deleted!</p>

									<a href="./" class="activated_account_log_in_button_link"><button class="activated_account_log_in_button">Homepage</button></a>

								</div>';

					} else {

						echo '<div class="main_outer_activated_account_div_container">
		
									<p class="activated_account_label">This confirmation link has expired, please click the button below to send another confirmation email to delete your account!</p>

									<form method="POST" action="" class="resend_confirmation_email_form">
										
										<input type="submit" class="resend_confirmation_email_button" name="resend_confirmation_delete_account_email" value="Resend confirmation email" />

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