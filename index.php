<?php
/*
Plugin Name:  Search Product
Plugin URI:   https://searchproduct.yourstaging.me/
Description:  This plugin is used for search product 
version:6.7
Requires at least: 4.7
Tested up to: 6.7
Stable tag: 4.3
Requires PHP: 7.0
Author:       Swarnatek
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

  
if (!defined('ABSPATH')) {
   die;
}
    
/**************link external file using hok function*****************************/
function add_external_files() {   
    wp_enqueue_script( 'jquery' );    
	wp_enqueue_style( 'frontendsstyle', plugin_dir_url( __FILE__ ) . '/frontend/css/search.css', array(), '6.7', true);
     wp_enqueue_script( 'frontendsscript', plugin_dir_url( __FILE__ ) . '/frontend/js/search.js', array(), '6.7', true);	
}
add_action('wp_enqueue_scripts', 'add_external_files');

/********************End code for link external file using hok function***********************************************/

/* add_action( 'admin_menu', 'register_my_custom_menu_page' );
function register_my_custom_menu_page() {
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( 'Search Filter', 'Search Filter', 'manage_options', 'search-filter', 'create_search_option', 'dashicons-welcome-widgets-menus', 10 );
}
function create_search_option(){
?>
<div class="search_fields">
<form method="post">
<label>Category Title</label>
<input type="checkbox" name="cat_title">Category Title
<input type="checkbox" name="pro_title">Product Title
<input type="checkbox" name="pro_title">Product Image
<input type="submit" name="search_button">
</form>
</div>
<?php
}  */
function add_search_frontend(){
ob_start();
?>
<form method="post">
<input type="text" name="search_field" class="search_input_field">
<input type="hidden" name="site_url_get" value="<?php echo esc_url(site_url());?>" class="site_url_get"> 
</form>
<div  class="search_data_show"></div>
<?php
return ob_get_clean();	  
}
add_shortcode("search_data","add_search_frontend");

add_action( 'wp_ajax_nopriv_get_search_data', 'ajax_search_function' );
add_action( 'wp_ajax_get_search_data', 'ajax_search_function' );

function ajax_search_function(){

if ( isset($_POST['current_val_search']) && wp_verify_nonce( sanitize_key( $_POST['current_val_search']))) {
$search_val =wp_verify_nonce( sanitize_key( $_POST['current_val_search']));
$search_val = wp_unslash( $search_val); 
}
$args1 = array(
    'post_type'      => 'product', //custom post type
    'post_status'    => 'publish',
    's'              => $search_val,
    'posts_per_page' => -1,
);

$output =  new WP_Query( $args1 );
if ( $output->have_posts() ) :
    while ( $output->have_posts() ) : $output->the_post();
       $title_pro = get_the_title();
	   $get_id = get_the_id();
	   ?>
	   <div class="product_loop">
	     <div class="product_title">
		  <a href="<?php echo esc_url(get_the_permalink($get_id));?>"><?php echo esc_html($title_pro);?></a>
		 </div>
	   </div>
	   <?php
    endwhile;
endif;
die();	
}
