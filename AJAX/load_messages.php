<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";
	include_once $MAIN_URL_ROOT_USE . "Color.php";

	use Mexitek\PHPColors\Color;

	if (isset($_GET["convoId"]) && isset($_GET["orderId"]) && isset($_GET["offset"]) && isset($_SESSION["id"])) {

		$numericalOrderId = "";
		$output = "";
		$content = "";
		$fromWhoClassContentImage = "";
		$fromWhoClassContent = "";
		$fromWhoClassTimestamp = "";
		$fromWhoClassContainerDiv = "";
		$fromWhoClassContainerWrapper = "";
		$mostCommonColorFinalResult = "";
		$deleteMessageImage = "";
		$messageContent = "";

		$convoId = $_GET["convoId"];
		$orderId = $_GET["orderId"];
		$offset = $_GET["offset"];
		$userId = $_SESSION["id"];

		$query = "SELECT * FROM orders WHERE uniqueOrderId = ? ORDER BY id DESC;";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $orderId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {

			$numericalOrderId = $row["id"];

		}

		$query1 = "SELECT * FROM conversations WHERE convoId = ? AND fromUserIdConvo = ? AND orderIdConvo = ? ORDER BY updateDateAndTimestamp DESC;";
		$stmt1 = $db->prepare($query1);
		$stmt1->bind_param("iii", $convoId, $userId, $numericalOrderId);
		$stmt1->execute();
		$result1 = $stmt1->get_result();

		if ($result1->num_rows >= 1) {

			if ($row1 = $result1->fetch_assoc()) {

				$query2 = "SELECT * FROM messages WHERE orderId = ? ORDER BY id DESC LIMIT 7 OFFSET " . $offset . ";";
				$stmt2 = $db->prepare($query2);
				$stmt2->bind_param("i", $numericalOrderId);
				$stmt2->execute();
				$result2 = $stmt2->get_result();

				if ($result2->num_rows >= 1) {

					while ($row2 = $result2->fetch_assoc()) {

						$imagePath = $MAIN_SUB_URL_ROOT_USE . "message_images/";
						$fullImagePath = $imagePath . $row2["contentImage"];
						$formattedDateAndTimeSent = date("H:i, d/m/Y", strtotime($row2["messageSentTimestamp"]));

						if (strip_tags(trim(decrypt($row2["contentText"], $key))) == "" && $row2["contentImage"] == "") {

							$messageContent = "No content";

						} else if ($row2["contentText"] == "") {

							$messageContent = $row2["contentImage"];

						} else {

							$messageContent = decrypt($row2["contentText"], $key);

						}

						if ($row2["fromUserId"] == $userId) {

							$fromWhoClassContainerWrapper = "each_message_from_me_container_div";
							$fromWhoClassContainerDiv = "each_message_from_me_container_div";
							$fromWhoClassTimestamp = "each_message_from_me_timestamp";
							$fromWhoClassContent = "each_message_from_me_content";
							$fromWhoClassContentImage = "each_message_from_me_image";
							$fromWhoClassTimestampImage = "each_message_from_me_timestamp_image";

							if ($_SESSION["id"] == $ADMIN_USER_ID) {

								$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image_admin" data-messageid="' . $row2["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row2["toUserId"] . '" data-convoid="' . $row1["convoId"] . '" />';

							} else {

								$deleteMessageImage = '<img src="images/bin.png" class="delete_chat_bin_image" data-messageid="' . $row2["id"] . '" data-messagecontent="' . $messageContent . '" data-orderid="' . $numericalOrderId . '" data-otherorderid="' . $orderId . '" data-touserid="' . $row2["toUserId"] . '" data-convoid="' . $row1["convoId"] . '" />';

							}

						} else {

							$fromWhoClassContainerWrapper = "each_message_from_them_container_div";
							$fromWhoClassContainerDiv = "each_message_from_them_container_div";
							$fromWhoClassTimestamp = "each_message_from_them_timestamp";
							$fromWhoClassContent = "each_message_from_them_content";
							$fromWhoClassContentImage = "each_message_from_them_image";
							$fromWhoClassTimestampImage = "each_message_from_them_timestamp_image";
							$deleteMessageImage = "";

						}

						if ($row2["contentImage"] != "") {

							$mostCommonColorObject = new GetMostCommonColors();

							$mostCommonColorFinalResult = "";

							$resultNumber = 5;
							$reduceBrightness = 1;
							$reduceGradients = 1;
							$delta = 30;
							$mostCommonColor = $mostCommonColorObject->Get_Color($MAIN_URL_ROOT_USE . "message_images/" . $row2["contentImage"], $resultNumber, $reduceBrightness, $reduceGradients, $delta);
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

							$content = '<p class="' . $fromWhoClassTimestampImage . '">' . $formattedDateAndTimeSent . '</p>

										<img src="' . $fullImagePath . '" data-imagesource="' . $fullImagePath . '" data-bgcolor="' . $mostCommonColorFinalResult . '" class="' . $fromWhoClassContentImage . ' message_image" />';

						} else {

							$content = '<p class="' . $fromWhoClassTimestamp . '">' . $formattedDateAndTimeSent . '</p>

										<p class="' . $fromWhoClassContent . '">' . $messageContent . '</p>';

						}

						$output .= '<div class="each_message_outer_main_container_wrapper" id="each_message_outer_main_container_wrapper_' . $row2["id"] . '">
					
										<div class="' . $fromWhoClassContainerDiv . '">

											' . $deleteMessageImage . '
										
											' . $content . '

										</div>

									</div>';

					}

				}

			}

		}

	}

	echo $output;

?>