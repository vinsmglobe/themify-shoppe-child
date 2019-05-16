<?php
// Child Theme Style.css
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
 
}
// checks for null
function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '');
}

// Displays events for an artist
function artist_previous_performances() {
	
	$artistEventsField = get_field('artistevents');
	if(!IsNullOrEmptyString($artistEventsField)) {
		echo '<br/>';
		echo '<h1 class="entry-title" style="font-size: 4em; text-align: center; text-transform: none;">Event Bookings</h1>';
		echo '<p style="border-bottom: 1px solid #efbe5a;width: 30px;text-align: center;margin: 0 auto;"><p>';	
	
		$artistEventsHTML = '';
		$artistEvents = explode("\n", $artistEventsField);
		foreach($artistEvents as $event) {
			$data = explode(",", $event);
			if($data)
				$artistEventsHTML .='<div class="e-post-container"><div class="e-post-thumb"><img src="' . $data[4] . '" /></div><div class="e-post-content"><h3 class="e-post-title">' . $data[3] . '</h3><p>' . $data[2] . ' Event at ' . $data[0] . ' on ' . $data[1] . '</p></div></div>';
		}
		echo $artistEventsHTML;

		global $product;
		$units_sold = get_post_meta( $product->id, 'total_sales', true );
		echo '<div class="e-post-container"><div class="e-post-thumb"><h3 style="font-size:2.5em; width:92px; margin-bottom:0">' . $units_sold . '</h3></div><div class="e-post-content"><h3 class="e-post-title"> </h3><p style="margin-top:20px;text-transform: capitalize;">People are interested for booking this Artist</p></div></div>';
		echo '<br/><br/><br/><br/>';
	}
	
	//work history
	$artistWorkField = get_field('artistworkhistory');
	if(!IsNullOrEmptyString($artistWorkField)) {
		echo '<h1 class="entry-title" style="font-size: 4em; text-align: center; text-transform: none;">Work History</h1>';
		echo '<p style="border-bottom: 1px solid #efbe5a;width: 30px;text-align: center;margin: 0 auto;"><p>';	
		echo '<p style="font-size: 1.5em;text-transform: none;">' . $artistWorkField . '</p>';
		echo '<br/><br/>';
	}
	
	//achievements
	$artistAchievementsField = get_field('artistachivements');
	if(!IsNullOrEmptyString($artistAchievementsField)) {
		echo '<h1 class="entry-title" style="font-size: 4em; text-align: center; text-transform: none;">Achievements</h1>';
		echo '<p style="border-bottom: 1px solid #efbe5a;width: 30px;text-align: center;margin: 0 auto;"><p>';	
	
		$artistAchievementsHTML = '';
		$artistAchievements = explode("\n", $artistAchievementsField);
		foreach($artistAchievements as $achievement) {
			$data = explode(";", $achievement);
			if($data)
				$artistAchievementsHTML .='<div class="e-post-container"><div class="e-post-thumb"><img src="https://images.vexels.com/media/users/3/136916/isolated/lists/aa21eb60437133bf4f4be189636a187a-star-favorite-outline-icon.png" /></div><div class="e-post-content"><h3 class="e-post-title">' . $data[0] . '</h3><p>' . $data[1] . '</p></div></div>';
		}
		echo $artistAchievementsHTML;
		echo '<br/><br/>';
	}
}
// Displays events for an artist
add_action('woocommerce_product_meta_start', 'artist_previous_performances');


function get_youtube_embed($youtube_url, $width=560, $height=315)
{
    $height = (int)$height;
    $width = (int)$width;
    $embed_html = '';
	$parts = parse_url($youtube_url);
	if(isset($parts['query'])) {
		parse_str($parts['query'], $query);
		if(isset($query['v'])) {
			$embed_html = '<iframe width="100%" height="'.$height.'" src="" data-src="https://www.youtube.com/embed/'.$query['v'].'" frameborder="0" allowfullscreen></iframe>';
		}
	}
	return $embed_html;
}

