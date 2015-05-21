<?php
/*
Plugin Name: Halal-List
Plugin URI: http://www.hidayathalim.com/blog
Description: Listing halal restaurants
Version: 1.0
Author: Hidayat Halim
Author URI: http://hidayathalim.com
License: GPL
*/

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'halal_list_initiate');

// /* Runs on plugin deactivation*/
// register_deactivation_hook( __FILE__, 'halal_list_remove' );

function halal_list_initiate() {
	/* Creates new database table */
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	
	$table_name = $wpdb->prefix . 'halalList_data';

	$sql = "CREATE TABLE $table_name (
			RestaurantName varchar(255),
			Address varchar(255),
			HalalStatus varchar(255),
			MeatSource varchar(255),
			AlcoholFreeStatus varchar(255),
			PorkFreeStatus varchar(255),
			SeparateKitchenStatus varchar(255)
			) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

// function halal_list_remove() {
// // Deletes the database field 
// }

if ( is_admin() ){
    /* Call the html code */
    add_action('admin_menu', 'halal_list_admin_menu');
    function halal_list_admin_menu() {
        add_options_page('Halal List', 'Halal List', 'administrator', 'halal-list', 'halal_list_html_page');
    }
}

function halal_list_html_page() {

	global $wpdb;

	if ( isset($_POST['page-action']) ){
		// // are they allowed to do that?
		// if (function_exists('current_user_can') && !current_user_can('manage_options'))
		// 	die(__('Cheatin’ uh?'));

		// check the nonce
		check_admin_referer('wplinkdir-nonce-update-halal-list');

		// do your update stuff here
		$table_name = $wpdb->prefix . 'halalList_data';

		$name = $_POST['restaurant_name'];
		$address = $_POST['restaurant_address'];
		$halal_status = $_POST['halal_status'];
		$meat_source = $_POST['meat_source'];
		$alcohol_free = $_POST['alcohol_free_status'];
		$pork_free = $_POST['pork_free_status'];
		$separate_kitchen = $_POST['separate_kitchen_status'];

		$wpdb->insert(
			$table_name,
			array(
				'RestaurantName' => $name,
				'Address' => $address,
				'HalalStatus' => $halal_status,
				'MeatSource' => $meat_source,
				'AlcoholFreeStatus' => $alcohol_free,
				'PorkFreeStatus' => $pork_free,
				'SeparateKitchenStatus' => $separate_kitchen
			)
		);
	}
?>

<div>
<h2>Halal List Options</h2>

<form method="post" action="" onsubmit="return validateHalalListForm();" name="halalListForm">
<?php wp_nonce_field('wplinkdir-nonce-update-halal-list'); ?>

	<table width="650">
		<tr valign="top">
			<th width="150" scope="row">Restaurant Name</th>
			<td width="500">
				<input name="restaurant_name" type="text" id="restaurant_name_id" />
			</td>
		</tr>
		<tr valign="top">
			<th width="150" scope="row">Restaurant Address</th>
			<td width="500">
				<input name="restaurant_address" type="text" id="restaurant_address_id" />
			</td>
		</tr>
		<tr valign="top">
			<th width="150" scope="row">Halal Status</th>
			<td width="500">
                <select id="selectHalal" onchange="jQuery('#halal_status_id').val(jQuery('#selectHalal option:selected').text())">
                    <option value="Halal">Halal</option>
                    <option value="Non-Halal">Non-Halal</option>
                </select>
				<input name="halal_status" type="hidden" id="halal_status_id" value="Halal"/>
			</td>
		</tr>
		<tr valign="top">
			<th width="150" scope="row">Meat Source</th>
			<td width="500">
				<input name="meat_source" type="text" id="meat_source_id" />
			</td>
		</tr>
		<tr valign="top">
			<th width="150" scope="row">Alcohol Free Status</th>
			<td width="500">
                <select id="selectAlcoholStatus" onchange="jQuery('#alcohol_free_status_id').val(jQuery('#selectAlcoholStatus option:selected').text())">
                    <option value="Alcohol free">Alcohol free</option>
                    <option value="Alcohol served">Alcohol served</option>
                </select>
				<input name="alcohol_free_status" type="hidden" id="alcohol_free_status_id" value="Alcohol free"/>
			</td>
		</tr>
		<tr valign="top">
			<th width="150" scope="row">Pork Free Status</th>
			<td width="500">
                <select id="selectPorkFreeStatus" onchange="jQuery('#pork_free_status_id').val(jQuery('#selectPorkFreeStatus option:selected').text())">
                    <option value="Pork free">Pork free</option>
                    <option value="Pork served">Pork served</option>
                </select>
				<input name="pork_free_status" type="hidden" id="pork_free_status_id" value="Pork free"/>
			</td>
		</tr>
		<tr valign="top">
			<th width="150" scope="row">Separate Kitchen Status</th>
			<td width="500">
                <select id="selectSeparateKitchenStatus" onchange="jQuery('#separate_kitchen_status_id').val(jQuery('#selectSeparateKitchenStatus option:selected').text())">
                    <option value="Separated kitchen">Separated kitchen</option>
                    <option value="Nonseparated kitchen">Nonseparated kitchen</option>
                </select>
				<input name="separate_kitchen_status" type="hidden" id="separate_kitchen_status_id" value="Separated kitchen"/>
			</td>
		</tr>
	</table>

	<input type="hidden" name="page-action" value="update" />

	<p>
	<input type="submit" value="<?php _e('Save Changes') ?>" />
	</p>

</form>
</div>
    <script>
        function validateHalalListForm() {
            if (document.forms["halalListForm"]["restaurant_name"].value == null || document.forms["halalListForm"]["restaurant_name"].value == "") {
                alert("Restaurant name must be filled out!");
                return false;
            }else if (document.forms["halalListForm"]["restaurant_address"].value == null || document.forms["halalListForm"]["restaurant_address"].value == "") {
                alert("Restaurant address must be filled out!");
                return false;
            }else if (document.forms["halalListForm"]["halal_status"].value == null || document.forms["halalListForm"]["halal_status"].value == "") {
                alert("Halal status must be filled out!");
                return false;
            }else if (document.forms["halalListForm"]["meat_source"].value == null || document.forms["halalListForm"]["meat_source"].value == "") {
                alert("Meat source must be filled out!");
                return false;
            }else if (document.forms["halalListForm"]["alcohol_free_status"].value == null || document.forms["halalListForm"]["alcohol_free_status"].value == "") {
                alert("Alcohol free status must be filled out!");
                return false;
            }else if (document.forms["halalListForm"]["pork_free_status"].value == null || document.forms["halalListForm"]["pork_free_status"].value == "") {
                alert("Pork free status must be filled out!");
                return false;
            }else if (document.forms["halalListForm"]["separate_kitchen_status"].value == null || document.forms["halalListForm"]["separate_kitchen_status"].value == "") {
                alert("Separate kitchen status must be filled out!");
                return false;
            }
        }
    </script>
<?php
}
?>