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

		if (isset($_GET["sent"]) && isset($_GET["selector"]) && isset($_GET["token"])) {

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

	?>

	<h1 class="page_main_label">Sign Up</h1>

	<div class="main_outer_form_sign_up_div_container">
		
		<form class="sign_up_form" method="POST" action="">

			<label for="first_name" class="form_input_label">First name</label>

			<?php

				if ($emptyFirstName !== "") {

					echo $emptyFirstName;

				}

			?>

			<input type="text" name="first_name" class="form_input" style="text-transform: capitalize;" maxlength="30" />

			<label for="last_name" class="form_input_label">Last name</label>

			<?php

				if ($emptyLastName !== "") {

					echo $emptyLastName;

				}

			?>

			<input type="text" name="last_name" class="form_input" style="text-transform: capitalize;" maxlength="30" />

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

			<label for="confirm_password" class="form_input_label">Confirm Password</label>

			<?php

				if ($emptyConfirmPassword !== "") {

					echo $emptyConfirmPassword;

				}

			?>

			<input type="password" name="confirm_password" class="form_input" maxlength="50" />

			<label for="address" class="form_input_label">Address</label>

			<?php

				if ($emptyAddress !== "") {

					echo $emptyAddress;

				}

			?>

			<input type="text" name="address" class="form_input" maxlength="100" />

			<label for="phone" class="form_input_label">Phone number</label>

			<?php

				if ($emptyPhone !== "") {

					echo $emptyPhone;

				}

			?>

			<input type="tel" name="phone" class="form_input" maxlength="25" placeholder="Including country prefix e.g: +40777111222" />

			<label for="shipping" class="form_input_label shipping_label">Shipping</label>

			<?php

				if ($emptyShippingOption !== "") {

					echo $emptyShippingOption;

				}

			?>

			<div class="form_checkbox_wrapper_div">

				<label for="shipping" class="form_input_label courier_label">Courier</label>
				
				<input type="checkbox" name="shipping" value="courier" class="form_input_checkbox" />

				<label for="shipping" class="form_input_label post_label">Post</label>

				<input type="checkbox" name="shipping" value="post" class="form_input_checkbox" />

			</div>

			<input type="submit" name="sign_up" class="sign_up_submit" value="Sign up" />

		</form>

		<p class="already_have_an_account_sign_up_label">Already have an account? <a class="already_have_an_account_sign_up_label_link" href="/<?php echo basename(__DIR__); ?>/log_in">Log in</a></p>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>