function product_price_start_add_video_audio() {
	$videoField = get_field('artistvideo');
	if(!IsNullOrEmptyString($videoField)) {
		echo '<h1 class="entry-title" style="font-size: 4em; text-align: center; text-transform: none;">Videos</h1>';	
		echo '<p style="border-bottom: 1px solid #efbe5a;width: 30px;text-align: center;margin: 0 auto;"><p>';	
		echo do_shortcode('[easy_youtube_gallery id=' . $videoField . ' cols=4 ar=16_9 thumbnail=0 title=top wall=1]');	
	} 
	
	$videoFacebookField = get_field('artistvideofacebook');
	if(!IsNullOrEmptyString($videoFacebookField)) {
		echo '<br/><br/>';
		$videoFacebookHTML = '';
// 		$fbcount = 0;
		$videosFacebook = explode(",", $videoFacebookField);
		foreach($videosFacebook as $vidFb) {
// 			$fbcount += 1;
// 			if($fbcount == 2){
// 				break;
// 			}
			$vidFb = trim($vidFb);
			$videoFacebookHTML .='<iframe width="100%" height="300" style="border:none;overflow:hidden" src="" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true" scrolling="no" frameborder="no" data-src="https://www.facebook.com/plugins/video.php?href=' . $vidFb . '"></iframe><br/>';
		}
		echo $videoFacebookHTML;
	} 
	echo '<br/><br/>';
	
	$audioField = get_field('artistaudio');
	if(!IsNullOrEmptyString($audioField)) {
		$audioHTML = '';
		$audios = explode(",", $audioField);
		foreach($audios as $aud) {
			$aud = trim($aud);
			$audioHTML .= "<iframe width='100%' height='500' scrolling='no' frameborder='no' src='' data-src='" . $aud . "'></iframe><br/>";
		}
		echo '<h1 class="entry-title" style="font-size: 4em; text-align: center; text-transform: none;">Audios</h1>';
		echo '<p style="border-bottom: 1px solid #efbe5a;width: 30px;text-align: center;margin: 0 auto;"><p><br/>';	
		echo $audioHTML;
	} 
	echo '<br/>';
};

// Displays audio and video on frontend. Gets them from fields created by the Advanced Custom Fields plugin
add_action('woocommerce_product_meta_end', 'product_price_start_add_video_audio');

// To show About over description section 
add_action( 'woocommerce_after_single_product_summary', 'bbloomer_custom_action', 5 );
function bbloomer_custom_action() {
	echo '<h1 class="entry-title" style="font-size: 4em; text-align: center; text-transform: none;">About</h1>';
	echo '<p style="border-bottom: 1px solid #efbe5a;width: 30px;text-align: center;margin: 0 auto;"><p>';	

};

// To show star ratings on shop and archive pages
add_action('woocommerce_after_shop_loop_item', 'add_star_rating' );
function add_star_rating() {
	global $woocommerce, $product;
	$average = $product->get_average_rating();
	echo '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';
}

/* QR'S CHANGES START */

// custom add to cart button text
add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text', 10, 2 );                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text', 10, 2 );  // 2.1 +
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_single_add_to_cart_text', 10, 2 );
function woo_custom_single_add_to_cart_text($price, $product) {
	if (0 == $product -> get_price()){
    return __( 'See Price and Book', 'woocommerce' );
	}
	else {
		return __('Book Now', 'woocommerce');
	}
}

// custom get quote button text
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text'); 
function woo_custom_order_button_text(){
	$total = 0;
		$order_id = absint( get_query_var( 'order-pay' ) );

// 		Gets order total from "pay for order" page.
		if ( 0 < $order_id ) {
			$order = wc_get_order( $order_id );
			$total = (float) $order->get_total();

			// Gets order total from cart/checkout.
		} elseif ( 0 == WC()->cart->total ) {
			$total = (float) WC()->cart->total;
			return __('See Price and Book');
		}
	else{
		return __('Book Now');
	}
}


//Remove budget field if Artist is prepaid

add_filter( 'woocommerce_checkout_fields', 'conditional_checkout_fields_products' );
function conditional_checkout_fields_products( $fields ) {
 	$totaly = 0;
		$order_id = absint( get_query_var( 'order-pay' ) );

// 		Gets order total from "pay for order" page.
		if ( 0 < $order_id ) {
			$order = wc_get_order( $order_id );
			$totaly = (float) $order->get_total();

			// Gets order total from cart/checkout.
		} elseif ( 0 < WC()->cart->total ) {
			$totaly = (float) WC()->cart->total;
            unset( $fields['billing']['billing_event_budget'] );
        }

    return $fields;
}
	

