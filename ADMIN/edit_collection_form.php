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

	<h1 class="page_main_label" id="password_reset_label">Edit Collection</h1>

	<div class="main_outer_add_collection_div">

		<div class="inner_outer_main_profile_buttons_div_no_text_align">

			<form class="reset_password_form" method="POST" action="" enctype="multipart/form-data">
		
				<?php

					if (isset($_GET["collection_id"])) {

						$query1 = "SELECT * FROM collections WHERE id = ?;";
						$stmt1 = $db->prepare($query1);
						$stmt1->bind_param("i", $_GET["collection_id"]);
						$stmt1->execute();
						$result1 = $stmt1->get_result();

						if ($result1->num_rows == 0) {

							header("Location: /" . basename(__DIR__) . "/ADMIN/edit_collection");

						} else {

							$output = "";
							$collectionId = $_GET["collection_id"];

							$query = "SELECT * FROM collections JOIN products ON products.collection = collections.id WHERE collections.id = ?;";
							$stmt = $db->prepare($query);
							$stmt->bind_param("i", $collectionId);
							$stmt->execute();
							$result = $stmt->get_result();
							$i = 1;
							$productImagePath = "./product_images/";

							$query1 = "SELECT * FROM collections WHERE id = ?;";
							$stmt1 = $db->prepare($query1);
							$stmt1->bind_param("i", $collectionId);
							$stmt1->execute();
							$result1 = $stmt1->get_result();

							if ($result->num_rows >= 1) {

								if ($row1 = $result1->fetch_assoc()) {

									$output .= '<label for="collection_name" class="form_input_label">Collection name</label>

											' . emptyField($emptyCollectionName) . '

											<input type="text" name="collection_name" class="form_input" value="' . $row1["name"] . '" maxlength="25" />';

								}

								while ($row = $result->fetch_assoc()) {

									$output .= '<div class="product_each_main_outer_div" id="product_each_main_outer_div_' . $i . '">

														<input type="hidden" value="' . $row["id"] . '" name="product_row_id[]" />

														<input type="hidden" value="' . $row["collection"] . '" name="collection_row_id" />
										
														<h2 class="product_each_title" id="product_each_title_' . $i . '">Product ' . $i . '</h2>

														<label for="product_name" class="form_input_label_collection" id="form_input_label_collection_' . $i . '">Product name</label>

														' . emptyField(${"emptyProductName" . $i}) . '

														<input type="hidden" name="updated_name[]" value="' . $i . '" />

														<input type="text" name="product_name_' . $i . '[]" value="' . $row["name"] . '" class="form_input_collection" maxlength="30" />

														<label for="product_description" class="form_input_label_collection">Product description</label>

														' . emptyField(${"emptyProductDescription" . $i}) . '

														<input type="hidden" name="updated_description[]" value="' . $i . '" />

														<textarea class="form_textarea_collection" name="product_description_' . $i . '[]" maxlength="200">' . $row["description"] . '</textarea>

														<label for="product_price" class="form_input_label_collection">Product price</label>

														' . emptyField(${"emptyProductPrice" . $i}) . '

														<input type="hidden" name="updated_price[]" value="' . $i . '" />

														<input type="text" name="product_price_' . $i . '[]" placeholder="€00.00" value="' . $row["price"] . '" class="form_input_collection product_price" id="product_price" />

														<label for="product_images" class="form_input_label_collection">Product images</label>

														' . emptyField(${"emptyProductImagesMain" . $i}) . '

														<input type="hidden" name="updated_main_picture[]" value="' . $i . '" />

														<input type="file" name="product_images_main_' . $i . '[]" class="form_input_collection product_images" id="product_images_main_' . $i . '" accept="image/jpg, image/jpeg, image/png" data-productimageidmain="' . $i . '"/>

														<div class="product_images_button_for_file_upload" id="product_images_button_for_file_upload_main_' . $i . '" data-productimageidmain="' . $i . '">
															
															<p class="product_images_button_for_file_upload_label" id="product_images_button_for_file_upload_label_main_' . $i . '">Choose main product image</p>

														</div>

														<div class="product_images_preview_div_edit" id="product_images_preview_div_main_' . $i . '">

															<div class="product_images_main_images_div" id="product_images_main_images_div_main_' . $i . '">
																
																<h3 class="product_images_main_image_label" id="product_images_main_image_label_main_' . $i . '">Main product image</h3>

																<div class="product_images_main_image_inner_image_div" id="product_images_main_image_inner_image_div_main_' . $i . '">

																	<img src="' . $productImagePath . $row["mainPicture"] . '" class="product_each_image_preview_image" />

																</div>

															</div>

														</div>

														' . emptyField(${"emptyProductImagesSecondary" . $i}) . '

														<input type="hidden" name="updated_second_picture[]" value="' . $i . '" />

														<input type="file" name="product_images_secondary_' . $i . '[]" class="form_input_collection product_images_secondary" id="product_images_secondary_' . $i . '" accept="image/jpg, image/jpeg, image/png" data-productimageidsecondary="' . $i . '"/>

														<div class="product_images_button_for_file_upload_secondary" id="product_images_button_for_file_upload_secondary_' . $i . '" data-productimageidsecondary="' . $i . '">
															
															<p class="product_images_button_for_file_upload_label" id="product_images_button_for_file_upload_label_secondary_' . $i . '">Choose secondary product image</p>

														</div>

														<div class="product_images_preview_div_edit" id="product_images_preview_div_secondary_' . $i . '">

															<div class="product_images_main_images_div" id="product_images_secondary_images_div_secondary_' . $i . '">
																
																<h3 class="product_images_main_image_label" id="product_images_secondary_image_label_secondary_' . $i . '">Secondary product image</h3>

																<div class="product_images_main_image_inner_image_div" id="product_images_secondary_image_inner_image_div_secondary_' . $i . '">

																	<img src="' . $productImagePath . $row["secondPicture"] . '" class="product_each_image_preview_image" />

																</div>

															</div>

														</div>

														' . emptyField(${"emptyProductImagesTertiary" . $i}) . '

														<input type="hidden" name="updated_third_picture[]" value="' . $i . '" />

														<input type="file" name="product_images_third_' . $i . '[]" class="form_input_collection product_images_third" id="product_images_third_' . $i . '" accept="image/jpg, image/jpeg, image/png" data-productimageidthird="' . $i . '"/>

														<div class="product_images_button_for_file_upload_third" id="product_images_button_for_file_upload_third_' . $i . '" data-productimageidthird="' . $i . '">
															
															<p class="product_images_button_for_file_upload_label" id="product_images_button_for_file_upload_label_third_' . $i . '">Choose tertiary product image</p>

														</div>

														<div class="product_images_preview_div_edit" id="product_images_preview_div_third_' . $i . '">

															<div class="product_images_main_images_div" id="product_images_third_images_div_third_' . $i . '">
																
																<h3 class="product_images_main_image_label" id="product_images_third_image_label_third_' . $i . '">Tertiary product image</h3>

																<div class="product_images_main_image_inner_image_div" id="product_images_third_image_inner_image_div_third_' . $i . '">

																	<img src="' . $productImagePath . $row["thirdPicture"] . '" class="product_each_image_preview_image" />

																</div>

															</div>

														</div>

													</div>';

									$i++;

								}

								$output .= '<input type="submit" id="edit_collection" name="edit_collection" class="add_collection_submit" value="Edit collection" />';

							}

							echo $output;

						}

					}

				?>

			</form>

		</div>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/ADMIN/edit_collection'">Back</button>

	</div>

</body>

<script type="text/javascript">
	
	$(document).ready(function() {

		const pathName = <?php echo json_encode("/" . basename(__DIR__)); ?>;

		var searchParams = new URLSearchParams(window.location.search);

		if (!searchParams.has("collection_id")) {

			window.location.href = pathName + "/edit_collection";

		} else {

			$(".form_input").on("input", function() {

				var name = $(this).attr("name");

				if (!name.match(/updated/i)) {

					$(this).attr("name", name + "_updated");

				}

			});

			$(".form_input_collection").on("input", function() {

				var name = $(this).attr("name");
				var nameLen = name.length - 2;
				var output = [name.slice(0, nameLen), "_updated", name.slice(nameLen)].join("");

				if (!name.match(/updated/i)) {

					$(this).attr("name", output);

				}

			});

			$(".form_textarea_collection").on("input", function() {

				var name = $(this).attr("name");
				var nameLen = name.length - 2;
				var output = [name.slice(0, nameLen), "_updated", name.slice(nameLen)].join("");

				if (!name.match(/updated/i)) {

					$(this).attr("name", output);

				}

			});

		}

	});

</script>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>