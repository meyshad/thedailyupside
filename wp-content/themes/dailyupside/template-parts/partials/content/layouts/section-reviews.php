<section class="o-section c-section--reviews">
    <div class="o-section__wrapper">
        <div class="c-reviews">
            <?php
            $title = get_sub_field('title');
            if ($title): ?>
            <div class="c-reviews__title">
                <?php echo $title; ?>
            </div>
            <?php endif; ?>
            <?php 
            $rows = get_sub_field('blockquote');
            if ($rows):
            ?>
            <div class="c-reviews__blockquote">
            <?php foreach( $rows as $row ):
                $text = $row['blockquote_text']; 
                $name = $row['name']; 
                ?>
                <div class="c-blockquote">
                    <p class="c-blockquote__text"><?php echo $text; ?></p>
                    <div class="c-blockquote__name"><?php echo $name; ?></div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <?php 
        $cta = get_sub_field('cta');
        if( $cta ): 
            $cta_url = $cta['url'];
            $cta_title = $cta['title'];
            $cta_target = $cta['target'] ? $cta['target'] : '_self';
            ?>
            <a href="<?php echo esc_url( $cta_url ); ?>" target="<?php echo esc_attr( $cta_target ); ?>" class="c-btn c-reviews__btn">
                <?php echo esc_html( $cta_title ); ?>
            </a>
        <?php endif; ?>
    </div>
</section>