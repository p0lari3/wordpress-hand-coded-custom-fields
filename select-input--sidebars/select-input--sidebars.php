<?php 

/**
 * Dropdown Select Input, Populated with registered sidebars
 *
 * This demonstrates how to add a select box to Wordpress
 * which is populated with the currently registered 
 * sidebars
**/


/**
 * Init META box
 */

add_action('add_meta_boxes','sidebar_select_meta_box_init');

function sidebar_select_meta_box_init() {
    
    // Create our custom META box
    add_meta_box(
    	'sidebar-select-meta',				// $id: Unique Id
    	'Sidebar Select', 					// $title: META Box title
    	'sidebar_select_meta_box',			// Callback to function that populates the metabox
    	'page',								// $screen: screens to display on
    	'side',								// $context: position on page, 'normal', 'side' or 'advance'
    	'high'								// $priority: 'high' or 'low'
    ); 	
    
}



/**
 * Set Content of META Box
**/

function sidebar_select_meta_box($post,$box) {
 
    // Retrieve the selected sidebar if already set
    $selectedSidebar = get_post_meta($post->ID,'_selected-sidebar',true);
	
	// Grab an array of all registered sidebars
	$wp_registered_sidebars = $GLOBALS['wp_registered_sidebars'];


	// Echo out a select box. And populate with the content of 
	// the above object. While looping if the saved sidebar 
	// id matches the current option, set it to selected
    ?>
    <p> 
    	<select name="sidebar_product_type" id="sidebar_product_type">
    		<option value=''></option>
		    <?php foreach ( $wp_registered_sidebars as $sidebar ) : ?>
		    	<option value="<?php echo $sidebar['id'];?>" <?php if($selectedSidebar == $sidebar['id']): ?>selected='selected'<?php endif; ?>> 
		    		<?php echo $sidebar['name']; ?>
		    	</option>;
		    <?php endforeach; ?>
		   
    	</select>
    </p>
    <?php
}



/**
 * Save The Meta Box
**/

add_action('save_post','sidebar_save_meta_box'); 
function sidebar_save_meta_box($post_id,$post = null) {
    
    // process form data if $_POST is set
    if(isset($_POST['sidebar_product_type'])) {

        // save the meta box data as post meta using the post ID as a unique prefix
        update_post_meta(
        	$post_id,										// $post_id
        	'_selected-sidebar',							// $key: field key
        	esc_attr($_POST['sidebar_product_type'])		// $value: value to save 
        ); 

    }
}

?>