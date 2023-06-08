<?php

/**
 * 
 * @package 
 */
class MetaBox_FT_Post_Checkbox{

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_custom_meta_box'));
        add_action('save_post', array($this, 'save_custom_meta_box'));
    }


  /**
   *  Add Metabox per post/page and any registered custom post type
   *
   * @since 1.2.0
   */
  function add_custom_meta_box() {
  
	$args = array(
			'public'   => true,
			'_builtin' => false
	);

     $post_types = get_post_types( $args );
	 
     array_push($post_types, 'post');


    //  add_meta_box( 
    //     string $id, 
    //     string $title, 
    //     callable $callback, 
    //     string|array|WP_Screen $screen = null, 
    //     string $context = 'advanced', 
    //     string $priority = 'default', 
    //     array $callback_args = null 
    //     )

	 foreach ( $post_types as $post_type ) {
	  add_meta_box('checkbox-meta-box',
       __('Featured Post','dpuk-cpt'),
       array($this, 'display_meta_box'),
         $post_types,
        'side',
        'default',
         null);
	 }
  }

    /**
     *  Metabox markup per post/page
     *
     * @since 1.2.0
     */

    public function display_meta_box($post) {
        // Add an nonce field so we can check for it later.
        wp_nonce_field(basename(__FILE__), "dpukcpt_featured_post_nonce");

        // Use get_post_meta to retrieve an existing value from the database.
        $checkbox_stored_meta = get_post_meta( $post->ID );
    
        // Display the Checkbox.
        ?>
        <label for="dpukcpt_featured_post">
        <input type="checkbox" name="dpukcpt_featured_post" id="dpukcpt_featured_post" value="yes" <?php if ( isset ( $checkbox_stored_meta ['dpukcpt_featured_post'] ) ) checked( $checkbox_stored_meta['dpukcpt_featured_post'][0], 'yes' ); ?> />
        <?php _e( 'Set as a Featured Post', 'dpuk-cpt' )?>
        </label>
    
        <?php
    
    }

 /**
   *  Save metabox markup per post/page
   *
   * @since 1.2.0
   */
  
   function save_custom_meta_box( $post_id ) {
        // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );

    // Verify that the nonce is valid.
    $is_valid_nonce = ( isset( $_POST[ 'dpukcpt_featured_post_nonce' ] ) && wp_verify_nonce( $_POST[ 'dpukcpt_featured_post_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
  
    // Exits script depending on save status
	 if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		 return;
	 }

    // Check the user's permissions.
    if (!current_user_can('edit_page', $post_id)){
        return $post_id;
    }
         
    $meta_key = 'dpukcpt_featured_post';

    // Checks for input and saves
    if( isset( $_POST[ 'dpukcpt_featured_post' ] ) ) {
        update_post_meta( $post_id, 'dpukcpt_featured_post', 'yes');
    }
    else {
        update_post_meta( $post_id, 'dpukcpt_featured_post', '' );
    }
  }

}