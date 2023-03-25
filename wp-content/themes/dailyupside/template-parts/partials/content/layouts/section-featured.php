    <?php
      $featured_post = get_sub_field('featured_articles');
      if($featured_post):
      ?>
    <section class="o-section c-section--featured">
      <div class="o-section__wrapper">
        <div class="c-article-section">

          <?php $counter = 0; foreach($featured_post as $post_item):
          $featured_post_main = $post_item['featured_article'];
          if($featured_post_main):
            $post_title = get_the_title( $featured_post_main );
            $post_permalink = get_permalink( $featured_post_main );
            $post_category = get_the_category( $featured_post_main );
            $post_thumbnail = get_the_post_thumbnail( $featured_post_main, 'blog-post');
            $excerpt = get_field('home_excerpt', $featured_post_main);
            $post_excerpt = get_the_excerpt( $featured_post_main );
            $post_excerpt = empty($excerpt) ? $post_excerpt : $excerpt;
            ?>
            <?php if($counter == 0):?>
              <div class="c-article__col c-article-section__articles">
                <div class="c-article__column">
                  <div class="c-article__category">
                    <a href="<?php echo esc_url( get_category_link( $post_category[0]->term_id ) ); ?>" class="c-link">
                      <?php echo $post_category[0]->name; ?>
                    </a>
                  </div>
                  <h2 class="c-article__title">
                    <a href="<?php echo $post_permalink; ?>" class="c-link">
                      <?php echo $post_title; ?>
                    </a>
                  </h2>
                  <div class="c-article__photo">
                    <a href="<?php echo $post_permalink; ?>" class="c-article__photo--link media media--landscape">
                      <?php echo $post_thumbnail; ?>
                    </a>
                  </div>
                  <div class="c-article__text">
                    <?php echo $post_excerpt; ?>
                  </div>
                  <div class="c-article__column--more">
                    <a href="<?php echo $post_permalink; ?>" class="c-article__link">
                      Read More
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.83534 15.297V11.6489H0.404694V3.73632H6.87523V0.181335L15.4635 7.75668L6.83534 15.297Z" fill="#F4D35E"/>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            <?php endif;?>
            <?php if($counter == 1):?>
              <div class="c-article__col c-article-section__widgets">
                <!-- <div class="c-section__sticky"> -->
                  <div class="c-article_column-widget">
                    <div class="c-article__widget--photo">
                      <a href="<?php echo $post_permalink; ?>" class="c-article__photo--link media media--landscape">
                        <?php echo $post_thumbnail; ?>
                      </a>
                    </div>
                    <div class="c-article__widget--category c-article__category">
                      <a href="<?php echo esc_url( get_category_link( $post_category[0]->term_id ) ); ?>" class="c-link">
                        <?php echo $post_category[0]->name; ?>
                      </a>
                    </div>
                    <h3 class="c-article__widget--title">
                      <a href="<?php echo $post_permalink; ?>" class="c-link">
                        <?php echo $post_title; ?>
                      </a>
                    </h3>
                  </div>
                <?php endif;?>
                <?php if($counter == 2):?>
                  <div class="c-article_column-widget">
                    <div class="c-article__widget--photo">
                      <a href="<?php echo $post_permalink; ?>" class="c-article__photo--link media media--landscape">
                        <?php echo $post_thumbnail; ?>
                      </a>
                    </div>
                    <div class="c-article__widget--category c-article__category">
                      <a href="<?php echo esc_url( get_category_link( $post_category[0]->term_id ) ); ?>" class="c-link">
                        <?php echo $post_category[0]->name; ?>
                      </a>
                    </div>
                    <h3 class="c-article__widget--title">
                      <a href="<?php echo $post_permalink; ?>" class="c-link">
                        <?php echo $post_title; ?>
                      </a>
                    </h3>
                  </div>
                <!-- </div> -->
              </div>
            <?php endif;?>
          <?php endif;?>
          <?php $counter++; endforeach;?>
        </div>
      </div>
    </section>
    <?php endif;?>
