<?php

/**
 * Datepicker Example
 *
 * This is a demonstration of how to add a datepicker
 * custom field. 
 * 
 * Although HTML5 gives the "date" input type, it is
 * still not supported fully cross browser. As such
 * this example uses Pikaday. 
 * https://github.com/dbushell/Pikaday
 *
 * JS has been minified, CSS has been left verbose for
 * easy editing.
 *
 * You should add this to a plugin. You will need
 * to include the CSS & JS also. 
**/



/**
 * Enque required CSS & Javascript in WP Admin Area
**/
    
add_action( 'admin_enqueue_scripts', 'add_pickaday_dependencies' );
function add_pickaday_dependencies() {
	wp_enqueue_style( 'pikaday-css', plugins_url('pikaday.css', __FILE__) );
	wp_enqueue_script( 'pikaday-js', plugins_url('pikaday.js', __FILE__) );
}



/**
 * Init META Box
**/

add_action('add_meta_boxes','datepicker_meta_box_init');
function datepicker_meta_box_init() {

    add_meta_box(
        'datepicker-meta',      // $id: Unique Id
        'Date Picker',   		// $title: META Box title
        'datepicker_meta_box',  // Callback to function that populates the metabox
        'page',                 // $screen: screens to display on
        'side',                 // $context: position on page, 'normal', 'side' or 'advance'
        'high'                  // $priority: 'high' or 'low'
    );
    // https://developer.wordpress.org/reference/functions/add_meta_box/

}


/**
 * Set Content of META Box
**/
function datepicker_meta_box($post) {

    // Current value of the meta box
    $value = get_post_meta(
                $post->ID,      // $post_id
                '_datepicker',   // $key: field key
                true            // $single: return single value
             );

    ?>
    <!--
        Any other HTML, labels, instructions etc can go here
    -->

    <input id="datepicker" type="text" name="datepicker_type" value="<?php echo $value;?>" />

    <script>
    /**
     * Pickaday Settings set here
     **/
    var picker = new Pikaday(
    {
        field: document.getElementById('datepicker'),
        firstDay: 1,
        minDate: new Date(2000, 0, 1),
        maxDate: new Date(2020, 12, 31),
        yearRange: [2000,2020]
    });
    </script>
    <?php      
   
}



/**
 * Save The Meta Box
**/

add_action('save_post','datepicker_save_meta_box'); 
function datepicker_save_meta_box($post_id, $post = null) {
    
    if(isset($_POST['datepicker_type'])) {

        update_post_meta(
            $post_id,                               // $post_id
            '_datepicker',                           // $key: field key
            esc_attr($_POST['datepicker_type']));   // $value: value to save

    }
}

?>