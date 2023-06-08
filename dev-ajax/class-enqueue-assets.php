<?php


/**
 * Events loop ajax
 */
if ( is_post_type_archive( 'events' )|| is_page( 'events' )){
	wp_enqueue_script(
		'dpuk-events-ajax', 
		AC_URL . 'assets/js/dpuk-events-ajax.js',
		[ 'jquery' ],
		filemtime(AC_PATH . 'assets/js/dpuk-events-ajax.js'),
		true 
	);
	wp_localize_script( 'dpuk-events-ajax', 'dpuk-_fetch_events', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	));  

	}
