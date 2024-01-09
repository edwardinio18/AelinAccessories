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

	<?php

		if (isset($_GET["selector"]) && isset($_GET["token"])) {

			if (isset($_GET["collection_added"])) {

				if ($_GET["collection_added"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">New collection of products has been successfully added!</p>
									
								</div>';

					}

				} else if ($_GET["collection_added"] === "failed") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/x.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_failed_message">An error has occured, please try again!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["collection_edited"])) {

				if ($_GET["collection_edited"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">Collection has been successfully edited!</p>
									
								</div>';

					}

				}

			}

			if (isset($_GET["collection_deleted"])) {

				if ($_GET["collection_deleted"] === "successfully") {

					if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96 && isset($_GET["collection_id"])) {

						$query = "DELETE FROM collections WHERE id = ?;";
						$stmt = $db->prepare($query);
						$stmt->bind_param("i", $_GET["collection_id"]);
						$stmt->execute();

						echo '<div class="email_sent_outer_div overlay_helper_drop_div">
			
									<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

									<p class="email_sent_successfully_message">Collection has been successfully deleted!</p>
									
								</div>';

					}

				}

			}

		}

	?>

	<h1 class="page_main_label" id="password_reset_label">Control Panel</h1>

	<div class="main_outer_profile_div">

		<div class="inner_outer_main_profile_buttons_div">
			
			<div class="profile_button_div">
			
				<button class="profile_div_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/ADMIN/add_collection'">Add collection</button>

				<button class="profile_div_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/ADMIN/edit_collection'">Edit collection</button>

			</div>

			<div class="profile_button_div">
				
				<button class="profile_div_button_log_out" onclick="window.location = '/<?php echo basename(__DIR__); ?>/ADMIN/delete_collection'">Delete collection</button>

			</div>

			<div class="profile_button_div">
				
				<button class="profile_div_button_log_out" onclick="window.location = '/<?php echo basename(__DIR__); ?>/log_out'">Log out</button>

			</div>

		</div>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/profile'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>