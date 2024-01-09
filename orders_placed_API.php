<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");
	include realpath(dirname(__FILE__) . "/stripe-php-master/init.php");

	error_reporting(-1);
	ini_set('display_errors', 'On');
	set_error_handler("var_dump");

	use PHPMailer\PHPMailer\PHPMailer;

	require realpath(dirname(__DIR__) . "/vendor/autoload.php");

	function replaceFirstOccurance($from, $to, $content) {

		$from = '/' . preg_quote($from, '/') . '/';

		return preg_replace($from, $to, $content, 1);

	}

	$payload = @file_get_contents('php://input');
	$event = null;

	try {

	    $event = \Stripe\Event::constructFrom(json_decode($payload, true));

	} catch(\UnexpectedValueException $e) {

	    http_response_code(400);
	    exit();

	}

	if ($event->type === "payment_intent.succeeded") {

		$paymentIntent = $event->data->object;
		$userEmail = $paymentIntent->charges->data[0]->billing_details->email;
		$receiptURL = $paymentIntent->charges->data[0]->receipt_url;
		$productName = replaceFirstOccurance(" ", "", $paymentIntent->charges->data[0]->description);
		$productNameStripped = substr($productName, strpos($productName, "x") + 1);
		$uniqueOrderID = md5(uniqid(md5(uniqid(bin2hex(random_bytes(100))))));
		$userId = "";
		$productId = "";
		$userFirstName = "";
		$userLastName = "";
		$userEmailDB = "";
		$productPrice = "";
		$productMainPicture = "";
		$userAddress = "";
		$userShippingOption = "";
		$userPhone = "";

		$query = "SELECT * FROM users WHERE email = ?;";
		$stmt = $db->prepare($query);
		$stmt->bind_param("s", $userEmail);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 1) {

			if ($row = $result->fetch_assoc()) {

				$userId = $row["id"];
				$userFirstName = $row["firstName"];
				$userLastName = $row["lastName"];
				$userEmailDB = $row["email"];
				$userAddress = $row["address"];
				$userShippingOption = $row["shipping"];
				$userPhone = $row["phone"];

			}

		}

		$query1 = "SELECT * FROM products WHERE name = ?;";
		$stmt1 = $db->prepare($query1);
		$stmt1->bind_param("s", $productNameStripped);
		$stmt1->execute();
		$result1 = $stmt1->get_result();

		if ($result1->num_rows == 1) {

			if ($row1 = $result1->fetch_assoc()) {

				$productId = $row1["id"];
				$productPrice = $row1["price"];
				$productMainPicture = $row1["mainPicture"];

			}

		}

		$query4 = "INSERT INTO allOrdersHistory (userId, userEmail, firstName, lastName, address, shipping, phone, productName, productId, productPrice, productMainPicture, uniqueOrderId, receiptURL) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt4 = $db->prepare($query4);
		$stmt4->bind_param("isssssssissss", $userId, $userEmailDB, $userFirstName, $userLastName, $userAddress, $userShippingOption, $userPhone, $productNameStripped, $productId, $productPrice, $productMainPicture, $uniqueOrderID, $receiptURL);
		$stmt4->execute();

		$query2 = "INSERT INTO orders (userId, productId, uniqueOrderId, receiptURL) VALUES (?, ?, ?, ?);";
		$stmt2 = $db->prepare($query2);
		$stmt2->bind_param("iiss", $userId, $productId, $uniqueOrderID, $receiptURL);
		$stmt2->execute();

		$lastInsertedOrderId = $db->insert_id;

		$query3 = "INSERT INTO conversations (fromUserIdConvo, toUserIdConvo, orderIdConvo) VALUES (?, ?, ?);";
		$stmt3 = $db->prepare($query3);
		$adminId = $ADMIN_USER_ID;
		$stmt3->bind_param("iii", $userId, $adminId, $lastInsertedOrderId);
		$stmt3->execute();

		$mail = new PHPMailer(true);

		$emailBody = "<p>Order number: " . $uniqueOrderID . "</p><p>Thank you for shopping at AelinAccessories! We hope you enjoy your newly purchased item! Below you will find a link to your online receipt.</p><p><a href=" . $receiptURL . ">Online receipt</a></p>";

		$mail->isSMTP();
		$mail->Host = 'localhost';
		$mail->SMTPAuth = false;
		$mail->SMTPAutoTLS = false; 
		$mail->Port = 25; 
		$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		);

		$mail->setFrom("aelinaccessories@gmail.com", "AelinAccessories");
		$mail->addAddress($userEmail);

		$mail->isHTML(true);
		$mail->Subject = "Order confirmation";
		$mail->Body = $emailBody;

		try {

			$mail->send();

			$mail1 = new PHPMailer(true);

			$emailBody1 = "<p>User: " . $userFirstName . " " . $userLastName . "</p><p>Email: " . $userEmail . "</p><p>Address: " . $userAddress . "</p><p>Shipping method: " . $userShippingOption . "</p><p>Phone number: " . $userPhone . "</p><p>Product: " . $productNameStripped . "</p><p>Order number: " . $uniqueOrderID . "</p><p>Receipt: " . $receiptURL . "</p>";

			$mail1->isSMTP();
			$mail1->Host = 'localhost';
			$mail1->SMTPAuth = false;
			$mail1->SMTPAutoTLS = false; 
			$mail1->Port = 25; 
			$mail1->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
				)
			);

			$mail1->setFrom($userEmail, $userFirstName . " " . $userLastName);
			$mail1->addAddress("aelinaccessories@gmail.com");

			$mail1->isHTML(true);
			$mail1->Subject = "Order details";
			$mail1->Body = $emailBody1;

			try {

				$mail1->send();

			} catch (Exception $e) {}

		} catch (Exception $e) {}

	}

	http_response_code(200);

?>