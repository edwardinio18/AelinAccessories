function openMenu(menu) {

	menu.classList.toggle("opened");
	$(".navbar_container").toggleClass("opened_navbar_container");
	$(".navbar").toggleClass("opened_navbar");
	$(".navbar_ul").toggleClass("opened_navbar_ul");
	$(".navbar_link_li").toggleClass("opened_navbar_link_li");
	$(".navbar_li").toggleClass("opened_navbar_li");
	$(".logo_li").toggleClass("opened_logo_li");
	$(".logo").toggleClass("opened_logo");
	$(".navbar_inner_div").toggleClass("opened_navbar_inner_div");
	$(".page_main_label").toggleClass("opened_page_main_label");
	$(".outer_main_image_carousel_div").toggleClass("opened_outer_main_image_carousel_div");
	$(".unique_product_outer_div").toggleClass("opened_unique_product_outer_div");
	$(".navbar_li_dropdown_more").toggleClass("opened_navbar_li_dropdown_more");
	$(".navbar_li_dropdown_more_title").toggleClass("opened_navbar_li_dropdown_more_title");
	$(".navbar_li_dropdown_more_content_div").toggleClass("opened_navbar_li_dropdown_more_content_div");
	$(".navbar_link_li_more").toggleClass("opened_navbar_link_li_more");
	$(".navbar_li_more").toggleClass("opened_navbar_li_more");

}

function openProductsMenu(productsMenu) {

	productsMenu.classList.toggle("products_opened");
	$(".products_side_menu_bar").toggleClass("opened_products_side_menu_bar");
	$(".products_modal_container").toggleClass("opened_products_modal_container");
	$(".body").toggleClass("opened_body");

}

