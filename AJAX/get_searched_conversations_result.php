<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";

	$searchedOrderVal = "";

	if (isset($_GET["orderIdCurVal"]) && isset($_SESSION["id"])) {

		$searchedOrderVal = "%" . $_GET["orderIdCurVal"] . "%";

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

		$query1 = "SELECT * FROM conversations JOIN orders ON orders.id = conversations.orderIdConvo JOIN products ON products.id = orders.productId WHERE conversations.fromUserIdConvo = ? AND uniqueOrderId LIKE ?;";
		$stmt1 = $db->prepare($query1);
		$stmt1->bind_param("is", $userId, $searchedOrderVal);
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

					}

				} else {

					$lastMessage = "New order!";

				}

				$productImagePath = "product_images/" . $row1["mainPicture"];
				$uniqueOrderId = $row1["uniqueOrderId"];
				$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row1["updateDateAndTimestamp"]));
				$conversationId = $row1["convoId"];
				$userIdConvo = $row1["toUserIdConvo"];

				$output .= '<div class="each_conversation_main_outer_container_div each_conversation_main_outer_container_div_' . $row1["orderIdConvo"] . '" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row1["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-touserid="' . $userIdConvo . '">

								<div class="each_conversation_product_image" style="background-image: url(' . $productImagePath . ')" id="product_conversation_' . $uniqueOrderId . '"></div>

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

			$output = '<p class="no_matching_conversations_label">The entered order # doesn\'t seem to match any of your orders!</p>';

		}

	}

	echo $output;

?>