//Conditional visibility of price
add_filter( 'woocommerce_get_price_html', 'price_free_zero_empty', 100, 2 );
 
function price_free_zero_empty( $price, $product ){

if ( '' === $product->get_price() || 0 == $product->get_price() ) {
   $price = '<span class="woocommerce-Price-amount amount"></span>';
} 

return $price;
}

/*QR'S CHANGES END*/


/* add product filter on shop and category pages */
// add_action( 'woocommerce_before_shop_loop', 'product_filter', 15 );
// function product_filter() {
// 	echo do_shortcode( '[searchandfilter id="filter_artists"]' );
// }

// get quote page customizations  
add_filter( 'woocommerce_after_order_notes', 'woo_show_cart_before_customer_details' ); 
function woo_show_cart_before_customer_details() {
	global $woocommerce;
    $items = $woocommerce->cart->get_cart();
	foreach($items as $item => $values) { 
		echo "<br/><div style='text-align:center;'>";
		$_product =  wc_get_product( $values['data']->get_id()); 
		//product image
		$getProductDetail = wc_get_product( $values['product_id'] );
		echo $getProductDetail->get_image(); // accepts 3 arguments ( size, attr, placeholder );
		// title
		echo "<br/><br/><h1 style='font-size:2em;'>".$_product->get_title()."</h1><br/>";
		echo "</div>";
	} 
// 	echo do_shortcode( '[woocommerce_cart]' );
}


