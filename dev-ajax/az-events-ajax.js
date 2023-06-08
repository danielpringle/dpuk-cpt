jQuery(function($){

    /**
     * Collects all the values of checked checkboxes
     * Stores the values in an array
     * @returns array of checkbox values.
     */
    function get_cats() {

        var checkboxes = document.getElementsByName('cats');
        var checkboxesChecked = [];
        // loop over them all
        for (var i=0; i<checkboxes.length; i++) {
           // And stick the checked ones onto an array...
           if (checkboxes[i].checked) {
              checkboxesChecked.push(checkboxes[i].value);
           }
        }
        // Return the array if it is non-empty, or null
        return checkboxesChecked.length > 0 ? checkboxesChecked : null;

    }


    /**
     * Runs are AJAX call
     * @param {*} be_cats 
     * @param {*} page 
     */
    function run_ajax(be_cats, page = 1) {

        console.log(be_cats);
        $.ajax({
            url: dpuk_fetch_events.ajaxurl,
            type: 'post',
            data: { action: 'dpuk_fetch_events', 
                    be_categories: be_cats,
                    page: page,
                    sort: jQuery('#dpuk-events-sort-filter option:selected').val(),
                    keyword: jQuery('#dpuk-ajax-search').val(),
                    },
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#loader').removeClass('hidden')
            },
            success: function( data ) {
                //console.log(data);
                $('#dpuk-ajax-display-posts').html(data); // insert data // insert data
            },
            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                $('#loader').addClass('hidden')
            },
            error : function(error){ console.log(error) }

        })

    }


    /**
     * Pagination event
     */
    let page = 1;

	$(document).on( 'click', '.page-numbers', function( event ) {
 
		event.preventDefault();

        if($(this).closest("a").hasClass('next') ){
            page++;
        } else if ($(this).closest("a").hasClass('prev')){
            page--;
        } else {
            page = $(this).text();
        }

        var be_cats = get_cats();
        run_ajax(be_cats, page);

    });







    /**
     * initial page load
     */
    $(document).ready(function() {
        $.ajax({
            url: dpuk_fetch_events.ajaxurl,
            type: 'post',
            data: {
                action: 'dpuk_fetch_events',
            },
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#loader').removeClass('hidden')
            },
            success: function( data ) {
                console.log('success');
                console.log(data);
                $('#dpuk-ajax-display-posts').html(data); // insert data // insert data
            },
            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                $('#loader').addClass('hidden')
            },
            error : function(error){ console.log(error) 
            }
        })
    });

    
    /**
     * Checkbox Filter event
     */
    $(document).ready(function(){

            var checkboxElems = document.querySelectorAll("input[type='checkbox']");

            for (var i = 0; i < checkboxElems.length; i++) {
                checkboxElems[i].addEventListener("click", function() {
                    
                    var be_cats = get_cats();

                    run_ajax(be_cats)

                  });
            }
    });

    /**
     * Search event
     */
    $(document).ready(function(){

        $( "#dpuk-ajax-search" ).keyup(function() {

            // console.log( "Handler for .keyup() called." );

            var be_cats = get_cats();

            run_ajax(be_cats)

        });

    });


    /**
     * Sort Filter
     */
    $(document).ready(function(){

        $('#dpuk-events-sort-filter').change(function () {
         
            console.log('changed');

            var be_cats = get_cats();

            run_ajax(be_cats)

        });

    });

});