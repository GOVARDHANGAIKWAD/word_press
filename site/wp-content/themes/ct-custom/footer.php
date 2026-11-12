<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CT_Custom
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="ct-container site-footer-inner">
			<div class="site-info">
				<p class="ct-footer-copyright">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'ct-custom' ); ?>
				</p>
			</div><!-- .site-info -->
		</div><!-- .ct-container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
