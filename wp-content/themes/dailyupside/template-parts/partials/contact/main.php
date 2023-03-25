<section class="o-section c-section--contactus">
	<div class="o-section__wrapper">
		<div class="c-contactus row">
			<div class="c-contactus__col col-md-6">
				<div class="c-contactus__info">
					<?php $title = get_field('title');?>
					<?php if($title):?>
					<h2 class="c-contactus__title">
						<?php echo $title; ?>
					</h2>
					<?php endif;?>
					<?php $desc = get_field('description');?>
					<?php if($desc):?>
					<div class="c-contactus__text">
						<?php echo $desc; ?>
					</div>
					<?php endif;?>
					<div class="c-contactus__img">
						<img src="<?php echo get_template_directory_uri() ?>/assets/images/contact.png" alt="Contact Us">
					</div>
				</div>
			</div>
			<div class="c-contactus__col col-md-6">
			<?php $shortcode = get_field('form_shortcode');
      if($shortcode):?>
				<div class="c-contactbox">
					<?php echo do_shortcode($shortcode); ?>
				</div>
			<?php endif;?>

				<div class="c-contactbox__img">
					<img src="<?php echo get_template_directory_uri() ?>/assets/images/contact.png" alt="Contact Us">
				</div>
			</div>
		</div>
	</div>
</section>