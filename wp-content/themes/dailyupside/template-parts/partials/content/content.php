<?php 
if( have_rows( 'homepage' ) ):
    $key = -1;
    $selected_feature_post_ids = [];
    // loop through the rows of data
    while ( have_rows( 'homepage' ) ) : the_row(); $key++;

        if ( get_row_layout() == 'hero' ) :

            get_template_part( '/template-parts/partials/content/layouts/section', 'hero' );

        elseif ( get_row_layout() == 'featured' ) :
            $featured_post = get_sub_field('featured_articles');
            foreach($featured_post as $post_item):
                  $featured_post_main = $post_item['featured_article'];
                  $selected_feature_post_ids[] = $featured_post_main->ID;
              endforeach;

            get_template_part( '/template-parts/partials/content/layouts/section', 'featured' );
        
        elseif ( get_row_layout() == 'adv' ) :

            get_template_part( '/template-parts/partials/content/layouts/section', 'adv' );

        elseif ( get_row_layout() == 'articles' ) :

            get_template_part( '/template-parts/partials/content/layouts/section', 'article' );

        elseif ( get_row_layout() == 'item_info' ) :

            get_template_part( '/template-parts/partials/content/layouts/section', 'item_info' );

        elseif ( get_row_layout() == 'reviews' ) :

            get_template_part( '/template-parts/partials/content/layouts/section', 'reviews' );

        endif;

    endwhile;

else :

    // no layouts found

endif;
?>
