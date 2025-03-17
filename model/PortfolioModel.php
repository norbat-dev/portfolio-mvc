<?php

declare( strict_types=1 );

namespace Wombat\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Portfolio class
 */
class Portfolio {

    /**
     * 
     */
    private ?int $id = null; 

    /**
     * 
     */
    private \WP_Post|null $post = null; 

    /**
     * 
     */
    private string $growth_number = ''; 

    /**
     * 
     */
    private string $growth_indicator = ''; 

    /**
     * 
     */
    private array $categories = [];

    /**
     * 
     */
    private string $title = '';

    /**
     * 
     */
    private string $excerpt = '';

    /**
     * 
     */
    private string $permalink = '';

    /**
     * 
     */
    private string $post_thumbnail = '';


    /**
     * 
     */
    public function __construct( int $id ){

        if( ! is_int( $id ) && $id <= 0 ){
            return;
        }
        $this->post = \get_post( $id );

        if( is_null( $this->post ) ){
            return;
        }

        $this->id = $id;
        $portfolio_meta = \get_fields( $this->id );

        $this->growth_number = $portfolio_meta['portfolio_growth_number'] ?? '';
        $this->growth_indicator = $portfolio_meta['portfolio_growth_indicator'] ?? '';

        if( ! $this->categories = \get_the_terms( $portfolio_id, 'portfolio-category' ) ){
            $this->categories = [];
        }

        $this->title = \get_the_title( $this->post );
        $this->excerpt = \get_the_excerpt( $this->post );
        $this->permalink = \get_permalink( $this->post );
        $this->post_thumbnail = get_the_post_thumbnail( $this->post, 'medium' );


    }

	/**
	 * Retrieves the current portfolio post ID.
	 *
	 * @return int|null The portfolio post ID or null if not found.
	 */
	public function get_id(): ?int {
        return $this->id;
	}

	/**
	 * Retrieves growth number from ACF.
	 *
	 * @return string Growth number.
	 */
	public function get_growth_number( ): string {
		return $this->growth_number;
	}

	/**
	 * Retrieves growth indicator from ACF.
	 *
	 * @return string Growth indicator.
	 */
	public function get_growth_indicator( ): string {
		return $this->growth_indicator;
	}

	/**
	 * Retrieves categories for a given portfolio item.
	 *
	 * @return array Categories list.
	 */
	public function get_categories( ): array {
		return $this->categories;
	}

	/**
	 * Retrieves the title of the portfolio item.
	 *
	 * @return string The portfolio title.
	 */
	public function get_title( ): string {
		return $this->title;
	}

	/**
	 * Retrieves the excerpt of the portfolio item.
	 *
	 * @return string The portfolio excerpt.
	 */
	public function get_excerpt( ): string {
		return $this->excerpt;
	}

	/**
	 * Retrieves the permalink of the portfolio item.
	 *
	 * @return string The portfolio permalink.
	 */
	public function get_permalink( ): string {
		return $this->permalink;
	}

	/**
	 * Retrieves the post thumbnail image for a portfolio item.
	 *
	 * @return string HTML image element or an empty string.
	 */
	public function get_post_thumbnail(  ): string {
		return $this->post_thumbnail;
	}

	/**
	 * Retrieves all model's data.
	 *
	 * @return array .
	 */
	public function get_all_data(  ): array {
		return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'permalink' => $this->permalink,
            'categories' => $this->categories,
            'growth_number' => $this->growth_number,
            'growth_indicator' => $this->growth_indicator,
        ];
	}

}