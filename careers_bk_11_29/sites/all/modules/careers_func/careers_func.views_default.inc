<?php

/**
 * @file
 * Default view definitions for Feeds.
 */

/**
 * Implementation of hook_views_default_views().
 * 
 */
function careers_func_views_default_views() {
	$views = array();
	$view = '';
	
	//get all job types (stored in vocab with vid 10) and create a block view for each.
	$vid = 10;  // number of vocablurary
	$terms = taxonomy_get_tree($vid);
	foreach ( $terms as $term ) {
		$name = $term->name;
		$tid = $term->tid;
		$pathname = careers_func_sanitize($name);
		$machinename = careers_func_sanitize($name).$tid;
		$header = '<h2>'. $name .'</h2>';
		$noresults = '<p>There are no openings at this time</p>';
		
		include drupal_get_path('module', 'careers_func').'/views/view.inc';
		if (isset($view)) {
		  $views[$machinename] = $view;
		}   
	}
	
	//get all Departments (stored in vocab with vid 11) and create a block view for each.
	$vid = 11;  // number of vocablurary
	$terms = taxonomy_get_tree($vid);
	foreach ( $terms as $term ) {
		$name = "Dept " . $term->tid;
		$tid = $term->tid;
		$pathname = careers_func_sanitize($name);
		$machinename = careers_func_sanitize($name).$tid;
		$header = '<h2>'. $name .'</h2>';
		$noresults = '<p>There are no openings at this time</p>';
		
		include drupal_get_path('module', 'careers_func').'/views/viewbydept.inc';
		if (isset($view)) {
		  $views[$machinename] = $view;
		}   
	}
	
	//get all locations (stored in vocab with vid 9) and create a block view for each.
	$vid = 9;  // number of vocablurary
	$terms = taxonomy_get_tree($vid);
	foreach ( $terms as $term ) {
		$name = $term->name;
		$tid = $term->tid;
		$pathname = careers_func_sanitize($name);
		$machinename = careers_func_sanitize($name).$tid;
		$header = '<h2>'. $name .'</h2>';
		$noresults = '<p>There are no openings at this time</p>';
		
		include drupal_get_path('module', 'careers_func').'/views/viewbyloc.inc';
		if (isset($view)) {
		  $views[$machinename] = $view;
		}   
	}
	


  return $views;
}

function careers_func_get_views_terms($vid,$template) {
	$terms = taxonomy_get_tree($vid);
	foreach ( $terms as $term ) {
		$name = $term->name;
		$tid = $term->tid;
		$pathname = strtolower($name);
		$machinename = careers_func_sanitize($name).$tid;
		$header = '<h4>'. $name .'</h4>';
		$noresults = '<p>There are no openings at this time</p>';
		
		include drupal_get_path('module', 'careers_func').$template;
		if (isset($view)) {
		  $views[$machinename] = $view;
		}   
	}
	
}