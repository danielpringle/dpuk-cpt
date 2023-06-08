<?php

$customPosts = array (

    "books" => array(
        'name' => 'Books',
        'singular' => 'Book',
        'plural' => 'Books',
        'menu_icon' => 'dashicons-admin-users',
        'menu_position' => 18,
        'text_domain' => 'dpuk-cpt',
        'supports' => array(),
        'taxonomies' => array( 'category', 'post_tag'),
        'has_archives' => true,
		'rewrite' => 'libray/books',
    ),
    "resources" => array(
        'name' => 'Resources',
		'singular' => 'Resource',
		'plural'  => 'Resources',
		'menu_icon' => 'dashicons-portfolio',
		'menu_position' => 18,
		'text_domain' => 'dpuk-cpt',
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' ),
        'taxonomies' => array(),
		'has_archives' => true,
		'rewrite' => 'resources',
    ),
);

