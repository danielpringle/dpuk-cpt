<?php
/**
 * 
 * Usage:
 * [dpuk_events_loop]
 */
namespace dpuk\Shortcodes;

class SC_Events_Loop_Ajax {

    public function __construct(){
        add_shortcode('dpuk_events_loop', array($this, 'dpuk_events_loop_cb'));
        // Add ajax function that will receive the call back for logged in users
        add_action( 'wp_ajax_dpuk_ajax_fetch_events', array( $this, 'be_events_callback') );
        // Add ajax function that will receive the call back for guest or not logged in users
        add_action( 'wp_ajax_nopriv_dpuk_ajax_fetch_events', array( $this, 'be_events_callback') );

    }

    /**
     *  Resource Card Callback
     */

     public function dpuk_events_loop_cb(){

        $filters_title = __( 'Events', 'dpuk-ajax' );

        $output = '';


        $filter_most_recent = __('Most Recent', 'dpuk-ajax');
        $view_by = __('View By', 'dpuk-ajax');
        /**
         * Sort Filters
         */
        $output .= '<div class="sort-filter"><div class="sort-filter-inner">';
        $output .= '<div class="filter-title">'.$view_by.': </div>';
        $output .= '<div class="form-container">';
        $output .= '<form action="'.esc_url( home_url( '/' ) ).'" onsubmit="event.preventDefault();" method="POST" id="dpuk-category-selector">';
        /**
        *  Order filter
        */

        
        $sort =array(
            "title-a-z"=>"Title: A-Z",
            "title-z-a"=>"Title: Z-A",
        );
        $output .= '<select name="dpuk-events-sort-filter" class="dpuk-sort-filter" id="dpuk-events-sort-filter" ><option value="most-recent">'.$filter_most_recent.'</option>';
        foreach($sort as $key => $value):
            $output .= '<option value="' . $key  . '">' . $value  . '</option>'; // ID of the category as the value of an option
        endforeach;
        $output .= '</select>';
        $output .= '</form>';
        $output .= '</div>'; 
        $output .= '</div></div>'; 




        $output .= '<div class="dpuk-ajax-container">'; // filters
        $output .= '<div class="dpuk-ajax-filters">';

        $output .= '<div class="dpuk-ajax-filters-inner">';
        $output .= '<div class="dpuk-ajax-filters-title"><h2>'.$filters_title.'</h2></div>';

            /**
             *  Search Filter
             */
            $screen_reader_search_text = __( 'To search these events, enter a search term', 'dpuk-ajax' );
            $search_placeholder = __( 'Search', 'dpuk-ajax' );
              
            $output .= '<div class="search_bar">';
            $output .= '<form action="'.htmlspecialchars($_SERVER[" PHP_SELF "]).'" onsubmit="event.preventDefault();" method="get" autocomplete="off">';
            $output .= '<label for="dpuk-ajax-search">';
            $output .= '<span class="screen-reader-text">'.$screen_reader_search_text.'</span>';
            $output .= '<input class="search-field" id="dpuk-ajax-search" type="text" name="s" placeholder="'.$search_placeholder.'" value="'.get_search_query().'" aria-required="false" autocomplete="off" />';
            $output .= '<i class="fa fa-search"></i>';
            $output .= '</label>';
            $output .= '</form>';
            $output .= '</div>';

            /**
             *  Category Checkbox Filter
             */

             $cat_args = array(
                'orderby'    => 'name',
                'order'      => 'asc',
                'hide_empty' => false,
            );
            
            $terms = get_terms( 'event-categories', $cat_args ); 

            $output .= '<div class="ajax-catagories">';
            $output .= '<form action="'.htmlspecialchars($_SERVER[" PHP_SELF "]).'" onsubmit="event.preventDefault();" method="POST" id="dpuk-category-selector">';
            if( $terms ) : 
                $output .= '<div class="filter-checkboxes" id="filter-checkboxes">';
                $output .= '<div class="filter-cat-title"><a href="javascript:void(0)" class="btn-display-categories" id="btn-display-filter-categories" onclick="display_filter_categories()">'.__( 'Categories', 'dpuk-ajax' ).'</a></div>';
                $output .= '<div class="filter-categories" id="show-filter-categories">';
                $output .= '<ul>';
                foreach ( $terms as $term ) :
                    $output .= '<li><input type="checkbox" name="cats" value="' . $term->slug . '"> ' . $term->name.'</li>';
                endforeach;
                $output .= '</ul>';
                $output .= '</div>';
                $output .= '</div>';
            endif;
            $output .= '<noscript><input type="submit" value="Submit"></noscript>';
            $output .= '</form>';
            $output .= '</div>'; // ajax-catagories
        $output .= '</div>'; //dpuk-ajax-filters-inner
        $output .= '</div>'; // dpuk-ajax-filters

        $output .= '<div id="dpuk-ajax-display-posts">';
        $output .= '</div>'; // dpuk-ajax-display-posts
        $output .= '<div class="loader-container"><div id="loader" class="spinner-dual-ring hidden"></div></div>';
        $output .= '</div>'; //dpuk-ajax-container

        return $output;
     }

