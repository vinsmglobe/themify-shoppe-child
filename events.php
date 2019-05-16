<?php /* Template Name: Events */ ?>

<?php get_header(); ?>

<?php
/** Themify Default Variables
 *  @var object */
global $themify; ?>

<!-- layout-container -->
<div id="layout" class="pagewidth clearfix">

	<?php themify_content_before(); // hook ?>
	<!-- content -->
	<div id="content" class="clearfix">
    	<?php themify_content_start(); // hook ?>

		<?php
		/////////////////////////////////////////////
		// 404
		/////////////////////////////////////////////
		if ( is_404() ) : ?>
			<h1 class="page-title"><?php _e( '404','themify' ); ?></h1>
			<p><?php _e( 'Page not found.', 'themify' ); ?></p>
			<?php if( current_user_can('administrator') ): ?>
				<p><?php _e( '@admin Learn how to create a <a href="https://themify.me/docs/custom-404" target="_blank">custom 404 page</a>.', 'themify' ); ?></p>
			<?php endif; ?>
		<?php endif; ?>

		<?php
		/////////////////////////////////////////////
		// PAGE
		/////////////////////////////////////////////
		?>
		<?php if ( ! is_404() && have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="page-<?php the_ID(); ?>" class="type-page">

			<!-- page-title -->
			<?php if($themify->page_title != 'yes'): ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
			<?php endif; ?>
			<!-- /page-title -->

				<div class="page-content entry-content">

				<?php if ( $themify->hide_page_image != 'yes' && has_post_thumbnail() ) : ?>
					<figure class="post-image"><?php themify_image( "{$themify->auto_featured_image}w={$themify->image_page_single_width}&h={$themify->image_page_single_height}&ignore=true" ); ?></figure>
				<?php endif; ?>

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:','themify').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

				<?php edit_post_link(__('Edit','themify'), '<span class="edit-button">[', ']</span>'); ?>

				<!-- comments -->
				<?php if(!themify_check('setting-comments_pages') && $themify->query_category == ""): ?>
					<?php comments_template(); ?>
				<?php endif; ?>
				<!-- /comments -->

			</div>
			<!-- /.post-content -->

			<?php
				// Get orders with extra info about the results.
				$args = array(
				    'paginate' => true,
				);
				$results = wc_get_orders( $args );
				foreach ($results->orders as $key => $value) {
					echo $value->get_billing_first_name();
					echo "<br/>";
					echo get_post_meta($value->get_id(), '_billing_event_type', true );
					echo "<br/>";
					echo get_post_meta($value->get_id(), '_billing_event_date', true );
					echo "<br/>";
					echo get_post_meta($value->get_id(), '_billing_event_venue', true );
					echo "<br/>";

			        // foreach ($value->get_items() as $item_id => $item) {
			        //     $product = $item->get_product();
			        //     if (is_object($product)) {
			        //         echo $product->get_title();
			        //         echo "<br/> "
			        //     }
			        // }

			        echo "<br/><br/>";

				}
				echo "<br/><br/>";
				echo $results->total . " bookings found\n";
				echo "<br/>";
				echo 'Page 1 of ' . $results->max_num_pages . "\n";
				$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
				// echo "<br/>";
				// echo 'First order id is: ' . $results->orders[0]->get_id() . "\n";


			?>

			<div class="pagination">
			    <?php
			    $args = array(
			        'base' => '%_%',
			        'format' => '?page=%#%',
			        'total' => $results->max_num_pages,
			        'current' => $paged,
			        'show_all' => False,
			        'end_size' => 5,
			        'mid_size' => 5,
			        'prev_next' => True,
			        'prev_text' => __('&laquo; Previous'),
			        'next_text' => __('Next &raquo;'),
			        'type' => 'plain',
			        'add_args' => False,
			        'add_fragment' => ''
			    );
			    echo paginate_links($args);
			    ?>
			</div>

			</div><!-- /.type-page -->
		<?php endwhile; endif; ?>

		<?php
		/////////////////////////////////////////////
		// Query Category
		/////////////////////////////////////////////
		if( $themify->query_category != '' ) :
			if ( themify_theme_is_product_query() ) :
				themify_get_ecommerce_template( 'includes/query-product', 'page' );
			else :
				// Query posts action based on global $themify options
				do_action( 'themify_custom_query_posts' );

				if( have_posts() ) : ?>

					<!-- loops-wrapper -->
					<div id="loops-wrapper" class="loops-wrapper <?php esc_attr_e(themify_theme_query_classes()); ?>">

						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'includes/loop', $themify->query_post_type ); ?>
						<?php endwhile; ?>

					</div>
					<!-- /loops-wrapper -->

					<?php if ($themify->page_navigation != 'yes'): ?>
						<?php get_template_part( 'includes/pagination'); ?>
					<?php endif; ?>

				<?php endif; ?>

			<?php endif; ?>
		<?php endif; ?>
		<?php themify_content_end(); // hook ?>
	</div>
	<!-- /content -->
    <?php themify_content_after(); // hook ?>

	<?php
	/////////////////////////////////////////////
	// Sidebar
	/////////////////////////////////////////////
	if ($themify->layout != 'sidebar-none'): get_sidebar(); endif; ?>

	

</div>
<!-- /layout-container -->

<?php get_footer(); ?>
