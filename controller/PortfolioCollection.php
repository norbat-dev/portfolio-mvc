<?php


declare(strict_types=1);

namespace Wombat\Controllers;
use Wombat\Models\Portfolio as PortfolioModel;


/**
 * Portfolio Post Type Class
 */
class PortfolioCollection {

    /**
     * 
     */
    private array $portfolios = []; 


	/**
	 * 
	 */
	private function get_all( $args ) {
		$query_args = [
			'post_type' 	=> 'portfolio',
			'fields' 		=> 'ids',
            'no_found_rows' => true,
			'paged'     	=> isset( $args['paged'] ) ? $args['paged'] : 1,
		];

		if ( $args['manualSelect'] && ! empty( $args['selectedPostsIDs'] ) ) {
			$query_args['post__in']       = $args['selectedPostsIDs'];
			$query_args['posts_per_page'] = 50;
			$query_args['orderby']        = 'post__in';
		} else {
			$query_args['posts_per_page'] = isset( $args['numberOfPosts'] ) ? $args['numberOfPosts'] : 4;
			$query_args['orderby']        = 'date';
		}
		
		$the_query = new \WP_Query( $query_args );

		$portolio_collection = [];
		if ( $the_query->have_posts() ) {
			$portolio_ids = $the_query->posts;
			foreach ( $portolio_ids as $portolio_id ) {
				$portolio_collection[] = new PortfolioModel( $portolio_id );
			}
		} 

		return $portolio_collection;
	}
}