<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";

	if (isset($_POST["messageId"]) && isset($_SESSION["id"]) && isset($_POST["messageTypeLabel"]) && isset($_POST["orderId"]) && isset($_POST["convoId"])) {

		$messageId = $_POST["messageId"];
		$messageType = $_POST["messageTypeLabel"];
		$orderId = $_POST["orderId"];
		$convoId = $_POST["convoId"];
		$userId = $_SESSION["id"];

		if ($messageType == "text") {

			$query = "DELETE FROM messages WHERE id = ? AND fromUserId = ?;";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ii", $messageId, $userId);
			$stmt->execute();

		} else if ($messageType == "picture") {

			$query = "SELECT * FROM messages WHERE id = ? AND fromUserId = ?;";
			$stmt = $db->prepare($query);
			$stmt->bind_param("ii", $messageId, $userId);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows >= 1) {

				if ($row = $result->fetch_assoc()) {

					unlink($MAIN_URL_ROOT_USE . "message_images/" . $row["contentImage"]);

					$query1 = "DELETE FROM messages WHERE id = ? AND fromUserId = ?;";
					$stmt1 = $db->prepare($query1);
					$stmt1->bind_param("ii", $messageId, $userId);
					$stmt1->execute();

				}

			}

		}

		$query2 = "UPDATE conversations SET updateDateAndTimestamp = current_timestamp WHERE convoId = ? AND (fromUserIdConvo = ? OR toUserIdConvo = ?) AND orderIdConvo = ?;"; 
		$stmt2 = $db->prepare($query2);
		$stmt2->bind_param("iiii", $convoId, $_SESSION["id"], $_SESSION["id"], $orderId);
		$stmt2->execute();

	}

?>