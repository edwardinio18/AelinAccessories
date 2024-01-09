<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";

	$output = "";

	$query = "SELECT * FROM users WHERE email = ?;";
	$stmt = $db->prepare($query);
	$stmt->bind_param("s", $_SESSION["user"]);
	$stmt->execute();
	$result = $stmt->get_result();

	$userId = "";

	if ($row = $result->fetch_assoc()) {

		$userId = $row["id"];

	}

	$query1 = "SELECT * FROM conversations JOIN orders ON orders.id = conversations.orderIdConvo JOIN products ON products.id = orders.productId WHERE conversations.fromUserIdConvo = ? ORDER BY updateDateAndTimestamp DESC LIMIT 1;";
	$stmt1 = $db->prepare($query1);
	$stmt1->bind_param("i", $userId);
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	if ($result1->num_rows >= 1) {

		while ($row1 = $result1->fetch_assoc()) {

			$query2 = "SELECT * FROM messages WHERE orderId = ? ORDER BY id DESC;";
			$stmt2 = $db->prepare($query2);
			$stmt2->bind_param("i", $row1["orderIdConvo"]);
			$stmt2->execute();
			$result2 = $stmt2->get_result();

			$lastMessage = "";

			if ($result2->num_rows >= 1) {

				if ($row2 = $result2->fetch_assoc()) {

					if (strip_tags(trim(decrypt($row2["contentText"], $key))) == "" && $row2["contentImage"] == "") {

						$lastMessage = "No content";

					} else if ($row2["contentText"] == "") {

						$lastMessage = "Image attachment";

					} else {

						$lastMessage = decrypt($row2["contentText"], $key);

					}

					$productImagePath = "product_images/" . $row1["mainPicture"];
					$uniqueOrderId = $row1["uniqueOrderId"];
					$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row1["updateDateAndTimestamp"]));
					$conversationId = $row1["convoId"];
					$userIdConvo = $row1["toUserIdConvo"];

					$output .= '<div class="each_conversation_main_outer_container_div each_conversation_main_outer_container_div_' . $row1["orderIdConvo"] . ' active_conversation" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row1["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-touserid="' . $userIdConvo . '">

									<div class="each_conversation_product_image active_conversation_product_image" style="background-image: url(' . $productImagePath . ')" id="product_conversation_' . $uniqueOrderId . '"></div>

									<p class="each_conversation_product_order_id">' . $uniqueOrderId . '</p>

									<div class="each_conversation_last_messages_info_div">
										
										<p class="each_conversation_message_content">' . $lastMessage . '</p>

										<p class="each_conversation_message_content_2">&#9679;</p>

										<p class="each_conversation_message_content_3">' . $formattedDateAndTimeCreatedConvo . '</p>

									</div>

									' . unSeenMessagesCounter($_SESSION["id"], $row1["orderIdConvo"], $db) . '
								
								</div>';

				}

			} else {

				$lastMessage = "New order!";

				$productImagePath = "product_images/" . $row1["mainPicture"];
				$uniqueOrderId = $row1["uniqueOrderId"];
				$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row1["updateDateAndTimestamp"]));
				$conversationId = $row1["convoId"];
				$userIdConvo = $row1["toUserIdConvo"];

				$output .= '<div class="each_conversation_main_outer_container_div each_conversation_main_outer_container_div_' . $row1["orderIdConvo"] . ' active_conversation" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row1["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-touserid="' . $userIdConvo . '">

								<div class="each_conversation_product_image active_conversation_product_image" style="background-image: url(' . $productImagePath . ')" id="product_conversation_' . $uniqueOrderId . '"></div>

								<p class="each_conversation_product_order_id">' . $uniqueOrderId . '</p>

								<div class="each_conversation_last_messages_info_div">
									
									<p class="each_conversation_message_content">' . $lastMessage . '</p>

									<p class="each_conversation_message_content_2">&#9679;</p>

									<p class="each_conversation_message_content_3">' . $formattedDateAndTimeCreatedConvo . '</p>

								</div>

								' . unSeenMessagesCounter($_SESSION["id"], $row1["orderIdConvo"], $db) . '
							
							</div>';

			}

		}

	}

	$query5 = "SELECT * FROM conversations WHERE fromUserIdConvo = ?;";
	$stmt5 = $db->prepare($query5);
	$stmt5->bind_param("i", $userId);
	$stmt5->execute();
	$result5 = $stmt5->get_result();

	$rowsLimit = $result5->num_rows - 1;

	$query3 = "SELECT * FROM conversations JOIN orders ON orders.id = conversations.orderIdConvo JOIN products ON products.id = orders.productId WHERE conversations.fromUserIdConvo = ? ORDER BY updateDateAndTimestamp DESC LIMIT " . $rowsLimit . " OFFSET 1;";
	$stmt3 = $db->prepare($query3);
	$stmt3->bind_param("i", $userId);
	$stmt3->execute();
	$result3 = $stmt3->get_result();

	if ($result3->num_rows >= 1) {

		while ($row3 = $result3->fetch_assoc()) {

			$query4 = "SELECT * FROM messages WHERE orderId = ? ORDER BY id DESC;";
			$stmt4 = $db->prepare($query4);
			$stmt4->bind_param("i", $row3["orderIdConvo"]);
			$stmt4->execute();
			$result4 = $stmt4->get_result();

			$lastMessage = "";

			if ($result4->num_rows >= 1) {

				if ($row4 = $result4->fetch_assoc()) {

					if (strip_tags(trim(decrypt($row4["contentText"], $key))) == "" && $row4["contentImage"] == "") {

						$lastMessage = "No content";

					} else if ($row4["contentText"] == "") {

						$lastMessage = "Image attachment";

					} else {

						$lastMessage = decrypt($row4["contentText"], $key);

					}

					$productImagePath = "product_images/" . $row3["mainPicture"];
					$uniqueOrderId = $row3["uniqueOrderId"];
					$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row3["updateDateAndTimestamp"]));
					$conversationId = $row3["convoId"];
					$userIdConvo = $row3["toUserIdConvo"];

					$output .= '<div class="each_conversation_main_outer_container_div each_conversation_main_outer_container_div_' . $row3["orderIdConvo"] . '" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row3["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-touserid="' . $userIdConvo . '">

									<div class="each_conversation_product_image" style="background-image: url(' . $productImagePath . ')" id="product_conversation_' . $uniqueOrderId . '"></div>

									<p class="each_conversation_product_order_id">' . $uniqueOrderId . '</p>

									<div class="each_conversation_last_messages_info_div">
										
										<p class="each_conversation_message_content">' . $lastMessage . '</p>

										<p class="each_conversation_message_content_2">&#9679;</p>

										<p class="each_conversation_message_content_3">' . $formattedDateAndTimeCreatedConvo . '</p>

									</div>

									' . unSeenMessagesCounter($_SESSION["id"], $row3["orderIdConvo"], $db) . '
								
								</div>';

				}

			} else {

				$lastMessage = "New order!";

				$productImagePath = "product_images/" . $row3["mainPicture"];
				$uniqueOrderId = $row3["uniqueOrderId"];
				$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row3["updateDateAndTimestamp"]));
				$conversationId = $row3["convoId"];
				$userIdConvo = $row3["toUserIdConvo"];

				$output .= '<div class="each_conversation_main_outer_container_div each_conversation_main_outer_container_div_' . $row3["orderIdConvo"] . '" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row3["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-touserid="' . $userIdConvo . '">

								<div class="each_conversation_product_image" style="background-image: url(' . $productImagePath . ')" id="product_conversation_' . $uniqueOrderId . '"></div>

								<p class="each_conversation_product_order_id">' . $uniqueOrderId . '</p>

								<div class="each_conversation_last_messages_info_div">
									
									<p class="each_conversation_message_content">' . $lastMessage . '</p>

									<p class="each_conversation_message_content_2">&#9679;</p>

									<p class="each_conversation_message_content_3">' . $formattedDateAndTimeCreatedConvo . '</p>

								</div>

								' . unSeenMessagesCounter($_SESSION["id"], $row3["orderIdConvo"], $db) . '
							
							</div>';

			}

		}

	}

	echo $output;

?>