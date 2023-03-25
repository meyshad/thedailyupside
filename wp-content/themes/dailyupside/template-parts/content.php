<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Daily_Upside
 */

 // Custom class
$class = ( isset( $args['class'] ) ) ? $args['class'] : '' ;
?>

<article id="post-<?php the_ID(); ?>" class="o-section c-section--post <?php echo $class; ?>">
	<div class="o-section__wrapper">
		<header class="c-post__header">
			<div class="c-article__category">
				<a href="<?php $cat = get_the_category(); echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>" class="c-link">
					<?php $cat = get_the_category(); echo $cat[0]->cat_name; ?>
				</a>
            </div>
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="c-post__title">', '</h1>' );
			else :
				the_title( '<h2 class="c-post__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
			<div class="c-post__description">
				<?php
					daily_upside_description();
				?>
			</div>

			<div class="c-post__details">
				<div class="c-post__details-col">
					<div class="c-details__title">
						<?php
							daily_upside_posted_by();
							daily_upside_posted_on();
						?>
					</div>
				</div>
				<div class="c-post__details-col">
					<?php
						// Share
						include get_template_directory() . '/template-parts/partials/share.php';
					?>
				</div>
			</div>
			<?php endif; ?>
		</header>
	</div>

	<?php daily_upside_post_thumbnail(); ?>

		<?php $single_adv = get_field('adv_single', 'option');
		if($single_adv):
			$single_img = $single_adv['image'];
			$single_cta = $single_adv['cta'];
		?>
    <section class="o-section c-section--adv">
      <div class="o-section__wrapper">
        <div class="c-adv__768">
					<?php if($single_cta):?>
          <a href="<?php the_sub_field('cta'); ?>" class="c-adv-768__link">
					<?php endif;?>
        	 <?php if($single_img):?>
					<img src="<?php echo $single_img['url']; ?>" alt="<?php echo $single_img['alt']; ?>" width="<?php echo $single_img['width']; ?>"  height="<?php echo $single_img['height']; ?>" loading="lazy" />
					<?php endif;?>
					<?php if($single_cta):?>
          </a>
					<?php endif;?>
        </div>
      </div>
    </section>
		<?php endif;?>

	<section class="o-section c-section--post c-section--post__content">
      <div class="o-section__wrapper">
        <div class="c-post__content">
          <div class="c-content__col c-post-section__content">
			  <div class="c-content-subscribe">
					<div class="c-content-subscribe__text">
						Sign up for insightful business news.
					</div>
					<?php
					$link = get_field('subscribe_link', 'options');
					if ($link):
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						<a class="c-btn" href="<?php echo esc_url($link_url); ?>"
							 target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
					<?php endif; ?>
				</div>

			  <div class="s-content">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'daily-upside' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);
				?>
			  </div>


				<?php $single_widget = get_field('single_pages', 'option');
					if($single_widget):
						$title = $single_widget['title'];
						$desc = $single_widget['description'];
						$shortcode = $single_widget['shortcode'];
					?>
					<div class="c-subscribe-widget">
						<?php if($title):?>
						<h2 class="c-subscribe-widget__title">
							<?php echo $title;?>
						</h2>
						<?php endif;?>
						<?php if($desc):?>
						<div class="c-subscribe-widget__text">
							<?php echo $desc; ?>
						</div>
							<?php endif;?>
						<?php if ($shortcode): ?>
						<div class="c-subscribe-widget__form">
							<?php echo do_shortcode( $shortcode ); ?>
						</div>
						<?php endif; ?>
					</div>
				<?php endif;?>

			  <div class="c-related-posts">
			  <?php
				$the_query = new WP_Query( array( 'posts_per_page' => 3, 'post__not_in' => array($post->ID) ) );
				while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
				<div class="c-article__column">
					<div class="c-article__category">
						<a href="<?php $cat = get_the_category(); echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>" class="c-link">
							<?php $cat = get_the_category(); echo $cat[0]->name; ?>
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
							<path d="M6.83534 15.297V11.6489H0.404694V3.73632H6.87523V0.181335L15.4635 7.75668L6.83534 15.297Z" fill="#F4D35E"/>
						</svg>
						</a>
					</div>
				</div>
				<?php
					endwhile;
					wp_reset_postdata();
				?>
			  </div>
          </div>
          <div class="c-content__col c-article-section__widgets">
			<!-- <div class="c-section__sticky"> -->
				<div class="c-article-section__title">
					Analysis
					<a href="<?php echo home_url() ?>/category/analysis/" class="c-article-section__title-link">
						more
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M7.68917 17.5541V13.4012H0.368568V4.39357H7.73457V0.346596L17.5114 8.97032L7.68917 17.5541Z" fill="#F4D35E"/>
						</svg>
					</a>
				</div>
				<div class="c-article_column-widgets">
				<?php
					$relatedpost = array(
						'category__in'	=> array('85','86','88','87'),
						'showposts'   	=> 2
					);
				$relatedposts = new WP_Query($relatedpost);
				if( $relatedposts->have_posts() ) {
				while ($relatedposts->have_posts()) : $relatedposts->the_post(); ?>
				<div class="c-article_column-widget">
					<div class="c-article__widget--photo">
					<a href="<?php the_permalink() ?>" class="c-article__photo--link media media--landscape">
						<?php the_post_thumbnail('side-post'); ?>
					</a>
					</div>
					<div class="c-article__widget--category c-article__category">
						<a href="<?php $cat = get_the_category(); echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>" class="c-link">
							<?php $cat = get_the_category(); echo $cat[0]->name; ?>
						</a>
					</div>
					<h3 class="c-article__widget--title">
						<a href="<?php the_permalink() ?>" class="c-link">
							<?php the_title(); ?>
						</a>
					</h3>
				</div>
				<?php
					endwhile;
					wp_reset_query();
				} ?>
				</div>
				<div class="c-article-section__title">
				Recent News
				</div>
				<div class="c-article_column-widgets c-recent-news">
				<?php
				$the_query = new WP_Query( array( 'posts_per_page' => 4, 'offset' => 3, 'post__not_in' => array($post->ID) ) );
				while ($the_query -> have_posts()) : $the_query -> the_post();
				?>
				<div class="c-article_column-widget">
					<div class="c-article__widget--category c-article__category">
						<a href="<?php $cat = get_the_category(); echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>" class="c-link">
							<?php $cat = get_the_category(); echo $cat[0]->name; ?>
						</a>
					</div>
					<h3 class="c-article__widget--title">
						<a href="<?php the_permalink() ?>" class="c-link">
							<?php the_title(); ?>
						</a>
					</h3>
					<?php
						daily_upside_posted_on();
					?>
				</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
				</div>
			<!-- </div> -->
          </div>
        </div>
      </div>
    </section>
</article>
