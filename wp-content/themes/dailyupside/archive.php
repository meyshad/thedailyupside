<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Daily_Upside
 */

get_header('');
?>

<?php if ( have_posts() ) : ?>

	<header class="o-section c-section--category-header">
		<div class="o-section__wrapper">
			<?php
			the_archive_title( '<h1 class="c-category__title">', '</h1>' );
			the_archive_description( '<div class="c-category__description">', '</div>' );
			?>
		</div>
	</header><!-- .page-header -->

	<section class="o-section c-section--category-article">
		<div class="o-section__wrapper">
		<?php
			$cat = get_the_category();
			$lastpost = array(
				'category__in'	=> $cat[0]->term_id,
				'showposts'   	=> 1,
			);

			$posts_already_shown = [];
			$lastposts = new WP_Query($lastpost);
			if( $lastposts->have_posts() ) {
				while ($lastposts->have_posts()) : $lastposts->the_post();
					$posts_already_shown[] = get_the_ID(); ?>
			<div class="c-category-article">
				<div class="c-category-article__col">
					<div class="c-category-article__content">
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
						<div class="c-article__text">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</div>
				<div class="c-category-article__col">
					<div class="c-category-article__photo">
						<a href="<?php the_permalink() ?>" class="c-article__photo--link">
						<?php the_post_thumbnail('blog-post', ['loading' => false, 'fetchpriority' => 'high']); ?>
						</a>
					</div>
				</div>
			</div>
			<?php
				endwhile;
				wp_reset_query();
			} ?>
		</div>
	</section>

	<?php $single_adv = get_field('adv_cat', 'option');
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

	<?php $category_widget = get_field('category_pages', 'option');
	if($category_widget):
		$title = $category_widget['title'];
		$desc = $category_widget['description'];
		$shortcode = $category_widget['shortcode'];
	?>
	<section class="o-section c-section--subscribe">
		<div class="o-section__wrapper">
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
		</div>
	</section>
	<?php endif;?>

	<?php
		$global_analysis_posts = get_field('featured_analysis', 'option');

		$analysis_posts = [];
		if ($global_analysis_posts) {
			foreach ($global_analysis_posts as $gap_key => $global_analysis_post) {
				$featured_post_main = $global_analysis_post['article'];
				if ($featured_post_main) {
					$post_title = get_the_title( $featured_post_main );
					$post_permalink = get_permalink( $featured_post_main );
					$post_category = get_the_category( $featured_post_main );
					$post_thumbnail = get_the_post_thumbnail( $featured_post_main, 'blog-post');
					$post_excerpt = get_the_excerpt( $featured_post_main );

					$analysis_posts[] = [
						'title' 	=> $post_title,
						'permalink' => $post_permalink,
						'terms' 	=> $post_category,
						'thumbnail' => $post_thumbnail,
						'excerpt' 	=> $post_excerpt
					];

					$posts_already_shown[] = $featured_post_main->ID;
				}
			}
		} else {
			$relatedpost = array(
				'category__in'	=> array('85','86','88','87'),
				'showposts'   	=> 2
			);
			if (!empty($posts_already_shown)) {
				$posts_already_shown = array_unique($posts_already_shown);
				$relatedpost['post__not_in'] = $posts_already_shown;
			}
			$relatedposts = new WP_Query($relatedpost);
			if( $relatedposts->have_posts() ) {
				while ($relatedposts->have_posts()) { $relatedposts->the_post();
					$terms = get_the_terms(get_the_ID(), 'category');

					$analysis_posts[] = [
						'title' 	=> get_the_title(),
						'permalink' => get_the_permalink(),
						'terms' 	=> $terms,
						'thumbnail' => get_the_post_thumbnail(get_the_ID(), 'side-post'),
						'excerpt' 	=> get_the_excerpt()
					];

					$posts_already_shown[] = get_the_ID();
				}
			wp_reset_query();
		}
		
	}
	?>
	
	<section class="o-section c-section--article c-section--article--list">
		<div class="o-section__wrapper">
			<div class="c-article-section">
				<div class="c-article__col c-article-section__articles">
				<?php
				/* Start the Loop */
				
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$args = array(
					'cat' 			 => get_query_var('cat'),
					'paged' 		 => $paged,
					'post_status'	 => 'publish'
				);

				// offset won't work with paged
				// if ($paged == 1) {
				// 	$args['offset'] = 1;
				// }

				if (!empty($posts_already_shown)) {
					$posts_already_shown = array_unique($posts_already_shown);
					$args['post__not_in'] = $posts_already_shown;
				}

				$loop = new WP_Query( $args );

				$i=0;
				$message_subscribe = get_field('category_page_message', 'options');
				while ( $loop->have_posts() ) :
					if( $i == 5 && $message_subscribe ) {
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
					$loop->the_post();
					$posts_already_shown[] = get_the_ID();
				endwhile;
			wp_reset_query();

	?>

	<section class="o-section c-section--article c-section--article--list">
		<div class="o-section__wrapper">
			<div class="c-article-section">
				<div class="c-article__col c-article-section__articles">

				<?php
				$post__not_in = '';
				if (!empty($posts_already_shown)) {
					$posts_already_shown = array_unique($posts_already_shown);
					$post__not_in = implode(',', $posts_already_shown);
				}

				echo do_shortcode('[ajax_load_more id="archive_posts" archive="true" post__not_in="' . $post__not_in . '" posts_per_page="8" loading_style="white" scroll="false" button_loading_label="Loading ..." container_type="div" vars="is_archive:true;"]');
				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
				</div>
				<div class="c-article__col c-article-section__widgets">
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
							if ($analysis_posts) { ?>
								<?php foreach ($analysis_posts as $ap_key => $analysis_post) { ?>
									<div class="c-article_column-widget">
									<div class="c-article__widget--photo">
										<a href="<?php echo $analysis_post['permalink'] ?>" class="c-article__photo--link media media--landscape">
											<?php echo $analysis_post['thumbnail']; ?>
										</a>
										</div>
									<div class="c-article__widget--category c-article__category">
										<?php
										foreach ( $analysis_post['terms'] as $term ) :
											if($term->parent != 0) :
											?>
											<a href="<?php echo get_term_link($term); ?>" class="c-link">
																	<?php echo $term->name; ?>
																</a>
											<?php
											break;
											endif;
										endforeach;
										?>
									</div>
									<h3 class="c-article__widget--title">
										<a href="<?php echo $analysis_post['permalink'] ?>" class="c-link">
											<?php echo $analysis_post['title']; ?>
										</a>
									</h3>

								</div>

								<?php } ?>
							<?php } ?>
						</div>
					 </div>
				</div>
			</div>
		</div>
	</section>

<?php
get_footer();
