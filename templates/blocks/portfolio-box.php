<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

$growth_number    = $args['growth_number'];
$growth_indicator = $args['growth_indicator'];
$categories       = $args['categories'];
$portfolio_title  = $args['title'];
$excerpt          = $args['excerpt'];
$permalink        = $args['permalink'];
$post_thumbnail   = $args['post_thumbnail'];
?>

<div class="c-portfolio">
	<div class="c-portfolio__content-wrapper">
		<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
			<div class="c-portfolio__category">
				<?php foreach ( $categories as $category ) : ?>
					<span><?php echo esc_html( $category->name ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<h3 class="c-portfolio__title">
			<?php echo esc_html( $portfolio_title ); ?>
		</h3>
		<div class="c-portfolio__excerpt">
			<?php echo esc_html( $excerpt ); ?>
		</div>
		<div class="c-portfolio__button wp-block-button is-style-primary">
			<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $permalink ); ?>">
				<?php echo esc_html__( 'Zobacz case study', 'adwise' ); ?>
			</a>
		</div>
		<?php if ( ! empty( $growth_number ) && ! empty( $growth_indicator ) ) : ?>
			<div class="c-portfolio__growth-wrapper">
				<div class="c-portfolio__growth">
					<span class="c-portfolio__growth-number"><?php echo esc_html( $growth_number ); ?></span>
					<span class="c-portfolio__growth-indicator"><?php echo esc_html( $growth_indicator ); ?></span>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( ! empty( $post_thumbnail ) ) : ?>
		<div class="c-portfolio__image-wrapper">
			<?php echo wp_kses_post( $post_thumbnail ); ?>
		</div>
	<?php endif; ?>
</div>