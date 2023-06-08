<?php

function cpt_checker(){

var_dump(post_type_supports( 'books', 'custom-fields' ));

$supports = array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' );

$post_types = []; 

$args = array(
    'public'   => true,
    '_builtin' => false
);

$list_post_types = get_post_types( $args );

echo '<p>The following post types are registered:</p>';
echo '<ul>';
foreach ( $list_post_types  as $list_post_type ) {

    echo '<li>' . $list_post_type . '</li>';
    $post_types[] = $list_post_type;
}
echo '</ul>';

foreach ( $post_types  as $post_type ) {

    $supported = [];
    $not_supported = [];


    

    $taxonomies = get_object_taxonomies( $post_type );


    echo '<h3>'.$post_type.'</h3>';
    echo '<p>';
    foreach ( $supports  as $support ) {

        if ( post_type_supports( $post_type, $support ) ) {

            $supported[] = $support;
            
        } else {
            $not_supported[] = $support;
        }
    }


    if ($supported) {
        
        echo '<p><strong>Supports:</strong> ';
        foreach ( $supported  as $supported_item ) {
            echo $supported_item . ', ';
        }
        echo '</p>';
    } else {
        echo '<p>nothing currently supported</p>';
    }

    
    

    if (count($not_supported) >= 1) {
        echo '<p><strong>Not Supported:</strong> ';
        foreach ( $not_supported  as $not_supported_item ) {
            echo $not_supported_item . ', ';
        }
        echo '</p>';
    }


    
    echo '<p>';
    echo '<strong>Connected taxonomies: </strong>';
    foreach ( $taxonomies  as $taxonomy ) {
        
        echo $taxonomy . ', ';

    }
    echo '</p>';
}

}
add_action( 'init', 'cpt_checker', 20 );