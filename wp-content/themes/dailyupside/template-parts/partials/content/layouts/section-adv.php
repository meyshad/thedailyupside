    <section class="o-section c-section--adv">
      <div class="o-section__wrapper">
        <div class="c-adv__768">
          <a href="<?php the_sub_field('adv_cta'); ?>" class="c-adv__768--link">
          <?php 
          $image = get_sub_field('adv_image');
          if( !empty( $image ) ): ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
          <?php endif; ?>
          </a>
        </div>
      </div>
    </section>