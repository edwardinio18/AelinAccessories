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
		
				<?php

					if (isset($_GET["collection_id"])) {

						$query1 = "SELECT * FROM collections WHERE id = ?;";
						$stmt1 = $db->prepare($query1);
						$stmt1->bind_param("i", $_GET["collection_id"]);
						$stmt1->execute();
						$result1 = $stmt1->get_result();

						if ($result1->num_rows == 0) {

							header("Location: /" . basename(__DIR__) . "/ADMIN/delete_collection");

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

												<p class="form_input">' . $row1["name"] . '</p>';

								}

								while ($row = $result->fetch_assoc()) {

									$output .= '<div class="product_each_main_outer_div" id="product_each_main_outer_div_' . $i . '">

														<input type="hidden" value="' . $row["id"] . '" name="product_row_id[]" />

														<input type="hidden" value="' . $row["collection"] . '" name="collection_row_id" />
										
														<h2 class="product_each_title" id="product_each_title_' . $i . '">Product ' . $i . '</h2>

														<label for="product_name" class="form_input_label_collection" id="form_input_label_collection_' . $i . '">Product name</label>

														<p class="form_input_collection delete_form_input">' . $row["name"] . '</p>

														<label for="product_description" class="form_input_label_collection">Product description</label>

														<p class="form_textarea_collection delete_form_input delete_textarea">' . $row["description"] . '</p>

														<label for="product_price" class="form_input_label_collection">Product price</label>

														<p class="form_input_collection delete_form_input">' . $row["price"] . '</p>

														<label for="product_images" class="form_input_label_collection">Product images</label>

														<input type="hidden" value="' . $row["mainPicture"] . '" name="main_picture[]" />

														<div class="product_images_preview_div_edit" id="product_images_preview_div_main_' . $i . '">

															<div class="product_images_main_images_div" id="product_images_main_images_div_main_' . $i . '">
																
																<h3 class="product_images_main_image_label" id="product_images_main_image_label_main_' . $i . '">Main product image</h3>

																<div class="product_images_main_image_inner_image_div" id="product_images_main_image_inner_image_div_main_' . $i . '">

																	<img src="' . $productImagePath . $row["mainPicture"] . '" class="product_each_image_preview_image" />

																</div>

															</div>

														</div>

														<input type="hidden" value="' . $row["secondPicture"] . '" name="second_picture[]" />

														<div class="product_images_preview_div_edit" id="product_images_preview_div_secondary_' . $i . '">

															<div class="product_images_main_images_div" id="product_images_secondary_images_div_secondary_' . $i . '">
																
																<h3 class="product_images_main_image_label" id="product_images_secondary_image_label_secondary_' . $i . '">Secondary product image</h3>

																<div class="product_images_main_image_inner_image_div" id="product_images_secondary_image_inner_image_div_secondary_' . $i . '">

																	<img src="' . $productImagePath . $row["secondPicture"] . '" class="product_each_image_preview_image" />

																</div>

															</div>

														</div>

														<input type="hidden" value="' . $row["thirdPicture"] . '" name="third_picture[]" />

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

								$output .= '<input type="submit" id="delete_collection" name="delete_collection" class="add_collection_submit" value="Delete collection" />';

							}

							echo $output;

						}

					}

				?>

			</form>

		</div>

	</div>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/ADMIN/delete_collection'">Back</button>

	</div>

</body>

<script type="text/javascript">

	const pathName = <?php echo json_encode("/" . basename(__DIR__)); ?>;
	
	$(document).ready(function() {

		var searchParams = new URLSearchParams(window.location.search);

		if (!searchParams.has("collection_id")) {

			window.location.href = pathName + "/delete_collection";

		}

	});

</script>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>