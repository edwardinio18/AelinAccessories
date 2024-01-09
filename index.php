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

	<div class="outer_main_image_carousel_div">
		
		<div class="image_carousel">
		
			<div class="image_carousel_div" style="background-image: url(./images/content/IMG_1168.jpeg);">

			</div>

			<div class="image_carousel_div" style="background-image: url(./images/content/IMG_9461.jpeg);">

			</div>

			<div class="image_carousel_div" style="background-image: url(./images/content/IMG_9555.jpeg);">

			</div>

		</div>

	</div>

	<div class="unique_product_outer_div">

		<h1 class="unique_product_name_label">Most popular products</h1>
		
		<div class="unique_product_inner_div">
			
			<h1 class="unique_product_sign">!</h1>

			<div class="unique_product_image_div_container">
				
				<div class="unique_product_image_div" style="background-image: url(./images/content/IMG_9783.jpeg);">

				</div>

				<div class="unique_product_image_div" style="background-image: url(./images/content/IMG_1029.jpeg);">

				</div>

				<div class="unique_product_image_div" style="background-image: url(./images/content/IMG_1031.jpeg);">

				</div>

			</div>

		</div>

	</div>

	<div class="new_collection_products_preview_outer_div">
		
		<h1 class="new_collection_products_preview_name_label">Colectia Nr.1</h1>

		<div class="new_collection_products_preview_inner_div">
			
			<div class="new_collection_products_preview_each_outer_div" style="background-image: url(./images/content/IMG_9691.jpeg);">

			</div>

			<div class="new_collection_products_preview_each_outer_div" style="background-image: url(./images/content/IMG_9535.jpeg);">
				
			</div>

			<div class="new_collection_products_preview_each_outer_div" style="background-image: url(./images/content/IMG_9392.jpeg);">
				
			</div>

		</div>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>