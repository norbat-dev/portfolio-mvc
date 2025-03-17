<?php


declare(strict_types=1);

namespace Wombat\Controllers;

/**
 * Portfolio Post Type Class
 */
class PortfolioCPT {

	/**
	 * Properties
	 */
	public const POST_NAME = 'portfolio';
	public const POST_SLUG = 'portfolio';
	const TAXONOMY         = 'portfolio-category';

	/**
	 * Construct
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'registerPostType' ] );
	}

	/**
	 * Register Post type and Taxonomy.
	 *
	 * @return void
	 */
	public function registerPostType(): void {
		$post_type_labels = [
			'name'          => __( 'Portfolio', 'adwise' ),
			'singular_name' => __( 'Projekt', 'adwise' ),
			'add_new'       => __( 'Dodaj nowy', 'adwise' ),
			'add_new_item'  => __( 'Dodaj nowy Projekt', 'adwise' ),
			'new_item'      => __( 'Nowy Projekt', 'adwise' ),
			'edit_item'     => __( 'Edytuj Projekt', 'adwise' ),
			'view_item'     => __( 'Zobacz Projekt', 'adwise' ),
			'all_items'     => __( 'Wszystkie Projekty', 'adwise' ),
		];

		$post_type_args = [
			'labels'              => $post_type_labels,
			'supports'            => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ],
			'show_ui'             => true,
			'show_admin_column'   => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'public'              => true,
			'show_in_rest'        => true,
			'capability_type'     => 'post',
			'hierarchical'        => true,
			'has_archive'         => true,
			'menu_icon'           => 'dashicons-tickets-alt',
			'rewrite'             => [
				'slug'       => self::POST_SLUG,
				'with_front' => false,
			],
		];
		register_post_type( self::POST_NAME, $post_type_args );

		$tax_args = [
			'labels'            => [
				'name'          => __( 'Kategoria', 'adwise' ),
				'singular_name' => __( 'kategoria', 'adwise' ),
			],
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_rest'      => true,
			'rewrite'           => [ 'slug' => 'portfolio-category' ],
		];
		register_taxonomy( self::TAXONOMY, [ self::POST_NAME ], $tax_args );
	}
}