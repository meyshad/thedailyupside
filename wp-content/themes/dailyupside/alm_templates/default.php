<?php if (isset($args['alm_vars']['is_archive'])): ?>
<?php
	if( $alm_current == 5 ) {
		$message_subscribe = get_field('category_page_message', 'options');
		if ($message_subscribe) {
			$message = esc_attr( $message_subscribe['message'] );
			$cta_url = esc_url( $message_subscribe['cta']['url'] );
			$cta_title = esc_html( $message_subscribe['cta']['title'] );
			echo '
						<div class="c-article__column">
							<div class="c-article-subscribe">
								<div class="c-article-subscribe__text">
									'. $message .'
								</div>
								<a href="'. $cta_url .'" class="c-btn">
									'. $cta_title .'
								</a>
							</div>
						</div>
						';
		}
	}

	/*
	* Include the Post-Type-specific template for the content.
	* If you want to override this in a child theme, then include a file
	* called content-___.php (where ___ is the Post Type name) and that will be used instead.
	*/
	get_template_part( 'template-parts/content', 'archive' );
?>
	<?php else: ?>
<div class="c-article__column">
	<div class="c-article__category">
		<a href="<?php $cat = get_the_category();
		echo esc_url(get_category_link($cat[0]->term_id)); ?>" class="c-link">
			<?php $cat = get_the_category();
			echo $cat[0]->name; ?>
		</a>
	</div>
	<h2 class="c-article__title">
		<a href="<?php the_permalink() ?>" class="c-link">
			<?php the_title(); ?>
		</a>
	</h2>
	<div class="c-article__photo">
		<a href="<?php the_permalink() ?>" class="c-article__photo--link media media--landscape">
			<?php the_post_thumbnail('blog-post'); ?>
		</a>
	</div>
	<div class="c-article__text">
		<?php the_excerpt(); ?>
	</div>
	<div class="c-article__column--more">
		<a href="<?php the_permalink() ?>" class="c-article__link">
			Read More
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6.83534 15.297V11.6489H0.404694V3.73632H6.87523V0.181335L15.4635 7.75668L6.83534 15.297Z"
							fill="#F4D35E"/>
			</svg>
		</a>
	</div>
</div>
<?php endif; ?>