$(document).ready(function() {

	if ($(window).width() < 320) {

		window.location = "https://www.google.com";

	}

	$(window).on("resize", function() {

		if ($(this).width() < 320) {

			window.location = "https://www.google.com";

		}

	});

	$('.image_carousel').slick({

		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3500,
		mobileFirst: true,
		speed: 750

	});

	setTimeout(function() {

		$(".email_sent_outer_div").fadeOut(500, function() {

			$(".email_sent_outer_div").remove();

			window.location = window.location.href.split("?")[0];

		});

		$(".email_not_activated_url_invalid_div").fadeOut(500, function() {

			$(".email_not_activated_url_invalid_div").remove();

			window.location.replace("log_in");

		});

	}, 3000);

	$(document).mousedown(function(e) {

		var productsMenuBar = $(".products_side_menu_bar");

		if (!productsMenuBar.is(e.target) && productsMenuBar.has(e.target).length == 0) {

			$(".products_menu_burger").removeClass("products_opened");
			$(".products_side_menu_bar").removeClass("opened_products_side_menu_bar");
			$(".products_modal_container").removeClass("opened_products_modal_container");
			$(".body").removeClass("opened_body");

		}

	});

	var $productsSideMenuBarLinks = $("#products_side_menu_bar > div > a > div");
	var $productsSideMenuBarLinksText = $("#products_side_menu_bar > div > a > div > p");
	var $sections = $($(".products_main_each_collection_hidden_scroll_to_div").get().reverse());

	var sectionIdToNavigationLink = {};
	var sectionIdToNavigationLinkText = {};

	$sections.each(function() {

		var id = $(this).attr("id");

		sectionIdToNavigationLink[id] = $("#products_side_menu_bar > div > a[href=\\#" + id + "] > div");
		sectionIdToNavigationLinkText[id] = $("#products_side_menu_bar > div > a[href=\\#" + id + "] > div > p");

	});

	function throttle(fn, interval) {

		var lastCall, timeoutId;

		return function() {

			var now = new Date().getTime();

			if (lastCall && now < (lastCall + interval)) {

				clearTimeout(timeoutId);

				timeoutId = setTimeout(function() {

					lastCall = now;
					fn.call();

				}, interval - (now - lastCall));

			} else {

				lastCall = now;
				fn.call();

			}

		}

	}

	function highlightProductsSideMenuBarNavigation() {

		var scrollPosition = $(window).scrollTop();

		$sections.each(function() {

			var currentSection = $(this);
			var sectionTop = currentSection.offset().top;

			if (scrollPosition >= sectionTop) {

				var id = currentSection.attr("id");
				var $navigationLink = sectionIdToNavigationLink[id];
				var $navigationLinksText = sectionIdToNavigationLinkText[id];

				if (!$navigationLink.hasClass("active") && !$navigationLinksText.hasClass("active")) {

					$productsSideMenuBarLinks.removeClass("active");
					$productsSideMenuBarLinksText.removeClass("active_text");
					$navigationLink.addClass("active");
					$navigationLinksText.addClass("active_text");

				}

				return false;

			}

		});

	}

	$(window).scroll(throttle(highlightProductsSideMenuBarNavigation, 100));

	$(".products_side_menu_bar_each_div_link").on("click", function(e) {

		$(".products_menu_burger").toggleClass("products_opened");
		$(".products_side_menu_bar").toggleClass("opened_products_side_menu_bar");
		$(".products_modal_container").toggleClass("opened_products_modal_container");
		$(".body").toggleClass("opened_body");

		if (this.hash !== "") {

			e.preventDefault();

			var hash = this.hash;

			$("html, body").animate({

				scrollTop: $(hash).offset().top

			}, 650, function() {

				window.location.hash = hash;

			});

		}

	});

	$(".log_out_button").on("click", function() {

		$.ajax({

			url: "/log_out",
			method: "POST",
			success: function(data) {

				window.location.replace(data);

			}

		});

	});

	function imageIsLoadedMain(e, productImageId) {

		$('#product_images_main_image_inner_image_div_main_' + productImageId).html('<img src=' + e.target.result + ' class="product_each_image_preview_image" />');

	};

	function imageIsLoadedSecondary(e, productImageId) {

		$('#product_images_secondary_image_inner_image_div_secondary_' + productImageId).html('<img src=' + e.target.result + ' class="product_each_image_preview_image" />');

	};

	function imageIsLoadedTertiary(e, productImageId) {

		$('#product_images_third_image_inner_image_div_third_' + productImageId).html('<img src=' + e.target.result + ' class="product_each_image_preview_image" />');

	};

	function collection() {

		$(".product_price").priceFormat({

			limit: 5,
			centsLimit: 2,
			prefix: '',
			suffix: 'RON'

		});

		$(".product_price").on("keyup", function() {

			if ($(".product_price").val() === '€0.00') {

				$(".product_price").val('');

			}

		});

		$(".product_price").blur(function() {

			if ($(".product_price").val() === '€0.00') {

				$(".product_price").val('');

			}

		});

		$(".product_images").on("change", function() {

			var productImageId = $(this).data("productimageidmain");

			$("#product_images_preview_div_main_" + productImageId).addClass("product_images_preview_div_visible");

			if (this.files && this.files[0]) {

				if ($("#product_images_main_image_inner_image_div_main_" + productImageId).is(":empty")) {

					var reader = new FileReader();
					reader.onload = function(e) {

						imageIsLoadedMain(e, productImageId);

					}
					reader.readAsDataURL(this.files[0]);

				} else {

					$("#product_images_main_image_inner_image_div_main_" + productImageId).empty();

					var reader = new FileReader();
					reader.onload = function(e) {

						imageIsLoadedMain(e, productImageId);

					}
					reader.readAsDataURL(this.files[0]);

				}

			}

		});

		$(".product_images_button_for_file_upload").on("click", function() {

			var productImageId = $(this).data("productimageidmain");

			$("#product_images_main_" + productImageId).click();

		});

		$(".product_images_secondary").on("change", function() {

			var productImageId = $(this).data("productimageidsecondary");

			$("#product_images_preview_div_secondary_" + productImageId).addClass("product_images_preview_div_visible");

			if (this.files && this.files[0]) {

				if ($("#product_images_secondary_image_inner_image_div_secondary_" + productImageId).is(":empty")) {

					var reader = new FileReader();
					reader.onload = function(e) {

						imageIsLoadedSecondary(e, productImageId);

					}
					reader.readAsDataURL(this.files[0]);

				} else {

					$("#product_images_secondary_image_inner_image_div_secondary_" + productImageId).empty();

					var reader = new FileReader();
					reader.onload = function(e) {

						imageIsLoadedSecondary(e, productImageId);

					}
					reader.readAsDataURL(this.files[0]);

				}

			}

		});

		$(".product_images_button_for_file_upload_secondary").on("click", function() {

			var productImageId = $(this).data("productimageidsecondary");

			$("#product_images_secondary_" + productImageId).click();

		});

		$(".product_images_third").on("change", function() {

			var productImageId = $(this).data("productimageidthird");

			$("#product_images_preview_div_third_" + productImageId).addClass("product_images_preview_div_visible");

			if (this.files && this.files[0]) {

				if ($("#product_images_third_image_inner_image_div_third_" + productImageId).is(":empty")) {

					var reader = new FileReader();
					reader.onload = function(e) {

						imageIsLoadedTertiary(e, productImageId);

					}
					reader.readAsDataURL(this.files[0]);

				} else {

					$("#product_images_third_image_inner_image_div_third_" + productImageId).empty();

					var reader = new FileReader();
					reader.onload = function(e) {

						imageIsLoadedTertiary(e, productImageId);

					}
					reader.readAsDataURL(this.files[0]);

				}

			}

		});

		$(".product_images_button_for_file_upload_third").on("click", function() {

			var productImageId = $(this).data("productimageidthird");

			$("#product_images_third_" + productImageId).click();

		});

	}

	collection();

	$(".select_collection").on("change", function() {

		var collectionId = this.value;

		window.location.href = "edit_collection_form?collection_id=" + collectionId;

	});

	$(".select_collection_delete").on("change", function() {

		var collectionId = this.value;

		window.location.href = "delete_collection_form?collection_id=" + collectionId;

	});

	$(document).on("click", ".products_main_each_collection_each_inner_outer_div", function() {

		var productID = $(this).attr("id");

		window.location.href = "product?id=" + productID;

	});

	$(document).on("click", ".product_small_preview_each_div", function() {

		var image = $(this).data("image");

		$(".product_small_preview_each_div").removeClass("image_active");
		$(this).addClass("image_active");

		$("#product_each_image_preview_outer_div").css("background-image", "url(" + image + ")");

	});

	$(document).on("click", ".product_buy_button_log_in", function() {

		var redir = $(this).data("redir");

		window.location.href = redir;

	});

	$(document).on("click", ".send_chat_message_image_span_image", function() {

		$(".upload_pictures_input").trigger("click");

	});

	var imagesCounter = 0;
	var uploadedImagesCounter = 0;
	var imagesLimitAmount = 20;
	var index = 0;
	var imagesArray = [];

	function countUploadedImages(input) {

		for (var i = 0; i < input.files.length; i++) {

			uploadedImagesCounter++;

		}

		return uploadedImagesCounter;

	}

	function imagesPreview(input, container) {

		index = 0;

		if (input.files) {

			imagesCounter = input.files.length;

			for (var i = 0; i < imagesCounter; i++) {

				if (imagesCounter > imagesLimitAmount) {

					$(".image_upload_amount_limit_error_container_div").html('<div class="image_upload_amount_limit_error"><span class="image_helper"><img src="/images/x.png" class="email_sent_tick_image" /></span><p class="email_sent_failed_message">You have exceeded the maximum image upload amount! Maximum number of images allowed: ' + imagesLimitAmount + '</p></div>');

					$(".uploaded_images_preview_outer_container_div").css("display", "none");

				} else {

					var reader = new FileReader();

					reader.onload = function(e) {

						if (imagesArray.length === 0) {

							index = 0;

						}

						imagesArray.push("uploaded_image_" + index);

						$(container).css("display", "block");

						$(container).append('<div class="each_image_helper_container" id="uploaded_image_' + (index + 1) + '" data-id="' + (index + 1) + '"><span class="each_image_uploaded_index" id="indexed_labelling_span_image_uploaded_' + (index + 1) + '">' + (index + 1) + '</span><span class="each_image_helper_container_span"></span><img src="' + e.target.result + '" class="uploaded_picture_each" /><span class="remove_uploaded_image_from_preview">&times;</span></div>');

						index++;

						$(".image_upload_amount_limit_error_container_div").empty();

					}

					reader.readAsDataURL(input.files[i]);

				}

			}

		}

	}

	$(document).on("change", ".upload_pictures_input", function(e) {

		uploadedImagesCounter = 0;

		countUploadedImages(this);

		if (uploadedImagesCounter > imagesLimitAmount) {

			imagesCounter = this.files.length;
			uploadedImagesCounter = uploadedImagesCounter - imagesCounter;

			if ($(".inner_uploaded_images_preview_container_div").is(":empty")) {

				uploadedImagesCounter = 0;

				$(".uploaded_images_preview_outer_container_div").css("display", "none");

			}

			$(".image_upload_amount_limit_error_container_div").html('<div class="image_upload_amount_limit_error"><span class="image_helper"></span><img src="/images/x.png" class="email_sent_tick_image" /><p class="email_sent_failed_message">You have exceeded the maximum image upload amount! Maximum number of images allowed: ' + imagesLimitAmount + '</p></div>');

		} else {

			$(".uploaded_images_preview_outer_container_div").css("display", "block");
			$(".inner_uploaded_images_preview_container_div").empty();

			imagesPreview(this, ".inner_uploaded_images_preview_container_div");

		}

		if ($(this).val().length === 0) {

			uploadedImagesCounter = 0;

			$(".uploaded_images_preview_outer_container_div").css("display", "none");

		}

		setTimeout(function() {

			$(".image_upload_amount_limit_error").fadeOut(500, function() {

				$(".image_upload_amount_limit_error").remove();

			});

		}, 3000);

	});

	$(document).on("click", ".remove_uploaded_image_from_preview", function() {

		$(".uploaded_images_preview_outer_container_div").css("display", "none");
		$(".upload_pictures_input").val("");

		$.when($(this).parent(".each_image_helper_container").remove()).then(function() {

			var imageIndex = $(this).data("id");

			if (imageIndex > -1) {

				imagesArray.splice(imageIndex, 1);

			}

			for (var i = imageIndex; i <= imagesArray.length + 1; i++) {

				$("#uploaded_image_" + i).attr("id", "uploaded_image_" + (i - 1));
				$("#uploaded_image_" + (i - 1)).attr("data-id", (i - 1));
				$("#indexed_labelling_span_image_uploaded_" + (i)).attr("id", "indexed_labelling_span_image_uploaded_" + (i - 1));
				$("#indexed_labelling_span_image_uploaded_" + (i - 1)).html((i - 1));

			}

			if ($(".inner_uploaded_images_preview_container_div").is(":empty")) {

				$(".uploaded_images_preview_outer_container_div").css("display", "none");
				index = 0;

			} else {

				index = imagesArray.length - 1;

			}

		});

		uploadedImagesCounter--;

		if (uploadedImagesCounter == 0) {

			$(".upload_pictures_input").val("");

		}

	});

	$(document).on("click", ".message_image", function() {

		var imageSource = $(this).data("imagesource");
		var bgColor = $(this).data("bgcolor");

		$(".opened_image_outer_container_div").css("display", "block");
		$(".opened_image_outer_container_div").css("background-color", bgColor);
		$(".opened_image_outer_container_secondary_div").css("display", "block");
		$(".opened_image_outer_container_secondary_div").html('<img src="' + imageSource + '" class="opened_image" /><span class="opened_image_close">&times;</span>');
		$(".opened_image").css("display", "block");

	});

	$(document).on("click", ".opened_image_close", function() {

		$(".opened_image_outer_container_div").css("display", "none");
		$(".opened_image_outer_container_secondary_div").css("display", "none");
		$(".opened_image_outer_container_secondary_div").empty();
		$(".opened_image").css("display", "none");

	});

	$(document).keydown(function(e) {

		if (e.keyCode === 27) {

			if ($(".opened_image").is(":visible")) {

				$(".opened_image_outer_container_div").css("display", "none");
				$(".opened_image_outer_container_secondary_div").css("display", "none");
				$(".opened_image_outer_container_secondary_div").empty();
				$(".opened_image").css("display", "none");

			} else if ($(".delete_message_x").is(":visible")) {

				$(".delete_message_main_outer_container_div").remove();

			}

		} else if (e.keyCode === 13) {

			if ($(".message_textarea").is(":focus")) {

				$(".message_submit").trigger("click");
				$(".message_textarea").val("");

			}

		}

	});

	function fetchConversationHistory(convoId, orderId, toUserId) {

		$.ajax({

			url: "/AJAX/fetch_conversation.php",
			method: "GET",
			data: {

				convoId: convoId,
				orderId: orderId,
				toUserId: toUserId

			},
			success: function(data) {

				$.ajax({

					url: "/AJAX/messages_seen_status.php",
					method: "GET",
					data: {

						orderId: orderId,
						toUserId: toUserId

					},
					success: function(res) {

						return $(".main_conversation_container_div").html('<div class="unseen_messages_counter_scrolled_up_div"><img src="images/down_arrow.png" class="unseen_messages_counter_scrolled_up_arrow_image" /></div><div class="spacing_helper_container"></div><div class="outer_helper_inverser_div">' + data + '</div><div class="seen_message_div">' + res + '</div>');

					}

				});

			}

		});

	}

	function chatContainer(convoId, orderId, productImage, numericalOrderId, toUserId) {

		var chatContainerContent = '<div class="right_top_conversation_name_chat_div"><div class="right_top_conversation_name_chat_product_image" style="background-image: url(' + productImage + ');"></div><p class="right_top_conversation_name_chat_user_username">Order #: ' + orderId + '</p></div><div class="main_conversation_container_div"></div><div class="bottom_conversation_container_div"><div class="uploaded_images_preview_outer_container_div"><div class="inner_uploaded_images_preview_container_div"></div></div><form class="send_message_form" action="" method="POST" enctype="multipart/form-data" data-touserid="' + toUserId + '" data-numericalorderid="' + numericalOrderId + '" data-convoid="' + convoId + '" data-orderid="' + orderId + '"><div class="submit_form_inner_right_div"><label for="send_chat_message_image" class="send_chat_message_image_label"><span class="send_chat_message_image_span"><img src="images/send_picture.png" class="send_chat_message_image_span_image" /></span></label></div><textarea maxlength="1000" name="send_message_textarea" class="message_textarea" placeholder="Type your message..."></textarea><input type="submit" name="send_message_submit" class="message_submit" value="Send" /><input type="file" name="uploaded_pictures[]" class="upload_pictures_input" accept="image/jpg, image/jpeg, image/png" multiple></form></div>';

		return $(".right_main_outer_container_inbox").html(chatContainerContent);

	}

	function chatContainerAdmin(convoId, orderId, productImage, numericalOrderId, toUserId) {

		var chatContainerContent = '<div class="right_top_conversation_name_chat_div"><div class="right_top_conversation_name_chat_product_image" style="background-image: url(' + productImage + ');"></div><p class="right_top_conversation_name_chat_user_username">Order #: ' + orderId + '</p></div><div class="main_conversation_container_div"></div><div class="bottom_conversation_container_div"><div class="uploaded_images_preview_outer_container_div"><div class="inner_uploaded_images_preview_container_div"></div></div><form class="send_message_form_admin" action="" method="POST" enctype="multipart/form-data" data-touserid="' + toUserId + '" data-numericalorderid="' + numericalOrderId + '" data-convoid="' + convoId + '" data-orderid="' + orderId + '"><div class="submit_form_inner_right_div"><label for="send_chat_message_image" class="send_chat_message_image_label"><span class="send_chat_message_image_span"><img src="images/send_picture.png" class="send_chat_message_image_span_image" /></span></label></div><textarea maxlength="1000" name="send_message_textarea" class="message_textarea" placeholder="Type your message..."></textarea><input type="submit" name="send_message_submit" class="message_submit" value="Send" /><input type="file" name="uploaded_pictures[]" class="upload_pictures_input" accept="image/jpg, image/jpeg, image/png" multiple></form></div>';

		return $(".right_main_outer_container_inbox").html(chatContainerContent);

	}

	$(document).on("click", ".each_conversation_main_outer_container_div", function() {

		var offset = 7;

		var orderId = $(this).attr("id");
		var convoId = $(this).data("convoid");
		var productImage = $(this).data("imagesource");
		var numericalOrderId = $(this).data("orderid");
		var toUserId = $(this).data("touserid");

		if ($(".mobile_helper_div").is(":visible")) {

			$(".left_main_outer_container_inbox_div").css("display", "none");
			$(".right_main_outer_container_inbox").css("display", "block");
			$(".right_main_outer_container_inbox").css("width", "100%");
			$(".account_settings_back_button_orders").remove();
			$(".account_settings_back_button_orders_div").html('<button class="account_settings_back_button_orders back_to_conversations_list" data-orderid="' + numericalOrderId + '">Back</button>');

		}

		$(".search_conversations_result_container_div").css("display", "none");
		$(".left_top_search_bar_inbox_input").val("");
		$(".search_conversations_result_container_div").empty();

		$(".select_and_open_conversation_div").css("display", "none");
		chatContainer(convoId, orderId, productImage, numericalOrderId, toUserId);
		fetchConversationHistory(convoId, orderId, toUserId);

		$.ajax({

			url: "/AJAX/update_messages_status.php",
			method: "POST",
			data: {

				orderId: orderId,
				toUserId: toUserId

			},
			success: function(data) {

				$("#unseen_messages_counter_" + numericalOrderId).remove();

			}

		});

		$(".each_conversation_main_outer_container_div").removeClass("active_conversation");
		$(".each_conversation_product_image").removeClass("active_conversation_product_image");
		$(".each_conversation_main_outer_container_div_" + numericalOrderId).addClass("active_conversation");
		$("#product_conversation_" + orderId).addClass("active_conversation_product_image");

		var messageLoadedInterval = setInterval(function() {

			if (!$(".main_conversation_container_div").is(":empty")) {

				clearInterval(messageLoadedInterval);

				$(".message_textarea").focus();

				$(".main_conversation_container_div").animate({

					scrollTop: $(".main_conversation_container_div")[0].scrollHeight * $(".main_conversation_container_div")[0].scrollHeight

				}, 10);

			}

		}, 50);

		$(".main_conversation_container_div").on("scroll", function() {

			var scrollTop = $(this).scrollTop();
			var innerHeight = $(this).innerHeight();

			if (scrollTop == 0) {

				$.ajax({

					url: "/AJAX/load_messages.php",
					method: "GET",
					data: {

						orderId: orderId,
						convoId: convoId,
						offset: offset

					},
					success: function(data) {

						if (data != "") {

							$(".outer_helper_inverser_div").append(data);

							$(".main_conversation_container_div").scrollTop(750);

							offset += 7;

						}

					}

				});

			}

			if (scrollTop + innerHeight >= $(this)[0].scrollHeight - 250) {

				$(".unseen_messages_counter_scrolled_up_div").css("display", "none");

			} else {

				$(".unseen_messages_counter_scrolled_up_div").css("display", "block");

			}

		});

	});

	$(document).on("submit", ".send_message_form", function(e) {

		e.preventDefault();
		e.stopImmediatePropagation();

		var numericalOrderId = $(this).data("numericalorderid");

		var messageContent = $(".message_textarea").val();
		var messageContentTrimmed = messageContent.trim();
		var messageContentTrimmedLength = messageContentTrimmed.length;

		var uploadedImageFileLength = $(".upload_pictures_input").get(0).files.length;
		var uploadedImageFile = $(".upload_pictures_input").get(0).files;

		if (uploadedImageFileLength == 0 && (messageContentTrimmed === "" || messageContentTrimmedLength == 0)) {

				$(".message_textarea").css("border", "2px solid red");
				$(".message_textarea").attr("placeholder", "Can't send empty message!");
				$(".message_textarea").val("");

		} else {

			var formData = new FormData(this);
			formData.append("convoId", $(this).data("convoid"));
			formData.append("orderId", $(this).data("orderid"));
			formData.append("toUserId", $(this).data("touserid"));

			$.ajax({

				url: "/AJAX/insert_message.php",
				method: "POST",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {

					uploadedImagesCounter = 0;

					if (data == 1) {

						$(".image_upload_amount_limit_error_container_div").html('<div class="image_upload_amount_limit_error"><span class="image_helper"></span><img src="/images/x.png" class="email_sent_tick_image" /><p class="email_sent_failed_message">Files must be smaller than 10MB!</p></div>');

						setTimeout(function() {

							$(".image_upload_amount_limit_error").fadeOut(500, function() {

								$(".image_upload_amount_limit_error").remove();

							});

						}, 3000);

					} else {

						if ($(".select_and_open_conversation_div").is(":visible")) {

							$(".select_and_open_conversation_div").css("display", "none");

						}

						if ($(".uploaded_images_preview_outer_container_div").is(":visible")) {

							$(".uploaded_images_preview_outer_container_div").css("display", "none");

						}

						$(".outer_helper_inverser_div").prepend(data);

						var messageLoadedInterval = setInterval(function() {

							if (!$(".main_conversation_container_div").is(":empty")) {

								clearInterval(messageLoadedInterval);

								$(".message_textarea").focus();

								$(".main_conversation_container_div").animate({

									scrollTop: $(".main_conversation_container_div")[0].scrollHeight * $(".main_conversation_container_div")[0].scrollHeight

								}, 10);

							}

						}, 50);

						$.ajax({

							url: "/AJAX/load_conversations.php",
							method: "GET",
							success: function(data) {

								$(".conversations_main_outer_left_container_div").html(data);
								$("#message_seen_" + numericalOrderId).remove();
								$(".message_textarea").val("");

							}

						});

					}

				}

			});

		}

	});

	$(document).on("focus", ".message_textarea", function() {

		$(".message_textarea").css("border", "2px solid #6a7755");
		$(".message_textarea").attr("placeholder", "Type your message...");

	});

	$(document).on("click", ".unseen_messages_counter_scrolled_up_div", function() {

		$(".unseen_messages_counter_scrolled_up_div").css("display", "none");

		$(".main_conversation_container_div").animate({

			scrollTop: $(".main_conversation_container_div")[0].scrollHeight * $(".main_conversation_container_div")[0].scrollHeight

		}, 10);

	});

	$(document).on("click", ".delete_chat_bin_image", function() {

		var messageContent = $(this).data("messagecontent");
		var messageId = $(this).data("messageid");
		var orderId = $(this).data("orderid");
		var otherOrderId = $(this).data("otherorderid");
		var toUserId = $(this).data("touserid");
		var convoId = $(this).data("convoid");
		var messageTypeContent;
		var messageType;
		var messageTypeLabel;

		if (parseInt(messageContent) !== NaN) {

			messageContent = messageContent.toString();

		}

		if (messageContent.includes("png")) {

			messageTypeContent = '<img src="message_images/' + messageContent + '" class="delete_message_message_content_preview_content_image" />';
			messageType = "delete_message_message_content_preview_image_div";
			messageTypeLabel = "picture";

		} else {

			messageTypeContent = '<p class="delete_message_message_content_preview_content">' + messageContent + '</p>';
			messageType = "delete_message_message_content_preview_text_div";
			messageTypeLabel = "text";

		}

		$("body").prepend('<div class="delete_message_main_outer_container_div"><div class="delete_message_main_outer_container_content_div"><span class="delete_message_x">&times;</span><p class="delete_message_label">Are you sure you want to delete this ' + messageTypeLabel + '?</p><div class="' + messageType + '">' + messageTypeContent + '</div><div class="delete_message_buttons_outer_div"><button class="delete_message_button delete_message_button_yes" data-messageid="' + messageId + '" data-messagetype="' + messageTypeLabel + '" data-orderid="' + orderId + '" data-otherorderid="' + otherOrderId + '" data-touserid="' + toUserId + '" data-convoid="' + convoId + '">Yes</button><button class="delete_message_button delete_message_button_no">No</button></div></div></div>');

	});

	$(document).on("click", ".delete_message_x", function() {

		$(".delete_message_main_outer_container_div").remove();

	});

	$(document).on("click", ".delete_message_button_no", function() {

		$(".delete_message_main_outer_container_div").remove();

	});

	$(document).on("click", ".delete_message_button_yes", function() {

		var messageId = $(this).data("messageid");
		var messageTypeLabel = $(this).data("messagetype");
		var orderId = $(this).data("orderid");
		var otherOrderId = $(this).data("otherorderid");
		var toUserId = $(this).data("touserid");
		var convoId = $(this).data("convoid");

		$.ajax({

			url: "/AJAX/delete_message.php",
			method: "POST",
			data: {

				messageId: messageId,
				messageTypeLabel: messageTypeLabel,
				orderId: orderId,
				convoId: convoId

			},
			success: function(data) {

				$.ajax({

					url: "/AJAX/load_conversations.php",
					method: "GET",
					success: function(data) {

						$.ajax({

							url: "/AJAX/messages_seen_status.php",
							method: "GET",
							data: {

								otherOrderId: otherOrderId,
								toUserId: toUserId

							},
							success: function(res) {

								$(".conversations_main_outer_left_container_div").html(data);

								$(".each_conversation_main_outer_container_div").removeClass("active_conversation");
								$(".each_conversation_product_image").removeClass("active_conversation_product_image");
								$(".each_conversation_main_outer_container_div_" + orderId).addClass("active_conversation");
								$("#product_conversation_" + otherOrderId).addClass("active_conversation_product_image");

								$("#each_message_outer_main_container_wrapper_" + messageId).remove();
								$(".delete_message_main_outer_container_div").remove();

								$(".seen_message_div").html(res);

								if (($(".outer_helper_inverser_div").text()).trim() == 'No messages have been sent in this conversation yet!' || ($(".outer_helper_inverser_div").text()).trim() == "") {

									$(".outer_helper_inverser_div").html('<div class="select_and_open_conversation_div"><p class="no_messages_yet">No messages have been sent in this conversation yet!</p></div>');

									$(".select_and_open_conversation_div").attr("style", "display: block");

								}

							}

						});

					}

				});

			}

		});

	});

	$(".left_top_search_bar_inbox_input").keyup(function() {

		var orderIdCurVal = $(this).val();

		if (orderIdCurVal != '') {

			$(".search_conversations_result_container_div").css("display", "block");

			$(".search_conversations_result_container_div").html("");

			$.ajax({

				url: "/AJAX/get_searched_conversations_result.php",
				method: "GET",
				data: {

					orderIdCurVal: orderIdCurVal

				},
				success: function(data) {

					$(".search_conversations_result_container_div").html(data);

				}

			});

		} else {

			$(".search_conversations_result_container_div").css("display", "none");

		}

	});

	$(document).on("click", ".each_conversation_main_outer_container_div_admin", function() {

		var offset = 7;

		var orderId = $(this).attr("id");
		var convoId = $(this).data("convoid");
		var productImage = $(this).data("imagesource");
		var numericalOrderId = $(this).data("orderid");
		var toUserId = $(this).data("touserid");

		if ($(".mobile_helper_div").is(":visible")) {

			$(".left_main_outer_container_inbox_div").css("display", "none");
			$(".right_main_outer_container_inbox").css("display", "block");
			$(".right_main_outer_container_inbox").css("width", "100%");
			$(".account_settings_back_button_orders").remove();
			$(".account_settings_back_button_orders_div").html('<button class="account_settings_back_button_orders back_to_conversations_list_admin" data-orderid="' + numericalOrderId + '">Back</button>');

		}

		$(".search_conversations_result_container_div").css("display", "none");
		$(".left_top_search_bar_inbox_input").val("");
		$(".search_conversations_result_container_div").empty();

		$(".select_and_open_conversation_div").css("display", "none");
		chatContainerAdmin(convoId, orderId, productImage, numericalOrderId, toUserId);
		fetchConversationHistory(convoId, orderId, toUserId);

		$.ajax({

			url: "/AJAX/update_messages_status.php",
			method: "POST",
			data: {

				orderId: orderId,
				toUserId: toUserId

			},
			success: function(data) {

				$("#unseen_messages_counter_" + numericalOrderId).remove();

			}

		});

		$(".each_conversation_main_outer_container_div_admin").removeClass("active_conversation");
		$(".each_conversation_product_image").removeClass("active_conversation_product_image");
		$(".each_conversation_main_outer_container_div_admin_" + numericalOrderId).addClass("active_conversation");
		$("#product_conversation_" + orderId).addClass("active_conversation_product_image");

		var messageLoadedInterval = setInterval(function() {

			if (!$(".main_conversation_container_div").is(":empty")) {

				clearInterval(messageLoadedInterval);

				$(".message_textarea").focus();

				$(".main_conversation_container_div").animate({

					scrollTop: $(".main_conversation_container_div")[0].scrollHeight * $(".main_conversation_container_div")[0].scrollHeight

				}, 10);

			}

		}, 50);

		$(".main_conversation_container_div").on("scroll", function() {

			var scrollTop = $(this).scrollTop();
			var innerHeight = $(this).innerHeight();

			if (scrollTop == 0) {

				$.ajax({

					url: "/AJAX/load_messages_admin.php",
					method: "GET",
					data: {

						orderId: orderId,
						convoId: convoId,
						offset: offset

					},
					success: function(data) {

						if (data != "") {

							$(".outer_helper_inverser_div").append(data);

							$(".main_conversation_container_div").scrollTop(750);

							offset += 7;

						}

					}

				});

			}

			if (scrollTop + innerHeight >= $(this)[0].scrollHeight - 250) {

				$(".unseen_messages_counter_scrolled_up_div").css("display", "none");

			} else {

				$(".unseen_messages_counter_scrolled_up_div").css("display", "block");

			}

		});

	});

	$(document).on("submit", ".send_message_form_admin", function(e) {

		e.preventDefault();
		e.stopImmediatePropagation();

		var numericalOrderId = $(this).data("numericalorderid");

		var messageContent = $(".message_textarea").val();
		var messageContentTrimmed = messageContent.trim();
		var messageContentTrimmedLength = messageContentTrimmed.length;

		var uploadedImageFileLength = $(".upload_pictures_input").get(0).files.length;
		var uploadedImageFile = $(".upload_pictures_input").get(0).files;

		if (uploadedImageFileLength == 0 && (messageContentTrimmed === "" || messageContentTrimmedLength == 0)) {

				$(".message_textarea").css("border", "2px solid red");
				$(".message_textarea").attr("placeholder", "Can't send empty message!");
				$(".message_textarea").val("");

		} else {

			var formData = new FormData(this);
			formData.append("convoId", $(this).data("convoid"));
			formData.append("orderId", $(this).data("orderid"));
			formData.append("toUserId", $(this).data("touserid"));

			$.ajax({

				url: "/AJAX/insert_message.php",
				method: "POST",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {

					uploadedImagesCounter = 0;

					if (data == 1) {

						$(".image_upload_amount_limit_error_container_div").html('<div class="image_upload_amount_limit_error"><span class="image_helper"></span><img src="/images/x.png" class="email_sent_tick_image" /><p class="email_sent_failed_message">Files must be smaller than 10MB!</p></div>');

						setTimeout(function() {

							$(".image_upload_amount_limit_error").fadeOut(500, function() {

								$(".image_upload_amount_limit_error").remove();

							});

						}, 3000);

					} else {

						if ($(".select_and_open_conversation_div").is(":visible")) {

							$(".select_and_open_conversation_div").css("display", "none");

						}

						if ($(".uploaded_images_preview_outer_container_div").is(":visible")) {

							$(".uploaded_images_preview_outer_container_div").css("display", "none");

						}

						$(".outer_helper_inverser_div").prepend(data);

						var messageLoadedInterval = setInterval(function() {

							if (!$(".main_conversation_container_div").is(":empty")) {

								clearInterval(messageLoadedInterval);

								$(".message_textarea").focus();

								$(".main_conversation_container_div").animate({

									scrollTop: $(".main_conversation_container_div")[0].scrollHeight * $(".main_conversation_container_div")[0].scrollHeight

								}, 10);

							}

						}, 50);

						$.ajax({

							url: "/AJAX/load_conversations_admin.php",
							method: "GET",
							success: function(data) {

								$(".conversations_main_outer_left_container_div").html(data);
								$("#message_seen_" + numericalOrderId).remove();
								$(".message_textarea").val("");

							}

						});

					}

				}

			});

		}

	});

	$(document).on("click", ".delete_chat_bin_image_admin", function() {

		var messageContent = $(this).data("messagecontent");
		var messageId = $(this).data("messageid");
		var orderId = $(this).data("orderid");
		var otherOrderId = $(this).data("otherorderid");
		var toUserId = $(this).data("touserid");
		var convoId = $(this).data("convoid");
		var messageTypeContent;
		var messageType;
		var messageTypeLabel;

		if (parseInt(messageContent) !== NaN) {

			messageContent = messageContent.toString();

		}

		if (messageContent.includes("png")) {

			messageTypeContent = '<img src="message_images/' + messageContent + '" class="delete_message_message_content_preview_content_image" />';
			messageType = "delete_message_message_content_preview_image_div";
			messageTypeLabel = "picture";

		} else if (/^\d+$/.test(messageContent)) {

			messageTypeContent = '<p class="delete_message_message_content_preview_content">' + messageContent + '</p>';
			messageType = "delete_message_message_content_preview_text_div";
			messageTypeLabel = "text";

		} else {

			messageTypeContent = '<p class="delete_message_message_content_preview_content">' + messageContent + '</p>';
			messageType = "delete_message_message_content_preview_text_div";
			messageTypeLabel = "text";

		}

		$("body").prepend('<div class="delete_message_main_outer_container_div"><div class="delete_message_main_outer_container_content_div"><span class="delete_message_x">&times;</span><p class="delete_message_label">Are you sure you want to delete this ' + messageTypeLabel + '?</p><div class="' + messageType + '">' + messageTypeContent + '</div><div class="delete_message_buttons_outer_div"><button class="delete_message_button delete_message_button_yes_admin" data-messageid="' + messageId + '" data-messagetype="' + messageTypeLabel + '" data-orderid="' + orderId + '" data-otherorderid="' + otherOrderId + '" data-touserid="' + toUserId + '" data-convoid="' + convoId + '">Yes</button><button class="delete_message_button delete_message_button_no">No</button></div></div></div>');

	});

	$(document).on("click", ".delete_message_button_yes_admin", function() {

		var messageId = $(this).data("messageid");
		var messageTypeLabel = $(this).data("messagetype");
		var orderId = $(this).data("orderid");
		var otherOrderId = $(this).data("otherorderid");
		var toUserId = $(this).data("touserid");
		var convoId = $(this).data("convoid");

		$.ajax({

			url: "/AJAX/delete_message.php",
			method: "POST",
			data: {

				messageId: messageId,
				messageTypeLabel: messageTypeLabel,
				orderId: orderId,
				convoId: convoId

			},
			success: function(data) {

				$.ajax({

					url: "/AJAX/load_conversations_admin.php",
					method: "GET",
					success: function(data) {

						$.ajax({

							url: "/AJAX/messages_seen_status.php",
							method: "GET",
							data: {

								otherOrderId: otherOrderId,
								toUserId: toUserId

							},
							success: function(res) {

								$(".conversations_main_outer_left_container_div").html(data);

								$(".each_conversation_main_outer_container_div_admin").removeClass("active_conversation");
								$(".each_conversation_product_image").removeClass("active_conversation_product_image");
								$(".each_conversation_main_outer_container_div_admin_" + orderId).addClass("active_conversation");
								$("#product_conversation_" + otherOrderId).addClass("active_conversation_product_image");

								$("#each_message_outer_main_container_wrapper_" + messageId).remove();
								$(".delete_message_main_outer_container_div").remove();

								$(".seen_message_div").html(res);

								if (($(".outer_helper_inverser_div").text()).trim() == 'No messages have been sent in this conversation yet!' || ($(".outer_helper_inverser_div").text()).trim() == "") {

									$(".outer_helper_inverser_div").html('<div class="select_and_open_conversation_div"><p class="no_messages_yet">No messages have been sent in this conversation yet!</p></div>');

									$(".select_and_open_conversation_div").attr("style", "display: block");

								}

							}

						});

					}

				});

			}

		});

	});

	$(".left_top_search_bar_inbox_input_admin").keyup(function() {

		var orderIdCurVal = $(this).val();

		if (orderIdCurVal != '') {

			$(".search_conversations_result_container_div").css("display", "block");

			$(".search_conversations_result_container_div").html("");

			$.ajax({

				url: "/AJAX/get_searched_conversations_result_admin.php",
				method: "GET",
				data: {

					orderIdCurVal: orderIdCurVal

				},
				success: function(data) {

					$(".search_conversations_result_container_div").html(data);

				}

			});

		} else {

			$(".search_conversations_result_container_div").css("display", "none");

		}

	});

	$(document).on("click", ".back_to_conversations_list", function() {

		var numericalOrderId = $(this).data("orderid");

		$(".left_main_outer_container_inbox_div").css("display", "block");
		$(".right_main_outer_container_inbox").css("display", "none");
		$(".left_main_outer_container_inbox").css("width", "100%");
		$(".account_settings_back_button_orders").remove();
		$(".account_settings_back_button_orders_div").html('<button class="account_settings_back_button_orders" onclick="window.location = \'/profile\'">Back</button>');
		$(".left_top_search_bar_inbox_input").val("");

		$.ajax({

			url: "/AJAX/load_conversations.php",
			method: "GET",
			success: function(data) {

				$(".conversations_main_outer_left_container_div").html(data);
				$("#message_seen_" + numericalOrderId).remove();
				$(".each_conversation_main_outer_container_div").removeClass("active_conversation");
				$(".each_conversation_product_image").removeClass("active_conversation_product_image");

			}

		});

	});

	$(document).on("click", ".back_to_conversations_list_admin", function() {

		var numericalOrderId = $(this).data("orderid");

		$(".left_main_outer_container_inbox_div").css("display", "block");
		$(".right_main_outer_container_inbox").css("display", "none");
		$(".left_main_outer_container_inbox").css("width", "100%");
		$(".account_settings_back_button_orders").remove();
		$(".account_settings_back_button_orders_div").html('<button class="account_settings_back_button_orders" onclick="window.location = \'/profile\'">Back</button>');
		$(".left_top_search_bar_inbox_input_admin").val("");

		$.ajax({

			url: "/AJAX/load_conversations_admin.php",
			method: "GET",
			success: function(data) {

				$(".conversations_main_outer_left_container_div").html(data);
				$("#message_seen_" + numericalOrderId).remove();
				$(".each_conversation_main_outer_container_div_admin").removeClass("active_conversation");
				$(".each_conversation_product_image").removeClass("active_conversation_product_image");

			}

		});

	});

	$(document).on("click", ".form_input_checkbox", function() {

		$(".form_input_checkbox").prop("checked", false);
		$(this).prop("checked", true);

	});

});