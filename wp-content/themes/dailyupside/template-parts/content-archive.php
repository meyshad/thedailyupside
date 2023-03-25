<?php
/**
 * Template part for displaying archive content in archive.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Daily_Upside
 */

?>
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
