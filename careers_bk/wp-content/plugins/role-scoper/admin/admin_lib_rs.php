<?php
if( basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME']) )
	die();
	
/**
 * ScoperAdminLib PHP class for the WordPress plugin Role Scoper
 * scoper_admin_lib.php
 * 
 * @author 		Kevin Behrens
 * @copyright 	Copyright 2009
 * 
 * Used by Role Scoper Plugin as a container for statically-called functions
 * These function can be used during activation, deactivation, or other 
 * scenarios where no Scoper or WP_Scoped_User object exists
 *
 */
class ScoperAdminLib {
	function get_blogrole_users($role_name, $role_type, $cols = COLS_ALL_RS) {
		global $wpdb;
		
		if ( COL_ID_RS == $cols )
			$results = scoper_get_col("SELECT user_id FROM $wpdb->user2role2object_rs WHERE scope = 'blog' AND role_type = '$role_type' AND role_name = '$role_name'");
		else {
			$query = "SELECT r.user_id as ID, u.display_name FROM $wpdb->user2role2object_rs AS r "
					. " INNER JOIN $wpdb->users AS u ON r.user_id = u.ID"
					. " WHERE r.scope = 'blog' AND r.role_type = '$role_type' AND r.role_name = '$role_name'";
					
			$results = scoper_get_results($query);
		}
		
		return $results;
	}
	
	function get_group_members($group_id, $cols = COLS_ALL_RS, $maybe_metagroup = false) {
		global $wpdb;
		
		if ( ! is_array($group_id) ) {
			$cache_flag = 'group_members';
			$cache_id = $group_id;
			$cache = wpp_cache_get($cache_id, $cache_flag);
			$ckey = md5( serialize($cols) . $maybe_metagroup );
	
			if ( isset($cache[$ckey]) )
				return $cache[$ckey];
		}
		
		$group_in = "'" . implode("', '", (array) $group_id) . "'";
		
		if ( COL_ID_RS == $cols ) {
			$query = "SELECT gu.$wpdb->user2group_uid_col 
	              FROM $wpdb->user2group_rs gu
	              WHERE gu.$wpdb->user2group_gid_col IN ($group_in)";
			
	        if ( ! $results = scoper_get_col( $query ) )
	        	$results = array();
	        
		} else {
			$qcols = ( COLS_ID_DISPLAYNAME_RS == $cols ) ? "u.ID, u.display_name" : "u.*";
		
			$query = "SELECT $qcols FROM $wpdb->users AS u"
					. " INNER JOIN $wpdb->user2group_rs AS gu ON gu.$wpdb->user2group_uid_col = u.ID "
					. " AND gu.{$wpdb->user2group_gid_col} IN ($group_in) ORDER BY u.display_name";

			$results = scoper_get_results( $query );
		}
		
		if ( ! $results && $maybe_metagroup ) {
			$meta_id = scoper_get_var("SELECT group_meta_id FROM $wpdb->groups_rs WHERE $wpdb->groups_id_col IN ($group_in)");
			if ( 0 === strpos($meta_id, 'wp_role_') ) {
				$role_name = substr($meta_id, 8);
				$results = ScoperAdminLib::get_blogrole_users($role_name, 'wp', $cols);
			}
		}
		
		if ( ! is_array($group_id) ) {
			$cache[ $ckey ] = $results;
			wpp_cache_set($cache_id, $cache, $cache_flag);
		}
		
		return $results;
	}
	
    // (adapted from WP-Group-Restriction plugin)
    // returns all groups, or all groups the current user can manage
	function get_all_groups( $filtering = UNFILTERED_RS, $cols = COLS_ALL_RS ) {
		if ( $filtering && is_administrator_rs() )
			$filtering = 0;
	
		if ( $filtering ) {
			$cache_flag = 'usergroups';
			
			global $current_user;
			$cache = $current_user->cache_get($cache_flag);
		
		} else {
			$cache_flag = 'all_usergroups';
			$cache_id = 'all';
			$cache = wpp_cache_get($cache_id, $cache_flag);
		}
		
		$ckey = md5( serialize($cols) );
		
		if ( isset($cache[$ckey]) )
			return $cache[$ckey];
		
		global $wpdb, $current_user;
		
		if ( $filtering && ! $current_user->is_administrator ) {
			$join = "LEFT JOIN $wpdb->user2role2object_rs AS uro"
					. " ON uro.obj_or_term_id = {$wpdb->groups_rs}.{$wpdb->groups_id_col}"
					. " AND uro.src_or_tx_name = 'group' AND uro.scope = 'object' ";

			$where = "WHERE uro.user_id = $current_user->ID";
		} else {
			$join = '';
			$where = '';
		}
		
		if ( COL_ID_RS == $cols )
			$query = "SELECT DISTINCT $wpdb->groups_id_col FROM $wpdb->groups_rs $join $where";
		else
			$query = "SELECT DISTINCT $wpdb->groups_id_col AS ID, $wpdb->groups_name_col AS display_name, $wpdb->groups_descript_col as descript, $wpdb->groups_meta_id_col as meta_id"
					. " FROM $wpdb->groups_rs $join $where ORDER BY $wpdb->groups_name_col";
			
		if ( COL_ID_RS == $cols )
			$results = scoper_get_col($query);
		else
			$results = scoper_get_results($query);
			
		$cache[ $ckey ] = $results;
		if ( $filtering )
			$current_user->cache_set($cache, $cache_flag);	
		else
			wpp_cache_set($cache_id, $cache, $cache_flag);
		
		if ( ! $results )
			$results = array();
			
		return $results;
	}
	
	function get_metagroup_name( $meta_id ) {
		global $wp_roles;
		
		if ( 0 === strpos( $meta_id, 'wp_role_' ) ) {
			$role_name = substr($meta_id, strlen('wp_role_') );
			$role_display_name = isset( $wp_roles->role_names[$role_name] ) ? _c($wp_roles->role_names[$role_name]) : $role_name;
	
			return sprintf( _c('[WP %s]|Readers/Contributors/Editors, etc.', 'scoper'), $role_display_name );
		}
	}
	
	function get_metagroup_descript( $meta_id ) {
		if ( 0 === strpos( $meta_id, 'wp_role_' ) ) {
			$role_display_name = ScoperAdminLib::get_metagroup_name( $meta_id );
			$role_display_name = str_replace('[WP ', '', $role_display_name);
			$role_display_name = str_replace(']', '', $role_display_name);
			return sprintf( __( 'All users with the WordPress role of %s', 'scoper'), $role_display_name );
		}
	}
		
	function flush_user_cache( $user_ids ) {
		if ( ! is_array($user_ids) )
			$user_ids = array($user_ids);
		
		scoper_flush_results_cache( ROLE_BASIS_USER, $user_ids );
		scoper_flush_roles_cache( OBJECT_SCOPE, ROLE_BASIS_USER, $user_ids);
		scoper_flush_roles_cache( TERM_SCOPE_RS, ROLE_BASIS_USER, $user_ids);
		scoper_flush_roles_cache( BLOG_SCOPE, ROLE_BASIS_USER, $user_ids);	
	}
	
	function flush_groups_cache_for_user( $user_ids ) {
		if ( ! is_array($user_ids) )
			$user_ids = array($user_ids);
		
		wpp_cache_flush_group( 'group_members' );
		
		foreach ( $user_ids as $user_id )
			wpp_cache_delete($user_id, 'group_membership_for_user');
		
		scoper_flush_results_cache( ROLE_BASIS_USER_AND_GROUPS, $user_ids );
		scoper_flush_roles_cache( OBJECT_SCOPE, ROLE_BASIS_USER_AND_GROUPS, $user_ids);
		scoper_flush_roles_cache( TERM_SCOPE_RS, ROLE_BASIS_USER_AND_GROUPS, $user_ids);
		scoper_flush_roles_cache( BLOG_SCOPE, ROLE_BASIS_USER_AND_GROUPS, $user_ids);	
	}
	
	/**
	 * Adds a user to a group  (adapted from WP-Group-Restriction plugin)
	 * @param int $groupID - Group Identifier
	 * @param int $userID - Identifier of the User to add
	 **/
	function add_group_user($group_id, $user_ids){
		global $wpdb;
		
		if ( ! is_array($user_ids) )
			$user_ids = array($user_ids);
			
		foreach( $user_ids as $user_id ) {
			if ( $already_member = $wpdb->get_col( "SELECT $wpdb->user2group_uid_col FROM $wpdb->user2group_rs WHERE $wpdb->user2group_gid_col = '$group_id' AND $wpdb->user2group_uid_col = '$user_id'" ) )
				continue;

			$insert = "INSERT INTO $wpdb->user2group_rs ($wpdb->user2group_gid_col, $wpdb->user2group_uid_col)"
					. " VALUES ('$group_id','$user_id');";
					
			scoper_query( $insert );
			
			do_action('add_group_user_rs', $group_id, $user_id);	
		}
		
		ScoperAdminLib::flush_groups_cache_for_user( $user_ids );
	}
	
	/** 
	 * Removes a User from a group (adapted from WP-Group-Restriction plugin)
	 *
	 * @param int $group_id - Group Identifier
	 * @param int $user_id - Identifier of the User to remove
	 **/
	function remove_group_user($group_id, $user_ids) {
		global $wpdb;

		if ( ! is_array($user_ids) )
			$user_ids = array($user_ids);
		
		$id_in = "'" . implode("', '", $user_ids) . "'";
		$delete = "DELETE FROM $wpdb->user2group_rs WHERE $wpdb->user2group_gid_col='$group_id' AND $wpdb->user2group_uid_col IN ($id_in)";
		scoper_query( $delete );

		foreach( $user_ids as $user_id )
			do_action('delete_group_user_rs', $group_id, $user_id);	
			
		ScoperAdminLib::flush_groups_cache_for_user( $user_ids );
	}
	
	/**
	 * Removes a User from all groups  (adapted from WP-Group-Restriction plugin)
	 *
	 * @param int $user - User Identifier
	 **/
	function delete_user_from_groups($user_id){
		global $wpdb;

		// possible todo: pre-query user groups so we can do_action delete_group_user_rs
		
		$delete = "DELETE FROM $wpdb->user2group_rs WHERE $wpdb->user2group_uid_col='$user_id';";
		scoper_query( $delete );

		ScoperAdminLib::flush_groups_cache_for_user( $user_id );
	}

	function delete_users($user_ids) {
		global $wpdb;
		
		if ( $user_ids && ( ! is_array($user_ids) ) )
			$user_ids = array($user_ids);
			
		$user_clause = "user_id IN ('" . implode("', '", $user_ids) . "')"; 
		scoper_query("DELETE FROM $wpdb->user2role2object_rs WHERE $user_clause");
		
		foreach ( $user_ids as $user_id ) {
			ScoperAdminLib::delete_user_from_groups($user_id);
			ScoperAdminLib::flush_user_cache( $user_id );
		}
	}

	function clear_roles( $scope, $src_or_tx_name, $obj_or_term_id, $args = '' ) {
		$defaults = array ( 'inherited_only' => false, 'clear_propagated' => false );
		$args = array_merge( $defaults, (array) $args );
		extract($args);
		
		global $wpdb;
		
		$inherited_clause = ( $inherited_only ) ? "AND inherited_from > 0" : '';

		$qry = "SELECT assignment_id FROM $wpdb->user2role2object_rs WHERE scope = '$scope' AND src_or_tx_name = '$src_or_tx_name' $inherited_clause AND obj_or_term_id = '$obj_or_term_id'";
		$assignment_ids = scoper_get_col( $qry );
		
		if ( $assignment_ids ) {
			$qry = "DELETE FROM $wpdb->user2role2object_rs WHERE assignment_id IN ('" . implode( "', '", $assignment_ids) . "')";
			
			if ( $clear_propagated )
				$qry .= " OR inherited_from IN ('" . implode( "', '", $assignment_ids) . "') ";
			
			scoper_query( $qry );
		}
	}
	
	function clear_restrictions ( $scope, $src_or_tx_name, $obj_or_term_id, $args = '' ) {
		$defaults = array ( 'inherited_only' => false, 'clear_propagated' => false );
		$args = array_merge( $defaults, (array) $args );
		extract($args);	
	
		global $wpdb;

		$inherited_clause = ( $inherited_only ) ? "AND inherited_from > 0" : '';
		
		$qry = "SELECT requirement_id FROM $wpdb->role_scope_rs WHERE topic = '$scope' AND src_or_tx_name = '$src_or_tx_name' $inherited_clause AND obj_or_term_id = '$obj_or_term_id'";
		$req_ids = scoper_get_col( $qry );

		if ( $req_ids ) {
			$qry = "DELETE FROM $wpdb->role_scope_rs WHERE requirement_id IN ('" . implode( "', '", $req_ids) . "')";
			
			if ( $clear_propagated )
				$qry .= " OR inherited_from IN ('" . implode( "', '", $req_ids) . "') ";
				
			scoper_query( $qry );
		}
	}
	
	function any_custom_caps_assigned() {
		global $wpdb;
		
		$got_any = scoper_get_var("SELECT assignment_id FROM $wpdb->user2role2object_rs WHERE scope = 'blog' AND role_type = 'wp_cap' LIMIT 1");
		return ( $got_any );
	}
	
	// This is currently only used following WP core deletion to delete ALL role assignments for specified rolename and type
	// In the future, additional args could be handled for selective assignment deletions
	function delete_role($role_name, $role_type = 'rs') {
		global $wpdb;
		scoper_query("DELETE FROM $wpdb->user2role2object_rs WHERE role_type = '$role_type' AND role_name = '$role_name'");
		
		wpp_cache_flush();
	
		$hook = "update_option_{$wpdb->prefix}user_roles";
		// Role Manager doesn't actually rename the role until after the referer check, so defer our maintenance operation
		add_action( $hook, array('ScoperAdminLib', 'sync_all_wproles'), 99 );
	}

	function rename_role($role_name_old, $role_type = 'rs') {
		$role_name_new = $_POST['role-name'];
		if ( ! $role_name_old )
			return;

		wpp_cache_flush();

		global $wpdb;
		scoper_query("UPDATE $wpdb->user2role2object_rs SET role_name = '$role_name_new' WHERE role_type = '$role_type' AND role_name = '$role_name_old'");

		$hook = "update_option_{$wpdb->prefix}user_roles";
		// Role Manager doesn't actually rename the role until after the referer check, so defer our maintenance operation
		add_action( $hook, array('ScoperAdminLib', 'sync_all_wproles'), 99 );
	}

	function sync_wproles($user_ids = '') {
		require_once('update_rs.php');
		scoper_sync_wproles($user_ids);
	} // end sync_wproles function
	
	// simplifies attaching this function to hook which pass irrelevant argument
	function sync_all_wproles() {
		ScoperAdminLib::sync_wproles();
	} // end sync_wproles function
	
} // end ScoperAdmin class
?>