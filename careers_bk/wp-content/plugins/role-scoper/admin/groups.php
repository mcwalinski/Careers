<?php
if( basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME']) )
	die( 'This page cannot be called directly.' );
	
/* this file adapted from:
 Group Restriction plugin
 http://code.google.com/p/wp-group-restriction/
 Tiago Pocinho, Siemens Networks, S.A.
 */

/*************************************************************
 * This File loads the "Groups -> Groups" Tab
 * It allows to manage Groups by editing, adding or deleting
 ************************************************************/

require_once('groups-support.php');

global $wpdb;

$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';
$cancel = isset($_REQUEST['cancel']) ? $_REQUEST['cancel'] : '';

$success_msg = '';
$errorMessage = "";
$suppress_groups_list = false;

switch ($mode) {
	case "add":
		if( ! is_administrator_rs() && ! current_user_can('manage_groups') )
			wp_die(__('Cheatin&#8217; uh?'));
	
		check_admin_referer( 'scoper-edit-groups' );
		
		if ( ! empty($_POST['groupName']) ) {
			$_POST['groupName'] = str_replace( '[', '', $_POST['groupName'] );
			$_POST['groupName'] = str_replace( ']', '', $_POST['groupName'] );
		}
			
		if( ! UserGroups_tp::isValidName($_POST['groupName'])) {
			if($_POST['groupName'] == "")
				$errorMessage = __("Please specify a name for the group.", 'scoper');
			else
				$errorMessage = sprintf( __("A group with the name <b>%s</b> already exists.", 'scoper'), $_POST['groupName']);
		} else {
			if( UserGroups_tp::createGroup ($_POST['groupName'], $_POST['groupDesc'])){
				$success_msg = sprintf( __("Group <b>%s</b> created successfuly.", 'scoper'), $_POST['groupName']);
				
				$group = UserGroups_tp::getGroupByName($_POST['groupName']);
			}
		}
		//$suppress_groups_list = true;
		break;
		
	case "edit":
		$id = $_REQUEST['id'];
		
		if( ! is_administrator_rs() && ! current_user_can('manage_groups', $id) )
			wp_die(__('Cheatin&#8217; uh?'));
		
		$group = UserGroups_tp::getGroup($id);
		
		if ( $group->meta_id )
			die( __('This meta group is automatically populated. You cannot manually edit it.', 'scoper') );
			
		$group->prev_name = $group->display_name;
		$suppress_groups_list = true;
		break;
		
	case "editSubmit":
		if ( ! empty($_POST['groupName']) ) {
			$_POST['groupName'] = str_replace( '[', '', $_POST['groupName'] );
			$_POST['groupName'] = str_replace( ']', '', $_POST['groupName'] );
		}
	
		//to continue edit
		$group->display_name = $_POST['groupName'];
		$group->prev_name = $_POST['prevName'];
		$group->ID = $_POST['groupID'];
		$group->descript = $_POST['groupDesc'];
		
		if( ! is_administrator_rs() && ! current_user_can('manage_groups', $group->ID) )
			wp_die(__('Cheatin&#8217; uh?'));
		
		check_admin_referer( 'scoper-edit-group_' . $group->ID );
			
		if(! UserGroups_tp::isValidName($_POST['groupName']) && $_POST['groupName'] != $_POST['prevName']){
			if($_POST['groupName'] == ""){
				$errorMessage = __("Please specify a name for the group.", 'scoper');
				$mode = "edit";
			} else {
				$errorMessage = sprintf( __("A group with the name <b>%s</b> already exists.", 'scoper'), $_POST['groupName']);
				$mode = "edit";
			}
		} else {
			if ( UserGroups_tp::updateGroup ($_POST['groupID'], $_POST['groupName'], $_POST['groupDesc']) ) {
				$success_msg = sprintf( __("Group <b>%s</b> updated successfuly.", 'scoper'), $_POST['groupName']);
			} else {
				$errorMessage = sprintf( __("Group <b>%s</b> was not updated successfuly.", 'scoper'), $_POST['prevName']);
				$mode = "edit";
			}
		}
		break;
		
	case "delete":
		$idDel = $_REQUEST['id'];
		if($idDel != ""){
			if( ! is_administrator_rs() && ! current_user_can('manage_groups', $idDel) )
				wp_die(__('Cheatin&#8217; uh?'));
		
			check_admin_referer( 'scoper-edit-group_' . $idDel );
				
			if(UserGroups_tp::deleteGroup($idDel)){
				UserGroups_tp::write( __("Group Deleted.", 'scoper') );
			}else{
				UserGroups_tp::write( __("Invalid group. No groups were deleted.", 'scoper'), false);
			}
			$_REQUEST['id'] = "";
		}
		break;
		
	default:
		switch($cancel){
			case 1:
				UserGroups_tp::write( __("Group edit canceled.", 'scoper') );
				break;
			default:
				break;
		}
		break;
}

if ( ! $errorMessage && ( ('editSubmit' == $mode) || ('add' == $mode) ) ) {
	// -----  add/delete group members or managers ----
	$current_members = ScoperAdminLib::get_group_members($group->ID, COL_ID_RS);
	

	// members
	$posted_members = ( isset($_POST['member']) ) ? $_POST['member'] : array();
	if ( $delete_members = array_diff($current_members, $posted_members) ) {
		ScoperAdminLib::remove_group_user($group->ID, $delete_members);
		$success_msg .= ' ' . sprintf( __ngettext('%d member deleted.', '%d members deleted.', count($delete_members), 'scoper'), count($delete_members) ); 
	}
		
	if ( $new_members = array_diff($posted_members, $current_members) ) {
		ScoperAdminLib::add_group_user($group->ID, $new_members);
		$success_msg .= ' ' . sprintf( __ngettext('%d member added.', '%d members added.', count($new_members), 'scoper'), count($new_members) ); 
	}

	
	// administrators
	if ( is_administrator_rs() || current_user_can('manage_groups', $group->ID) ) {
		$managers = ( isset($_POST['manager']) ) ? array( 'rs_group_manager' => array_fill_keys( $_POST['manager'], 'entity' ) ) : '';
		
		if ( $managers ) {
			$role_assigner = init_role_assigner();
			$args = array( 'implicit_removal' => true );
			$role_assigner->assign_roles( OBJECT_SCOPE_RS, 'group', $group->ID, $managers, ROLE_BASIS_USER, $args );
		}
	}
	// -------- end member / manager update ----------

	UserGroups_tp::write( $success_msg );
	
	if ( 'add' == $mode )
		$group = '';
}
?>

<?php if ( ! $suppress_groups_list) :?>
	<div class="wrap">
	<h2><?php _e('User Groups'); 
	
	if( is_administrator_rs() || current_user_can('manage_groups') ) {
		$url_def = SCOPER_ADMIN_URL . "/default_groups.php'";
		$url_members = SCOPER_ADMIN_URL . "/group_members.php'";
		echo ' <span style="font-size: 0.6em; font-style: normal">( ';
		echo '<a href="#new">' . __('add new') . '</a>';
		echo " &middot; <a href='$url_def'>" . __('set defaults') . '</a>';
		echo " &middot; <a href='$url_members'>" . __('browse members') . '</a>';
		echo ' )</span></h2>';
	}
	
	$results = ScoperAdminLib::get_all_groups(FILTERED_RS);
	
	$i = 0;
	if ( isset($results) && count($results) ) {
		$msg = __( 'You are about to delete the group %s. Do you wish to continue?', 'scoper');
		$msg = sprintf( $msg, '"\'+name+\'"' );
		?> <script type="text/javascript">
		function DelConfirm(name){
			var message= '<?php echo($msg);?>';
			return confirm(message);
		}
		</script>
		<table class="rs-member_table" width="100%" border="0" cellspacing="3" cellpadding="3">
		<tr class="thead">
			<th><?php _e('Name'); ?></th>
			<th><?php _e('Description'); ?></th>
			<th style="width:5em;">&nbsp;</th>
		</tr>
		<?php
		foreach ($results as $result) {
			if($i%2 == 0)
				$style = 'class=\'alternate\'';
			else
				$style = '';
		 ?>
		<tr <?php echo $style; ?>>
			<td><?php 
			$name = ( $result->meta_id ) ? ScoperAdminLib::get_metagroup_name( $result->meta_id ) : $result->display_name;

			if ( $group_editable = ! $result->meta_id && (is_administrator_rs() || current_user_can('manage_groups', $result->ID) ) ) {
				$url = SCOPER_ADMIN_URL . "/groups.php&amp;mode=edit&amp;id={$result->ID}";
				$url = wp_nonce_url( $url, 'scoper-edit-group_' . $result->ID );
				echo "<a class='edit' href='$url'>$name</a>";
			} else
				echo $name;
			?>
			</td>
			<td><?php 
			if ( $result->meta_id )
				echo ScoperAdminLib::get_metagroup_descript( $result->meta_id );
			else
				echo $result->descript;
			?></td>
			<td>
			<?php if ( $group_editable ):?>
			<?php 
			$url = SCOPER_ADMIN_URL . "/groups.php&amp;mode=delete&amp;id={$result->ID}";
			$url = wp_nonce_url( $url, 'scoper-edit-group_' . $result->ID );
			?>
			<a class="delete"
				href="<?php echo($url);?>"
				onClick="return DelConfirm('<?php echo $result->display_name; ?>');"><?php _e('Delete');?></a>
			<?php endif;?>
			</td>
		</tr>
	
		<?php
			$i++;
		} // end foreach ($results)
	?>
	</table>
	<?php
	}//close if(isset($results) && count($results)>0)
	else {
		echo "<p><strong>" . __('No groups available.', 'scoper') . "</strong></p>";
	}
	?>
	</div>
<?php endif; /* endif showing groups list */ ?>

<?php
if ( $errorMessage != "" ) {
	UserGroups_tp::write($errorMessage,false, "msg");
}
if ( ($mode != "edit") && ( ('editSubmit' == $mode) || empty($_POST['prevName']) ) ) {
?>
	<?php
	global $scoper;
	if ( ! $is_administrator = is_administrator_rs() )
		$can_manage_groups = awp_user_can('manage_groups', BLOG_SCOPE_RS);

	if ( $is_administrator || $can_manage_groups ):
	?>
		<br /><br />
		<div class="agp-width97 rs-newgroup" id="new">
		<h2><?php _e('Create New Group', 'scoper');?></h2>
		<form action="<?php echo (SCOPER_ADMIN_URL);?>/groups.php&amp;mode=add#msg" method="post">
		<?php
		$group_id = 0;
		if ( isset($group) )
			unset($group);
		wp_nonce_field( 'scoper-edit-groups' );
		
		$submitName = "Create";
	else:
		$suppress_form = true;
	endif;
} else {
	$submitName = "Update";
	?>
	<div class="wrap">
	<h2><?php printf(__('Edit Group: %s', 'scoper'), $group->display_name);?></h2>
	<form action="<?php echo (SCOPER_ADMIN_URL);?>/groups.php&amp;mode=editSubmit#msg" method="post">
	<input type="hidden" name="prevName" value="<?php echo $group->prev_name; ?>" />
	<input type="hidden" name="groupID" value="<?php echo $group->ID; ?>" />
	<?php 
	wp_nonce_field( 'scoper-edit-group_' . $group->ID );
}

if ( empty($suppress_form) ):
?>
<fieldset>
<table style="width: 100%;">
	<tr>
		<td style="width:0.7em;"><b>*</b></td>
		<td style="width:4em;"><b><?php _e('Name');?>:</b></td>
		<td><input style="width: 250px;" type="text" name="groupName"
		<?php if(isset($group) && is_object($group)) echo 'value="' . $group->display_name . '"';?>/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="vertical-align:top;"><b><?php _e('Description');?>:</b></td>
		<td><textarea style="width: 90%;" name="groupDesc" id="groupDesc" rows="2" cols="30"><?php if(isset($group) && is_object($group)) echo $group->descript; ?></textarea>
		</td>
	</tr>
</table>

<div class="rs-group_members">
<h3><?php _e('Group Members', 'scoper');?></h3>
<?php
$group_id = ( ! empty($group) ) ? $group->ID : 0;
$all_users = $scoper->users_who_can('', COLS_ID_DISPLAYNAME_RS);
UserGroups_tp::group_members_checklist( $group_id, 'member', $all_users );
?>
</div>

<div style="clear:both;"></div>
<div class="rs-group_admins">
<h3><?php _e('Group Administrators', 'scoper');?></h3>
<?php
UserGroups_tp::group_members_checklist( $group_id, 'manager', $all_users );
?>
</div>

<div style="clear:both;"></div>

<div class="rs-scoped_role_profile">
<?php 
do_action('edit_group_profile_rs', $group_id);
?>
</div>

<?php if ( 'edit' == $mode ):?>
<a href="javascript:void(0)" class="button" style="padding:0.35em; margin-right: 1em;" onclick="javascript:location.href='<?php echo(SCOPER_ADMIN_URL);?>/groups.php&amp;cancel=1'">
<?php _e('Cancel', 'scoper');?>
</a>
<?php endif;?>

<span class="submit" style='border:none;'>
<input type="submit" value="<?php echo $submitName; ?>"/>
</span>

</fieldset>

</form>
</div>
<?php endif;?>