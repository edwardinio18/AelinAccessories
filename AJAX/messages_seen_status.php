<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";

	if ((isset($_GET["otherOrderId"]) || isset($_GET["orderId"])) && isset($_SESSION["id"])) {

		$numericalOrderId = "";
		$output = "";
		$generalOrderId = "";

		if (isset($_GET["otherOrderId"])) {

			$generalOrderId = $_GET["otherOrderId"];

		}

		if (isset($_GET["orderId"])) {

			$generalOrderId = $_GET["orderId"];
			
		}

		$userId = $_SESSION["id"];

		$query = "SELECT * FROM orders WHERE uniqueOrderId = ? ORDER BY id DESC;";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $generalOrderId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {

			$numericalOrderId = $row["id"];

		}

		$query1 = "SELECT * FROM messages WHERE orderId = ? ORDER BY id DESC LIMIT 1;";
		$stmt1 = $db->prepare($query1);
		$fromUserId = $_SESSION["id"];
		$stmt1->bind_param("i", $numericalOrderId);
		$stmt1->execute();
		$result1 = $stmt1->get_result();

		if ($result1->num_rows >= 1) {

			if ($row1 = $result1->fetch_assoc()) {

				if ($row1['status'] == 1 && $row1["fromUserId"] == $_SESSION["id"]) {

					$output = '<p class="message_seen" id="message_seen_' . $numericalOrderId . '">Seen</p>';

				}

			}

		}

		echo $output;

	}

?>