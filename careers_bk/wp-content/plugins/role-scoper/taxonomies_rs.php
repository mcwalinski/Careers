<?php
if( basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME']) )
	die();

require_once('lib/agapetry_config_items.php');

class WP_Scoped_Taxonomies extends AGP_Config_Items {
	var $data_sources;

	function WP_Scoped_Taxonomies( &$data_sources, $arr_use_wp_taxonomies ) {
		$this->data_sources =& $data_sources;
		
		// Detect and support additional WP taxonomies (just require activation via Role Scoper options panel)
		if ( ! empty($arr_use_wp_taxonomies) ) {
			global $wp_taxonomies;
			
			foreach ( $wp_taxonomies as $taxonomy => $wp_tax ) {
				// taxonomy must be approved for scoping and have a Scoper-defined object type
				if ( isset($arr_use_wp_taxonomies[$taxonomy]) ) {
					if ( $data_sources->is_member($wp_tax->object_type) )
						$src_name = $wp_tax->object_type;
					elseif ( ! $src_name = $data_sources->is_member_alias($wp_tax->object_type) ) // in case the 3rd party plugin uses a taxonomy->object_type property different from the src_name we use for RS data source definition
						continue;
					
					// create taxonomies definition if necessary (additional properties will be set later)
					$this->members[$taxonomy] = (object) array(
						'name' => $taxonomy,								
						'uses_standard_schema' => 1,	'requires_term' => 0,		'autodetected_wp_taxonomy' => 1,
						'display_name' => ucwords( __( str_replace('_', ' ', $taxonomy) ) ),	
						'hierarchical' => $wp_tax->hierarchical,
						'object_source' => $src_name,
						
						//TODO: need wp_taxonomies to provide a plural display name
						'display_name_plural' => ucwords( __( str_replace('_', ' ', $taxonomy) ) )				
					);
					
					if ( ! in_array($taxonomy, $data_sources->member_property($src_name, 'uses_taxonomies') ) ) {
						$obj_src =& $data_sources->get_ref($src_name);
						$obj_src->uses_taxonomies []= $taxonomy;
					}
					
					$this->process( $this->members[$taxonomy], $this->data_sources );
					
				} // endif scoping is enabled for this taxonomy
			} // end foreach taxonomy know to WP core
		} // endif any taxonomies have scoping enabled
	} // end function
	
	// creates related data source and taxonomy objects
	function &add( $name, $defining_module_name, $display_name, $display_name_plural, $uses_standard_schema = true, $default_strict = true, $args = '' ) {	
		if ( $this->locked ) {
			$notice = sprintf('A plugin or theme (%1$s) is too late in its attempt to define a role (%2$s).', $defining_module_name, $name)
					. '<br /><br />' . 'This must be done via the define_data_sources_rs hook.';
			rs_notice($notice);
			return;
		}
		
		if ( isset($this->members[$name]) )
			unset($this->members[$name]);
		
		$this->members[$name] = new WP_Scoped_Taxonomy($name, $defining_module_name, $display_name, $display_name_plural, $uses_standard_schema, $default_strict, $args);

		$this->process( $this->members[$name], $this->data_sources );
		return $this->members[$name];
	}
	
	// $tx = reference to WP_Scoped_Taxonomy object (must pass object so we can call base class function statically)
	// $data_sources = reference to WP_Scoped_Data_Sources object
	function process( &$tx, &$data_sources ) {
		global $wpdb;
		
		$taxonomy = $tx->name;	
		
		// scoper_core_taxonomies sets source prop to data source name.  Convert it to object reference
		if ( isset($tx->source) && ! is_object($tx->source) )
			$tx->source =& $data_sources->get_ref($tx->source);
		
		// Establish reference to object source
		if ( isset($tx->object_source) && ! is_object($tx->object_source) )
			// auto-added custom WP taxonomies set object_source to name provided by wp_taxonomies
			$tx->object_source =& $data_sources->get_ref($tx->object_source);
		else {
			// scoper-defined taxonomies set object source by uses_taxonomies property of WP_Scoped_Data_Source object
			foreach ($data_sources->get_all_keys() as $src_name) {
				$uses_taxonomies = $data_sources->member_property($src_name, 'uses_taxonomies');
				if ( is_array( $uses_taxonomies) )
					foreach ( $uses_taxonomies as $uses_taxonomy )
						if ( $uses_taxonomy == $taxonomy ) {
							$tx->object_source =& $data_sources->get_ref($src_name);
							break 2;	
						}
			}
		}
		
		// Apply default / derived properties to Taxonomy definitions
		if ( $tx->uses_standard_schema ) {
			$tx->source = $data_sources->get_ref('term');
			
			// default WP schema properties			
			$tx->cols->count = 'count';
			
			$tx->table_term2obj_basename = 'term_relationships';
			$tx->table_term2obj_alias = 'tr';
			$tx->cols->term2obj_oid = 'object_id';
			$tx->cols->term2obj_tid = 'term_taxonomy_id';
			
			$tx->edit_url = 'categories.php?action=edit&amp;cat_ID=%d';
		}

		// term2obj table: add prefix
		$pfx = ( empty($tx->table_term2obj_noprefix) ) ? $wpdb->prefix : '';
		$tx->table_term2obj = $pfx . $tx->table_term2obj_basename;
		
		// term2obj taxonomy table: if no alias, set alias property to tablename
		if ( empty($tx->table_term2obj_alias) )
			$tx->table_term2obj_alias = $tx->table_term2obj;
		
		if ( is_admin() ) {
			$taxonomy = $tx->name;
		
			// note: this defaults to source hook names save_[taxonomyname], edit_[taxonomyname], create_[taxonomyname], delete_[taxonomyname]
			// unless otherwise specified in data source definition.  Better to support a logical default even if it means registering hooks that are never used.
			// (since WP core uses create_category, edit_category, delete_category only, the save_category registration is suppressed in default_taxonoimies() by admin_hooks 'save_term' => '')
			$defaults = array( 'save_term' => "save_$taxonomy", 'edit_term' => "edit_$taxonomy", 
								'create_term' => "create_$taxonomy", 'delete_term' => "delete_$taxonomy", 
								'term_edit_ui' => '' );
			if ( isset($tx->admin_actions) )
				// array_intersect_key rejects custom keys not in defaults, array_merge adds defaults not in custom
				$tx->admin_actions = (object) array_merge($defaults, array_intersect_key((array) $tx->admin_actions, $defaults ) );
			else
				$tx->admin_actions = (object) $defaults;
				
			$defaults = array( 'pre_object_terms' => "pre_{$taxonomy}" );
			if ( isset($tx->admin_filters) )
				// array_intersect_key rejects custom keys not in defaults, array_merge adds defaults not in custom
				$tx->admin_filters = (object) array_merge($defaults, array_intersect_key((array) $tx->admin_filters, $defaults ) );
			else
				$tx->admin_filters = (object) $defaults;
		}
	}
	
	// override base class method because process function for this subclass takes data_sources reference as 2nd arg
	function process_added_members($arr) {
		foreach (array_keys($arr) as $name )
			$this->process($this->members[$name], $this->data_sources);
	}
	
	// standard taxonomy query variables using WP taxonomy schema with objects filtering or term id filtering
	function standard_query_vars($terms_only = false) {
		global $wpdb;
		$arr = array();
		
		if ( $terms_only ) {
			$tmp = array();
			$tmp['table'] = $wpdb->term_taxonomy;
			$tmp['alias'] = 'tt';
			$tmp['as'] = 'AS tt';
			$tmp['col_id'] = 'term_taxonomy_id';
			$arr['term'] = (object) $tmp;
		} else {
			$tmp = array();
			$tmp['table'] = $wpdb->term_relationships;
			$tmp['alias'] = 'tr';
			$tmp['as'] = 'AS tr';
			$tmp['col_id'] = 'term_taxonomy_id';
			$tmp['col_obj_id'] = 'object_id';
			$arr['term'] = (object) $tmp;
			
			$tmp = array();
			$tmp['table'] = $wpdb->posts;
			$tmp['alias'] = $tmp['table'];
			$tmp['as'] = '';
			$tmp['col_id'] = 'ID'; // posts ID column
			$arr['obj'] = (object) $tmp;
		}
		
		return (object) $arr;
	}
	
	// standard get_terms query using WP taxonomy schema
	function standard_query( $taxonomy, $cols, $object_id, $terms_only ) {
		global $wpdb;
		
		$where = "AND tt.taxonomy = '$taxonomy'";
		$join = $orderby = '';
		
		if ( $object_id || ! $terms_only ) {
			$join = " INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id"; 
			if ( $object_id )
				$join .= " AND tr.object_id = '$object_id'";
		}

		switch ( $cols ) {
			case COL_ID_RS:
				$qcols = 'tt.term_id';
				break;
			case COL_TAXONOMY_ID_RS:
				$qcols = 'tt.term_taxonomy_id';
				break;
			case COL_COUNT_RS:
				$qcols = 'COUNT(tt.term_id)';
				break;
			default: // COLS_ALL
				$qcols = 't.*, tt.*';
				
				$orderby = 'ORDER BY t.name';
				$join .= " INNER JOIN $wpdb->terms AS t ON t.term_id = tt.term_id";
		}

		return "SELECT DISTINCT $qcols FROM $wpdb->term_taxonomy AS tt $join WHERE 1=1 $where $orderby";
	}
	
	// taxonomy query variables for use with objects filtering or term id filtering
	function get_terms_query_vars($tx, $terms_only = false) {
		if ( ! is_object($tx) )
			$tx = $this->get($tx);
		
		$arr = array();

		if ( ! empty($tx->uses_standard_schema) )
			return $this->standard_query_vars($terms_only);

		require_once('taxonomies-custom_rs.php');
		return ScoperCustomTaxonomyHelper::get_terms_query_vars($tx, $terms_only);
	}
	
	// called by Scoper::get_terms
	function get_terms_query($taxonomy, $cols = COLS_ALL_RS, $object_id = 0, $terms_only = true) {
		if ( ! isset($this->members[$taxonomy]) )
			return;

		$tx = $this->members[$taxonomy];

		if ( ! empty($tx->uses_standard_schema) )
			return $this->standard_query($taxonomy, $cols, $object_id, $terms_only);  //this is a required child method
		
		require_once('taxonomies-custom_rs.php');
		return ScoperCustomTaxonomyHelper::get_terms_query($tx, $cols, $object_id, $terms_only);
	}
}

// usage: $src = new WP_Scoped_Taxonomy, then set additional properties on $src
class WP_Scoped_Taxonomy extends AGP_Config_Item {
	var $display_name;	 // REQUIRED:  	// proper case display name (singular)
	var $display_name_plural; // REQUIRED: proper case display name (plural)
	var $source;						// object reference to a Scoped_DataSource (REQUIRED but auto-set for WP taxonomies)
	var $object_source;					// auto-generated upon ScoperConfig::load_config
	
	var $requires_term = 0;				// must every object type using this category relate every object to at least one term?
	var $uses_standard_schema = 0;		// child classes may set this true if corresponding _Taxonomies class has standard_query_vars, standard_query methods
	
	var $cols = array();
	
	// Term to Object schema properties ( i.e. post2cat for WP < 2.3, term_relationships for WP > 2.3 )
	var $table_term2obj_basename = '';	// table basename (without prefix) for table relating terms to objects (and taxonomies, if multiple taxonomies are sharing the same DB schema)
	var $table_term2obj_noprefix = 0;
	var $table_term2obj;				// auto-generated upon ScoperConfig::load_config
	var $table_term2obj_alias = '';
	
	// Note: Term to Taxonomy schema (such as term_taxonomies in WP 2.3+)
	// is supported, but cannot be custom-defined for individual taxonomies.
	// Instead, define it in via standard_query, standard_query_vars methods 
	// as in WP_Scoped_Taxonomies, then set the uses_standard_schema property of pertinent Taxonomy objects
	
	function WP_Scoped_Taxonomy($name, $defining_module_name, $display_name, $display_name_plural, $uses_standard_schema = true, $requires_term = false, $args = '' ) {
		$this->AGP_Config_Item($name, $defining_module_name, $args);

		$this->display_name = $display_name;
		$this->display_name_plural = $display_name_plural;
		$this->uses_standard_schema = $uses_standard_schema;
		$this->requires_term = $requires_term;
	}
}

?>