// inserts PYR form on top of every category,archive, browse and product pages
add_action( 'woocommerce_before_main_content', 'woo_before_main_content', 15 );
function woo_before_main_content() {	
	
	global $wp;
	$pageUrl = $wp->request;
	if (strpos($pageUrl, 'book-online') !== false) {
		$args = array(
			'post_type' => 'weddingtagpages',
			'meta_query' => array(
				array(
					'key'     => 'tag_url_slug',
					'value'   => explode("/", $pageUrl)[1]
				)
			)
		);
		$obituary_query = new WP_Query($args);
		while ($obituary_query->have_posts()) : $obituary_query->the_post();

			echo '<div>';
				echo '<div>';
					echo '<img class="tag-desktop-hero" src="' . get_field('banner_hero_image') . '" style="width:100%;">';
					echo '<img class="tag-mobile-hero" src="' . get_field('mobile_banner_hero_image') . '" style="width:100%;display:none;">';		
				echo '</div>';
				echo '<div>';
					echo '<h2 class="wedding-title">' . get_field('banner_title') . '</h2>';
					echo '<p class="wedding-subtitle">' . get_field('banner_description') . '</p>';
					echo '<style>#nf-form-8-cont,#nf-form-9-cont,#nf-form-10-cont,#nf-form-11-cont,#nf-form-12-cont,#nf-form-13-cont{text-align:center;}</style>';
					if (strpos($pageUrl, 'wedding-anchor-emcee') !== false) {
						echo '<p class="wedding-subtitle">' . do_shortcode('[ninja_form id=8]') . '</p>';
					}
					if (strpos($pageUrl, 'wedding-band') !== false) {
						echo '<p class="wedding-subtitle">' . do_shortcode('[ninja_form id=9]') . '</p>';
					}
					if (strpos($pageUrl, 'wedding-dj') !== false) {
						echo '<p class="wedding-subtitle">' . do_shortcode('[ninja_form id=10]') . '</p>';
					}
					if (strpos($pageUrl, 'wedding-dancer') !== false) {
						echo '<p class="wedding-subtitle">' . do_shortcode('[ninja_form id=11]') . '</p>';
					}
					if (strpos($pageUrl, 'wedding-instrumentalist') !== false) {
						echo '<p class="wedding-subtitle">' . do_shortcode('[ninja_form id=12]') . '</p>';
					}
					if (strpos($pageUrl, 'wedding-singer') !== false) {
						echo '<p class="wedding-subtitle">' . do_shortcode('[ninja_form id=13]') . '</p>';
					}
					
				echo '</div>';
				
				/*
				echo '<div class="row">';
				$video1Field = get_field('banner_youtube_video_1');
				if(!IsNullOrEmptyString($video1Field)) {
					$videos1 = explode("|||", $video1Field);
					echo '<div class="column">';
						echo '<div class="card">';
							echo '<div class="videoWrapper">';
								echo do_shortcode('[lyte id="' . $videos1[0] . '" /]');
							echo '</div>';
							echo '<div class="container">';
								echo '<p>' . $videos1[1] . '</p> ';
								echo '<a href="/' . $videos1[3] . '" target="_blank" class="link_button">' . $videos1[2] . '</a>';
							echo '</div>';
						echo '</div>';		
					echo '</div>';
				}
				$video2Field = get_field('banner_youtube_video_2');
				if(!IsNullOrEmptyString($video2Field)) {
					$videos2 = explode("|||", $video2Field);
					echo '<div class="column">';
						echo '<div class="card">';
							echo '<div class="videoWrapper">';
								echo do_shortcode('[lyte id="' . $videos2[0] . '" /]');
							echo '</div>';
							echo '<div class="container">';
								echo '<p>' . $videos2[1] . '</p> ';
								echo '<a href="/' . $videos2[3] . '" target="_blank" class="link_button">' . $videos2[2] . '</a>';
							echo '</div>';
						echo '</div>';		
					echo '</div>';
				}
				echo '</div>';
				echo '<div class="row">';
				$video3Field = get_field('banner_youtube_video_3');
				if(!IsNullOrEmptyString($video3Field)) {
					$videos3 = explode("|||", $video3Field);
					echo '<div class="column">';
						echo '<div class="card">';
							echo '<div class="videoWrapper">';
								echo do_shortcode('[lyte id="' . $videos3[0] . '" /]');
							echo '</div>';
							echo '<div class="container">';
								echo '<p>' . $videos3[1] . '</p> ';
								echo '<a href="/' . $videos3[3] . '" target="_blank" class="link_button">' . $videos3[2] . '</a>';
							echo '</div>';
						echo '</div>';		
					echo '</div>';
				}
				$video4Field = get_field('banner_youtube_video_4');
				if(!IsNullOrEmptyString($video4Field)) {
					$videos4 = explode("|||", $video4Field);
					echo '<div class="column">';
						echo '<div class="card">';
							echo '<div class="videoWrapper">';
								echo do_shortcode('[lyte id="' . $videos4[0] . '" /]');
							echo '</div>';
							echo '<div class="container">';
								echo '<p>' . $videos4[1] . '</p> ';
								echo '<a href="/' . $videos4[3] . '" target="_blank" class="link_button">' . $videos4[2] . '</a>';
							echo '</div>';
						echo '</div>';		
					echo '</div>';
				}
				echo '</div>';
				

			echo '</div><br/><br/>';
			echo '<div class="black-strip">
				<p class="wedding-subtitle white">4 YEARS OF EXPERIENCE IN</p>
				<p class="wedding-subtitle pink">ARTIST BOOKING</p>
				<p class="wedding-subtitle white">We have the know-how you need.</p>
			</div>';
			*/
		endwhile;
	}
}

