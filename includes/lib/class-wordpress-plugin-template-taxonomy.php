<?php
/**
 * Taxonomy functions file.
 *
 * @package WordPress Plugin Template/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Taxonomy functions class.
 */
class WordPress_Plugin_Template_Taxonomy {

	/**
	 * The name for the taxonomy.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $taxonomy;

	/**
	 * The plural name for the taxonomy terms.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plural;

	/**
	 * The singular name for the taxonomy terms.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $single;

	/**
	 * The array of post types to which this taxonomy applies.
	 *
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $post_types;

	/**
	 * The array of taxonomy arguments
	 *
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $taxonomy_args;

	/**
	 * Taxonomy constructor.
	 *
	 * @param string $taxonomy Taxonomy variable nnam.
	 * @param string $plural Taxonomy plural name.
	 * @param string $single Taxonomy singular name.
	 * @param array  $post_types Affected post types.
	 * @param array  $tax_args Taxonomy additional args.
	 */
	public function __construct( $taxonomy = '', $plural = '', $single = '', $post_types = array(), $tax_args = array() ) {

		if ( ! $taxonomy || ! $plural || ! $single ) {
			return;
		}

		// Post type name and labels.
		$this->taxonomy = $taxonomy;
		$this->plural   = $plural;
		$this->single   = $single;
		if ( ! is_array( $post_types ) ) {
			$post_types = array( $post_types );
		}
		$this->post_types    = $post_types;
		$this->taxonomy_args = $tax_args;

		// Register taxonomy.
		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}

	/**
	 * Register new taxonomy
	 *
	 * @return void
	 */
	public function register_taxonomy() {
		//phpcs:disable
		$labels = array(
			'name'                       => $this->plural,
			'singular_name'              => $this->single,
			'menu_name'                  => $this->plural,
			'all_items'                  => sprintf( esc_html__( 'All %s', 'wordpress-plugin-template' ), esc_html($this->plural) ),
			'edit_item'                  => sprintf( esc_html__( 'Edit %s', 'wordpress-plugin-template' ), esc_html($this->single) ),
			'view_item'                  => sprintf( esc_html__( 'View %s', 'wordpress-plugin-template' ), esc_html($this->single) ),
			'update_item'                => sprintf( esc_html__( 'Update %s', 'wordpress-plugin-template' ), esc_html($this->single) ),
			'add_new_item'               => sprintf( esc_html__( 'Add New %s', 'wordpress-plugin-template' ), esc_html($this->single) ),
			'new_item_name'              => sprintf( esc_html__( 'New %s Name', 'wordpress-plugin-template' ), esc_html($this->single) ),
			'parent_item'                => sprintf( esc_html__( 'Parent %s', 'wordpress-plugin-template' ), esc_html($this->single) ),
			'parent_item_colon'          => sprintf( esc_html__( 'Parent %s:', 'wordpress-plugin-template' ), esc_html($this->single) ),
			'search_items'               => sprintf( esc_html__( 'Search %s', 'wordpress-plugin-template' ), esc_html($this->plural) ),
			'popular_items'              => sprintf( esc_html__( 'Popular %s', 'wordpress-plugin-template' ), esc_html($this->plural) ),
			'separate_items_with_commas' => sprintf( esc_html__( 'Separate %s with commas', 'wordpress-plugin-template' ), esc_html($this->plural) ),
			'add_or_remove_items'        => sprintf( esc_html__( 'Add or remove %s', 'wordpress-plugin-template' ), esc_html($this->plural) ),
			'choose_from_most_used'      => sprintf( esc_html__( 'Choose from the most used %s', 'wordpress-plugin-template' ), esc_html($this->plural) ),
			'not_found'                  => sprintf( esc_html__( 'No %s found', 'wordpress-plugin-template' ), esc_html($this->plural) ),
		);
		//phpcs:enable
		$args = array(
			'label'                 => $this->plural,
			'labels'                => $labels,
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'show_tagcloud'         => true,
			'meta_box_cb'           => null,
			'show_admin_column'     => true,
			'show_in_quick_edit'    => true,
			'update_count_callback' => '',
			'show_in_rest'          => true,
			'rest_base'             => $this->taxonomy,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'query_var'             => $this->taxonomy,
			'rewrite'               => true,
			'sort'                  => '',
		);

		$args = array_merge( $args, $this->taxonomy_args );

		register_taxonomy( $this->taxonomy, $this->post_types, $args );
	}

}
