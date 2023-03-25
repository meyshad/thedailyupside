<section class="o-section c-section--item">
    <div class="o-section__wrapper">
        <div class="c-item">
            <?php
            $title = get_sub_field('title');
            if ($title): ?>
            <div class="c-item__title">
                <?php echo $title; ?>
            </div>
            <?php endif; ?>

            <?php 
            $rows = get_sub_field('items');
            if ($rows): $i = 0;
            ?>
            <div class="c-item__items">
            <?php foreach( $rows as $row ): $i++; ?>
                <?php if ( $row['content'] ): ?>
                <div class="c-item__item">
                    <div class="c-item__number">
                        0<?php echo $i; ?>
                    </div>
                    <div class="c-item__text">
                        <?php echo $row['content']; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>