// inserts PYR form on the bottom of every category,archive, browse and product pages
add_action( 'woocommerce_after_main_content', 'woo_after_main_content', 15 );
function woo_after_main_content() {
	
	global $wp;
	$pageUrl = $wp->request;
	if (strpos($pageUrl, 'book-online') !== false) {
		$args = array(
			'post_type' => 'weddingtagpages',
			'meta_query' => array(
				array(
					'key'     => 'tag_url_slug',
					'value'   => explode("/", $pageUrl)[1]
				)
			)
		);
			$obituary_query = new WP_Query($args);
	
		while ($obituary_query->have_posts()) : $obituary_query->the_post();
		if (strpos($pageUrl, 'book-online/wedding') !== false) {
		echo '
	<div>
		<h2 class="wedding-title">Unique Wedding Entertainment Acts</h2>
		<p class="wedding-subtitle">
			Wow your Guests at your Wedding with these Splendid Acts. Each of these Acts has the ability to spell-bound your Guests. Book these Acts to make your Wedding the "Talk of The Town".
		</p>
	</div>	
	<br/>
	<div class="row unique-acts">
		<div class="column column-nopadding">
			<div class="row">
				<div class="columnq columnq-color ">
					<div class="videoWrapper2">';
						echo do_shortcode('[lyte id="rZJWGTuhZcM" /]');
					echo '
					</div>
				</div>
				<div class="columnq columnq-data columnq-color ">
					<h2>Flute Mermaid</h2>
					<p>Have a soothing and blissful night with beautiful mermaid playing flute.</p>
					<a href="/book-wedding/?category=flute-mermaid" target="_blank" class="link_button">Book Now</a>
				</div>
			</div>
		</div>
		<div class="column column-nopadding">
			<div class="row">
				<div class="columnq columnq-color ">
					<div class="videoWrapper2">'; 
						echo do_shortcode('[lyte id="jNrT6m-Gr6s" /]');
					echo '
					</div>
				</div>
				<div class="columnq columnq-color columnq-data">
					<h2>Martini Girl</h2>
					<p>Get the pleasure of having the gorgeous burlesque dancer performing subtle movements in a glass to mesmerise guests.</p>
					<a href="/book-wedding/?category=martini-girl" target="_blank" class="link_button">Book Now</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row unique-acts">
		<div class="column column-nopadding">
			<div class="row">
				<div class="columnq columnq-data columnq-color ">
					<h2>Champagne Chandelier</h2>
					<p>Enjoy the unique and entertainment Aerial Act with an added beauty of Chandelier.</p>
					<a href="/book-wedding/?category=champagne-chandelier" target="_blank" class="link_button">Book Now</a>
				</div>
				<div class="columnq columnq-color ">
					<div class="videoWrapper2">';
						echo do_shortcode('[lyte id="pxBFeDiMZEo" /]');
					echo '
					</div>
				</div>
			</div>
		</div>
		<div class="column column-nopadding">
			<div class="row">
				<div class="columnq columnq-color columnq-data">
					<h2>Intl. Symphony Bands</h2>
					<p>Feel the vibes of 80’s with some smarter and more advanced musicians.</p>
					<a href="/book-wedding/?category=symphony-band" target="_blank" class="link_button">Book Now</a>
				</div>
				<div class="columnq columnq-color ">
					<div class="videoWrapper2">';
						echo do_shortcode('[lyte id="bDeV-_nNNF0" /]');
					echo '
					</div>
				</div>
			</div>
		</div>
	</div>
	<br/><br/>';
		}
		
		// Testimonials
			echo '
	<div>
		<h2 class="wedding-title">What Clients Say About Us</h2>
		<p class="wedding-subtitle">
			We are thankful to all our esteemed Clients, who gave us the opportunity to serve them
		</p>
	</div>

	<div class="row testimonials">
		<div class="column-quarter">
			<div class="card">
			  <img src="https://i.imgur.com/wm2YIMz.png" alt="Avatar" style="width:100px">
			  <div class="container">
			    <h4><b>Riaz Sheryari</b></h4> 
			    <p>“I contacted StarClinch for our event in Pattaya and almost immediately got a mail response and a call back for my query. From then on, everything was smooth as silk. Look forward to working with StarClinch soon.”</p> 
			  </div>
			</div>
		</div>
		<div class="column-quarter">
			<div class="card">
			  <img src="https://i.imgur.com/hJ0XnqF.png" alt="Avatar" style="width:100px">
			  <div class="container">
			    <h4><b>Sarthak Jain</b></h4> 
			    <p>“Had a great experience with Starclinch. The team is very supportive and helped with one of our events end to end. Looking forward to work with them in the near future. Best of luck!”</p> 
			  </div>
			</div>
		</div>
		<div class="column-quarter">
			<div class="card">
			  <img src="https://i.imgur.com/qkTatYp.png" alt="Avatar" style="width:100px">
			  <div class="container">
			    <h4><b>Sheena Thukral</b></h4> 
			    <p>“It was a really wonderful opportunity given by StarClinch. We really liked the service. Would like to have more business deals for future. Thank-you!”</p> 
			  </div>
			</div>
		</div>
		<div class="column-quarter">
			<div class="card">
			  <img src="https://i.imgur.com/hZKABU3.png" alt="Avatar" style="width:100px">
			  <div class="container">
			    <h4><b>Jyotika Jogi</b></h4> 
			    <p>“Had a wonderful experience interacting with the StarClinch team. Very professional. We had a great evening with Aviral Malay and his melodies which made the party great fun. The guests loved it.”</p> 
			  </div>
			</div>
		</div>
	</div>
		
<div class=container-fluid>
	<div class="row d-flex">
	<div class="col-sm">
		 ' . get_field(content_block) . ' 
	</div>
	</div>
</div>

	<div class="wedding-milestone">
		<div>
			<h2 class="wedding-title wedding-text-white">Our Milestones</h2>
			<p class="wedding-subtitle wedding-text-white"></p>
		</div>
		<div class="row">
			<div class="column-third">
				<div class="card">
				  <img src="https://i.imgur.com/yqLwjAn.png" alt="Avatar" style="width:150px">
				  <div class="container">
				    <h4><b>17,256</b></h4> 
				    <p>ARTISTS ON BOARD</p> 
				  </div>
				</div>
			</div>
			<div class="column-third">
				<div class="card">
				  <img src="https://i.imgur.com/yfrhthN.png" alt="Avatar" style="width:150px">
				  <div class="container">
				    <h4><b>7,126</b></h4> 
				    <p>GIGS SO FAR</p> 
				  </div>
				</div>
			</div>
			<div class="column-third">
				<div class="card">
				  <img src="https://i.imgur.com/zLBCr08.png" alt="Avatar" style="width:150px">
				  <div class="container">
				    <h4><b>₹ 7,15,59,688</b></h4> 
				    <p>ARTIST EARNING</p> 
				  </div>
				</div>
			</div>
		</div>
	</div>';
		endwhile;
	}
	else {
		echo '<div style="text-align:center;padding-left:10%;padding-right:10%;">';
		echo '<br/><h4>Did not find what you were looking for?<br/>Post your requirement here!<h4>';
		echo '<div class="pyrontop">';
		echo do_shortcode( '[ninja_form id=5]' );	
		echo '</div>';
		echo '</div>';
	}
}

