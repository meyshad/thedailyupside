<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Daily_Upside
 */

?>

<article id="post-<?php the_ID(); ?>" class="o-section c-section--post">
	<div class="o-section__wrapper c-page">
		<header class="c-post__header">
			<?php the_title( '<h1 class="c-post__title is-page">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="s-content">
			<?php
			the_content();
			?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'daily-upside' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					),
					'<span class="edit-link">',
					'</span>'
				);
				?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
