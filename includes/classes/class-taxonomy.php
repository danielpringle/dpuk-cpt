<?php
/**
 * CPT Taxonomy Custom Meta
 * To apply use add Taxonomy Name, Singular CPT Name
 * e.g. $customTaxClass = new custom_taxonomy_class( 'Genre', 'Book' );
 */
class custom_taxonomy_class
{

 private $taxo_name;
 private $CPT_name;
 private $textdomain;
 private $name;
 private $singular;
 private $rewrite;
 private $rewrite_with_front;
 private $hierarchical;

 public function __construct( 
    $taxo_name,
    $CPT_name,
    $textdomain, 
    $name,
    $singular,
    $rewrite,
    $rewrite_with_front,
    $hierarchical
    )
    {
        $this->taxo_name = $taxo_name;
        $this->CPT_name = strtolower( $CPT_name );
        $this->textdomain = $textdomain;
        $this->name = $name;
        $this->singular = $singular;
        $this->rewrite = $rewrite;
        $this->rewrite_with_front = $rewrite_with_front;
        $this->hierarchical = $hierarchical;

        add_action( 'init', array($this, 'register_custom_fields_taxonomy'), 0 );
    }

 public function register_custom_fields_taxonomy() {


    $labels = array(
        'name' => _x( $this->name, 'taxonomy general name', $this->textdomain ),
        'singular_name' => _x( $this->singular, 'taxonomy singular name', $this->textdomain ),
        'search_items' =>  __( 'Search ' . $this->name, $this->textdomain ),
        'all_items' => __( 'All ' . $this->name, $this->textdomain ),
        'parent_item' => __( 'Parent ' . $this->singular, $this->textdomain ),
        'parent_item_colon' => __( 'Parent ' . $this->singular . ':', $this->textdomain ),
        'edit_item' => __( 'Edit ' . $this->singular, $this->textdomain ),
        'update_item' => __( 'Update ' . $this->singular, $this->textdomain ),
        'add_new_item' => __( 'Add New ' . $this->singular, $this->textdomain ),
        'new_item_name' => __( 'New ' . $this->singular . ' Name', $this->textdomain ),
        'menu_name' => __( $this->name, $this->textdomain ),
      );     
      register_taxonomy(strtolower( $this->taxo_name),array($this->CPT_name), array(
        'hierarchical' => $this->hierarchical ,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => strtolower( $this->rewrite ), 'with_front' => $this->rewrite_with_front, 'hierarchical' => $this->hierarchical),
        'show_in_rest'          => true,
      ));

   } //end register_custom_fields_taxonomy()
} //End Class    