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

	<h1 class="page_main_label">My Account</h1>

	<div class="main_outer_profile_div">
			
		<?php

			if (isset($_SESSION["user"])) {

				?>

					<p class="profile_user_email_label"><?php echo $_SESSION["user"]; ?></p>

				<?php

			}

		?>

		<div class="inner_outer_main_profile_buttons_div">

			<?php

				if (isset($_SESSION["id"]) && isset($_SESSION["user"])) {

					$output = "";

					if ($_SESSION["id"] == $ADMIN_USER_ID) {

						$output .= '<div class="profile_button_div">';

						$output .= '<button class="profile_div_button" onclick="window.location = \'/' . basename(__DIR__) . '/orders\'">All Orders</button>';

						$output .= '<button class="profile_div_button" onclick="window.location = \'/' . basename(__DIR__) . '/inbox\'">Inbox (';

						$query = "SELECT COUNT(*) FROM messages WHERE toUserId = ? AND status = ? GROUP BY orderId;";
						$stmt = $db->prepare($query);
						$status = 0;
						$stmt->bind_param("ii", $_SESSION["id"], $status);
						$stmt->execute();
						$result = $stmt->get_result();

						$output .= $result->num_rows;

						$output .= ')</button>';

						$output .= '</div>';

						$output .= '<div class="profile_button_div">';

						$output .= '<button class="profile_div_button" onclick="window.location = \'/' . basename(__DIR__) . '/account_settings\'">Account Settings</button>';

						$output .= '<button class="profile_div_button log_out_button">Log Out</button>';

						$output .= '</div>';

						$output .= '<div class="profile_button_div_admin">';

						$output .= '<button class="profile_div_button_admin profile_div_button" onclick="window.location = \'/' . basename(__DIR__) . '/ADMIN/admin_log_in\'">Admin</button>';

						$output .= '</div>';

						$output .= '</div>';

					} else {

						$output .= '<div class="profile_button_div">';

						$output .= '<button class="profile_div_button" onclick="window.location = \'/' . basename(__DIR__) . '/orders\'">My Orders</button>';

						$output .= '<button class="profile_div_button" onclick="window.location = \'/' . basename(__DIR__) . '/inbox\'">Inbox (';

						$query = "SELECT COUNT(*) FROM messages WHERE toUserId = ? AND status = ? GROUP BY orderId;";
						$stmt = $db->prepare($query);
						$status = 0;
						$stmt->bind_param("ii", $_SESSION["id"], $status);
						$stmt->execute();
						$result = $stmt->get_result();

						$output .= $result->num_rows;

						$output .= ')</button>';

						$output .= '</div>';

						$output .= '<div class="profile_button_div">';

						$output .= '<button class="profile_div_button" onclick="window.location = \'/' . basename(__DIR__) . '/account_settings\'">Account Settings</button>';

						$output .= '<button class="profile_div_button log_out_button">Log Out</button>';

						$output .= '</div>';

					}

					echo $output;

				}

			?>

		</div>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>