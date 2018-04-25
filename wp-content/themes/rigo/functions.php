<?php

/**
* Autoload for PHP Composer and definition of the ABSPATH
*/

//defining the absolute path for the wordpress instalation.
if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) . '/');

//including composer autoload
require ABSPATH."vendor/autoload.php";

//including the custom post types
require('setup_types.php');

//including the api endpoints
require('setup_api.php');

//including any monolitic tempaltes
require('setup_templates.php');


//need it to add custom changes like feautured images see notes 4/9/18
add_theme_support('post-thumbnails');


function my_acf_add_local_field_groups() {
	
	acf_add_local_field_group(array(
		'key' => 'event_group',
		'title' => 'Event Group',
		'fields' => array (
			array (
				'key' => 'day',
				'label' => 'Day',
				'name' => 'day',
				'type' => 'date_picker',
			),
			array (
				'key' => 'time',
				'label' => 'Time',
				'name' => 'time',
				'type' => 'time_picker',
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'event',
				),
			),
		),
	));
	
}

add_action('acf/init', 'my_acf_add_local_field_groups');



add_action( 'admin_init', 'add_meta_boxes' );
function add_meta_boxes() {
    //Event - Meetup Relationship - WRITE
                    //ID            //LABEL                 //CALLBACK      //SCREEN
    add_meta_box( 'some_metabox', 'meetups Relationship', 'meetup_field', 'event' );
    
    //Meetup - Event Relationship - READ
    add_meta_box( 'list_events', 'List of Events', 'events_list', 'meetup' );
}

function meetup_field() {
    global $post;//Current EVENT
    $selected_meetups = get_post_meta( $post->ID, '_meetup', true );
    //var_dump($selected_meetups);
    $all_meetups = get_posts( array(
        'post_type' => 'meetup',
        'numberposts' => -1,
        'orderby' => 'post_title',
        'order' => 'ASC'
    ) );
    ?>
    <input type="hidden" name="meetups_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
    <table class="form-table">
    <tr valign="top"><th scope="row">
    <label for="meetup">Meetups</label></th>
    <td><select name="meetup">
        <option value="Select One">Select a Meetup</option>
    <?php foreach ( $all_meetups as $meetup ) : ?>
        <option value="<?php echo $meetup->ID; ?>"<?php echo $meetup->ID === intval($selected_meetups) ? ' selected="selected"' : ''; ?> ><?php echo $meetup->post_title; ?></option>
    <?php endforeach; ?>
    </select></td></tr>
    </table>
<?php
}

add_action( 'save_post', 'save_meetup_field' );
function save_meetup_field( $post_id ) {
    
    
    // only run this for series
    if ( 'event' != get_post_type( $post_id ) )
        return $post_id;        

    // verify nonce
    if ( empty( $_POST['meetups_nonce'] ) || !wp_verify_nonce( $_POST['meetups_nonce'], basename( __FILE__ ) ) )
        return $post_id;


    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    // check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;

    
    // save
    update_post_meta( $post_id, '_meetup', $_POST['meetup'] );

}

function events_list(){
    global $post;
    
    $args = array(
           'post_type' => 'event',
           'meta_key' => '_meetup',
           'meta_value' => $post->ID,
           'compare' => '='
    );
    $the_query = new WP_Query($args);
    //var_dump($query);
    if ( $the_query->have_posts() ) {
    	echo '<ul>';
    	while ( $the_query->have_posts() ) {
    		$the_query->the_post();
    		echo '<li>' . get_the_title() . '</li>';
    	}
    	echo '</ul>';
    	/* Restore original Post Data */
    	wp_reset_postdata();
    } else {
    	// no posts found
    	echo 'No Events';
    }
} 