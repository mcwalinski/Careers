 <?php
 
$view = new view;
$view->name = $machinename;
$view->description = '';
$view->tag = 'default';
$view->base_table = 'node';
$view->human_name = $name;
$view->core = 7;
$view->api_version = '3.0';
$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

/* Display: Master */
$handler = $view->new_display('default', 'Master', 'default');
$handler->display->display_options['title'] = '<none>';
$handler->display->display_options['css_class'] = 'job_category';
$handler->display->display_options['use_more'] = TRUE;
$handler->display->display_options['access']['type'] = 'perm';
$handler->display->display_options['cache']['type'] = 'none';
$handler->display->display_options['query']['type'] = 'views_query';
$handler->display->display_options['query']['options']['query_comment'] = FALSE;
$handler->display->display_options['exposed_form']['type'] = 'basic';
$handler->display->display_options['pager']['type'] = 'none';
$handler->display->display_options['pager']['options']['offset'] = '0';
$handler->display->display_options['style_plugin'] = 'default';
$handler->display->display_options['style_options']['row_class'] = 'job_title';
$handler->display->display_options['row_plugin'] = 'fields';
$handler->display->display_options['row_options']['inline'] = array(
  'title' => 'title',
);
$handler->display->display_options['row_options']['hide_empty'] = 0;
$handler->display->display_options['row_options']['default_field_elements'] = 1;
/* Header: Global: PHP */
$handler->display->display_options['header']['php']['id'] = 'php';
$handler->display->display_options['header']['php']['table'] = 'views';
$handler->display->display_options['header']['php']['field'] = 'php';
$handler->display->display_options['header']['php']['empty'] = FALSE;
$handler->display->display_options['header']['php']['php_output'] = $header;
/* No results behavior: Global: PHP */
$handler->display->display_options['empty']['php']['id'] = 'php';
$handler->display->display_options['empty']['php']['table'] = 'views';
$handler->display->display_options['empty']['php']['field'] = 'php';
$handler->display->display_options['empty']['php']['empty'] = FALSE;
$handler->display->display_options['empty']['php']['php_output'] = $header . $noresults;
/* Field: Content: Title */
$handler->display->display_options['fields']['title']['id'] = 'title';
$handler->display->display_options['fields']['title']['table'] = 'node';
$handler->display->display_options['fields']['title']['field'] = 'title';
$handler->display->display_options['fields']['title']['label'] = '';
$handler->display->display_options['fields']['title']['alter']['alter_text'] = 0;
$handler->display->display_options['fields']['title']['alter']['make_link'] = 0;
$handler->display->display_options['fields']['title']['alter']['absolute'] = 0;
$handler->display->display_options['fields']['title']['alter']['word_boundary'] = 0;
$handler->display->display_options['fields']['title']['alter']['ellipsis'] = 0;
$handler->display->display_options['fields']['title']['alter']['strip_tags'] = 0;
$handler->display->display_options['fields']['title']['alter']['trim'] = 0;
$handler->display->display_options['fields']['title']['alter']['html'] = 0;
$handler->display->display_options['fields']['title']['hide_empty'] = 0;
$handler->display->display_options['fields']['title']['empty_zero'] = 0;
$handler->display->display_options['fields']['title']['link_to_node'] = 1;
/* Field: Content: Job description */
$handler->display->display_options['fields']['field_job_description']['id'] = 'field_job_description';
$handler->display->display_options['fields']['field_job_description']['table'] = 'field_data_field_job_description';
$handler->display->display_options['fields']['field_job_description']['field'] = 'field_job_description';
$handler->display->display_options['fields']['field_job_description']['alter']['alter_text'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['make_link'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['absolute'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['external'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['replace_spaces'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['trim_whitespace'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['nl2br'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['word_boundary'] = 1;
$handler->display->display_options['fields']['field_job_description']['alter']['ellipsis'] = 1;
$handler->display->display_options['fields']['field_job_description']['alter']['more_link'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['strip_tags'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['trim'] = 0;
$handler->display->display_options['fields']['field_job_description']['alter']['html'] = 0;
$handler->display->display_options['fields']['field_job_description']['element_label_colon'] = 1;
$handler->display->display_options['fields']['field_job_description']['element_default_classes'] = 1;
$handler->display->display_options['fields']['field_job_description']['hide_empty'] = 0;
$handler->display->display_options['fields']['field_job_description']['empty_zero'] = 0;
$handler->display->display_options['fields']['field_job_description']['hide_alter_empty'] = 1;
$handler->display->display_options['fields']['field_job_description']['type'] = 'text_summary_or_trimmed';
$handler->display->display_options['fields']['field_job_description']['settings'] = array(
  'trim_length' => '600',
);
$handler->display->display_options['fields']['field_job_description']['field_api_classes'] = 0;
/* Sort criterion: Content: Post date */
$handler->display->display_options['sorts']['created']['id'] = 'created';
$handler->display->display_options['sorts']['created']['table'] = 'node';
$handler->display->display_options['sorts']['created']['field'] = 'created';
$handler->display->display_options['sorts']['created']['order'] = 'DESC';
/* Filter criterion: Content: Published */
$handler->display->display_options['filters']['status']['id'] = 'status';
$handler->display->display_options['filters']['status']['table'] = 'node';
$handler->display->display_options['filters']['status']['field'] = 'status';
$handler->display->display_options['filters']['status']['value'] = 1;
$handler->display->display_options['filters']['status']['group'] = 1;
$handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
/* Filter criterion: Content: Type */
$handler->display->display_options['filters']['type']['id'] = 'type';
$handler->display->display_options['filters']['type']['table'] = 'node';
$handler->display->display_options['filters']['type']['field'] = 'type';
$handler->display->display_options['filters']['type']['value'] = array(
  'job' => 'job',
);
/* Filter criterion: Content: Type (field_type) */
$handler->display->display_options['filters']['field_type_tid']['id'] = 'field_type_tid';
$handler->display->display_options['filters']['field_type_tid']['table'] = 'field_data_field_type';
$handler->display->display_options['filters']['field_type_tid']['field'] = 'field_type_tid';
$handler->display->display_options['filters']['field_type_tid']['value'] = array(
  0 => $tid,
);
$handler->display->display_options['filters']['field_type_tid']['reduce_duplicates'] = 0;
$handler->display->display_options['filters']['field_type_tid']['vocabulary'] = 'job_type';

/* Display: Page */
$handler = $view->new_display('page', 'Page', 'page');
$handler->display->display_options['path'] = $pathname;

/* Display: Block */
$handler = $view->new_display('block', 'Block', 'block');
$handler->display->display_options['defaults']['pager'] = FALSE;
$handler->display->display_options['pager']['type'] = 'some';
$handler->display->display_options['pager']['options']['items_per_page'] = '5';
$handler->display->display_options['defaults']['fields'] = FALSE;
/* Field: Content: Title */
$handler->display->display_options['fields']['title']['id'] = 'title';
$handler->display->display_options['fields']['title']['table'] = 'node';
$handler->display->display_options['fields']['title']['field'] = 'title';
$handler->display->display_options['fields']['title']['label'] = '';
$handler->display->display_options['fields']['title']['alter']['alter_text'] = 0;
$handler->display->display_options['fields']['title']['alter']['make_link'] = 0;
$handler->display->display_options['fields']['title']['alter']['absolute'] = 0;
$handler->display->display_options['fields']['title']['alter']['external'] = 0;
$handler->display->display_options['fields']['title']['alter']['replace_spaces'] = 0;
$handler->display->display_options['fields']['title']['alter']['trim_whitespace'] = 0;
$handler->display->display_options['fields']['title']['alter']['nl2br'] = 0;
$handler->display->display_options['fields']['title']['alter']['word_boundary'] = 0;
$handler->display->display_options['fields']['title']['alter']['ellipsis'] = 0;
$handler->display->display_options['fields']['title']['alter']['more_link'] = 0;
$handler->display->display_options['fields']['title']['alter']['strip_tags'] = 0;
$handler->display->display_options['fields']['title']['alter']['trim'] = 0;
$handler->display->display_options['fields']['title']['alter']['html'] = 0;
$handler->display->display_options['fields']['title']['element_type'] = 'span';
$handler->display->display_options['fields']['title']['element_class'] = 'job_title';
$handler->display->display_options['fields']['title']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['title']['element_default_classes'] = 0;
$handler->display->display_options['fields']['title']['hide_empty'] = 0;
$handler->display->display_options['fields']['title']['empty_zero'] = 0;
$handler->display->display_options['fields']['title']['hide_alter_empty'] = 1;
$handler->display->display_options['fields']['title']['link_to_node'] = 1;
/* Field: Content: City */
$handler->display->display_options['fields']['field_jobcity']['id'] = 'field_jobcity';
$handler->display->display_options['fields']['field_jobcity']['table'] = 'field_data_field_jobcity';
$handler->display->display_options['fields']['field_jobcity']['field'] = 'field_jobcity';
$handler->display->display_options['fields']['field_jobcity']['label'] = '';
$handler->display->display_options['fields']['field_jobcity']['alter']['alter_text'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['make_link'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['absolute'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['external'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['replace_spaces'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['trim_whitespace'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['nl2br'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['word_boundary'] = 1;
$handler->display->display_options['fields']['field_jobcity']['alter']['ellipsis'] = 1;
$handler->display->display_options['fields']['field_jobcity']['alter']['more_link'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['strip_tags'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['trim'] = 0;
$handler->display->display_options['fields']['field_jobcity']['alter']['html'] = 0;
$handler->display->display_options['fields']['field_jobcity']['element_type'] = 'span';
$handler->display->display_options['fields']['field_jobcity']['element_class'] = 'job_city';
$handler->display->display_options['fields']['field_jobcity']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['field_jobcity']['element_default_classes'] = 0;
$handler->display->display_options['fields']['field_jobcity']['hide_empty'] = 0;
$handler->display->display_options['fields']['field_jobcity']['empty_zero'] = 0;
$handler->display->display_options['fields']['field_jobcity']['hide_alter_empty'] = 1;
$handler->display->display_options['fields']['field_jobcity']['type'] = 'taxonomy_term_reference_plain';
$handler->display->display_options['fields']['field_jobcity']['field_api_classes'] = 0;
/* Field: Content: State */
$handler->display->display_options['fields']['field_jobstate']['id'] = 'field_jobstate';
$handler->display->display_options['fields']['field_jobstate']['table'] = 'field_data_field_jobstate';
$handler->display->display_options['fields']['field_jobstate']['field'] = 'field_jobstate';
$handler->display->display_options['fields']['field_jobstate']['label'] = '';
$handler->display->display_options['fields']['field_jobstate']['alter']['alter_text'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['make_link'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['absolute'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['external'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['replace_spaces'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['trim_whitespace'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['nl2br'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['word_boundary'] = 1;
$handler->display->display_options['fields']['field_jobstate']['alter']['ellipsis'] = 1;
$handler->display->display_options['fields']['field_jobstate']['alter']['more_link'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['strip_tags'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['trim'] = 0;
$handler->display->display_options['fields']['field_jobstate']['alter']['html'] = 0;
$handler->display->display_options['fields']['field_jobstate']['element_type'] = 'span';
$handler->display->display_options['fields']['field_jobstate']['element_class'] = 'job_state';
$handler->display->display_options['fields']['field_jobstate']['element_label_colon'] = FALSE;
$handler->display->display_options['fields']['field_jobstate']['element_default_classes'] = 0;
$handler->display->display_options['fields']['field_jobstate']['hide_empty'] = 0;
$handler->display->display_options['fields']['field_jobstate']['empty_zero'] = 0;
$handler->display->display_options['fields']['field_jobstate']['hide_alter_empty'] = 1;
$handler->display->display_options['fields']['field_jobstate']['type'] = 'taxonomy_term_reference_plain';
$handler->display->display_options['fields']['field_jobstate']['field_api_classes'] = 0;
