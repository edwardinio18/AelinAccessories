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

<body class="body">

	<?php

		require_once realpath(dirname(__FILE__) . "/snippets/nav_bar.php");

	?>

	<h1 class="page_main_label" id="page_main_label">Products</h1>

	<div class="products_menu_burger" onclick="openProductsMenu(this)">
		
		<div class="products_menu_burger_each" id="products_top_line"></div>

		<div class="products_menu_burger_each" id="products_mid_line"></div>

		<div class="products_menu_burger_each" id="products_bot_line"></div>

	</div>

	<div class="products_modal_container"></div>

	<div class="products_side_menu_bar" id="products_side_menu_bar">

		<p class="products_side_menu_bar_title">Collections</p>

		<?php

			$query = "SELECT * FROM collections;";
			$stmt = $db->prepare($query);
			$stmt->execute();
			$result = $stmt->get_result();

			$output = "";

			if ($result->num_rows >= 1) {

				while ($row = $result->fetch_assoc()) {

					$output .= '<div class="products_side_menu_bar_inner_each_main_div">
		
									<a href="#collection_' . $row["id"] . '" class="products_side_menu_bar_each_div_link">
										
										<div class="products_side_menu_bar_each_div">
									
											<p class="products_side_menu_bar_each_div_collection_title">' . $row["name"] . '</p>

										</div>

									</a>

								</div>';

				}

			}

			echo $output;

		?>

	</div>

	<div class="products_main_outer_container_div">
		
		<?php

			$query = "SELECT * FROM products JOIN collections ON collections.id = products.collection GROUP BY collection;";
			$stmt = $db->prepare($query);
			$stmt->execute();
			$result = $stmt->get_result();

			$output = "";
			$imagePath = "./product_images/";

			if ($result->num_rows >= 1) {

				while ($row = $result->fetch_assoc()) {

					$collection = $row["collection"];
					$output .= '<div class="products_main_each_collection_outer_div"><div class="products_main_each_collection_hidden_scroll_to_div" id="collection_' . $row["collection"] . '"></div><h2 class="products_main_each_collection_title">' . $row["name"] . '</h2><div class="products_main_each_collection_container_outer_main_div">';

					$query1 = "SELECT * FROM products WHERE collection = ?;";
					$stmt1 = $db->prepare($query1);
					$stmt1->bind_param("i", $collection);
					$stmt1->execute();
					$result1 = $stmt1->get_result();

					if ($result1->num_rows >= 1) {

						while ($row1 = $result1->fetch_assoc()) {

							$output .= '<div class="products_main_each_collection_each_inner_outer_div" id="' . $row1["id"] . '">
				
											<div class="products_main_each_collection_each_top_product_title_div">
												
												<p class="products_main_each_collection_each_top_product_title_content">' . $row1["name"] . '</p>

											</div>

											<div class="products_main_each_collection_each_main_product_image_div" style="background-image: url(' . $imagePath . $row1["mainPicture"] . ');"></div>

											<div class="products_main_each_collection_each_bottom_product_description_div">

												<p class="products_main_each_collection_each_bottom_product_price_content">' . $row1["price"] . '</p>
												
												<p class="products_main_each_collection_each_bottom_product_description_content">' . $row1["description"] . '</p>

											</div>

										</div>';

						}

					}

					$output .= '</div></div>';

				}

			}

			echo $output;

		?>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>