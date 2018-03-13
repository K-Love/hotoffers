<?php
/**
 * The template for displaying single products
 *
 * @package GiveMeStuff
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="single-product-bg">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'singleproduct' );

			// the_post_navigation();
			?>

			</div><!-- END single product bg -->

			<div class="row">
				<div class="column">

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>
		</div><!-- END column -->
		<?php endwhile; ?>
		</div><!-- END row -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar('singleproductaside');
get_footer();
