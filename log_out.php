<?php

	include realpath(dirname(__FILE__) . "/scripts/main.php");

	if (!isset($_SESSION["user"])) {

		header("Location: /" . basename(__DIR__) . "/");

	} else {

		if (isset($_SESSION["admin"])) {

			unset($_SESSION["admin"]);
			header("Location: /" . basename(__DIR__) . "/");
				
		} else {

			session_unset();
			session_destroy();

			$selector = bin2hex(random_bytes(16));
			$token = bin2hex(random_bytes(48));

			if (isset($_GET["selector"]) && isset($_GET["token"])) {

				if (strlen($_GET["selector"]) == 32 && strlen($_GET["token"]) == 96) {

					if (isset($_GET["password_changed"])) {

						if ($_GET["password_changed"] === "successfully") {

							header("Location: /" . basename(__DIR__) . "/log_in?password_changed=successfully&selector=" . $selector . "&token=" . $token . "");

						}

					} else if (isset($_GET["logged_out"])) {

						if ($_GET["logged_out"] === "successfully") {

							header("Location: /" . basename(__DIR__) . "/log_in?logged_out=successfully&selector=" . $selector . "&token=" . $token . "");

						}

					} else {

						if (isset($_GET["delete_account"])) {

							if ($_GET["delete_account"] === "successfully") {

								header("Location: /" . basename(__DIR__) . "/log_in?delete_account=successfully&selector=" . $selector . "&token=" . $token . "");

							} else if ($_GET["delete_account"] === "failed") {

								header("Location: /" . basename(__DIR__) . "/log_in?delete_account=failed&selector=" . $selector . "&token=" . $token . "");

							}

						}

					}

				}

			}

		}

	}

?>