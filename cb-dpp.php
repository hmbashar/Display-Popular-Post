<?php 

/*
Plugin Name: Display Popular Post
Plugin URI: https://codingbank.com/plugins/cb-display-popular-post
Author: Md Abul Bashar
Author URI: https://www.codingbank.com
Version: 1.0
Description: Display popular post using shortcode ['cb-dp-post']

*/


//define url
define('CB_DISPLAY_POPULAR_POST_URL', plugin_dir_url( __FILE__ ));




// Enqueue style for the plugin
function cb_display_popular_post_script() {

	wp_enqueue_style('cb-display-popular-post-css', CB_DISPLAY_POPULAR_POST_URL.'css/style.css');

}
add_action('after_setup_theme', 'cb_display_popular_post_script');



// Register Shortcode
function cb_display_popular_post($attrs, $content = NULL) {
	ob_start();
	extract(shortcode_atts(array(
		'pcount'		=> 5,
		'count'			=> 20,
	), $attrs));

	if(function_exists('the_views')) :

	?>


	<div class="cb-display-popular-post-area"> 		
		<?php 
		$cb_dppost = new WP_Query(array(
			'post_type'			=> 'post',
			'posts_per_page' 	=> $pcount,
			'meta_key'			=> 'views',
			'orderby'			=> 'meta_value_num',
			'order'				=> 'DESC'
		));
		if($cb_dppost->have_posts()) : while($cb_dppost->have_posts()) : $cb_dppost->the_post();

		?>
			<!-- cb single display popular post start -->
			<div class="cb-single-display-popular-post">
				<div class="cb-display-popular-title">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>
				<div class="cb-display-popular-thumbnil">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				</div>
				<div class="cb-display-popular-content">
					<p><?php echo wp_trim_words( get_the_content(), $count, NULL ); ?> </p>
				</div>
			</div>
			<!-- cb single display popular post End -->
		<?php endwhile; endif; ?>

	</div>



	<?php else : ?>

		<p>Please Install <a href="https://wordpress.org/plugins/wp-postviews/" target="_blank">WP-PostViews</a> for working the plugin</p>

	<?php 

	endif;

	return ob_get_clean();

}

add_shortcode('cb-dp-post', 'cb_display_popular_post');