add_action('woocommerce_thankyou', 'woo_thank_you_custom', 10, 1);


function woo_thank_you_custom($order_id) { //<--check this line
	session_start();
	$order = wc_get_order($order_id);
	$orderusername = $order->get_billing_first_name();
	$orderemail = $order->get_billing_email();
	$orderphone = $order->get_billing_phone();
	$mess='';
	
	
		debug_to_console($_SESSION['otp']); 
		debug_to_console($_SESSION['otp_order_id']); 
		debug_to_console($order_id); 
	
	
	
	if(!isset($_SESSION['otp']) || 
		!isset($_SESSION['otp_order_id']) || 
			 (isset($_SESSION['otp_order_id']) && $_SESSION['otp_order_id'] != $order_id )){
		
		unset ($_SESSION["otp"]);
		unset ($_SESSION["otp_order_id"]);
		
		debug_to_console("I am called before!"); 
		$_SESSION['otp']=rand(100000, 999999);
		$_SESSION['otp_order_id'] = $order_id;  
		
		
		debug_to_console($_SESSION['otp']); 
		debug_to_console($_SESSION['otp_order_id']); 
		debug_to_console($order_id); 
		
		

		$mess="Dear $orderusername, Your OTP for verifying your query on StarClinch is ".$_SESSION['otp']." . Kindly verify to confirm your identity.";
		file_get_contents("http://msg.mtalkz.com/V2/http-api.php?apikey=tDwuSCs7VMnugioA&senderid=STARCL&number=$orderphone&message=".str_replace(' ', '%20', $mess)."&format=json");
		echo "<div style='text-align:center';>
		  <h4>Please enter the OTP below - </h4>
		  <form method=post>
		    <input name=otp-value type=number required/><br><br>
		    <input type=submit value='Submit otp' />
		  </form>
		  <br>
		  <form method=post>
		  	<input type=hidden name='resend-otp' value=0>
		  	<input type='submit' value='resend otp' />
		  </form>
		</div>";
	}
	elseif (isset($_POST['resend-otp'])) {
		$mess="Dear $orderusername, Your OTP for verifying your query on StarClinch is ".$_SESSION['otp']." . Kindly verify to confirm your identity.";
		file_get_contents("http://msg.mtalkz.com/V2/http-api.php?apikey=tDwuSCs7VMnugioA&senderid=STARCL&number=$orderphone&message=".str_replace(' ', '%20', $mess)."&format=json");
		echo "<div style='text-align:center';>
		  <h4>OTP has been resent<br>Please enter the OTP below</h4>
		  <form method=post>
		    <input name=otp-value type=number required/><br><br>
		    <input type=submit value='Submit otp' />
		  </form>
		  <br>
		  <form method=post>
		  	<input type=hidden name='resend-otp' value=0>
		  	<input type='submit' value='resend otp' />
		  </form>
		</div>";	
	}
	elseif (isset($_POST['otp-value'])) {
		if($_SESSION['otp']==$_POST['otp-value']){
			$url = 'https://hook.integromat.com/kqqnz5q25cw2dis0aibq6bfu7ly259ip';
			$options = array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query(array('email' => $orderemail, 'phone' => $orderphone, 'name' => $orderusername))
				)
			);
			$context  = stream_context_create($options);
			file_get_contents($url, false, $context);
		    $orderstat = $order->get_status();
		    $view_order_url = $order->get_view_order_url();   

		    foreach ($order->get_items() as $item_id => $item) {
		        $product = $item->get_product();
		        $product_id = null;
		        if (is_object($product)) {
		            $product_id = $product->get_id();
		            $product_name = $product->get_title();
		            $url = get_permalink( $product_id );
		            $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
		            
		            echo '<div style="text-align:center">';
		            echo '<a style="font-size: 1.3em;" href="' . $url . '"> 
		            		<img src="' . $image[0] . '" style="width:200px;">
		            		<p>' . $product_name . '</p>
		            	 </a>';
		            echo '</div>';
		        }
		    }

		    echo '<div style="text-align:center">';
		    // echo $orderusername;
		    // echo $orderemail;
		    // echo $orderphone;
			// echo $view_order_url;

		    if (($orderstat == 'completed')) {
		        echo "<h2>Your request has been completed.</h2>";
		    } 
		    elseif (($orderstat == 'processing')) {
		        echo "<h2>Your request has been received.</h2>";
		    } 
		    elseif (($orderstat == 'pending')) {
		        echo "<h2>Your request has been received.</h2>";
		    }

		    // echo "<h2>Subscribe to push notification updates on your request.</h2><br/>";
		    // echo '<button onclick="window._izq = window._izq||[]; window._izq.push([\'triggerPrompt\']);">Subscribe</button>';
		    // echo '<button onclick=\'window._izq.push(["updateSubscription","subscribe"]);\'>Subscribe</button>';
			// echo '<button onclick=\'window._izq.push(["updateSubscription","unsubscribe"]);\'>Unsubscribe</button>';

		    echo '<br/><br/><p>If you dont hear from us within 12 hours, contact us on the email or phone number mentioned at the bottom of this page.</p> <br>';
echo '<a href="https://starclinch.com/browse"><button>Continue Shopping</button></a>';
		    echo '</div>';
			debug_to_console("this did happen"); 
			unset ($_SESSION["otp"]);
			unset ($_SESSION["otp_order_id"]);
		}
		else
			echo "<div style='text-align:center';>
		  <h4>Wrong OTP entered<br>Please enter the correct OTP</h4>
		  <form method=post>
		    <input name=otp-value type=number required/><br><br>
		    <input type=submit value='Submit otp' />
		  </form>
		  <br>
		  <form method=post>
		  	<input type=hidden name='resend-otp' value=0>
		  	<input type='submit' value='resend otp' />
		  </form>
		</div>";
	}
	else
		echo "<div style='text-align:center';>
		  <h4>Please enter the OTP below:</h4>
		  <form method=post>
		    <input name=otp-value type=number required/><br><br>
		    <input type=submit value='Submit otp' />
		  </form>
		  <br>
		  <form method=post>
		  	<input type=hidden name='resend-otp' value=0>
		  	<input type='submit' value='resend otp' />
		  </form>
		</div>";
}


