<?php 
/**
 * Basic Text Area
 *
 * This is a demonstration of a basic textarea field.
 * You can add this to functions.php, a plugin or a
 * custom helper file. 
**/


/**
 * Init META Box
**/

add_action('add_meta_boxes','textarea_meta_box_init');
function textarea_meta_box_init() {

    add_meta_box(
        'textarea-meta',        // $id: Unique Id
        'Meta Box Name Here',   // $title: META Box title
        'textarea_meta_box',    // Callback to function that populates the metabox
        'page',                 // $screen: screens to display on
        'side',                 // $context: position on page, 'normal', 'side' or 'advance'
        'high'                  // $priority: 'high' or 'low'
    );
    // https://developer.wordpress.org/reference/functions/add_meta_box/

}


/**
 * Set Content of META Box
**/
function textarea_meta_box($post) {

    // Current value of the meta box
    $value = get_post_meta(
                $post->ID,      // $post_id
                '_textarea',   // $key: field key
                true            // $single: return single value
             );

    ?>
    <!--
        Any other HTML, labels, instructions etc can go here
    -->
    <textarea name="textarea_type" style="width:100%;"><?php echo $value;?></textarea>
    
    <?php      
    
}



/**
 * Save The Meta Box
**/

add_action('save_post','textarea_save_meta_box'); 
function textarea_save_meta_box($post_id, $post = null) {
    
    if(isset($_POST['textarea_type'])) {

        update_post_meta(
            $post_id,                             // $post_id
            '_textarea',                          // $key: field key
            esc_attr($_POST['textarea_type']));   // $value: value to save

    }
}

?>