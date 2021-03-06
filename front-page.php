<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 2.2.0
 */
get_header(); ?>

	<main id="content" class="<?php echo odin_classes_page_full(); ?>" tabindex="-1" role="main">
		<div class="desc">
			<h1><?php echo bloginfo( 'title' ); ?></h1>
			<?php if ( $desc = get_theme_mod( 'desc' ) ): ?>
				<span><?php echo apply_filters( 'the_content', $desc ); ?></span>
			<?php endif; ?>
		</div><!-- desc -->
	</main><!-- #content -->
</div><!-- .container -->

<?php if ( $embed = get_theme_mod( 'embed_map' ) ): ?>
	<embed class="embed-mapa" src="<?php echo esc_url( $embed ); ?>">
<?php endif; ?>

<?php if ( $slider = get_theme_mod( 'slider' ) ): ?>
	<div class="slider col-sm-12 nopadding">

		<?php echo do_shortcode( html_entity_decode( $slider ) ); ?>
	</div><!-- slider -->
<?php endif; ?>

<div class="container">
	<div class="col-sm-12 loop-acervo">
		<h1><?php _e( 'Acervo Digital', 'odin' ); ?></h1>

		<?php
		// WP_Site_Query arguments
		$args = array (
			'order'             => 'DESC',
			'orderby'           => diadograffiti_get_site_query_order(),
		);

		// The Site Query
		$site_query = new WP_Site_Query( $args );

		// The Loop
		if ( $site_query ) :
			$current_site_id = get_current_blog_id();
			foreach ( $site_query->get_sites() as $site ) :
				if ( $site->blog_id == $current_site_id ) {
					continue;
				}
				switch_to_blog( $site->blog_id );
				$desc = diadograffiti_get_site_title_by_url( get_home_url() );
				$image = get_theme_mod( 'home_site_image_mu', false );
				if ( ! $image ) {
					continue;
				}
				?>
				<a href="<?php echo esc_url( get_home_url() ); ?>">
					<div class="col-sm-3 nopadding thumb">
						<div class="desc">
							<?php echo apply_filters( 'the_content', $desc ); ?>
						</div><!-- desc -->
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php get_bloginfo( 'name' ); ?>">
					</div><!-- thumb -->
				</a>
			<?php endforeach; switch_to_blog( $current_site_id );
		endif;
		?>
	</div><!-- loop-acervo -->

<?php
get_footer();
