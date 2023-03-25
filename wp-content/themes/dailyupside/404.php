<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Daily_Upside
 */

get_header();
?>

		<section class="o-section c-section--notfound">
			<div class="o-section__wrapper">
				<div class="c-notfound row">
					<div class="c-notfound__col col-md-6">
						<div class="c-notfound__info">
							<div class="c-notfound__title">
								404
							</div>
							<div class="c-notfound__text">
								Don’t worry! You are just one click away from landing in a great place.
							</div>
							<div class="c-notfound__img">
								<img src="<?php echo get_template_directory_uri() ?>/assets/images/404.png" alt="Not Found">
							</div>
						</div>
					</div>
					<div class="c-notfound__col col-md-6">
						<div class="c-infobox">
							<div class="c-infobox__item">
								<span class="c-infobox__text">Want to sign up for our newsletter? Of course you do, join the 750k+ others</span>
								<a href="<?php echo esc_url( home_url( '' ) ); ?>/welcome/" class="c-infobox__cta">
									<span>Join now</span>
									<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.18919 17.5541V13.4012H0.868591V4.39357H8.2346V0.346603L18.0114 8.97032L8.18919 17.5541Z" fill="#F4D35E"/>
									</svg>
								</a>
							</div>
							<div class="c-infobox__item">
								<span class="c-infobox__text">Interested in the latest and greatest from our award winning news desk?</span>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-infobox__cta">
									<span>oh yeah</span>
									<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.18919 17.5541V13.4012H0.868591V4.39357H8.2346V0.346603L18.0114 8.97032L8.18919 17.5541Z" fill="#F4D35E"/>
									</svg>
								</a>
							</div>
							<div class="c-infobox__item">
								<span class="c-infobox__text">Want “next level” thematic content on the trends moving markets?</span>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-infobox__cta">
									<span>yes please</span>
									<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.18919 17.5541V13.4012H0.868591V4.39357H8.2346V0.346603L18.0114 8.97032L8.18919 17.5541Z" fill="#F4D35E"/>
									</svg>
								</a>
							</div>
							<div class="c-infobox__item">
								<span class="c-infobox__text">Want to buy an ad? We’d love to help.</span>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>/advertise-with-us/" class="c-infobox__cta">
									<span>Connect</span>
									<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.18919 17.5541V13.4012H0.868591V4.39357H8.2346V0.346603L18.0114 8.97032L8.18919 17.5541Z" fill="#F4D35E"/>
									</svg>
								</a>
							</div>
						</div>

						<div class="c-infobox__img">
							<img src="<?php echo get_template_directory_uri() ?>/assets/images/404.png" alt="Not Found">
						</div>
					</div>
				</div>
			</div>
		</section>

<?php
get_footer();
