<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";

	$date = "";

	if (isset($_GET["date"]) && isset($_SESSION["id"]) && $_SESSION["id"] == $ADMIN_USER_ID) {

		$date = $_GET["date"];
		$output = "";
		$output2 = "";
		$output3 = "";
		$orderCounter = "";
		$totalPriceInTotal = 0;
		$mostBoughtProductArr = array_fill(0, 10000, 0);
		$timesBoughtProduct = "";

		$query = "SELECT * FROM allOrdersHistory WHERE DATE(orderPlacedTimestamp) = ? ORDER BY orderPlacedTimestamp DESC;";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $date);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1) {

			if ($row = $result->fetch_assoc()) {

				if ($result->num_rows == 1) {

					$orderCounter .= "1 order has";

				} else {

					$orderCounter .= $result->num_rows . " orders have";

				}

			}

		} else {

			$orderCounter .= "No orders have";

		}

		$output3 .= '<p class="all_orders_placed_on_date_chosen_label">' . $orderCounter . ' been placed on this date</p>';

		$query = "SELECT * FROM allOrdersHistory WHERE DATE(orderPlacedTimestamp) = ? GROUP BY userId ORDER BY orderPlacedTimestamp DESC;";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $date);
		$stmt->execute();
		$result = $stmt->get_result();

		$i = 0;

		if ($result->num_rows >= 1) {

			while ($row = $result->fetch_assoc()) {

				$i++;
				$totalPrice = 0;

				$query2 = "SELECT * FROM allOrdersHistory WHERE userId = ? AND DATE(orderPlacedTimestamp) = ? ORDER BY orderPlacedTimestamp DESC;";
				$stmt2 = $db->prepare($query2);
				$stmt2->bind_param("is", $row["userId"], $date);
				$stmt2->execute();
				$result2 = $stmt2->get_result();

				if ($result2->num_rows >= 1) {

					while ($row2 = $result2->fetch_assoc()) {

						$productImage = $row2["productMainPicture"];
						$price = $row2["productPrice"];
						$formatPrice = substr($price, 0, -3);
						$floatPrice = (float)$formatPrice;
						$totalPrice += $floatPrice;
						$totalPriceInTotal += $floatPrice;

					}

				}

				$query3 = "SELECT * FROM allOrdersHistory WHERE userId = ? AND DATE(orderPlacedTimestamp) = ? ORDER BY orderPlacedTimestamp DESC;";
				$stmt3 = $db->prepare($query3);
				$stmt3->bind_param("is", $row["userId"], $date);
				$stmt3->execute();
				$result3 = $stmt3->get_result();

				$targetImageFullPath = "/product_images/" . $productImage;
				$userName = ucfirst($row["firstName"]) . " " . ucfirst($row["lastName"]);
				$userEmail = $row["userEmail"];
				$orderCounterEachUser = $result3->num_rows;
				$userId = $row["userId"];

				$output .= '<div class="inner_outer_main_outer_container_order_products_div" data-userid="' . $userId . '">

									<div class="inner_outer_container_each_order_main_div_all_orders_admin">

										<p class="inner_outer_container_each_order_main_product_order_number">' . $i . '</p>

										<hr class="inner_outer_container_each_order_main_product_order_number_line_break">

										<div class="inner_outer_container_each_order_main_product_image_admin" style="background-image: url(' . $targetImageFullPath . ')"></div>

										<div class="inner_outer_container_each_order_main_product_details_div">

											<div class="inner_outer_container_each_order_main_product_name_admin_helper_container">

												<p class="inner_outer_container_each_order_main_product_name_admin">' . $userName . '</p>

												<p class="inner_outer_container_each_order_main_product_name_admin_2">' . $userEmail . '</p>

											</div>

											<p class="inner_outer_container_each_order_main_product_orders_admin">Orders: ' . $orderCounterEachUser . '</p>

											<p class="inner_outer_container_each_order_main_product_price_admin">Total: ' . $totalPrice . 'RON</p>

										</div>

									</div>

								</div>';

			}

			$query3 = "SELECT * FROM allOrdersHistory WHERE DATE(orderPlacedTimestamp) = ?;";
			$stmt3 = $db->prepare($query3);
			$stmt3->bind_param("s", $date);
			$stmt3->execute();
			$result3 = $stmt3->get_result();

			if ($result3->num_rows >= 1) {

				while ($row3 = $result3->fetch_assoc()) {

					$mostBoughtProductArr[$row3["productId"]]++;

				}

			}

			$output2 .= '<div class="total_price_for_each_date_container_div">

							<p class="total_price_for_each_date total_price_for_each_date_1">Total:</p>

							<p class="total_price_for_each_date total_price_for_each_date_price">' . $totalPriceInTotal . 'RON</p>';

		}

	}

	$maxValueIndex = array_keys($mostBoughtProductArr, max($mostBoughtProductArr));
	$maxValueIndex = $maxValueIndex[count($maxValueIndex) - 1];

	$query = "SELECT * FROM allOrdersHistory WHERE productId = ?;";
	$stmt = $db->prepare($query);
	$stmt->bind_param("i", $maxValueIndex);
	$stmt->execute();
	$result = $stmt->get_result();

	$query3 = "SELECT * FROM allOrdersHistory WHERE productId = ? AND DATE(orderPlacedTimestamp) = ?;";
	$stmt3 = $db->prepare($query3);
	$stmt3->bind_param("is", $maxValueIndex, $date);
	$stmt3->execute();
	$result3 = $stmt3->get_result();

	$timesBoughtProduct = $result3->num_rows . " times";

	if ($result3->num_rows == 1) {

		$timesBoughtProduct = "1 time";

	}

	if ($result->num_rows >= 1) {

		if ($row = $result->fetch_assoc()) {

			$output2 .= '<div class="inner_outer_helper_most_bought_product_container_div">

							<p class="total_price_for_each_most_bought_product total_price_for_each_date_1">Most bought product:</p>

							<p class="total_price_for_each_most_bought_product total_price_for_each_most_bought_product_content">' . $row["productName"] . ' (' . $timesBoughtProduct . ')</p>

						</div>

						</div>';

		}

	}

	$finalOutput  = $output3 . $output2 . $output;

	echo $finalOutput;

?>