<?php
declare( strict_types=1 );

namespace Wombat\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Wombat\Helpers;
use Wombat\Blocks;
use Wombat\Models\PortfolioModel as PortfolioModel;

/**
 * Block portfolio-slider - Portfolio Slider
 */
class PortfolioSlider extends Blocks {


	const SLUG              = 'portfolio-slider';
	const HANDLE_JS         = 'block-portfolio-slider-scripts';
	const HANDLE_CSS        = 'block-portfolio-slider-styles';
	const HANDLE_EDITOR_JS  = 'block-portfolio-slider-editor-scripts';
	const HANDLE_EDITOR_CSS = 'block-portfolio-slider-editor-styles';

	/**
	 * Actions to register block
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueueEditor' ] );
		add_action( 'init', [ $this, 'init' ] );
	}

	/**
	 * Register styles and scripts
	 *
	 * @return void
	 */
	public function enqueue(): void {
		if ( has_block( 'client/' . self::SLUG ) || Helpers::isInnerblock( 'client/' . self::SLUG ) ) {
			wp_register_style( self::HANDLE_CSS, esc_url( WOMBAT_THEME_URL ) . '/dist/block_' . self::SLUG . '.css', false, Helpers::getThemeVersion() );
			wp_register_script( self::HANDLE_JS, esc_url( WOMBAT_THEME_URL ) . '/dist/block_' . self::SLUG . '.bundle.js', false, Helpers::getThemeVersion(), true );
		}
	}

	/**
	 * Register Editor Scripts and styles
	 *
	 * @return void
	 */
	public function enqueueEditor(): void {
		wp_register_style( self::HANDLE_EDITOR_CSS, esc_url( WOMBAT_THEME_URL ) . '/dist/block_' . self::SLUG . '_editor.css', false, Helpers::getThemeVersion() );
		wp_register_script( self::HANDLE_EDITOR_JS, esc_url( WOMBAT_THEME_URL ) . '/dist/block_' . self::SLUG . '_editor.bundle.js', false, Helpers::getThemeVersion(), true );
		wp_set_script_translations( self::HANDLE_EDITOR_JS, 'client', esc_url( WOMBAT_THEME_DIR ) . '/languages' );
	}

	/**
	 * Register Block
	 *
	 * @return void
	 */
	public function init(): void {

		register_block_type( 'client/' . self::SLUG, [
			'editor_script'   => self::HANDLE_EDITOR_JS,
			'editor_style'    => self::HANDLE_EDITOR_CSS,
			'script'          => self::HANDLE_JS,
			'style'           => self::HANDLE_CSS,
			'render_callback' => [ $this, 'renderTemplate' ],
			'attributes'      => [
				'numberOfPosts'    => [
					'type'    => 'number',
					'default' => 4,
				],
				'selectedPosts'    => [
					'type' => 'array',
				],
				'selectedPostsIDs' => [
					'type' => 'array',
				],
				'manualSelect'     => [
					'type'    => 'boolean',
					'default' => false,
				],
			],
			'supports'        => [
				'spacing' => [
					'padding' => [ 'top', 'bottom' ],
					'margin'  => [ 'top', 'bottom' ],
				],
				'anchor'  => true,
			],
		] );
	}

	/**
	 * Get articles based on provided arguments.
	 *
	 * @param array $args Arguments for the query.
	 *
	 * @return \WP_Query The query object containing posts.
	 */
	private function getArticles( $args ) {
		$query_args = [
			'post_type' => 'portfolio',
			'paged'     => isset( $args['paged'] ) ? $args['paged'] : 1,
		];

		if ( $args['manualSelect'] && ! empty( $args['selectedPostsIDs'] ) ) {
			$query_args['post__in']       = $args['selectedPostsIDs'];
			$query_args['posts_per_page'] = 50;
			$query_args['orderby']        = 'post__in';
		} else {
			$query_args['posts_per_page'] = isset( $args['numberOfPosts'] ) ? $args['numberOfPosts'] : 4;
			$query_args['orderby']        = 'date';
		}

		return new \WP_Query( $query_args );
	}

	/**
	 * Set data and render template
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function renderTemplate( $args ): string {
		$args['portfolios']           = \Wombat\Controllers\PortfolioCollection::get_all( $args );
		$args['blockAttributes'] = [
			'class' => 'b-portfolio-slider',
		];

		ob_start();
		get_template_part( 'template-parts/blocks/' . self::SLUG, '', $args );
		$output = ob_get_clean();
		wp_reset_postdata();
		return $output;
	}

	/**
	 * Retrieves the current portfolio ID.
	 *
	 * @return int|null Portfolio ID.
	 */
	public function getPortfolioID(): ?int {
		$portfolio_model = new PortfolioModel();
		return $portfolio_model->getPortfolioID();
	}

	/**
	 * Retrieves data for a portfolio item.
	 *
	 * @param int $portfolio_id The portfolio ID.
	 * @return array Portfolio data.
	 */
	public function getPortfolioData( int $portfolio_id ): array {
		$portfolio_model = new PortfolioModel();
		return [
			'growth_number'    => $portfolio_model->getGrowthNumber( $portfolio_id ),
			'growth_indicator' => $portfolio_model->getGrowthIndicator( $portfolio_id ),
			'categories'       => $portfolio_model->getCategories( $portfolio_id ),
			'title'            => $portfolio_model->getTitle( $portfolio_id ),
			'excerpt'          => $portfolio_model->getExcerpt( $portfolio_id ),
			'permalink'        => $portfolio_model->getPermalink( $portfolio_id ),
			'post_thumbnail'   => $portfolio_model->getPostThumbnail( $portfolio_id ),
		];
	}
}