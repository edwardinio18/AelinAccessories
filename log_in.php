<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");

	if (isset($_SESSION["user"])) {

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

	<?php

		if (isset($_GET["selector"]) && isset($_GET["token"])) {

			if (isset($_GET["sent"])) {

				if ($_GET["sent"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
								<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

								<p class="email_sent_successfully_message">We\'ve sent you a confirmation email to activate your account!</p>
								
							</div>';

					}

				} else if ($_GET["sent"] === "failed") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
								<span class="image_helper"><img src="./images/x.png" class="email_sent_tick_image" /></span>

								<p class="email_sent_failed_message">An error has occured, please try again!</p>
								
							</div>';

					}

				}

			}

			if (isset($_GET["logged_out"])) {

				if ($_GET["logged_out"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
				
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">You have successfully been logged out!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["password_changed"])) {

				if ($_GET["password_changed"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">Your password has been successfully changed!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["delete_account"])) {

				if ($_GET["delete_account"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">We\'ve sent you a confirmation email to delete your account!</p>
									
								</div>';

					}

				} else if ($_GET["delete_account"] === "failed") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/x.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_failed_message">An error has occured, please try again!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["delete_account_resent"])) {

				if ($_GET["delete_account_resent"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">We\'ve sent you a confirmation email to delete your account!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["password_reset_sent"])) {

				if ($_GET["password_reset_sent"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">We\'ve sent you a confirmation email to reset your password!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["password_reset"])) {

				if ($_GET["password_reset"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">Your password has been successfully reset!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["reset_password_resent"])) {

				if ($_GET["reset_password_resent"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">We\'ve sent you a confirmation email to reset your password!</p>
									
								</div>';

					}

				}

			}

		}

	?>

	<h1 class="page_main_label">Log In</h1>

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

			<input type="submit" name="log_in" class="log_in_submit" value="Log in" />

		</form>

		<button class="forgot_password_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/forgot_password'">Forgot your password?</button>

		<p class="no_account_sign_up_label">Don't have an account? <a class="no_account_sign_up_label_link" href="/<?php echo basename(__DIR__); ?>/sign_up">Sign up</a></p>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>