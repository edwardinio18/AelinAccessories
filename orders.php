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

		<?php

			$output = "";

			if (isset($_SESSION["id"])) {

				if ($_SESSION["id"] == $ADMIN_USER_ID) {

					?>

						<h1 class="page_main_label">All Orders</h1>

						<div class="main_outer_account_settings_div">

							<div class="inner_outer_main_orders_div_admin">

								<input type="text" name="orders_calendar" class="orders_calendar placeholder_color" placeholder="Choose a date" autocomplete="off" />

								<div class="outer_outer_container_helper_all_orders_div"></div>

							</div>

						</div>

					<?php

				} else {

					?>

						<h1 class="page_main_label">My Orders</h1>

						<div class="overlay_order_number_copied_div">
							
							<span class="image_helper"><img src="./images/tick_lighter.png" class="email_sent_tick_image" /></span>

							<p class="email_sent_successfully_message">Order # copied to clipboard!</p>

						</div>

						<div class="main_outer_account_settings_div">

							<div class="inner_outer_main_orders_div">
								
								<?php

									$query = "SELECT * FROM users WHERE email = ?;";
									$stmt = $db->prepare($query);
									$stmt->bind_param("s", $_SESSION["user"]);
									$stmt->execute();
									$result = $stmt->get_result();

									if ($result->num_rows >= 1) {

										if ($row = $result->fetch_assoc()) {

											$userId = $row["id"];

											$query1 = "SELECT COUNT(*) AS total FROM orders WHERE userId = ?;";
											$stmt1 = $db->prepare($query1);
											$stmt1->bind_param("i", $userId);
											$stmt1->execute();
											$result1 = $stmt1->get_result();
											$row1 = $result1->fetch_assoc();
											$total = $row1["total"];

											$output .= '<p class="profile_user_email_label_no_orders_1">Your total number of orders: ' . $total . '</p>';

											if ($total == 0) {

												$output .= '<p class="profile_user_email_label_no_orders_2">You currently have no placed orders. All your orders can be viewed here.</p>';

											} else {

												$query2 = "SELECT * FROM orders JOIN products ON products.id = orders.productId WHERE userId = ? ORDER BY orderPlacedTimestamp DESC;";
												$stmt2 = $db->prepare($query2);
												$stmt2->bind_param("i", $userId);
												$stmt2->execute();
												$result2 = $stmt2->get_result();

												$prodcutImagePath = "./product_images/";

												for ($i = $total; $i > 0; $i--) {

													$row2 = $result2->fetch_assoc();

													$formattedDate = strtotime($row2["orderPlacedTimestamp"]);

													$output .= '<div class="inner_outer_main_outer_container_order_products_div">';

													$output .= '<div class="inner_outer_container_each_order_main_div">
											
																	<p class="inner_outer_container_each_order_main_product_order_number">' . $i . '</p>

																	<hr class="inner_outer_container_each_order_main_product_order_number_line_break" />

																	<div class="inner_outer_container_each_order_main_product_image" style="background-image: url(' . $prodcutImagePath . $row2["mainPicture"] . ')"></div>

																	<div class="inner_outer_container_each_order_main_product_details_div">

																		<p class="inner_outer_container_each_order_main_product_name">' . $row2["name"] . '</p>

																		<p class="inner_outer_container_each_order_main_product_price">' . $row2["price"] . '</p>

																		<p class="inner_outer_container_each_order_main_product_unique_id">Order #:</p>

																		<p class="inner_outer_container_each_order_main_product_unique_id_2" data-clipboard-text="' . $row2["uniqueOrderId"] . '">' . $row2["uniqueOrderId"] . '</p>

																		<p class="inner_outer_container_each_order_main_product_date">Order placed on:</p>

																		<p class="inner_outer_container_each_order_main_product_date_2">' . date("l jS F Y", $formattedDate) . " at " . date("H:i", $formattedDate) . '</p>

																	</div>

																</div>';

													$output .= '</div>';

												}

											}

										}

									}

								?>

								<?php

									echo $output;

								?>

							</div>

						</div>

					<?php

				}
				
			}

		?>

	<div class="account_settings_back_button_orders_div">
				
		<button class="account_settings_back_button_orders" onclick="window.location = '/<?php echo basename(__DIR__); ?>/profile'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

<script type="text/javascript" src="./node_modules/clipboard/dist/clipboard.min.js"></script>

<script type="text/javascript">

	const pathName = <?php echo json_encode("/" . basename(__DIR__) . "/AJAX/load_all_orders_admin.php"); ?>;
	console.log(pathName);
	
	new ClipboardJS(".inner_outer_container_each_order_main_product_unique_id_2");

	$(document).on("click", ".inner_outer_container_each_order_main_product_unique_id_2", function() {

		$(".overlay_order_number_copied_div").css("display", "table");

		$(".overlay_order_number_copied_div").animate({

			opacity: "1"

		}, 200, function() {

			setTimeout(function() {

				$(".overlay_order_number_copied_div").animate({

					opacity: "0"

				}, 200, function() {

					$(".overlay_order_number_copied_div").css("display", "none");

				});

			}, 750);

		});

	});

	$(function() {

		$(".orders_calendar").datepicker({

			onSelect: function() {

				function formatDate(date) {

					var d = new Date(date),
						month = "" + (d.getMonth() + 1),
						day = "" + d.getDate(),
						year = d.getFullYear();

					if (month.length < 2) {

						month = "0" + month;

					}

					if (day.length < 2) {

						day = "0" + day;

					}

					return [year, month, day].join("/");

				}

				var date = new Date(formatDate($(this).val()));

				date = date.getUTCFullYear() + "-" + ("00" + (date.getUTCMonth() + 1)).slice(-2) + "-" + ("00" + (date.getUTCDate() + 1)).slice(-2);

				$.ajax({

					url: pathName,
					method: "GET",
					data: {

						date: date

					},
					success: function(data) {

						$(".outer_outer_container_helper_all_orders_div").html(data);
						$(".outer_outer_container_helper_all_orders_div").attr("style", "padding-bottom: 5px;");

					}

				});

			}

		});

	});

	$(".placeholder_color").hover(function() {

		$(this).addClass("hover_placeholder_color");

	}, function() {

		$(this).removeClass("hover_placeholder_color");

	});
	
</script>

</html>