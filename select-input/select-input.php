<?php 

/**
 * Dropdown Select Input
 *
 * This is a demonstration of a basic dropdown select input.
 * You can add this to functions.php, a plugin or a custom 
 * helper file.
**/


/**
 * Init META box
 */

add_action('add_meta_boxes','select_meta_box_init');
function select_meta_box_init() {
    
    // Create our custom META box
    add_meta_box(
        'select-meta',      // $id: Unique Id
        'Custom Select',    // $title: META Box title
        'select_meta_box',  // Callback to function that populates the metabox
        'page',             // $screen: screens to display on
        'side',             // $context: position on page, 'normal', 'side' or 'advance'
        'high'              // $priority: 'high' or 'low'
    );  

    // https://developer.wordpress.org/reference/functions/add_meta_box/

}



/**
 * Set Content of META Box
**/

function select_meta_box($post,$box) {
 

    // Retrieve the current value if it exists
    $currentlySavedValue = get_post_meta(
                            $post->ID,          // $post_id
                            '_select-value',    // $key: field key
                            true                // $single: return single value
                        );


    // Create an object of all potential values
    $select_values = [
        "brap",
        "dong", 
        "yeha"
    ];

    // Echo out a select box. Then loop through the values
    // of the above object in order to populate it. When 
    // looping through options, If the saved value
    // matches the current option, set it to 
    // selected

    ?>

    <!--
        Any other HTML, labels, instructions etc can go here
    -->

    <p> 
        <select name="select_input" id="select_input">
            <option value=''></option>
            <?php foreach ( $select_values as $value ) : ?>
                <option value="<?php echo $value;?>" <?php if($currentlySavedValue == $value): ?>selected='selected'<?php endif; ?>> 
                    <?php echo $value; ?>
                </option>;
            <?php endforeach; ?>
           
        </select>
    </p>
    <?php
}



/**
 * Save The Meta Box
**/

add_action('save_post','select_save_meta_box'); 
function select_save_meta_box($post_id,$post = null) {
    
    if(isset($_POST['select_input'])) {

        update_post_meta(
        	$post_id, 							// $post_id
        	'_select-value',					// $key: field key
        	esc_attr($_POST['select_input'])	// $value: value to save
        ); 

    }

}


?>