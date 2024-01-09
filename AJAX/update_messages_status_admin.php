<?php

	include "/home/j80axz1n1oj4/public_html/variables.php";
	include $MAIN_URL_ROOT_USE . "scripts/main.php";

	if (isset($_POST["orderId"]) && isset($_SESSION["id"]) && isset($_POST["toUserId"])) {

		$numericalOrderId = "";
		$output = "";

		$orderId = $_POST["orderId"];
		$toUserId = $_POST["toUserId"];
		$userId = $_SESSION["id"];

		$query = "SELECT * FROM orders WHERE uniqueOrderId = ? ORDER BY id DESC;";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $orderId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {

			$numericalOrderId = $row["id"];

		}

		$query1 = "UPDATE messages SET status = ? WHERE fromUserId = ? AND toUserId = ? AND orderId = ? AND status = ?;";
		$stmt1 = $db->prepare($query1);
		$status = 1;
		$status0 = 0;
		$stmt1->bind_param("iiiii", $status, $_SESSION["id"], $toUserId, $numericalOrderId, $status0);
		$stmt1->execute();

	}

?>