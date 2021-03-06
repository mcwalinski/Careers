<?php

if( basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME']) )
	die();

if ( DEFINE_GROUPS_RS && ( awp_ver('2.8') || defined('scoper_users_custom_column') ) ) {
	add_filter('manage_users_columns', array('ScoperAdminUsers', 'flt_users_columns'));
	add_action('manage_users_custom_column', array('ScoperAdminUsers', 'flt_users_custom_column'), 10, 3);
}

// abuse referer check to detect Role Manager operations (need to do this even if queryfilters are disabled for wp-admin)
add_action('check_admin_referer', array('ScoperAdminUsers', 'act_rolemanager_referer'));

class ScoperAdminUsers {

	function flt_users_columns($defaults) {
		$defaults['rs_groups'] = __('Groups', 'scoper');
		return $defaults;
	}

	function flt_users_custom_column($content = '', $column_name, $id) {
		if ( 'rs_groups' == $column_name ) {
			global $scoper;
			static $all_groups;
			
			if ( ! isset($all_groups) )
				$all_groups = ScoperAdminLib::get_all_groups();

			if ( empty($all_groups) )
				return;

			if ( $group_ids = WP_Scoped_User::get_groups_for_user($id) ) {

				$group_names = array();
				foreach ( array_keys($group_ids) as $group_id ) {
					foreach ( $all_groups as $group ) {
						if ( $group_id == $group->ID ) {
							$group_names [$group->display_name] = $group_id;
							break;
						}
					}
				}
				
				if ( $group_names ) {
					uksort($group_names, "strnatcasecmp");

					foreach( $group_names as $name => $id )
						$group_names[$name] = "<a href='" . SCOPER_ADMIN_URL . "/groups.php&mode=edit&id=$id'>$name</a>";

					return implode(", ", $group_names);
				}
			}
		}
	}
	
	function act_rolemanager_referer($action) {
		// Role Manager referers
		if ( strpos($action, 'rolemanager') ) { // don't search for 1st char or strpos will return zero
			// Role Manager plugin renamed a WP role
			if ( $pos = strpos($action, 'rename_role_') ) {
				if ( ! strpos($action, 'rename_role_form') ) {
					$role_name = substr($action, $pos + strlen('rename_role_') );
					ScoperAdminLib::rename_role($role_name, 'wp');
				}
				
			// Role Manager plugin deleted a WP role
			} elseif ( $pos = strpos($action, 'delete_role_') ) {
				if ( ! strpos($action, 'delete_role_form') ) {
					$role_name = substr($action, $pos + strlen('delete_role_') );
					ScoperAdminLib::delete_role($role_name, 'wp');
				}
			
			// Role Manager copied a WP role.  Resynchronize to include it in our WP metagroups checklist.
			} elseif ( ( strpos($action, 'copy_role_') || strpos($action, 'create_new_role') ) ) {
				if ( ! strpos($action, 'copy_role_form') && ! strpos($action, 'create_new_role_form') ) {
					global $wpdb;
					$hook = "update_option_{$wpdb->prefix}user_roles";
					// Role Manager doesn't actually create / copy the role until after the referer check, so defer our maintenance operation
					add_action( $hook, array('ScoperAdminLib', 'sync_all_wproles'), 99 );
				}
			}
		}
	}
} // end class
?>