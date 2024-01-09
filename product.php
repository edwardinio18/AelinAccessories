<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");
	include realpath(dirname(__FILE__) . "/stripe-php-master/init.php");

	\Stripe\Stripe::setApiKey('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');

?>

<!DOCTYPE html>

<html lang="en">

<head>

	<?php

		require_once realpath(dirname(__FILE__) . "/snippets/header.php");

	?>

	<script src="https://js.stripe.com/v3/"></script>

</head>

<body class="body">

	<?php

		require_once realpath(dirname(__FILE__) . "/snippets/nav_bar.php");

	?>

	<?php

		if (isset($_GET["id"])) {

			$query = "SELECT * FROM products WHERE id = ?;";
			$stmt = $db->prepare($query);
			$stmt->bind_param("i", $_GET["id"]);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 0) {

				header("Location: /" . basename(__DIR__) . "/products");

			} else {

				if (isset($_GET["order_status"]) && $_GET["order_status"] === "unsuccessful") {

					echo '<div class="order_not_placed_div_failed overlay_helper_drop_div">
		
								<span class="image_helper"><img src="./images/x.png" class="email_sent_tick_image" /></span>

								<p class="email_sent_failed_message">Order failed to be placed!</p>
								
							</div>';

				} else if (isset($_GET["order_status"]) && $_GET["order_status"] === "successful") {

					echo '<div class="order_not_placed_div overlay_helper_drop_div">
		
								<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

								<p class="email_sent_successfully_message">Your order has been successfully placed! We have sent you an email with your order confirmation!</p>
								
							</div>';

				}

				if ($row = $result->fetch_assoc()) {

					?>

						<h1 class="page_main_label" id="page_main_label_product"><?php echo $row["name"]; ?></h1>

						<div id="product_outer_main_div">
							
							<div id="product_image_outer_div">

								<?php

									$query1 = "SELECT * FROM products WHERE id = ?;";
									$stmt1 = $db->prepare($query1);
									$stmt1->bind_param("i", $_GET["id"]);
									$stmt1->execute();
									$result1 = $stmt1->get_result();

									$output = "";
									$imagePath = "./product_images/";

									if ($result1->num_rows >= 1) {

										if ($row1 = $result1->fetch_assoc()) {

											$output .= '<div id="product_each_image_preview_outer_div" style="background-image: url(' . $imagePath . $row1["mainPicture"] . ');"></div>';

										}

									}

									echo $output;

								?>

								<div id="product_bottom_small_preview_outer_div">

									<div id="product_bottom_small_preview_inner_div">
										
										<?php

											$query2 = "SELECT * FROM products WHERE id = ?;";
											$stmt2 = $db->prepare($query2);
											$stmt2->bind_param("i", $_GET["id"]);
											$stmt2->execute();
											$result2 = $stmt2->get_result();

											$output = "";
											$imagePath = "./product_images/";

											if ($result2->num_rows >= 1) {

												if ($row2 = $result2->fetch_assoc()) {

													$output .= '<div class="product_small_preview_each_div image_active" data-image="' . $imagePath . $row2["mainPicture"] . '" style="background-image: url(' . $imagePath . $row2["mainPicture"] . ');"></div>';

													$output .= '<div class="product_small_preview_each_div" data-image="' . $imagePath . $row2["secondPicture"] . '" style="background-image: url(' . $imagePath . $row2["secondPicture"] . ');"></div>';

													$output .= '<div class="product_small_preview_each_div" data-image="' . $imagePath . $row2["thirdPicture"] . '" style="background-image: url(' . $imagePath . $row2["thirdPicture"] . ');"></div>';

												}

											}

											echo $output;

										?>

									</div>

									<?php

										$query3 = "SELECT * FROM products WHERE id = ?;";
										$stmt3 = $db->prepare($query3);
										$stmt3->bind_param("i", $_GET["id"]);
										$stmt3->execute();
										$result3 = $stmt3->get_result();

										$output = "";

										if ($result3->num_rows >= 1) {

											if ($row3 = $result3->fetch_assoc()) {

												$output .= '<p id="product_description_content">' . $row3["description"] . '</p>';

											}

										}

										echo $output;

									?>

								</div>

							</div>

							<?php

								if (isset($_SESSION["user"])) {

									?>

										<?php

											$query2 = "SELECT * FROM products WHERE id = ?;";
											$stmt2 = $db->prepare($query2);
											$stmt2->bind_param("i", $_GET["id"]);
											$stmt2->execute();
											$result2 = $stmt2->get_result();

											$output = "";
											$imagePath = "./product_images/";

											if ($result2->num_rows >= 1) {

												if ($row2 = $result2->fetch_assoc()) {

													$output .= '<button id="product_buy_button" class="buy_product" data-productid="' . $row2["stripeProductId"] . '" data-priceid="' . $row2["stripePriceId"] . '">Buy now (' . $row2["price"] . ')</button>';

												}

											}

											echo $output;

										?>

									<?php

								} else {

									?>

										<?php

											$query2 = "SELECT * FROM products WHERE id = ?;";
											$stmt2 = $db->prepare($query2);
											$stmt2->bind_param("i", $_GET["id"]);
											$stmt2->execute();
											$result2 = $stmt2->get_result();

											$output = "";
											$imagePath = "./product_images/";

											if ($result2->num_rows >= 1) {

												if ($row2 = $result2->fetch_assoc()) {

													$output .= '<button id="product_buy_button" class="product_buy_button_log_in" data-redir="log_in?redir=' . $MAIN_SUB_URL_ROOT_USE . 'product?id=' . $_GET["id"] . '">Log in & buy (' . $row2["price"] . ')</button>';

												}

											}

											echo $output;

										?>

									<?php

								}

							?>

						</div>

					<?php

				}

			}

		}

	?>

	<div class="account_settings_back_button_div">
				
		<button class="account_settings_back_button" onclick="window.location = '/<?php echo basename(__DIR__); ?>/products'">Back</button>

	</div>

</body>

<script type="text/javascript">
	
	$(document).ready(function() {

		var searchParams = new URLSearchParams(window.location.search);
		const pathName = <?php echo json_encode("/" . basename(__DIR__)); ?>;

		if (!searchParams.has("id")) {

			window.location.href = pathName + "/products";

		}

		var urlString = window.location.href;
		var url = new URL(urlString);
		var productIdParam = url.searchParams.get("id");

		var stripe = Stripe('pk_live_51I2KDEBmZZhuwPxLQR3dAk8w4r0r1XXgOwt6NNyWbahShYv4Vo1AgiAdzQTIoz59mPX0LPkuHcectbbCBr7yI01Z00bvQDA6Xx');

		$(".buy_product").on("click", function() {

			var stripeProductId = $(this).data("productid");
			var stripePriceId = $(this).data("priceid");

			stripe.redirectToCheckout({

				lineItems: [{price: stripePriceId, quantity: 1}],
				mode: 'payment',
				successUrl: 'https://www.aelinaccessories.com/product?id=' + productIdParam + '&order_status=successful',
				cancelUrl: 'https://www.aelinaccessories.com/product?id=' + productIdParam + '&order_status=unsuccessful',

			});

		});

		setTimeout(function() {

			$(".order_not_placed_div").fadeOut(500, function() {

				$(".order_not_placed_div").remove();

				window.location.replace(pathName + "/product?id=" + productIdParam + "");

			});

			$(".order_not_placed_div_failed").fadeOut(500, function() {

				$(".order_not_placed_div_failed").remove();

				window.location.replace(pathName + "/product?id=" + productIdParam + "");

			});

		}, 3000);

	});

</script>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>