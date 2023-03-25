    <section class="o-section c-section--article c-section--article--list">
      <div class="o-section__wrapper">
        <div class="c-article-section">
          <div class="c-article__col c-article-section__articles">
						<?php
						global $selected_feature_post_ids;

						$post__not_in = '';
						if (!empty($selected_feature_post_ids)) {
							$post__not_in = implode(',', $selected_feature_post_ids);
						}

						echo do_shortcode('[ajax_load_more id="homepage_posts" post_type="post" category__not_in="85,86,87,88" post__not_in="' . $post__not_in . '" posts_per_page="' . get_sub_field('number_of_articles') . '" loading_style="white" scroll="false" button_loading_label="Loading ..." container_type="div"]')
						?>
          </div>
          <div class="c-article__col c-article-section__widgets">
            <!-- <div class="c-section__sticky"> -->
            <?php
            $featured_analysis_override = true;
            if( have_rows( 'content_sidebar' ) ):
              // loop through the rows of data
              while ( have_rows( 'content_sidebar' ) ) : the_row();?>
                 <?php if ( get_row_layout() == 'advertisements' ) :?>

                  <div class="c-adv__300">

                 <?php
                    $cta = get_sub_field('cta');
                    $img = get_sub_field('image');
                    if ($cta):
                        $link_url = $cta['url'];
                        $link_title = $cta['title'];
                        $link_target = $cta['target'] ? $cta['target'] : '_self';
                      ?>

                    <a href="<?php echo $link_url;?>" target="<?php echo $link_target; ?>" <?php if($cta['target'] == true):?>rel="nofollow, noopener"<?php endif;?> aria-label="<?php echo $link_title;?>">
                      <?php if($img):?>
                      <img src="<?php echo $img['url'];?>" alt="<?php echo $img['alt'];?>" width="<?php echo $img['width'];?>" height="<?php echo $img['height'];?>" loading="lazy">
                      <?php endif;?>
                    </a>
                    <?php else: ?>
                      <?php if($img):?>
                      <img src="<?php echo $img['url'];?>" alt="<?php echo $img['alt'];?>" width="<?php echo $img['width'];?>" height="<?php echo $img['height'];?>" loading="lazy">
                      <?php endif;?>
                  <?php endif; ?>
                  </div>
                  <?php elseif ( get_row_layout() == 'category' ) : ?>

                    <?php $category_items = get_sub_field('category_item');?>
                    <?php if($category_items):?>
                    <?php
                    if (get_term( $category_items )->slug == 'analysis') {
                      $featured_analysis_override = false;
                    }
                    ?>
                    <div class="c-article-section__title">
                      <?php echo get_term( $category_items )->name; ?>
                      <a href="<?php echo esc_url( get_term_link( $category_items ) ); ?>" class="c-article-section__title-link">
                        more
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.68917 17.5541V13.4012H0.368568V4.39357H7.73457V0.346596L17.5114 8.97032L7.68917 17.5541Z" fill="#F4D35E"/>
                        </svg>
                      </a>
                    </div>
                    <div class="c-article_column-widgets">
                      <?php
                        $args = array(
                          'post_type' => 'post',
                          'posts_per_page' => 2,
                          'orderby' => 'rand',
                          'tax_query' => array(
                            array(
                              'taxonomy' => 'category',
                              'terms' => $category_items,
                            )
                          ),
                        );
                      ?>
                      <?php
                        $cat_query = new WP_Query($args);
                        if ($cat_query->have_posts()):
                          while($cat_query->have_posts()):
                            $cat_query->the_post();
                      ?>
                      <div class="c-article_column-widget">
                        <div class="c-article__widget--photo">
                          <a href="<?php echo get_the_permalink(); ?>" class="c-article__photo--link media media--landscape">
                            <?php echo get_the_post_thumbnail(get_the_ID(), 'side-post'); ?>
                          </a>
                        </div>
                        <div class="c-article__widget--category c-article__category">
                          <?php
                          $terms = get_the_terms(get_the_ID(), 'category');
                          $cat_number = count($terms);
                          foreach ( $terms as $term ) :
                              if($term->parent != 0) :
                            ?>
                              <a href="<?= get_term_link($term); ?>" class="c-link">
                                <?= $term->name; ?>
                              </a>
                            <?php
                              break;
                            endif;
                          endforeach;
                          ?>
                        </div>
                        <h3 class="c-article__widget--title">
                          <a href="<?php echo get_the_permalink(); ?>" class="c-link">
                            <?php echo get_the_title(); ?>
                          </a>
                        </h3>
                      </div>
                      <?php
                      endwhile;
                        endif;
                        wp_reset_postdata();

                      ?>
                      <?php endif;?>
                    </div>
                      <?php elseif ( get_row_layout() == 'featured_analysis' ) : ?>
                      <?php $featured_analysis = get_sub_field('articles');?>
                      <?php if($featured_analysis):?>
                        <?php $featured_analysis_override = false;?>
                        <div class="c-article-section__title">
                          Analysis
                          <a href="<?php echo esc_url( get_term_link( get_term_by('slug', 'analysis', 'category') ) ); ?>" class="c-article-section__title-link">
                            more
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M7.68917 17.5541V13.4012H0.368568V4.39357H7.73457V0.346596L17.5114 8.97032L7.68917 17.5541Z" fill="#F4D35E"/>
                            </svg>
                          </a>
                        </div>
                        <div class="c-article_column-widgets">
                          <?php
                              foreach ($featured_analysis as $featured_post) :
                                $featured_post_main = $featured_post['articles'];
                              if($featured_post_main):
                                $post_ID = $featured_post_main->ID;
                                $post_title = get_the_title( $featured_post_main );
                                $post_permalink = get_permalink( $featured_post_main );
                                $post_category = get_the_category( $featured_post_main );
                                $post_thumbnail = get_the_post_thumbnail( $featured_post_main, 'side-post');
                                $post_excerpt = get_the_excerpt( $featured_post_main );?>
                                <div class="c-article_column-widget">
                                  <div class="c-article__widget--photo">
                                    <a href="<?php echo $post_permalink; ?>" class="c-article__photo--link media media--landscape">
                                      <?php echo $post_thumbnail; ?>
                                    </a>
                                  </div>
                                  <div class="c-article__widget--category c-article__category">
                                    <?php
                                    $terms = get_the_terms($post_ID, 'category');
                                    foreach ( $terms as $term ) :
                                        if($term->parent != 0) :
                                      ?>
                                        <a href="<?= get_term_link($term); ?>" class="c-link">
                                          <?= $term->name; ?>
                                        </a>
                                      <?php
                                        break;
                                      endif;
                                    endforeach;
                                    ?>
                                  </div>
                                  <h3 class="c-article__widget--title">
                                    <a href="<?php echo $post_permalink; ?>" class="c-link">
                                      <?php echo $post_title; ?>
                                    </a>
                                  </h3>
                                </div>
                                <?php
                              endif;
                              endforeach;
                          endif;?>
                        <?php endif;?>


                <?php endwhile;
              else :
                  // no layouts found
              endif;

              if ($featured_analysis_override) {
                $global_analysis_posts = get_field('featured_analysis', 'option');
                if ($global_analysis_posts) { ?>
                  <div class="c-article-section__title">
                    Analysis
                    <a href="<?php echo esc_url( get_term_link( get_term_by('slug', 'analysis', 'category') ) ); ?>" class="c-article-section__title-link">
                      more
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.68917 17.5541V13.4012H0.368568V4.39357H7.73457V0.346596L17.5114 8.97032L7.68917 17.5541Z" fill="#F4D35E"/>
                      </svg>
                    </a>
                  </div>
                  <?php
                  foreach ($global_analysis_posts as $gap_key => $global_analysis_post) {
                    $featured_post_main = $global_analysis_post['article'];
                    if ($featured_post_main) {
                      $post_ID = $featured_post_main->ID;
                      $post_title = get_the_title( $featured_post_main );
                      $post_permalink = get_permalink( $featured_post_main );
                      $post_category = get_the_category( $featured_post_main );
                      $post_thumbnail = get_the_post_thumbnail( $featured_post_main, 'blog-post');
                      $post_excerpt = get_the_excerpt( $featured_post_main ); ?>


                        <div class="c-article_column-widget">
                          <div class="c-article__widget--photo">
                            <a href="<?php echo $post_permalink; ?>" class="c-article__photo--link media media--landscape">
                              <?php echo $post_thumbnail; ?>
                            </a>
                          </div>
                          <div class="c-article__widget--category c-article__category">
                            <?php
                            $terms = get_the_terms($post_ID, 'category');
                            foreach ( $terms as $term ) :
                                if($term->parent != 0) :
                              ?>
                                <a href="<?= get_term_link($term); ?>" class="c-link">
                                  <?= $term->name; ?>
                                </a>
                              <?php
                                break;
                              endif;
                            endforeach;
                            ?>
                          </div>
                          <h3 class="c-article__widget--title">
                            <a href="<?php echo $post_permalink; ?>" class="c-link">
                              <?php echo $post_title; ?>
                            </a>
                          </h3>
                        </div>
                      <?php
                    }
                  }
                }
              }
              ?>
              <!-- </div> -->
            </div>
        </div>
      </div>
    </section>
