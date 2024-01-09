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

	<h1 class="page_main_label" id="password_reset_label">Add Collection</h1>

	<div class="main_outer_add_collection_div">

		<div class="inner_outer_main_profile_buttons_div_no_text_align">
			
			<form class="reset_password_form" method="POST" action="" enctype="multipart/form-data">

				<label for="collection_name" class="form_input_label">Collection name</label>

				<?php

					if ($emptyCollectionName !== "") {

						echo $emptyCollectionName;

					}

				?>

				<input type="text" name="collection_name" class="form_input" maxlength="25" />

				<div class="products_main_outer_div">
					
					<?php

						for ($i = 1; $i <= 10; $i++) {

							echo '<div class="product_each_main_outer_div" id="product_each_main_outer_div_' . $i . '">
					
									<h2 class="product_each_title" id="product_each_title_' . $i . '">Product ' . $i . '</h2>

									<label for="product_name" class="form_input_label_collection" id="form_input_label_collection_' . $i . '">Product name</label>

									' . emptyField(${"emptyProductName" . $i}) . '

									<input type="text" name="product_name[]" class="form_input_collection" maxlength="30" />

									<label for="product_description" class="form_input_label_collection">Product description</label>

									' . emptyField(${"emptyProductDescription" . $i}) . '

									<textarea class="form_textarea_collection" name="product_description[]" maxlength="200"></textarea>

									<label for="product_price" class="form_input_label_collection">Product price</label>

									' . emptyField(${"emptyProductPrice" . $i}) . '

									<input type="text" name="product_price[]" placeholder="00.00RON" class="form_input_collection product_price" id="product_price" />

									<label for="product_images" class="form_input_label_collection">Product images</label>

									' . emptyField(${"emptyProductImagesMain" . $i}) . '

									<input type="file" name="product_images_main[]" class="form_input_collection product_images" id="product_images_main_' . $i . '" accept="image/jpg, image/jpeg, image/png" data-productimageidmain="' . $i . '"/>

									<div class="product_images_button_for_file_upload" id="product_images_button_for_file_upload_main_' . $i . '" data-productimageidmain="' . $i . '">
										
										<p class="product_images_button_for_file_upload_label" id="product_images_button_for_file_upload_label_main_' . $i . '">Choose main product image</p>

									</div>

									<div class="product_images_preview_div" id="product_images_preview_div_main_' . $i . '">

										<div class="product_images_main_images_div" id="product_images_main_images_div_main_' . $i . '">
											
											<h3 class="product_images_main_image_label" id="product_images_main_image_label_main_' . $i . '">Main product image</h3>

											<div class="product_images_main_image_inner_image_div" id="product_images_main_image_inner_image_div_main_' . $i . '"></div>

										</div>

									</div>

									' . emptyField(${"emptyProductImagesSecondary" . $i}) . '

									<input type="file" name="product_images_secondary[]" class="form_input_collection product_images_secondary" id="product_images_secondary_' . $i . '" accept="image/jpg, image/jpeg, image/png" data-productimageidsecondary="' . $i . '"/>

									<div class="product_images_button_for_file_upload_secondary" id="product_images_button_for_file_upload_secondary_' . $i . '" data-productimageidsecondary="' . $i . '">
										
										<p class="product_images_button_for_file_upload_label" id="product_images_button_for_file_upload_label_secondary_' . $i . '">Choose secondary product image</p>

									</div>

									<div class="product_images_preview_div" id="product_images_preview_div_secondary_' . $i . '">

										<div class="product_images_main_images_div" id="product_images_secondary_images_div_secondary_' . $i . '">
											
											<h3 class="product_images_main_image_label" id="product_images_secondary_image_label_secondary_' . $i . '">Secondary product image</h3>

											<div class="product_images_main_image_inner_image_div" id="product_images_secondary_image_inner_image_div_secondary_' . $i . '"></div>

										</div>

									</div>

									' . emptyField(${"emptyProductImagesTertiary" . $i}) . '

									<input type="file" name="product_images_third[]" class="form_input_collection product_images_third" id="product_images_third_' . $i . '" accept="image/jpg, image/jpeg, image/png" data-productimageidthird="' . $i . '"/>

									<div class="product_images_button_for_file_upload_third" id="product_images_button_for_file_upload_third_' . $i . '" data-productimageidthird="' . $i . '">
										
										<p class="product_images_button_for_file_upload_label" id="product_images_button_for_file_upload_label_third_' . $i . '">Choose tertiary product image</p>

									</div>

									<div class="product_images_preview_div" id="product_images_preview_div_third_' . $i . '">

										<div class="product_images_main_images_div" id="product_images_third_images_div_third_' . $i . '">
											
											<h3 class="product_images_main_image_label" id="product_images_third_image_label_third_' . $i . '">Tertiary product image</h3>

											<div class="product_images_main_image_inner_image_div" id="product_images_third_image_inner_image_div_third_' . $i . '"></div>

										</div>

									</div>

								</div>';

						}

					?>

				</div>

				<input type="submit" name="add_collection" class="add_collection_submit" value="Add collection" />

			</form>

		</div>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/ADMIN/admin'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>