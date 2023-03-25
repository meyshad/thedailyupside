    <section id="hero" class="o-section c-section--hero<?php if( get_field('hide_headerfooter') ) { echo ' c-hero__full-height'; } ?>">
      <div class="o-section__wrapper">
        <div class="c-hero__wrapper">
          <div class="c-hero">
            <h2 class="c-hero__title">
              <?php
                $title_hero = get_sub_field('title_hero');
                if ($title_hero):
                  echo $title_hero;
                endif;
              ?>
              <?php
                $subtitle_hero = get_sub_field('subtitle_hero');
                if ($subtitle_hero):?>
                <strong><?php echo $subtitle_hero; ?></strong>
                <?php endif;?>
            </h2>
            <?php
              $description = get_sub_field('description');
              if ($description) :
            ?>
            <div class="c-hero__text">
              <?php echo $description; ?>
            </div>
            <?php endif; ?>

            <?php
              $subscribe = get_sub_field('subscribe');
              if ($subscribe) :
            ?>
            <div class="c-hero__form">
              <?php echo do_shortcode( $subscribe ); ?>
            </div>
            <?php endif; ?>
          </div>

          <?php 
          $image = get_sub_field('img_hero');
          if($image): 
            $size = 'full';
          ?>
          <div class="c-hero__image">
              <?php echo wp_get_attachment_image( $image, $size, false, ['loading' => false, 'fetchpriority' => 'high'] ); ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>