<div class="navbar_container">

	<div class="navbar">

		<ul class="navbar_ul">

			<div class="navbar_inner_div">
				
				<a href="./" class="navbar_link_li"><li class="navbar_li">Home</li></a>

				<a href="./products" class="navbar_link_li"><li class="navbar_li">Products</li></a>

				<li class="logo_li"><a href="./"><img src="./images/logo_transparent.png" class="logo" /></a></li>

				<a href="./about" class="navbar_link_li"><li class="navbar_li">About</li></a>
					
					<div class="navbar_li_dropdown_more">
					
						<p class="navbar_li_dropdown_more_title">More</p>

						<div class="navbar_li_dropdown_more_content_div">
							
							<a href="./contact" class="navbar_link_li_more"><li class="navbar_li_more">Contact</li></a>

							<a href="./log_in" class="navbar_link_li_more"><li class="navbar_li_more">My Account</li></a>

							<?php

								if (isset($_SESSION["user"])) {

									echo '<li class="navbar_li_more log_out_button">Log out</li>';

								}

							?>

						</div>

					</div>

			</div>

		</ul>

	</div>

</div>

<div id="menu_burger" onclick="openMenu(this)">
		
	<div class="menu_burger_each" id="top_line"></div>

	<div class="menu_burger_each" id="mid_line"></div>

	<div class="menu_burger_each" id="bot_line"></div>

</div>