<?php

/**
 * Custom Post Type Class.
 * @package CptClass
 */
class CptMaker {
    /**
     * Add variables to make them dynamic from user.
     * Are private to make sure they are applied to one class alone.
     */
    public $name;
    public $singular;
    public $plural;
    public $menu_icon;
    public $menu_position;
    public $text_domain;
    public $supports;
    public $taxonomies;
    public $has_archive;
    public $rewrite;
    public $public;
    public $publicly_queryable;
    public $rewrite_with_front;
    public $hierarchical;      

   /**
    * Add the variables into the class.
    * Run all the needed actions on class instantiation.
    */
    public function __construct( 
        string $name,
        string $singular, 
        string $plural, 
        $menu_icon, 
        int $menu_position, 
        string $text_domain, 
        array $supports, 
        array $taxonomies,
        bool $has_archive,
        string $rewrite,
        bool $rewrite_with_front,
        bool $hierarchical,
        $public = true,
        $publicly_queryable = true
        )
        {
            $this->name = $name;   
            $this->singular = $singular;
            $this->plural = $plural;
            $this->menu_icon = $menu_icon;
            $this->menu_position = $menu_position;
            $this->text_domain = $text_domain;
            $this->supports = $supports;
            $this->taxonomies = $taxonomies;
            $this->has_archive  = $has_archive;
            $this->rewrite  = $rewrite;
            $this->rewrite_with_front = $rewrite_with_front;
            $this->hierarchical  = $hierarchical;
            $this->public = $public;
            $this->publicly_queryable = $publicly_queryable;


            add_action( 'init', array( &$this, 'custom_post_type'), 10 , 4 );
            add_action( 'after_switch_theme', array( &$this, 'rewrite_flush') );
        }

  /**
    * Create Custom Post Types
    * @return The registered post type object, or an error object
    */
    public function custom_post_type(){

        $labels = array(
            'name'                  => _x( $this->plural, 'Post type general name', $this->text_domain ),
            'singular_name'         => _x( $this->singular, 'Post type singular name', $this->text_domain ),
            'menu_name'             => _x( $this->plural, 'Admin Menu text', $this->text_domain ),
            'name_admin_bar'        => _x( $this->singular, 'Add New on Toolbar', $this->text_domain ),
            'add_new'               => __( 'Add New', $this->text_domain ),
            'add_new_item'          => __( 'Add New ' . $this->singular, $this->text_domain ),
            'new_item'              => __( 'New ' . $this->singular, $this->text_domain ),
            'edit_item'             => __( 'Edit ' . $this->singular, $this->text_domain ),
            'view_item'             => __( 'View ' . $this->singular, $this->text_domain ),
            'all_items'             => __( 'All ' . $this->plural, $this->text_domain ),
            'search_items'          => __( 'Search ' . $this->plural, $this->text_domain ),
            'parent_item_colon'     => __( 'Parent ' . $this->plural.':', $this->text_domain ),
            'not_found'             => __( 'No ' . $this->plural . 'found', $this->text_domain ),
            'not_found_in_trash'    => __( 'No ' . $this->plural . 'found in Trash.', $this->text_domain ),
            'archives'              => _x( $this->singular . ' archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', $this->text_domain ),
            'insert_into_item'      => _x( 'Insert into ' . $this->singular, 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', $this->text_domain ),
            'uploaded_to_this_item' => _x( 'Uploaded to this ' . $this->singular, 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', $this->text_domain ),
            'filter_items_list'     => _x( 'Filter ' . $this->plural . 'list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', $this->text_domain ),
            'items_list_navigation' => _x( $this->plural . ' list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', $this->text_domain ),
            'items_list'            => _x( $this->plural . ' list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', $this->text_domain ),
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => $this->public,
            'publicly_queryable' => $this->publicly_queryable,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => $this->menu_icon,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => strtolower( $this->rewrite ), 'with_front' => $this->rewrite_with_front ),
            'capability_type'    => 'post',
            'has_archive'        => $this->has_archive,
            'hierarchical'       => $this->hierarchical,
            'menu_position'      => null,
            'supports'           => $this->supports,
            'taxonomies'         => $this->taxonomies, 
            'show_in_rest'       => true
        );

      register_post_type( strtolower( $this->name), $args );

    }

  /**
    * Flush Rewrite on CPT activation
    * @return empty
    */
    public function rewrite_flush()
    {
        // call the CPT init function
        $this->custom_post_type();
        // Flush the rewrite rules only on theme activation
        flush_rewrite_rules();
    }
}