    /**
     *  Custom get excerpt
     */
    public function get_the_excerpt_by_id($post_id, $length, $strip_html){

        if(!$length)
            $excerpt_length = 35;
        else
            $excerpt_length = $length;
    
        if(!isset($strip_html) || $strip_html == true)
            $strip_html = true;
    
        $the_post = get_post($post_id); //Gets post ID
        $the_excerpt = apply_filters('the_content',$the_post->post_content);//$the_post->post_content); //Gets post_content to be used as a basis for the excerpt
    
        if($strip_html == true)
        {
            $the_excerpt = strip_tags(strip_shortcodes($the_excerpt), '<style>');
            $the_excerpt = preg_replace("|<style\b[^>]*>(.*?)</style>|s", "", $the_excerpt);
        }
    
        $words = explode(' ', $the_excerpt, $excerpt_length + 1);
    
        if(count($words) > $excerpt_length) :
            array_pop($words);
            array_push($words, '…');
            $the_excerpt = implode(' ', $words);
        endif;
    
        return $the_excerpt;
    }


    public function be_events_callback() {

        $post_type = 'events';
        $taxonomy = 'event-categories';


        // Define our sort parameters
        $sort = $_POST['sort'];
        switch ($sort) {
            case "most-recent":
                $orderby = 'date';
                $order   = 'DESC';
                break;
              case "title-a-z":
                $orderby = 'title';
                $order   = 'ASC';
                break;
              case "title-z-a":
                $orderby = 'title';
                $order   = 'DESC';
                break;
              default:
              $orderby = 'date';
              $order   = 'DESC';
          }

        // An array of checkbox values
        $data = $_POST['be_categories'];

        $has_attribute_data = false;

        // Build our tax query based on the checkbox values
        foreach($data as $data_key => $data_val) {
         if ($data_val !== '') // Check for empty strings
             $has_attribute_data = true;
         }

        $tax_query = array( 'relation' => 'OR' );   
 
         if($has_attribute_data) {     
             foreach($data as $pa => $pt){
                 if(!empty($pt)){
                     $tax_query[] = array( 
                         'taxonomy' => $taxonomy, 
                         'terms'    => $pt, 
                         'field'    => 'slug',
                         );
                 }            
             }
         }

          // Set default paged number
          $paged = ( $_POST['page'] ) ? $_POST['page'] : 1;

          // Check if we are using a mobile
          if ( wp_is_mobile() ){
            $posts_per_page = 2;
          } else {
            $posts_per_page = 9;
          }
         
          // If is search
          if(isset($_POST['keyword'])){

            $args = array(
                'posts_per_page' => $posts_per_page, 
                's' => esc_attr( $_POST['keyword'] ), 
                'post_type' => $post_type, 
                'post_status' => 'publish',
                'orderby' => $orderby,
                'order'	=> $order,
                'paged' => $paged,
                'tax_query' => $tax_query,
            );

         } else { // if not search
 
          $args = array(
            'posts_per_page' => $posts_per_page, 
            's' => esc_attr( $_POST['keyword'] ), 
            'post_type' => $post_type, 
            'post_status' => 'publish',
            'orderby' => $orderby,
            'order'	=> $order,
            'paged' => $paged,
            'tax_query' => $tax_query,
        );
        }



          $query = new \WP_Query( $args );
 
          if( $query->have_posts() ) :
 
             echo '<div class="dpuk-events-loop">';
              while( $query->have_posts() ): $query->the_post();
 
              $id = get_the_ID();
              $title = get_the_title( $id );
              $link_title = __( 'View Events', 'dpuk-ajax' ); 
              $img_size = 'full'; //'resource-card';
              $ft_image = get_the_post_thumbnail( $id, $img_size );
              //$ft_image = get_the_post_thumbnail_url( $id );
              $length = 30;
              $strip_html = true;

              if ( ! empty( get_field('golbal_event_button_text', 'option') ) ) {
                $link_title = get_field('golbal_event_button_text', 'option');
              } else {
                $link_title = __( 'View Event', 'dpuk-ajax' ); 
              }


              if( has_excerpt() ){
                $excerpt = get_the_excerpt();
              } else {
                $excerpt = $this->get_the_excerpt_by_id($id, $length, $strip_html);
              }


              $event_external_link = get_post_meta( get_the_ID(), 'event_external_link', true );

                if ( ! empty( $event_external_link ) ) {
                    $url = $event_external_link;
                } else {
                    $url = get_permalink( $id );
                }

      
              $event_feature  =  get_post_meta( get_the_ID(), 'dpuk_event_feature', true );
              $event_date     = date("F j, Y", strtotime(get_post_meta( get_the_ID(), 'dpuk_event_date', true )));
              $event_time     = date("g:i A", strtotime(get_post_meta( get_the_ID(), 'dpuk_event_time', true )));
              $event_location = get_post_meta( get_the_ID(), 'dpuk_event_location', true );
              

              echo '<div class="event-card-container">';
              echo '<div class="event-card-inner">';

              echo '<div class="event-card-left">';
              echo '<div class="card__image">'.$ft_image.'</div>';
              //echo '<div class="card__image" style="background-image: url(\''.$ft_image.'\');"></div>';

              echo '<div class="event-card-highlights">';

              $output = '';

              if ( ! empty( $event_feature ) ) {
                echo '<div class="dpuk-events-detail">';
                echo '<span class="event-icon"><img src="'.AC_URL.'assets/images/icons/star.png'.'" alt="Event feature" title="Event feature"></span>';
                echo '<span class="event-feature">'.$event_feature.'</span>';
                echo '</div>';
              }
              if ( ! empty( $event_date ) ) {
                echo '<div class="dpuk-events-detail">';
                echo '<span class="event-icon"><img src="'.AC_URL.'assets/images/icons/date.png'.'" alt="Event date" title="Event date"></span>';
                echo '<span class="event-date">'.$event_date.'</span>';
                echo '</div>';
              }
              if ( ! empty( $event_time ) ) {
                echo '<div class="dpuk-events-detail">';
                echo '<span class="event-icon"><img src="'.AC_URL.'assets/images/icons/time.png'.'" alt="Event time" title="Event time"></span>';
                echo '<span class="event-time">'.$event_time.'</span>';
                echo '</div>';
              }
              if ( ! empty($event_location ) ) {
                echo '<div class="dpuk-events-detail">';
                echo '<span class="event-icon"><img src="'.AC_URL.'assets/images/icons/location.png'.'" alt="Event location" title="Event location"></span>';
                echo '<span class="event-location">'.$event_location .'</span>';
                echo '</div>';
              }
  
              echo '</div>';
              echo '</div>';

              echo '<div class="event-card-right">';
              echo '<div class="card__content">';
              echo '<div class="card__title"><h4>'.$title.'</h4></div>';
              echo '<div class="card__link_cta"><a href="'.esc_url( $url ).'" tabindex="0" title="link to '.esc_html( $title ).'" target="_self">'.$link_title.'<i class="fa-arrow-right fas" aria-hidden="true"></i></a></div>';
              echo '<div class="card__excerpt">'.$excerpt.'</div>';
              echo '</div>';
              echo '</div>';


              echo '</div>';
              echo '</div>';
   

 
              endwhile;
              echo '</div>';
              echo '<div class="pagination">';
             echo paginate_links( array(
             'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
             'total'        => $query->max_num_pages,
             'current'      => max( 1, $paged ),
             'format'       => '?paged=%#%',
             'show_all'     => false,
             'type'         => 'plain',
             'end_size'     => 2,
             'mid_size'     => 1,
             'prev_next'    => true,
            //  'prev_text'    => sprintf( '<i></i> %1$s', __( '&lt;', 'dpuk-ajax' ) ),
            //  'next_text'    => sprintf( '%1$s <i></i>', __( '&gt;', 'dpuk-ajax' ) ),
             'prev_text'    => '<span><img src="'.AC_URL.'assets\images\icons\left.png'.'" alt="Placholder Image" title="Placholder Image"></span>',
             'next_text'    => '<span><img src="'.AC_URL.'assets\images\icons\right.png'.'" alt="Placholder Image" title="Placholder Image"></span>',
             'add_args'     => false,
             'add_fragment' => '',
         ) );
             echo '</div>';
 
              wp_reset_postdata();
          else :
              echo 'No posts found';
          endif;
 
        wp_die(); // required to terminate the call so, otherwise wordpress initiates the termination and outputs weird '0' at the end.
 
    }

}