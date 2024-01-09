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

<body class="body">

	<?php

		require_once realpath(dirname(__FILE__) . "/snippets/nav_bar.php");

	?>

	<h1 class="page_main_label" id="password_reset_label">Delete Collection</h1>

	<div class="main_outer_add_collection_div">

		<div class="inner_outer_main_profile_buttons_div_no_text_align">
			
			<form class="reset_password_form" method="POST" action="" enctype="multipart/form-data">

				<label for="collection_name" class="form_input_label">Choose collection</label>

				<select name="collection_name" class="select_collection_delete">

					<option value="" disabled selected>Choose collection to delete</option>
					
					<?php

						$query = "SELECT * FROM collections;";
						$stmt = $db->prepare($query);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows >= 1) {

							while ($row = $result->fetch_assoc()) {

								echo '<option value="' . $row["id"] . '" class="collection_option" id="' . $row["id"] . '">' . $row["name"] . '</option>';

							}

						}

					?>

				</select>

			</form>

		</div>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/ADMIN/admin'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>