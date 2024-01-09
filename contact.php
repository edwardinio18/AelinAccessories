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

		if (isset($_GET["sent"]) && isset($_GET["selector"]) && isset($_GET["token"])) {

			if ($_GET["sent"] === "successfully") {

				if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

					echo '<div class="email_sent_outer_div overlay_helper_drop_div">
		
							<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

							<p class="email_sent_successfully_message">Your request has been successfully submitted!</p>
							
						</div>';

				}

			} else if ($_GET["sent"] === "failed") {

				if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

					echo '<div class="email_sent_outer_div overlay_helper_drop_div">
		
							<span class="image_helper"><img src="./images/x.png" class="email_sent_tick_image" /></span>

							<p class="email_sent_failed_message">There was an error processing your request, please try again!</p>
							
						</div>';

				}

			}

		}

	?>

	<h1 class="page_main_label">Contact</h1>

	<div class="contact_main_outer_div">
		
		<div class="contact_top_form_main_div">
			
			<h1 class="contact_top_form_title_label">Get in touch</h1>

			<form class="contact_top_form" action="/<?php echo basename(__DIR__); ?>/contact" method="POST">
				
				<label for="name" class="form_input_label">Name</label>

				<?php

					if ($emptyName !== "") {

						echo $emptyName;

					}

				?>

				<input type="name" name="name" class="form_input" id="name" maxlength="50" />

				<label for="email" class="form_input_label">Email</label>

				<?php

					if ($emptyEmail !== "") {

						echo $emptyEmail;

					}

				?>

				<input type="email" name="email" class="form_input" maxlength="50" />

				<label for="message" class="form_input_label">Message</label>

				<?php

					if ($emptyMessage !== "") {

						echo $emptyMessage;

					}

				?>

				<textarea class="form_textarea" name="message" maxlength="1000"></textarea>

				<input type="submit" name="submit" class="form_submit" />

			</form>

		</div>

		<div class="contact_line_separator_main_div">

			<div class="contact_line_separator"></div>

			<p class="contact_line_separator_or_label">OR</p>

		</div>

		<div class="contact_bottom_info_main_div">
			
			<p class="contact_info_type_label">Email address: aelinaccessories@gmail.com</p>
			
		</div>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>