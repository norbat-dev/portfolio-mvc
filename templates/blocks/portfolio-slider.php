<?php
/**
 * Portfolio Slider block template
 *
 * @package Wombat
 */

?>

<section <?php echo wp_kses_data( get_block_wrapper_attributes( $args['blockAttributes'] ) ); ?>>
	<div class="b-portfolio-slider__wrapper">
		<div class="b-portfolio-slider__list">
			<?php if ( isset( $args['portfolios'] ) && ! empty( $args['portfolios'] ) ) : ?>
				<?php
                foreach( $args['portfolios'] as $portfolio ){
                    get_template_part( 'template-parts/components/portfolio', 'box', $portfolio->get_all_data() );
                }
				?>
			<?php endif; ?>
		</div>
	</div>
</section>