<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Data Mapper Configuration
 *
 * Global configuration settings that apply to all DataMapped models.
 */

/*original: $config['prefix'] = '';
$config['join_prefix'] = '';
$config['error_prefix'] = '<p>';
$config['error_suffix'] = '</p>';
$config['created_field'] = 'created';
$config['updated_field'] = 'updated';
$config['local_time'] = FALSE;
$config['unix_timestamp'] = FALSE;
$config['timestamp_format'] = '';
$config['lang_file_format'] = 'model_${model}';
$config['field_label_lang_format'] = '${model}_${field}';
$config['auto_transaction'] = FALSE;
$config['auto_populate_has_many'] = FALSE;
$config['auto_populate_has_one'] = FALSE;
$config['all_array_uses_ids'] = FALSE;*/

$config['prefix'] = '';
$config['join_prefix'] = '';
$config['error_prefix'] = '<p>';
$config['error_suffix'] = '</p>';
$config['created_field'] = 'created_at';
$config['updated_field'] = 'updated_at';
$config['local_time'] = FALSE;
$config['unix_timestamp'] = FALSE;
$config['timestamp_format'] = 'Y-m-d H:i:s';
$config['lang_file_format'] = 'model_${model}';
$config['field_label_lang_format'] = '${model}_${field}';
$config['auto_transaction'] = FALSE;
$config['auto_populate_has_many'] = TRUE;
$config['auto_populate_has_one'] = TRUE;
$config['all_array_uses_ids'] = FALSE;

// set to FALSE to use the same DB instance across the board (breaks subqueries)
// Set to any acceptable parameters to $CI->database() to override the default.
$config['db_params'] = '';

// Uncomment to enable the production cache
// $config['production_cache'] = APPPATH.'cache';

$config['extensions_path'] = '../sparks/Datamapper-ORM/1.8.2/extensions';
$config['extensions'] = array('json');

/* End of file datamapper.php */
/* Location: ./sparks/Datamapper-ORM/config/datamapper.php */