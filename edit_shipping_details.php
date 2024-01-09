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

	<h1 class="page_main_label" id="page_main_label_change_password">Edit Shipping Details</h1>

	<div class="main_outer_account_settings_div">
			
		<form action="" method="POST" class="log_in_form">

			<?php

				$query = "SELECT * FROM users WHERE id = ?;";
				$stmt = $db->prepare($query);
				$stmt->bind_param("i", $_SESSION["id"]);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows >= 1) {

					while ($row = $result->fetch_assoc()) {

						?>

							<label for="address" class="form_input_label">Address</label>

							<?php

								if ($emptyAddress !== "") {

									echo $emptyAddress;

								}

							?>

							<input type="text" name="address" value="<?php echo $row["address"]; ?>" class="form_input" maxlength="100" />

							<label for="phone" class="form_input_label">Phone number</label>

							<?php

								if ($emptyPhone !== "") {

									echo $emptyPhone;

								}

							?>

							<input type="text" name="phone" value="<?php echo $row["phone"]; ?>" class="form_input" maxlength="25" placeholder="Including country prefix e.g: +40777111222"  />

							<label for="shipping" class="form_input_label">Shipping</label>

							<select name="shipping" class="select_shipping">

								<option value="" disabled>Choose preffered shipping option</option>
								
								<?php

									$query = "SELECT * FROM users WHERE id = ?;";
									$stmt = $db->prepare($query);
									$stmt->bind_param("s", $_SESSION["id"]);
									$stmt->execute();
									$result = $stmt->get_result();

									if ($result->num_rows >= 1) {

										while ($row = $result->fetch_assoc()) {

											if ($row["shipping"] == "courier") {

												echo '<option value="courier" selected class="collection_option">Courier</option>';

												echo '<option value="post" class="collection_option">Post</option>';

											} else {

												echo '<option value="courier" class="collection_option">Courier</option>';

												echo '<option value="post" selected class="collection_option">Post</option>';

											}

										}

									}

								?>

							</select>

						<?php

					}

				}

			?>

			<input type="submit" name="edit_shipping_details" class="log_in_submit" value="Update details" />

		</form>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/account_settings'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>