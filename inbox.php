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

	<div class="opened_image_outer_container_div"></div>

	<div class="opened_image_outer_container_secondary_div"></div>

	<?php

		require_once realpath(dirname(__FILE__) . "/snippets/nav_bar.php");

	?>

	<h1 class="page_main_label">My Inbox</h1>

	<div class="image_upload_amount_limit_error_container_div"></div>

	<div class="main_outer_inbox_div">

		<div class="mobile_helper_div"></div>

		<div class="left_main_outer_container_inbox_div">

				<?php

					$output = "";
					$userIdConvo = "";

					if (isset($_SESSION["id"])) {

						if ($_SESSION["id"] == $ADMIN_USER_ID) {

							$output .= '<input type="text" placeholder="Search by order #" class="left_top_search_bar_inbox_input_admin" maxlength="100" />

										<div class="search_conversations_result_container_div"></div>

										<div class="conversations_main_outer_left_container_div">';

							$query1 = "SELECT * FROM conversations JOIN orders ON orders.id = conversations.orderIdConvo JOIN products ON products.id = orders.productId WHERE conversations.toUserIdConvo = ? ORDER BY updateDateAndTimestamp DESC;";
							$stmt1 = $db->prepare($query1);
							$stmt1->bind_param("i", $_SESSION["id"]);
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

											} else if ($row2["contentText"] != "") {

												$lastMessage = decrypt($row2["contentText"], $key);

											} else if ($row2["contentText"] == "") {

												if ($row2["contentImage"] != "") {

													$lastMessage = "Image attachment";

												}

											}

											$productImagePath = "product_images/" . $row1["mainPicture"];
											$uniqueOrderId = $row1["uniqueOrderId"];
											$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row1["updateDateAndTimestamp"]));
											$conversationId = $row1["convoId"];
											$userIdConvo = $row1["fromUserIdConvo"];

											$output .= '<div class="each_conversation_main_outer_container_div_admin each_conversation_main_outer_container_div_admin_' . $row1["orderIdConvo"] . '" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row1["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-orderid="' . $row1["orderIdConvo"] . '" data-touserid="' . $userIdConvo . '">

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

										$lastMessage = "New order!";
										$productImagePath = "product_images/" . $row1["mainPicture"];
										$uniqueOrderId = $row1["uniqueOrderId"];
										$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row1["updateDateAndTimestamp"]));
										$conversationId = $row1["convoId"];
										$userIdConvo = $row1["fromUserIdConvo"];

										$output .= '<div class="each_conversation_main_outer_container_div_admin each_conversation_main_outer_container_div_admin_' . $row1["orderIdConvo"] . '" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row1["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-orderid="' . $row1["orderIdConvo"] . '" data-touserid="' . $userIdConvo . '">
							
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

								}

							}

						} else {

							$output .= '<input type="text" placeholder="Search by order #" class="left_top_search_bar_inbox_input" maxlength="100" />

										<div class="search_conversations_result_container_div"></div>

										<div class="conversations_main_outer_left_container_div">';

							$query = "SELECT * FROM users WHERE email = ?;";
							$stmt = $db->prepare($query);
							$stmt->bind_param("s", $_SESSION["user"]);
							$stmt->execute();
							$result = $stmt->get_result();

							$userId = "";

							if ($row = $result->fetch_assoc()) {

								$userId = $row["id"];

							}

							$query1 = "SELECT * FROM conversations JOIN orders ON orders.id = conversations.orderIdConvo JOIN products ON products.id = orders.productId WHERE conversations.fromUserIdConvo = ? ORDER BY updateDateAndTimestamp DESC;";
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

											} else if ($row2["contentText"] != "") {

												$lastMessage = decrypt($row2["contentText"], $key);

											} else if ($row2["contentText"] == "") {

												if ($row2["contentImage"] != "") {

													$lastMessage = "Image attachment";

												}

											}

											$productImagePath = "product_images/" . $row1["mainPicture"];
											$uniqueOrderId = $row1["uniqueOrderId"];
											$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row1["updateDateAndTimestamp"]));
											$conversationId = $row1["convoId"];
											$userIdConvo = $row1["toUserIdConvo"];

											$output .= '<div class="each_conversation_main_outer_container_div each_conversation_main_outer_container_div_' . $row1["orderIdConvo"] . '" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row1["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-orderid="' . $row1["orderIdConvo"] . '" data-touserid="' . $userIdConvo . '">
								
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

										$lastMessage = "New order!";
										$productImagePath = "product_images/" . $row1["mainPicture"];
										$uniqueOrderId = $row1["uniqueOrderId"];
										$formattedDateAndTimeCreatedConvo = date("H:i, d/m/Y", strtotime($row1["updateDateAndTimestamp"]));
										$conversationId = $row1["convoId"];
										$userIdConvo = $row1["toUserIdConvo"];

										$output .= '<div class="each_conversation_main_outer_container_div each_conversation_main_outer_container_div_' . $row1["orderIdConvo"] . '" id="' . $uniqueOrderId . '" data-convoid="' . $conversationId . '" data-orderid="' . $row1["orderIdConvo"] . '" data-imagesource="' . $productImagePath . '" data-orderid="' . $row1["orderIdConvo"] . '" data-touserid="' . $userIdConvo . '">
							
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

								}

							}

						}

					}

					echo $output;

				?>

			</div>

		</div>

		<div class="right_main_outer_container_inbox">
			
			<div class="select_and_open_conversation_div">
				
				<h1 class="select_conversation_label">No conversation opened!</h1>

				<p class="open_conversation_label">Click on a conversation to open it here</p>

			</div>

		</div>

	</div>

	<div class="account_settings_back_button_orders_div">
				
		<button class="account_settings_back_button_orders" onclick="window.location = '/<?php echo basename(__DIR__); ?>/profile'">Back</button>

	</div>

</body>

<script type="text/javascript" src="./scripts/main.js"></script>

</html>