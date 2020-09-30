(function($){

    /*
    *  acf/setup_fields (ACF4)
    *
    *  This event is triggered when ACF adds any new elements to the DOM.
    *
    *  @type	function
    *  @since	1.0.0
    *  @date	01/01/12
    *
    *  @param	event		e: an event object. This can be ignored
    *  @param	Element		postbox: An element which contains the new HTML
    *
    *  @return	n/a
    */
    acf.add_action('ready append', function( $el ){

        // search $el for fields of type 'oauth'
        acf.get_fields({ type : 'message'}, $el).each(function(){

            initialize_field( $(this) );

        });

    });



    
    function initialize_field( $el ) {

        $el.find('#acf__youtube-oauth').on( 'click', function(){
            oauth_do_request();
        });

        $el.find('#acf__youtube-oauth--delete').on( 'click', function(){
            delete_transient_tokens();   
            $(this).closest('.enabled').siblings().removeClass('enabled');
        });
        
    }


    /**
     * Send the user to a new window that
     * will have the authorisation URL open up in it.
     * 
     * ajax_object.auth_url contains the URL from PHP.
     */
    function oauth_do_request() {
        var win = window.open( youtube_ajax_object.auth_url, "_blank", "width=600,height=600" );
    }



    
    /**
     * Run AJAX request onto the delete_youtube_oauth_transients endpoint
     * 
     * This will clear out all transient tokens for YouTube OAuth.
     */
    function delete_transient_tokens() {

        $.ajax({

            type : "post",

            dataType : "json",

            url : youtube_ajax_object.ajax_url,

            data : { action: "delete_youtube_oauth_transients" },

            success: function(response) {
                if(response.success == true) {
                    alert(response.data);
                }
                else {
                    console.log(response);
                    alert("Error. See console.log for response.");
                }
            }
        }) 
    }
    


})(jQuery);