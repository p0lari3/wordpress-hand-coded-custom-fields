<?php 

/**
 * Dropdown Select Input, Populated with registered menus
 *
 * This demonstrates how to add a select box to Wordpress
 * which is populated with the registered menus
**/


/**
 * Init META box
 */

add_action('add_meta_boxes','menu_select_meta_box_init');
function menu_select_meta_box_init() {
    
    // Create our custom META box
    add_meta_box(
    	'menu-select-meta',				// $id: Unique Id
    	'Menu Select', 					// $title: META Box title
    	'menu_select_meta_box',			// Callback to function that populates the metabox
    	'page',							// $screen: screens to display on
    	'side',							// $context: position on page, 'normal', 'side' or 'advance'
    	'high'							// $priority: 'high' or 'low'
    ); 	
    
}


/**
 * Set Content of META Box
**/

function menu_select_meta_box($post,$box) {

    // Retrieve the selected menu if already set
    $selectedmenu = get_post_meta($post->ID,'_selected-menu',true);
    
    // Grab an array of all registered menus
    
    // Edd's Original Code
    // $wp_registered_menus = get_registered_nav_menus();

    // Updated var by Johny Farrar
    $wp_registered_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );

    // Echo out a select box. When looping through 
    // options. If the saved menu name matches
    // the current option, set it to selected
    ?>
    <p> 

        <select name="menu_product_type" id="menu_product_type">
            <option value=''></option>
            
            <?php foreach ( $wp_registered_menus as $menu ) : ?>

            
                <option value="<?php echo $menu->slug; ?>" <?php echo $selectedmenu == $menu->slug ? "selected='selected'" : ""; ?>> 
            
                    <?php echo $menu->name ?>
            
                </option>;
            
            <?php endforeach; ?>
           
        </select>

    </p>
    <?php
}



/**
 * Save The Meta Box
**/

add_action('save_post','menu_save_meta_box'); 
function menu_save_meta_box($post_id,$post = null) {
    
    if(isset($_POST['menu_product_type'])) {

        update_post_meta($post_id,'_selected-menu',esc_attr($_POST['menu_product_type'])); 

    }
}

?>