add_action('signup_integromat', 'signup_integromat');
function signup_integromat($data){
	$url = 'https://hook.integromat.com/9d8y1he9l063hjkd4tillq5fog7j2ctb';
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
}

add_action('bid_integromat', 'bid_integromat');
function bid_integromat($data){
	$url = 'https://hook.integromat.com/6gxa5ic3kezj8fqsv4xyozc6t9jrbwdi';
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
}

add_action('qualify_integromat', 'qualify_integromat');
function qualify_integromat($data){
	$url = 'https://hook.integromat.com/vymwppu4hpjn51coe1sqiagzp33w5i91';
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
}

// Farukh  its change the label of Sidebar

add_filter( 'woocommerce_register_post_type_product', 'custom_post_type_label_woo' );

function custom_post_type_label_woo( $args ){

	global $current_user;
	
	$labels = array(
        'name'               => __( 'Artists', 'your-custom-plugin' ),
        'singular_name'      => __( 'Artist', 'your-custom-plugin' ),
        'menu_name'          => _x( 'Artists', 'Admin menu name', 'your-custom-plugin' ),
      
    );

    $args['labels'] = $labels;
    $args['description'] = __( 'This is where you can add new tours to your store.', 'your-custom-plugin' );
    return $args;
}


add_action( 'after_setup_theme', 'yourtheme_setup' );
 
