<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";
	include_once $MAIN_URL_ROOT_USE . "Color.php";

	use Mexitek\PHPColors\Color;

	if ((isset($_POST["send_message_textarea"]) || isset($_FILES["uploaded_pictures"])) && isset($_POST["convoId"]) && isset($_POST["orderId"]) && isset($_POST["toUserId"])) {

		$numericalOrderId = "";
		$convoId = $_POST["convoId"];
		$orderId = $_POST["orderId"];
		$toUserId = $_POST["toUserId"];
		$output = "";
		$errors = 0;
		$messageContent = "";

		$query = "SELECT * FROM orders WHERE uniqueOrderId = ? ORDER BY id DESC;";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $orderId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {

			$numericalOrderId = $row["id"];

		}

		if ($_FILES["uploaded_pictures"]["size"][0] === 0) {

			$messageContentTrimmed = trim($_POST["send_message_textarea"]);
			$strippedTagsMessage = strip_tags($messageContentTrimmed);

			if (strlen($strippedTagsMessage) <= 1000) {

				$query1 = "UPDATE conversations SET updateDateAndTimestamp = current_timestamp WHERE convoId = ? AND (fromUserIdConvo = ? OR toUserIdConvo = ?) AND orderIdConvo = ?;"; 
				$stmt1 = $db->prepare($query1);
				$stmt1->bind_param("iiii", $convoId, $_SESSION["id"], $_SESSION["id"], $numericalOrderId);
				$stmt1->execute();

				$query2 = "INSERT INTO messages (fromUserId, toUserId, contentText, contentImage, status, orderId) VALUES (?, ?, ?, ?, ?, ?);";
				$stmt2 = $db->prepare($query2);
				$encryptedMessageContent = encrypt($strippedTagsMessage, $key);
				$emptyImageContent = "";
				$status = 0;
				$stmt2->bind_param("iissii", $_SESSION["id"], $toUserId, $encryptedMessageContent, $emptyImageContent, $status, $numericalOrderId);
				$stmt2->execute();

				$lastInsertedMessageId = $db->insert_id;

				$query3 = "SELECT * FROM messages WHERE id = ? AND fromUserId = ? AND orderId = ? ORDER BY id DESC;";
				$stmt3 = $db->prepare($query3);
				$stmt3->bind_param("iii", $lastInsertedMessageId, $_SESSION["id"], $numericalOrderId);
				$stmt3->execute();
				$result3 = $stmt3->get_result();

				if ($row3 = $result3->fetch_assoc()) {

					$formattedDateAndTimeSent = date("H:i, d/m/Y", strtotime($row3["messageSentTimestamp"]));

					$messageContent = decrypt($row3["contentText"], $key);

					if ($_SESSION["id"] == $ADMIN_USER_ID) {

						$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image_admin" data-messageid="' . $row3["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row3["toUserId"] . '" data-convoid="' . $convoId . '" />';

					} else {

						$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image" data-messageid="' . $row3["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row3["toUserId"] . '" data-convoid="' . $convoId . '" />';

					}

					if (strip_tags(trim(decrypt($row3["contentText"], $key))) == "" && $row3["contentImage"] == "") {

						$messageContent = "No content";

					} else if ($row3["contentText"] == "") {

						$messageContent = $row3["contentImage"];

					} else {

						$messageContent = decrypt($row3["contentText"], $key);

					}

					$output .= '<div class="each_message_outer_main_container_wrapper" id="each_message_outer_main_container_wrapper_' . $row3["id"] . '">
						
									<div class="each_message_from_me_container_div">

										' . $deleteMessageImage . '
									
										<p class="each_message_from_me_timestamp">' . $formattedDateAndTimeSent . '</p>

										<p class="each_message_from_me_content">' . $messageContent . '</p>

									</div>

								</div>';

				}

			}

		} else {

			$query1 = "UPDATE conversations SET updateDateAndTimestamp = current_timestamp WHERE convoId = ? AND (fromUserIdConvo = ? OR toUserIdConvo = ?) AND orderIdConvo = ?;"; 
			$stmt1 = $db->prepare($query1);
			$stmt1->bind_param("iiii", $convoId, $_SESSION["id"], $_SESSION["id"], $numericalOrderId);
			$stmt1->execute();

			$messageContentTrimmed = trim($_POST["send_message_textarea"]);
			$strippedTagsMessage = strip_tags($messageContentTrimmed);

			$encryptedMessageContent = "";

			if (strlen($strippedTagsMessage) > 0) {

				$encryptedMessageContent = encrypt($strippedTagsMessage, $key);

				$query2 = "INSERT INTO messages (fromUserId, toUserId, contentText, contentImage, status, orderId) VALUES (?, ?, ?, ?, ?, ?);";
				$stmt2 = $db->prepare($query2);
				$emptyImageContent = "";
				$status = 0;
				$stmt2->bind_param("iissii", $_SESSION["id"], $toUserId, $encryptedMessageContent, $emptyImageContent, $status, $numericalOrderId);
				$stmt2->execute();

				$lastInsertedMessageId = $db->insert_id;

				$query3 = "SELECT * FROM messages WHERE id = ? AND fromUserId = ? AND orderId = ? ORDER BY id DESC;";
				$stmt3 = $db->prepare($query3);
				$stmt3->bind_param("iii", $lastInsertedMessageId, $_SESSION["id"], $numericalOrderId);
				$stmt3->execute();
				$result3 = $stmt3->get_result();

				if ($row3 = $result3->fetch_assoc()) {

					$formattedDateAndTimeSent = date("H:i, d/m/Y", strtotime($row3["messageSentTimestamp"]));

					$messageContent = decrypt($row3["contentText"], $key);

					if ($_SESSION["id"] == $ADMIN_USER_ID) {

						$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image_admin" data-messageid="' . $row3["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row3["toUserId"] . '" data-convoid="' . $convoId . '" />';

					} else {

						$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image" data-messageid="' . $row3["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row3["toUserId"] . '" data-convoid="' . $convoId . '" />';

					}

					if (strip_tags(trim(decrypt($row3["contentText"], $key))) == "" && $row3["contentImage"] == "") {

						$messageContent = "No content";

					} else if ($row3["contentText"] == "") {

						$messageContent = $row3["contentImage"];

					} else {

						$messageContent = decrypt($row3["contentText"], $key);

					}

					$output .= '<div class="each_message_outer_main_container_wrapper" id="each_message_outer_main_container_wrapper_' . $row3["id"] . '">
						
									<div class="each_message_from_me_container_div">

										' . $deleteMessageImage . '
									
										<p class="each_message_from_me_timestamp">' . $formattedDateAndTimeSent . '</p>

										<p class="each_message_from_me_content">' . $messageContent . '</p>

									</div>

								</div>';

				}

			}

			$targetImagePath = $MAIN_URL_ROOT_USE . "message_images/";

			foreach ($_FILES["uploaded_pictures"]["size"] as $uploadedImage) {

				if ($uploadedImage > 10485760) {

					$errors = 1;

				}

			}

			if ($errors == 0) {

				foreach ($_FILES["uploaded_pictures"]["tmp_name"] as $uploadedImage) {

					$newImageName = uniqid() . ".png";

					$query3 = "INSERT INTO messages (fromUserId, toUserId, contentText, contentImage, status, orderId) VALUES (?, ?, ?, ?, ?, ?);";
					$stmt3 = $db->prepare($query3);
					$encryptedMessageContent = "";
					$status = 0;
					$stmt3->bind_param("iissii", $_SESSION["id"], $toUserId, $encryptedMessageContent, $newImageName, $status, $numericalOrderId);
					$stmt3->execute();

					move_uploaded_file($uploadedImage, $targetImagePath . $newImageName);

					$lastInsertedMessageId = $db->insert_id;

					$query4 = "SELECT * FROM messages WHERE id = ? AND fromUserId = ? AND orderId = ? ORDER BY id DESC;";
					$stmt4 = $db->prepare($query4);
					$stmt4->bind_param("iii", $lastInsertedMessageId, $_SESSION["id"], $numericalOrderId);
					$stmt4->execute();
					$result4 = $stmt4->get_result();

					$imagePath = $MAIN_SUB_URL_ROOT_USE . "message_images/";

					if ($row4 = $result4->fetch_assoc()) {

						$fullImagePath = $imagePath . $row4["contentImage"];

						$mostCommonColorObject = new GetMostCommonColors();

						$mostCommonColorFinalResult = "";

						$resultNumber = 5;
						$reduceBrightness = 1;
						$reduceGradients = 1;
						$delta = 30;
						$mostCommonColor = $mostCommonColorObject->Get_Color($MAIN_URL_ROOT_USE . "message_images/" . $row4["contentImage"], $resultNumber, $reduceBrightness, $reduceGradients, $delta);
						$mostCommonColorBackgroundColorHashtag = "#";
						$mostCommonColorBackgroundColor = "";
						$firstColor = "";
						$secondColor = "";
						$colorFactor = 0.5;

						$colorArrayCount = count($mostCommonColor);

						$mostCommonColorMinumumColorsArrayDark = array();
						$firstElementColorArrayDark = reset($mostCommonColorMinumumColorsArrayDark);
						$lastElementColorArrayDark = end($mostCommonColorMinumumColorsArrayDark);

						$mostCommonColorMinumumColorsArrayLight = array();
						$firstElementColorArrayLight = reset($mostCommonColorMinumumColorsArrayLight);
						$lastElementColorArrayLight = end($mostCommonColorMinumumColorsArrayLight);

						$darkColor = false;
						$lightColor = false;

						if ($colorArrayCount < 5) {

							foreach ($mostCommonColor as $hex => $count) {

								$singleMostCommonColorHex = $mostCommonColorBackgroundColorHashtag . $hex;

								$singleMostCommonColor = new Color($singleMostCommonColorHex);

								$singleMostCommonColorDark = $singleMostCommonColor->isDark();

								$singleMostCommonColorLight = $singleMostCommonColor->isLight();

								if ($singleMostCommonColorDark) {

									$darkColor = true;

									$singleMostCommonColorDarkLightened = $singleMostCommonColor->lighten();
									array_push($mostCommonColorMinumumColorsArrayDark, $singleMostCommonColorDarkLightened);

								} else if ($singleMostCommonColorLight) {

									$lightColor = true;

									$singleMostCommonColorLightDarkened = $singleMostCommonColor->darken();
									array_push($mostCommonColorMinumumColorsArrayLight, $singleMostCommonColorLightDarkened);

								}

							}

							if ($darkColor) {

								$firstElementColorArrayDark = reset($mostCommonColorMinumumColorsArrayDark);
								$lastElementColorArrayDark = end($mostCommonColorMinumumColorsArrayDark);

								$mostCommonColorFinalResult = colorAverage($firstElementColorArrayDark, $lastElementColorArrayDark, $colorFactor);

							} else if ($lightColor) {

								$firstElementColorArrayLight = reset($mostCommonColorMinumumColorsArrayLight);
								$lastElementColorArrayLight = end($mostCommonColorMinumumColorsArrayLight);

								$mostCommonColorFinalResult = colorAverage($firstElementColorArrayLight, $lastElementColorArrayLight, $colorFactor);

							}

						} else {

							foreach ($mostCommonColor as $hex => $count) {

								if ($hex === array_keys($mostCommonColor)[0]) {

									$firstColor = "#" . $hex;

								}

								if ($hex === array_keys($mostCommonColor)[4]) {

									$secondColor = "#" . $hex;

								}

							}

							$mostCommonColorFinalResult = colorAverage($firstColor, $secondColor, $colorFactor);

						}

						$formattedDateAndTimeSent = date("H:i, d/m/Y", strtotime($row4["messageSentTimestamp"]));

						$messageContent = $row4["contentImage"];

						if ($_SESSION["id"] == $ADMIN_USER_ID) {

							$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image_admin" data-messageid="' . $row4["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row4["toUserId"] . '" data-convoid="' . $convoId . '" />';

						} else {

							$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image" data-messageid="' . $row4["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row4["toUserId"] . '" data-convoid="' . $convoId . '" />';

						}

						$output .= '<div class="each_message_outer_main_container_wrapper" id="each_message_outer_main_container_wrapper_' . $row4["id"] . '">
						
										<div class="each_message_from_me_container_div">

											' . $deleteMessageImage . '
										
											<p class="each_message_from_me_timestamp_image">' . $formattedDateAndTimeSent . '</p>

											<img src="' . $fullImagePath . '" data-imagesource="' . $fullImagePath . '" data-bgcolor="' . $mostCommonColorFinalResult . '" class="each_message_from_me_image message_image" />

										</div>

									</div>';

					}

				}

			} else {

				$output = 1;

			}

		}

	}

	echo $output;

?>