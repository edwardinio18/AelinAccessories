<?php

	include_once realpath(dirname(__DIR__) . "/colors.inc.php");
	include_once realpath(dirname(__DIR__) . "/Color.php");
	require realpath(dirname(__DIR__) . "/vendor/autoload.php");

	use PHPMailer\PHPMailer\PHPMailer;
	use Mexitek\PHPColors\Color;

	session_start();

	$host = "127.0.0.1";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "AelinAccessories";

	$key = "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";

	$db = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

	function encrypt($message, $key) {

		$encryptionKey = base64_decode($key);
		$IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$encrypted = openssl_encrypt($message, 'aes-256-cbc', $encryptionKey, 0, $IV);

		return base64_encode($encrypted . '::' . $IV);

	}

	function decrypt($message, $key) {

		$encryptionKey = base64_decode($key);
		list($encryptedData, $IV) = array_pad(explode('::', base64_decode($message), 2), 2, null);

		return openssl_decrypt($encryptedData, 'aes-256-cbc', $encryptionKey, 0, $IV);

	}

	function colorAverage($color1, $color2, $factor) {

		list($r1, $g1, $b1) = str_split(ltrim($color1, '#'), 2);

		list($r2, $g2, $b2) = str_split(ltrim($color2, '#'), 2);

		$r_avg = (hexdec($r1) * (1 - $factor) + hexdec($r2) * $factor);
		$g_avg = (hexdec($g1) * (1 - $factor) + hexdec($g2) * $factor);
		$b_avg = (hexdec($b1) * (1 - $factor) + hexdec($b2) * $factor);

		$colorAverage = '#' . sprintf("%02s",dechex($r_avg)) . sprintf("%02s",dechex($g_avg)) . sprintf("%02s",dechex($b_avg));

		return $colorAverage;

	}

	function unSeenMessagesCounter($userId, $orderId, $db) {

		$query = "SELECT * FROM messages WHERE toUserId = ? AND orderId = ? AND status = ?;";
		$stmt = $db->prepare($query);
		$status = 0;
		$stmt->bind_param("iii", $userId, $orderId, $status);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {

			return '<span class="unseen_messages_counter" id="unseen_messages_counter_' . $orderId . '">' . $result->num_rows . '</span>';

		}

		return false;

	}

	$ADMIN_USER_ID = 1;
	$SERVER_ROOT = $_SERVER['REQUEST_URI'];
	$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
	$FULL_DOCUMENT_AND_SERVER_ROOT_URI = $DOCUMENT_ROOT . $SERVER_ROOT;

	$emptyName = $emptyEmail = $emptyMessage = $emptyPassword = $emptyConfirmPassword = $emailBody = $emptyOldPassword = $emptyNewPassword = $emptyConfirmNewPassword = $emptyCollectionName = $emptyProductName = $emptyProductDescription = $emptyProductPrice = $emptyProductImages = $name = $email = $message = $password = $confirmPassword = $oldPassword = $newPassword = $newConfirmPassword = $productName = $productDescription = $productPrice = $productImagesMain = $productImagesSecondary = $productImagesTertiary = $collectionName = $emptyFirstName = $emptyLastName = $emptyAddress = $address = $shippingOption = $emptyShippingOption = $phone = $emptyPhone = $loggedInUserEmail = "";
	$errors = 0;
	$currentTimeSinceUNIX = time();

	for ($i = 0; $i <= 10; $i++) {

		${"emptyProductName" . $i} = "";
		${"emptyProductDescription" . $i} = "";
		${"emptyProductPrice" . $i} = "";
		${"emptyProductImagesMain" . $i} = "";
		${"emptyProductImagesSecondary" . $i} = "";
		${"emptyProductImagesTertiary" . $i} = "";

	}

	function testInput($data) {

		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;

	}

	function emptyField($error) {

		if ($error !== "") {

			return $error;

		}

	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST["submit"])) {

			if (empty($_POST["name"])) {

				$name = "";
				$emptyName = "<p class='input_error'>Name is required!</p>";
				$errors = 1;

			} else {

				$name = testInput($_POST["name"]);

				if (!preg_match("/^[a-zA-Z]/", $name)) {

					$emptyName = "<p class='input_error'>Only letters allowed!</p>";
					$errors = 1;

				} else {

					if (strlen($name) > 50) {

						$emptyName = "<p class='input_error'>Name too long!</p>";
						$errors = 1;

					}

				}

			}

			if (empty($_POST["email"])) {

				$email = "";
				$emptyEmail = "<p class='input_error'>Email is required!</p>";
				$errors = 1;

			} else {

				$email = testInput($_POST["email"]);

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

					$emptyEmail = "<p class='input_error'>Invalid email!</p>";
					$errors = 1;

				} else {

					if (strlen($email) > 50) {

						$emptyEmail = "<p class='input_error'>Email too long!</p>";
						$errors = 1;

					}

				}

			}

			if (empty($_POST["message"])) {

				$message = "";
				$emptyMessage = "<p class='input_error'>Message is required!</p>";
				$errors = 1;

			} else {

				$message = testInput($_POST["message"]);

				if (strlen($message) > 1000) {

					$emptyMessage = "<p class='input_error'>Message too long!</p>";
					$errors = 1;

				}

			}

			if ($errors == 0) {

				$selector = bin2hex(random_bytes(16));
				$token = bin2hex(random_bytes(48));

				$mail = new PHPMailer(true);

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

				$mail->setFrom($email, $name);
				$mail->addAddress("aelinaccessories@gmail.com");

				$mail->isHTML(true);
				$mail->Subject = "Customer Enquiry";
				$mail->Body = $message;

				if ($mail->send()) {

					echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/contact?sent=successfully&selector=" . $selector . "&token=" . $token . "' />";

				} else {

					echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/contact?sent=failed&selector=" . $selector . "&token=" . $token . "' />";

				}

			}

		}

		if (isset($_POST["sign_up"])) {

			if (empty($_POST["first_name"])) {

				$firstName = "";
				$emptyFirstName = "<p class='input_error'>First name is required!</p>";
				$errors = 1;

			} else {

				$firstName = testInput($_POST["first_name"]);

				if (strlen($firstName) > 30) {

					$emptyFirstName = "<p class='input_error'>First name is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["last_name"])) {

				$lastName = "";
				$emptyLastName = "<p class='input_error'>Last name is required!</p>";
				$errors = 1;

			} else {

				$lastName = testInput($_POST["last_name"]);

				if (strlen($lastName) > 30) {

					$emptyLastName = "<p class='input_error'>Last name is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["email"])) {

				$email = "";
				$emptyEmail = "<p class='input_error'>Email is required!</p>";
				$errors = 1;

			} else {

				$email = testInput($_POST["email"]);

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

					$emptyEmail = "<p class='input_error'>Invalid email!</p>";
					$errors = 1;

				} else {

					if (strlen($email) > 50) {

						$emptyEmail = "<p class='input_error'>Email is too long!</p>";
						$errors = 1;

					}

				}

			}

			if (empty($_POST["password"])) {

				$password = "";
				$emptyPassword = "<p class='input_error'>Password is required!</p>";
				$errors = 1;

			} else {

				$password = testInput($_POST["password"]);

				if (strlen($password) > 50) {

					$emptyPassword = "<p class='input_error'>Password is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["confirm_password"])) {

				$confirmPassword = "";
				$emptyConfirmPassword = "<p class='input_error'>Confirm password is required!</p>";
				$errors = 1;

			} else {

				$confirmPassword = testInput($_POST["confirm_password"]);

				if (strlen($confirmPassword) > 50) {

					$emptyConfirmPassword = "<p class='input_error'>Confirm password is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["address"])) {

				$address = "";
				$emptyAddress = "<p class='input_error'>Address is required!</p>";
				$errors = 1;

			} else {

				$address = testInput($_POST["address"]);

				if (strlen($address) > 100) {

					$emptyAddress = "<p class='input_error'>Address is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["shipping"])) {

				$shippingOption = "";
				$emptyShippingOption = "<p class='input_error shipping_input_error'>Shipping option is required!</p>";
				$errors = 1;

			} else {

				switch ($_POST["shipping"]) {

					case "courier":

						$shippingOption = "courier";
						$shippingOption = testInput($shippingOption);
						break;

					case "post":

						$shippingOption = "post";
						$shippingOption = testInput($shippingOption);
						break;
					
					default:

						break;

				}

			}

			if (empty($_POST["phone"])) {

				$phone = "";
				$emptyPhone = "<p class='input_error'>Phone number is required!</p>";
				$errors = 1;

			} else {

				$phone = testInput($_POST["phone"]);

				if (strlen($phone) > 100) {

					$emptyPhone = "<p class='input_error'>Phone number is too long!</p>";
					$errors = 1;

				}

			}

			if ($password != $confirmPassword) {

				$errors = 1;
				$emptyPassword = "<p class='input_error'>Passwords don't match!</p>";
				$emptyConfirmPassword = "<p class='input_error'>Passwords don't match!</p>";

			}

			if ($errors == 0) {

				$query = "SELECT * FROM users WHERE email = ?;";
				$stmt = $db->prepare($query);
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows == 1) {

					$errors = 1;
					$emptyEmail = "<p class='input_error'>An account with this email already exists!</p>";

				} else {

					$selector = bin2hex(random_bytes(16));
					$token = bin2hex(random_bytes(48));

					$url = "https://www.aelinaccessories.com/activate_account?selector=" . $selector . "&token=" . $token;

					$emailBody = '<p>Click the following link to activate your account: <a href="' . $url . '">Activate account</a></p><p>If this action was not requested by you, you can ignore this email.</p>';

					$mail = new PHPMailer(true);

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
					$mail->addAddress($email);

					$mail->isHTML(true);
					$mail->Subject = "Account activation";
					$mail->Body = $emailBody;

					if ($mail->send()) {

						$expires = date("U") + 3600;

						$query = "SELECT * FROM activateAccount WHERE userEmail = ?;";
						$stmt = $db->prepare($query);
						$stmt->bind_param("s", $email);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows == 1) {

							$query2 = "DELETE FROM activateAccount WHERE userEmail = ?;";
							$stmt2 = $db->prepare($query2);
							$stmt2->bind_param("s", $email);
							$stmt2->execute();

						}

						$query = "INSERT INTO activateAccount (userEmail, selector, token, expiry) VALUES (?, ?, ?, ?);";
						$stmt = $db->prepare($query);
						$stmt->bind_param("sssi", $email, $selector, $token, $expires);
						$stmt->execute();

						$query = "INSERT INTO users (firstName, lastName, email, address, shipping, phone, password, activated, privilege) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
						$stmt = $db->prepare($query);
						$password = password_hash($password, PASSWORD_DEFAULT);
						$activated = 0;
						$privilege = 0;
						$stmt->bind_param("sssssssii", $firstName, $lastName, $email, $address, $shippingOption, $phone, $password, $activated, $privilege);
						$stmt->execute();

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/sign_up?sent=successfully&selector=" . $selector . "&token=" . $token . "' />";

					} else {

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/sign_up?sent=failed&selector=" . $selector . "&token=" . $token . "' />";

					}

				}

			}

		}

		if (isset($_POST["log_in"])) {

			if (empty($_POST["email"])) {

				$email = "";
				$emptyEmail = "<p class='input_error'>Email is required!</p>";
				$errors = 1;

			} else {

				$email = testInput($_POST["email"]);

			}

			if (empty($_POST["password"])) {

				$password = "";
				$emptyPassword = "<p class='input_error'>Password is required!</p>";
				$errors = 1;

			} else {

				$password = testInput($_POST["password"]);

			}

			if ($errors == 0) {

				$query = "SELECT * FROM users WHERE email = ?;";
				$stmt = $db->prepare($query);
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows == 1) {

					while ($row = $result->fetch_assoc()) {

						if (password_verify($password, $row["password"])) {

							if ($row["activated"] == 1) {

								$_SESSION["user"] = $email;
								$_SESSION["id"] = $row["id"];
								$loggedInUserEmail = $email;

								if (isset($_GET["redir"])) {

									header("Location: " . $_GET["redir"]);

									exit();

								} else {

									header("Location: profile");

									exit();

								}

							} else {

								$emptyEmail = "<p class='input_error'>Your account has not yet been activated!</p>";
								$errors = 1;

							}

						} else {

							$emptyPassword = "<p class='input_error'>Please check your password!</p>";
							$errors = 1;

						}

					}

				} else {

					$emptyEmail = "<p class='input_error'>No matching account with the entered email address could be found!</p>";
					$errors = 1;

				}

			}

		}

		if (isset($_POST["resend_confirmation_email"])) {

			$query = "SELECT * FROM activateAccount WHERE selector = ? AND token = ?;";
			$stmt = $db->prepare($query);
			$selector = $_GET["selector"];
			$token = $_GET["token"];
			$stmt->bind_param("ss", $selector, $token);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {

				while ($row = $result->fetch_assoc()) {

					$email = $row["userEmail"];

					$newSelector = bin2hex(random_bytes(16));
					$newToken = bin2hex(random_bytes(48));

					$url = "https://www.aelinaccessories.com/activate_account?selector=" . $newSelector . "&token=" . $newToken;

					$emailBody = '<p>Click the following link to activate your account: <a href="' . $url . '">Activate account</a></p><p>If this action was not requested by you, you can ignore this email.</p>';

					$newExpires = date("U") + 3600;

					$mail = new PHPMailer(true);

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
					$mail->addAddress($email);

					$mail->isHTML(true);
					$mail->Subject = "Account activation";
					$mail->Body = $emailBody;

					if ($mail->send()) {

						$query2 = "DELETE FROM activateAccount WHERE userEmail = ?;";
						$stmt2 = $db->prepare($query2);
						$stmt2->bind_param("s", $email);
						$stmt2->execute();

						$query3 = "INSERT INTO activateAccount (userEmail, selector, token, expiry) VALUES (?, ?, ?, ?);";
						$stmt3 = $db->prepare($query3);
						$stmt3->bind_param("sssi", $email, $newSelector, $newToken, $newExpires);
						$stmt3->execute();

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?sent=successfully&selector=" . $selector . "&token=" . $token . "' />";

					} else {

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?sent=failed&selector=" . $selector . "&token=" . $token . "' />";

					}

				}

			}

		}

		if (isset($_POST["change_password"])) {

			if (empty($_POST["old_password"])) {

				$oldPassword = "";
				$emptyOldPassword = "<p class='input_error'>Old password is incorrect!</p>";
				$errors = 1;

			} else {

				$oldPassword = testInput($_POST["old_password"]);

			}

			if (empty($_POST["new_password"])) {

				$newPassword = "";
				$emptyNewPassword = "<p class='input_error'>New password is required!</p>";
				$errors = 1;

			} else {

				$newPassword = testInput($_POST["new_password"]);

				if (strlen($newPassword) > 50) {

					$emptyNewPassword = "<p class='input_error'>New password is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["new_confirm_password"])) {

				$newConfirmPassword = "";
				$emptyConfirmNewPassword = "<p class='input_error'>New confirm password is required!</p>";
				$errors = 1;

			} else {

				$newConfirmPassword = testInput($_POST["new_confirm_password"]);

				if (strlen($newConfirmPassword) > 50) {

					$emptyConfirmNewPassword = "<p class='input_error'>New confirm password is too long!</p>";
					$errors = 1;

				}

			}

			if ($newPassword != $newConfirmPassword) {

				$errors = 1;
				$emptyNewPassword = "<p class='input_error'>New passwords don't match!</p>";
				$emptyConfirmNewPassword = "<p class='input_error'>New passwords don't match!</p>";

			}

			if ($errors == 0) {

				$query = "SELECT * FROM users WHERE email = ?;";
				$stmt = $db->prepare($query);
				$email = $_SESSION["user"];
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows == 1) {

					while ($row = $result->fetch_assoc()) {

						if (password_verify($oldPassword, $row["password"])) {

							$query1 = "UPDATE users SET password = ? WHERE email = ?;";
							$stmt1 = $db->prepare($query1);
							$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
							$email = $_SESSION["user"];
							$stmt1->bind_param("ss", $newPassword, $email);
							$stmt1->execute();

							$selector = bin2hex(random_bytes(16));
							$token = bin2hex(random_bytes(48));

							echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_out?password_changed=successfully&selector=" . $selector . "&token=" . $token . "' />";

						} else {

							$oldPassword = "";
							$emptyOldPassword = "<p class='input_error'>Old password is incorrect!</p>";
							$errors = 1;

						}

					}

				}

			}

		}

		if (isset($_POST["delete_account"])) {

			if (empty($_POST["email"])) {

				$email = "";
				$emptyEmail = "<p class='input_error'>Email is required!</p>";
				$errors = 1;

			} else {

				$email = testInput($_POST["email"]);

			}

			if (empty($_POST["password"])) {

				$password = "";
				$emptyPassword = "<p class='input_error'>Password is required!</p>";
				$errors = 1;

			} else {

				$password = testInput($_POST["password"]);

			}

			if ($errors == 0) {

				$query = "SELECT * FROM users WHERE email = ?;";
				$stmt = $db->prepare($query);
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows == 1) {

					while ($row = $result->fetch_assoc()) {

						if (password_verify($password, $row["password"])) {

							$selector = bin2hex(random_bytes(16));
							$token = bin2hex(random_bytes(48));

							$url = "https://www.aelinaccessories.com/delete_account_confirmed?selector=" . $selector . "&token=" . $token;

							$emailBody = '<p>Click the following link to delete your account: <a href="' . $url . '">Delete account</a></p><p>If this action was not requested by you, you can ignore this email.</p>';

							$expires = date("U") + 3600;

							$mail = new PHPMailer(true);

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
							$mail->addAddress($email);

							$mail->isHTML(true);
							$mail->Subject = "Account deletion";
							$mail->Body = $emailBody;

							if ($mail->send()) {

								$query1 = "SELECT * FROM deleteAccount WHERE userEmail = ?;";
								$stmt1 = $db->prepare($query1);
								$stmt1->bind_param("s", $email);
								$stmt1->execute();
								$result1 = $stmt1->get_result();

								if ($result1->num_rows == 1) {

									$query2 = "DELETE FROM deleteAccount WHERE userEmail = ?;";
									$stmt2 = $db->prepare($query2);
									$stmt2->bind_param("s", $email);
									$stmt2->execute();

								}

								$query3 = "INSERT INTO deleteAccount (userEmail, selector, token, expiry) VALUES (?, ?, ?, ?);";
								$stmt3 = $db->prepare($query3);
								$stmt3->bind_param("sssi", $email, $selector, $token, $expires);
								$stmt3->execute();

								echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_out?delete_account=successfully&selector=" . $selector . "&token=" . $token . "' />";

							} else {

								echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_out?delete_account=failed&selector=" . $selector . "&token=" . $token . "' />";

							}

						} else {

							$password = "";
							$emptyPassword = "<p class='input_error'>Password is incorrect!</p>";
							$errors = 1;

						}

					}

				} else {

					$errors = 1;
					$emptyEmail = "<p class='input_error'>The entered email doesn't match this account!</p>";
					$email = "";

				}

			}

		}

		if (isset($_POST["resend_confirmation_delete_account_email"])) {

			$query = "SELECT * FROM deleteAccount WHERE selector = ? AND token = ?;";
			$stmt = $db->prepare($query);
			$selector = $_GET["selector"];
			$token = $_GET["token"];
			$stmt->bind_param("ss", $selector, $token);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {

				while ($row = $result->fetch_assoc()) {

					$email = $row["userEmail"];

					$newSelector = bin2hex(random_bytes(16));
					$newToken = bin2hex(random_bytes(48));

					$url = "https://www.aelinaccessories.com/delete_account_confirmed?selector=" . $newSelector . "&token=" . $newToken;

					$emailBody = '<p>Click the following link to delete your account: <a href="' . $url . '">Delete account</a></p><p>If this action was not requested by you, you can ignore this email.</p>';

					$newExpires = date("U") + 3600;

					$mail = new PHPMailer(true);

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
					$mail->addAddress($email);

					$mail->isHTML(true);
					$mail->Subject = "Account deletion";
					$mail->Body = $emailBody;

					if ($mail->send()) {

						$query2 = "DELETE FROM deleteAccount WHERE userEmail = ?;";
						$stmt2 = $db->prepare($query2);
						$stmt2->bind_param("s", $email);
						$stmt2->execute();

						$query3 = "INSERT INTO deleteAccount (userEmail, selector, token, expiry) VALUES (?, ?, ?, ?);";
						$stmt3 = $db->prepare($query3);
						$stmt3->bind_param("sssi", $email, $newSelector, $newToken, $newExpires);
						$stmt3->execute();

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?delete_account_resent=successfully&selector=" . $selector . "&token=" . $token . "' />";

					} else {

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?delete_account_resent=failed&selector=" . $selector . "&token=" . $token . "' />";

					}

				}

			}

		}

		if (isset($_POST["reset_password"])) {

			if (empty($_POST["email"])) {

				$email = "";
				$emptyEmail = "<p class='input_error'>Email is required!</p>";
				$errors = 1;

			} else {

				$email = testInput($_POST["email"]);

			}

			if ($errors == 0) {

				$query = "SELECT * FROM users WHERE email = ?;";
				$stmt = $db->prepare($query);
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows == 1) {

					$selector = bin2hex(random_bytes(16));
					$token = bin2hex(random_bytes(48));

					$url = "https://www.aelinaccessories.com/reset_password?selector=" . $selector . "&token=" . $token;

					$emailBody = '<p>Click the following link to reset your password: <a href="' . $url . '">Reset password</a></p><p>If this action was not requested by you, you can ignore this email.</p>';

					$expires = date("U") + 3600;

					$mail = new PHPMailer(true);

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
					$mail->addAddress($email);

					$mail->isHTML(true);
					$mail->Subject = "Reset Password";
					$mail->Body = $emailBody;

					if ($mail->send()) {

						$query1 = "SELECT * FROM resetPassword WHERE userEmail = ?;";
						$stmt1 = $db->prepare($query1);
						$stmt1->bind_param("s", $email);
						$stmt1->execute();
						$result1 = $stmt1->get_result();

						if ($result1->num_rows == 1) {

							$query2 = "DELETE FROM resetPassword WHERE userEmail = ?;";
							$stmt2 = $db->prepare($query2);
							$stmt2->bind_param("s", $email);
							$stmt2->execute();

						}

						$query3 = "INSERT INTO resetPassword (userEmail, selector, token, expiry) VALUES (?, ?, ?, ?);";
						$stmt3 = $db->prepare($query3);
						$stmt3->bind_param("sssi", $email, $selector, $token, $expires);
						$stmt3->execute();

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?password_reset_sent=successfully&selector=" . $selector . "&token=" . $token . "' />";

					} else {

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?password_reset_sent=failed&selector=" . $selector . "&token=" . $token . "' />";

					}

				} else {

					$email = "";
					$emptyEmail = "<p class='input_error'>The entered email doesn't match to an account!</p>";
					$errors = 1;

				}

			}

		}

		if (isset($_POST["reset_password_confirmed"])) {

			if (empty($_POST["new_password"])) {

				$newPassword = "";
				$emptyNewPassword = "<p class='input_error'>New password is required!</p>";
				$errors = 1;

			} else {

				$newPassword = testInput($_POST["new_password"]);

				if (strlen($newPassword) > 50) {

					$emptyNewPassword = "<p class='input_error'>New password is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["new_confirm_password"])) {

				$newConfirmPassword = "";
				$emptyConfirmNewPassword = "<p class='input_error'>New confirm password is required!</p>";
				$errors = 1;

			} else {

				$newConfirmPassword = testInput($_POST["new_confirm_password"]);

				if (strlen($newConfirmPassword) > 50) {

					$emptyConfirmNewPassword = "<p class='input_error'>New confirm password is too long!</p>";
					$errors = 1;

				}

			}

			if ($newPassword != $newConfirmPassword) {

				$errors = 1;
				$emptyNewPassword = "<p class='input_error'>New passwords don't match!</p>";
				$emptyConfirmNewPassword = "<p class='input_error'>New passwords don't match!</p>";

			}

			if ($errors == 0) {

				$query = "SELECT * FROM resetPassword WHERE selector = ? AND token = ?;";
				$stmt = $db->prepare($query);
				$selector = $_GET["selector"];
				$token = $_GET["token"];
				$stmt->bind_param("ss", $selector, $token);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows == 1) {

					while ($row = $result->fetch_assoc()) {

						$query1 = "SELECT * FROM users WHERE email = ?;";
						$stmt1 = $db->prepare($query1);
						$email = $row["userEmail"];
						$stmt1->bind_param("s", $email);
						$stmt1->execute();
						$result1 = $stmt1->get_result();

						if ($result1->num_rows == 1) {

							while ($row1 = $result1->fetch_assoc()) {

								$query2 = "UPDATE users SET password = ? WHERE email = ?;";
								$stmt2 = $db->prepare($query2);
								$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
								$stmt2->bind_param("ss", $newPassword, $email);
								$stmt2->execute();

								$query3 = "DELETE FROM resetPassword WHERE selector = ? AND token = ?;";
								$stmt3 = $db->prepare($query3);
								$stmt3->bind_param("ss", $selector, $token);
								$stmt3->execute();

								$selector = bin2hex(random_bytes(16));
								$token = bin2hex(random_bytes(48));

								echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?password_reset=successfully&selector=" . $selector . "&token=" . $token . "' />";

							}

						}

					}

				}

			}

		}

		if (isset($_POST["resend_password_reset_email"])) {

			$query = "SELECT * FROM resetPassword WHERE selector = ? AND token = ?;";
			$stmt = $db->prepare($query);
			$selector = $_GET["selector"];
			$token = $_GET["token"];
			$stmt->bind_param("ss", $selector, $token);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1) {

				while ($row = $result->fetch_assoc()) {

					$email = $row["userEmail"];

					$newSelector = bin2hex(random_bytes(16));
					$newToken = bin2hex(random_bytes(48));

					$url = "https://www.aelinaccessories.com/reset_password?selector=" . $newSelector . "&token=" . $newToken;

					$emailBody = '<p>Click the following link to reset your password: <a href="' . $url . '">Reset password</a></p><p>If this action was not requested by you, you can ignore this email.</p>';

					$newExpires = date("U") + 3600;

					$mail = new PHPMailer(true);

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
					$mail->addAddress($email);

					$mail->isHTML(true);
					$mail->Subject = "Reset Password";
					$mail->Body = $emailBody;

					if ($mail->send()) {

						$query2 = "DELETE FROM resetPassword WHERE userEmail = ?;";
						$stmt2 = $db->prepare($query2);
						$stmt2->bind_param("s", $email);
						$stmt2->execute();

						$query3 = "INSERT INTO resetPassword (userEmail, selector, token, expiry) VALUES (?, ?, ?, ?);";
						$stmt3 = $db->prepare($query3);
						$stmt3->bind_param("sssi", $email, $newSelector, $newToken, $newExpires);
						$stmt3->execute();

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?reset_password_resent=successfully&selector=" . $selector . "&token=" . $token . "' />";

					} else {

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/log_in?reset_password_resent=failed&selector=" . $selector . "&token=" . $token . "' />";

					}

				}

			}

		}

		if (isset($_POST["admin_log_in"])) {

			if (empty($_POST["email"])) {

				$email = "";
				$emptyEmail = "<p class='input_error'>Email is required!</p>";
				$errors = 1;

			} else {

				$email = testInput($_POST["email"]);

			}

			if (empty($_POST["password"])) {

				$password = "";
				$emptyPassword = "<p class='input_error'>Password is required!</p>";
				$errors = 1;

			} else {

				$password = testInput($_POST["password"]);

			}

			if ($errors == 0) {

				$query = "SELECT * FROM users WHERE email = ? AND privilege = ?;";
				$stmt = $db->prepare($query);
				$privilege = 1;
				$stmt->bind_param("si", $email, $privilege);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows == 1) {

					while ($row = $result->fetch_assoc()) {

						if ($email == "radroxana20@gmail.com") {

							if ($row["privilege"] == 1) {

								if (password_verify($password, $row["password"])) {

									if ($row["activated"] == 1) {

										header("Location: /" . basename(__DIR__) . "/ADMIN/admin");
										$_SESSION["admin"] = 1;

									} else {

										$emptyEmail = "<p class='input_error'>Your account has not yet been activated!</p>";
										$errors = 1;

									}

								} else {

									$emptyPassword = "<p class='input_error'>Please check your password!</p>";
									$errors = 1;

								}

							} else {

								$emptyEmail = "<p class='input_error'>The account assosicated with the entered email does not have admin privileges!</p>";
								$errors = 1;

							}

						} else {

							$emptyEmail = "<p class='input_error'>The account assosicated with the entered email does not have admin privileges!</p>";
							$errors = 1;

						}

					}

				} else {

					$emptyEmail = "<p class='input_error'>No matching account with the entered email address could be found!</p>";
					$errors = 1;

				}

			}

		}

		if (isset($_POST["add_collection"])) {

			$productsArray = [

				"name" => $_POST["product_name"],
				"description" => $_POST["product_description"],
				"price" => $_POST["product_price"],
				"main_image" => $_FILES["product_images_main"]["name"],
				"secondary_image" => $_FILES["product_images_secondary"]["name"],
				"third_image" => $_FILES["product_images_third"]["name"]

			];

			print_r($productsArray);

			if (empty($_POST["collection_name"])) {

				$collectionName = "";
				$emptyCollectionName = "<p class='input_error'>Collection name is required!</p>";
				$errors = 1;

			} else {

				$collectionName = testInput($_POST["collection_name"]);

			}

			for ($i = 0; $i < 10; $i++) {

				if (empty($_POST["product_name"][$i])) {

					$productName = "";
					${"emptyProductName" . ($i + 1)} = "<p class='input_error_collection' id='input_error_" . ($i + 1) . "'>Product name is required!</p>";
					$errors = 1;

				} else {

					$productName = testInput($_POST["product_name"][$i]);

				}

				if (empty($_POST["product_description"][$i])) {

					$productDescription = "";
					${"emptyProductDescription" . ($i + 1)} = "<p class='input_error_collection input_error_collection_long' id='input_error_" . ($i + 1) . "'>Product description is required!</p>";
					$errors = 1;

				} else {

					$productDescription = testInput($_POST["product_description"][$i]);

				}				

				if (empty($_POST["product_price"][$i])) {

					$productPrice = "";
					${"emptyProductPrice" . ($i + 1)} = "<p class='input_error_collection' id='input_error_" . ($i + 1) . "'>Product price is required!</p>";
					$errors = 1;

				} else {

					$productPrice = testInput($_POST["product_price"][$i]);

				}

				if (empty($_FILES["product_images_main"]["tmp_name"][$i])) {

					$productImagesMain = "";
					${"emptyProductImagesMain" . ($i + 1)} = "<p class='input_error_collection input_error_collection_long' id='input_error_" . ($i + 1) . "'>Main product image is required!</p>";
					$errors = 1;

				} else {

					$productImagesMain = testInput($_FILES["product_images_main"]["name"][$i]);

				}

				if (empty($_FILES["product_images_secondary"]["tmp_name"][$i])) {

					$productImagesSecondary = "";
					${"emptyProductImagesSecondary" . ($i + 1)} = "<p class='input_error_collection input_error_collection_long' id='input_error_" . ($i + 1) . "'>Secondary product image is required!</p>";
					$errors = 1;

				} else {

					$productImagesSecondary = testInput($_FILES["product_images_secondary"]["name"][$i]);

				}

				if (empty($_FILES["product_images_third"]["tmp_name"][$i])) {

					$productImagesTertiary = "";
					${"emptyProductImagesTertiary" . ($i + 1)} = "<p class='input_error_collection input_error_collection_long' id='input_error_" . ($i + 1) . "'>Tertiary product image is required!</p>";
					$errors = 1;

				} else {

					$productImagesTertiary = testInput($_FILES["product_images_third"]["name"][$i]);

				}

			}

			if ($errors == 0) {

				$targetImagePath = __DIR__ . "/product_images/";

				$selector = bin2hex(random_bytes(16));
				$token = bin2hex(random_bytes(48));

				$query = "INSERT INTO collections (name) VALUES (?);";
				$stmt = $db->prepare($query);
				$stmt->bind_param("s", $collectionName);
				$stmt->execute();
				$collectionId = $db->insert_id;

				for ($i = 0; $i < 10; $i++) {

					$newMainImageName = uniqid() . ".png";

					if (move_uploaded_file($_FILES["product_images_main"]["tmp_name"][$i], $targetImagePath . $newMainImageName)) {

						$newSecondImageName = uniqid() . ".png";

						if (move_uploaded_file($_FILES["product_images_secondary"]["tmp_name"][$i], $targetImagePath . $newSecondImageName)) {

							$newThirdImageName = uniqid() . ".png";

							if (move_uploaded_file($_FILES["product_images_third"]["tmp_name"][$i], $targetImagePath . $newThirdImageName)) {

								$query1 = "INSERT INTO products (name, description, collection, price, mainPicture, secondPicture, thirdPicture) VALUES (?, ?, ?, ?, ?, ?, ?);";
								$stmt1 = $db->prepare($query1);
								$stmt1->bind_param("ssissss", $productsArray["name"][$i], $productsArray["description"][$i], $collectionId, $productsArray["price"][$i], $newMainImageName, $newSecondImageName, $newThirdImageName);
								$stmt1->execute();

							}

						}

					} else {

						echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/ADMIN/admin?collection_added=failed&selector=" . $selector . "&token=" . $token . "' />";

					}

				}

				if ($stmt && $stmt1) {

					echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/ADMIN/admin?collection_added=successfully&selector=" . $selector . "&token=" . $token . "' />";

				} else {

					echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/ADMIN/admin?collection_added=failed&selector=" . $selector . "&token=" . $token . "' />";

				}

			}

		}

		if (isset($_POST["edit_collection"])) {

			if (isset($_POST["collection_name_updated"])) {

				if (empty($_POST["collection_name_updated"])) {

					$collectionName = "";
					$emptyCollectionName = "<p class='input_error'>Collection name is required!</p>";
					$errors = 1;

				} else {

					$collectionName = testInput($_POST["collection_name_updated"]);

				}

			}

			for ($i = 0; $i < 10; $i++) {

				if (isset($_POST["product_name_" . ($i + 1) . "_updated"])) {

					if (empty($_POST["product_name_" . ($i + 1) . "_updated"][0])) {

						$productName = "";
						${"emptyProductName" . ($i + 1)} = "<p class='input_error_collection' id='input_error_" . ($i + 1) . "'>Product name is required!</p>";
						$errors = 1;

					}

				}

				if (isset($_POST["product_description_" . ($i + 1) . "_updated"])) {

					if (empty($_POST["product_description_" . ($i + 1) . "_updated"][0])) {

						$productDescription = "";
						${"emptyProductDescription" . ($i + 1)} = "<p class='input_error_collection input_error_collection_long' id='input_error_" . ($i + 1) . "'>Product description is required!</p>";
						$errors = 1;

					}

				}

				if (isset($_POST["product_price_" . ($i + 1) . "_updated"])) {

					if ($_POST["product_price_" . ($i + 1) . "_updated"][0] == "€0.00") {

						$productPrice = "";
						${"emptyProductPrice" . ($i + 1)} = "<p class='input_error_collection' id='input_error_" . ($i + 1) . "'>Product price is required!</p>";
						$errors = 1;

					} else if (empty($_POST["product_price_" . ($i + 1) . "_updated"][0])) {

						$productPrice = "";
						${"emptyProductPrice" . ($i + 1)} = "<p class='input_error_collection' id='input_error_" . ($i + 1) . "'>Product price is required!</p>";
						$errors = 1;

					}

				}

			}

			$updatedNamesArray = $_POST["updated_name"];
			$updatedDescriptionsArray = $_POST["updated_description"];
			$updatedPricesArray = $_POST["updated_price"];
			$updatedMainPictureArray = $_POST["updated_main_picture"];
			$updatedSecondPictureArray = $_POST["updated_second_picture"];
			$updatedThirdPictureArray = $_POST["updated_third_picture"];

			if ($errors == 0) {

				$targetImagePath = __DIR__ . "/product_images/";

				if (isset($_POST["collection_name_updated"])) {

					$query = "UPDATE collections SET name = ? WHERE id = ?;";
					$stmt = $db->prepare($query);
					$stmt->bind_param("si", $collectionName, $_POST["collection_row_id"]);
					$stmt->execute();

				}

				foreach ($updatedNamesArray as $updateNames) {

					if (isset($_POST["product_name_" . $updateNames . "_updated"])) {

						$query1 = "UPDATE products SET name = ? WHERE id = ?;";
						$stmt1 = $db->prepare($query1);
						$ID = $_POST["product_row_id"][$updateNames - 1];
						$newProductName = $_POST["product_name_" . $updateNames . "_updated"][0];
						$stmt1->bind_param("si", $newProductName, $ID);
						$stmt1->execute();

					}

				}

				foreach ($updatedDescriptionsArray as $updateDescriptions) {

					if (isset($_POST["product_description_" . $updateDescriptions . "_updated"])) {

						$query2 = "UPDATE products SET description = ? WHERE id = ?;";
						$stmt2 = $db->prepare($query2);
						$ID = $_POST["product_row_id"][$updateDescriptions - 1];
						$newProductDescription = $_POST["product_description_" . $updateDescriptions . "_updated"][0];
						$stmt2->bind_param("si", $newProductDescription, $ID);
						$stmt2->execute();

					}

				}

				foreach ($updatedPricesArray as $updatePrices) {

					if (isset($_POST["product_price_" . $updatePrices . "_updated"])) {

						$query2 = "UPDATE products SET price = ? WHERE id = ?;";
						$stmt2 = $db->prepare($query2);
						$ID = $_POST["product_row_id"][$updatePrices - 1];
						$newProductPrice = $_POST["product_price_" . $updatePrices . "_updated"][0];
						$stmt2->bind_param("si", $newProductPrice, $ID);
						$stmt2->execute();

					}

				}

				foreach ($updatedMainPictureArray as $updateMainPicture) {

					if (isset($_FILES["product_images_main_" . $updateMainPicture . "_updated"]["tmp_name"])) {

						$query3 = "SELECT * FROM products WHERE id = ?;";
						$stmt3 = $db->prepare($query3);
						$ID = $_POST["product_row_id"][$updateMainPicture - 1];
						$stmt3->bind_param("i", $ID);
						$stmt3->execute();
						$result3 = $stmt3->get_result();

						if ($result3->num_rows >= 1) {

							if ($row3 = $result3->fetch_assoc()) {

								if (unlink($targetImagePath . $row3["mainPicture"])) {

									$newMainImageName = uniqid() . ".png";

									$query4 = "UPDATE products SET mainPicture = ? WHERE id = ?;";
									$stmt4 = $db->prepare($query4);
									$ID = $_POST["product_row_id"][$updateMainPicture - 1];
									$stmt4->bind_param("si", $newMainImageName, $ID);
									$stmt4->execute();

									move_uploaded_file($_FILES["product_images_main_" . $updateMainPicture . "_updated"]["tmp_name"][0], $targetImagePath . $newMainImageName);

								}

							}

						}

					}

				}

				foreach ($updatedSecondPictureArray as $updateSecondPicture) {

					if (isset($_FILES["product_images_secondary_" . $updateSecondPicture . "_updated"]["tmp_name"])) {

						$query3 = "SELECT * FROM products WHERE id = ?;";
						$stmt3 = $db->prepare($query3);
						$ID = $_POST["product_row_id"][$updateSecondPicture - 1];
						$stmt3->bind_param("i", $ID);
						$stmt3->execute();
						$result3 = $stmt3->get_result();

						if ($result3->num_rows >= 1) {

							if ($row3 = $result3->fetch_assoc()) {

								if (unlink($targetImagePath . $row3["secondPicture"])) {

									$newSecondImageName = uniqid() . ".png";

									$query4 = "UPDATE products SET secondPicture = ? WHERE id = ?;";
									$stmt4 = $db->prepare($query4);
									$ID = $_POST["product_row_id"][$updateSecondPicture - 1];;
									$stmt4->bind_param("si", $newSecondImageName, $ID);
									$stmt4->execute();

									move_uploaded_file($_FILES["product_images_secondary_" . $updateSecondPicture . "_updated"]["tmp_name"][0], $targetImagePath . $newSecondImageName);

								}

							}

						}

					}

				}

				foreach ($updatedThirdPictureArray as $updateThirdPicture) {

					if (isset($_FILES["product_images_third_" . $updateThirdPicture . "_updated"]["tmp_name"])) {

						$query3 = "SELECT * FROM products WHERE id = ?;";
						$stmt3 = $db->prepare($query3);
						$ID = $_POST["product_row_id"][$updateThirdPicture - 1];
						$stmt3->bind_param("i", $ID);
						$stmt3->execute();
						$result3 = $stmt3->get_result();

						if ($result3->num_rows >= 1) {

							if ($row3 = $result3->fetch_assoc()) {

								if (unlink($targetImagePath . $row3["thirdPicture"])) {

									$newThirdImageName = uniqid() . ".png";

									$query4 = "UPDATE products SET thirdPicture = ? WHERE id = ?;";
									$stmt4 = $db->prepare($query4);
									$ID = $_POST["product_row_id"][$updateThirdPicture - 1];
									$stmt4->bind_param("si", $newThirdImageName, $ID);
									$stmt4->execute();

									move_uploaded_file($_FILES["product_images_third_" . $updateThirdPicture . "_updated"]["tmp_name"][0], $targetImagePath . $newThirdImageName);

								}

							}

						}

					}

				}

				$selector = bin2hex(random_bytes(16));
				$token = bin2hex(random_bytes(48));

				echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/ADMIN/admin?collection_edited=successfully&selector=" . $selector . "&token=" . $token . "' />";

			}

		}

		if (isset($_POST["delete_collection"])) {

			$targetImagePath = __DIR__ . "/product_images/";

			$collectionID = $_POST["collection_row_id"];
			$mainPictureArray = $_POST["main_picture"];
			$secondPictureArray = $_POST["second_picture"];
			$thirdPictureArray = $_POST["third_picture"];

			foreach ($mainPictureArray as $mainPicture) {

				unlink($targetImagePath . $mainPicture);

			}

			foreach ($secondPictureArray as $secondPicture) {

				unlink($targetImagePath . $secondPicture);

			}

			foreach ($thirdPictureArray as $thirdPicture) {

				unlink($targetImagePath . $thirdPicture);

			}

			$selector = bin2hex(random_bytes(16));
			$token = bin2hex(random_bytes(48));

			echo "<meta http-equiv='refresh' content='0; url=/" . basename(__DIR__) . "/ADMIN/admin?collection_deleted=successfully&selector=" . $selector . "&token=" . $token . "&collection_id=" . $collectionID . "' />";

		}

		if (isset($_POST["edit_shipping_details"])) {

			$shippingOption = testInput($_POST["shipping"]);

			if (empty($_POST["address"])) {

				$address = "";
				$emptyAddress = "<p class='input_error'>Address is required!</p>";
				$errors = 1;

			} else {

				$address = testInput($_POST["address"]);

				if (strlen($address) > 100) {

					$emptyAddress = "<p class='input_error'>Address is too long!</p>";
					$errors = 1;

				}

			}

			if (empty($_POST["phone"])) {

				$phone = "";
				$emptyPhone = "<p class='input_error'>Phone number is required!</p>";
				$errors = 1;

			} else {

				$phone = testInput($_POST["phone"]);

				if (strlen($phone) > 100) {

					$emptyPhone = "<p class='input_error'>Phone number is too long!</p>";
					$errors = 1;

				}

			}

			if ($errors == 0) {

				$query = "UPDATE users SET address = ?, shipping = ?, phone = ? WHERE id = ?;";
				$stmt = $db->prepare($query);
				$stmt->bind_param("sssi", $address, $shippingOption, $phone, $_SESSION["id"]);
				$stmt->execute();

				$selector = bin2hex(random_bytes(16));
				$token = bin2hex(random_bytes(48));

				header("Location: /" . basename(__DIR__) . "/account_settings?shipping_details_edited=successfully&selector=" . $selector . "&token=" . $token);

			}

		}

	}

?>