function yourtheme_setup() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}


// Add filter
add_filter( 'woocommerce_placeholder_img_src', 'starclinch_custom_woocommerce_placeholder', 10 );
/**
 * Function to return new placeholder image URL.
 */
function starclinch_custom_woocommerce_placeholder( $image_url ) {
  $image_url = 'https://starclinch.com/wp-content/uploads/2019/03/Starclinch-Logo_450x450.png';  // change this to the URL to your custom placeholder
  return $image_url;
}





function itsme_disable_feed() {
 wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);



remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

//Farukh Code

//* Adding DNS Prefetching
function ism_dns_prefetch() {
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">
<link rel="dns-prefetch" href="//fullstory.com" />
<link rel="dns-prefetch" href="//rs.fullstory.com" />
<link rel="dns-prefetch" href="//js.intercomcdn.com" />
<link rel="dns-prefetch" href="//api-iam.intercom.io" />
<link rel="dns-prefetch" href="//cdn.useproof.com" />
<link rel="dns-prefetch" href="//api.useproof.com" />
<link rel="dns-prefetch" href="//www.gstatic.com" />
<link rel="dns-prefetch" href="//fonts.gstatic.com" />
<link rel="dns-prefetch" href="//px.ads.linkedin.com" />
<link rel="dns-prefetch" href="//www.linkedin.com" />
<link rel="dns-prefetch" href="//nexus-websocket-a.intercom.io" />
<link rel="dns-prefetch" href="//nexus-websocket-b.intercom.io" />
<link rel="dns-prefetch" href="//widget.intercom.io" />
<link rel="dns-prefetch" href="//fonts.googleapis.com" />
<link rel="dns-prefetch" href="//widget.privy.com" />
<link rel="dns-prefetch" href="//assets.privy.com" />
<link rel="dns-prefetch" href="//api.privy.com" />
<link rel="dns-prefetch" href="//events.privy.com" />
<link rel="dns-prefetch" href="//tri.privy.com" />
<link rel="dns-prefetch" href="//privymktg.com" />
<link rel="dns-prefetch" href="//snap.licdn.com" />
<link rel="dns-prefetch" href="//platform-api.sharethis.com" />
<link rel="dns-prefetch" href="//c.sharethis.mgr.consensu.org" />
<link rel="dns-prefetch" href="//l.sharethis.com" />
<link rel="dns-prefetch" href="//proof-2.firebaseio.com" />
<link rel="dns-prefetch" href="//proof-3.firebaseio.com" />
<link rel="dns-prefetch" href="//proof-2.firebaseio.com" />
<link rel="dns-prefetch" href="//proof-3.firebaseio.com" />
<link rel="dns-prefetch" href="//www.googletagmanager.com" />
';
	
}
add_action('wp_head', 'ism_dns_prefetch', 0);






// validation for Billing Phone checkout field
add_action('woocommerce_checkout_process', 'custom_validate_billing_phone');
function custom_validate_billing_phone() {
    
		$is_correct = preg_match('/^[6-9][0-9]{9}$/', $_POST['billing_phone']) && (strlen($_POST['billing_phone'])==10);
		if ( $_POST['billing_phone'] && !$is_correct) {
			wc_add_notice( __( 'Incorrect <strong>Mobile Numbe</strong>r! Please enter a valid <strong>10 digit Indian</strong> mobile number' ), 'error' );
		}
	
}


function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

// add_action( 'woocommerce_before_checkout_billing_form', function() {
// 	echo '<a id="gtq-btn1" href="https://starclinch.com/browse"><button>Continue Shopping</button></a> <br>';
// });

?>
