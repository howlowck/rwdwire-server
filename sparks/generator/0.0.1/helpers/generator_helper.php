<?php
/**
 * This function generates the migration file
 * @param
 * @param
 */
function render_migration_filename($type, $tablename){
		if ($handle = opendir(config_item('migrations_path'))) {
			$count = 0;
		    while (false !== ($entry = readdir($handle))) {
		        if (pathinfo($entry, PATHINFO_EXTENSION)=="php") {
		            $count++;
		        }
		    }
		    closedir($handle);
		}
		return str_pad($count+1,3,'0',STR_PAD_LEFT).'_'.strtolower($type).'_'.$tablename.'.php';
	}

function get_migration_index_str($columns){
	$output='$this->dbforge->add_key(array(';
	foreach($columns as $column ){
		if ($column['index']) {
			$output .= "'{$column['name']}',";
		}
	}
	$output = rtrim($output, ',');
	$output.="));"."\n";
	return $output;
}
function get_migration_column_str($column){
	$output = "'".$column['name']."' => array("."\n";
	if ($column['type'] == 'char') {
		$output .= "\t"."'type' => 'VARCHAR',"."\n";
		$output .= "\t"."'constraint' => 255,"."\n";
	}
	elseif ($column['type'] == 'int') {
		$output .= "\t"."'type' => 'INT',"."\n";
		$output .= "\t"."'constraint' => 11,"."\n";
	}
	elseif ($column['type'] == 'bool') {
		$output .= "\t"."'type' => 'TINYINT',"."\n";
		$output .= "\t"."'constraint' => 1,"."\n";
	}
		$output .= "\t"."'null' => TRUE,"."\n";
	$output .= "\t"."),"."\n";
	$output = str_replace("\n","\n\t\t\t", "\n".$output);
	return $output;
}

function render_migration_content($type, $tablename, $columns){
	$filename = render_migration_filename($type,$tablename);
	$indexed = FALSE;
	$output = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');'."\n\n";

	$output .= "class Migration_".ucfirst($type)."_$tablename extends CI_Migration {" . "\n";
	$output .= "\t". "public function up() {" . "\n";
	if ($type=="create") {
		$output .= "\t\t".'$this->dbforge->add_field(array('."\n";
		$output .= <<<'ALLCOLS'
			// all tables must have:
            'id' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => TRUE,
                'null'           => FALSE
            ),

		    'created_at' => array(
		        'type'   => 'DATETIME',
		        'null'   => TRUE  
		    ),

		    'updated_at' => array(
		        'type'   => 'DATETIME',
		        'null'   => TRUE
		    ),

		    // custom columns:
ALLCOLS;
		foreach($columns as $column){
			$output .= get_migration_column_str($column);
			if ($column['index'] AND !$indexed) {
				$indexed = TRUE;
			}
		}
		$output .= "));"."\n";
		$output .= "\t\t".'$this->dbforge->add_key(\'id\', TRUE); // TRUE makes it primary' . "\n";
		if ($indexed) {
			$output .= "\t\t".get_migration_index_str($columns);
		}
		$output .= "\t\t".'$this->dbforge->create_table(\''.$tablename.'\');' . "\n";
		$output .= "\t". "}" . "\n";
		$output .= "\t\t". "public function down() {" . "\n";
		$output .= "\t\t\t". '$this->dbforge->drop_table(\''.$tablename.'\');' . "\n";
		$output .= "\t\t". "}" . "\n";
		$output .= "\t". "}" . "\n";
		$output .= "/* End of file $filename */";
		return $output;
	}
	elseif ($type=="add") {
		$output .= "\t\t".'$fields = array('."\n";
		foreach($columns as $column){
			$output .= get_migration_column_str($column);
			if ($column['index'] AND !$indexed) {
				$indexed = TRUE;
			}
		}
		$output .= ");"."\n";
		if ($indexed) {
			$output .= "\t\t".get_migration_index_str($columns);
		}

		$output .= "\t\t".'$this->dbforge->add_column(\''.$tablename.'\', $fields);'."\n";

		$output .= "\t". "}" . "\n"; //closes up function
		$output .= "\t\t". "public function down() {" . "\n";
		foreach ($columns as $column) {
			$output .= "\t\t\t".'$this->dbforge->drop_column(\''.$tablename.'\',\''.$column['name'].'\');' . "\n";
		}
		$output .= "\t\t". "}" . "\n"; //closes down function
		$output .= "\t". "}" . "\n";
		$output .= "/* End of file $filename */";
		return $output;
	}
	elseif ($type=="index"){

	}
	
}


/** These Function Render Controllers **/
function render_controller_filename($controller_name){
		return strtoLower($controller_name).".php";
	}

function render_controller_content($post) {
	$filename = render_controller_filename($post['controller']);
	$output = '<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\'); '."\n\n";
	$output .= "Class ". ucfirst(strtolower($post['controller'])). " extends " . $post["parent"] ."{ \n\n";

	$output .= "\t". "function __construct() {" ."\n";
	$output .= "\t\t". "parent::__construct();"."\n";
	$output .= "\t\t". "// Load class-wide libraries here"."\n";
	$output .= "\t". "}" ."\n\n";

	if ($post["indexAction"] != "") {
		$output .= "\t". "function ". $post["indexAction"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Index Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["createAction"] != "") {
		$output .= "\t". "function ". $post["createAction"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Create Action Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["createForm"] != "") {
		$output .= "\t". "function ". $post["createForm"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Create Form Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["readAction"] != "") {
		$output .= "\t". "function ". $post["readAction"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Read Action Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["readForm"] != "") {
		$output .= "\t". "function ". $post["readForm"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Read Form Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["updateAction"] != "") {
		$output .= "\t". "function ". $post["updateAction"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Update Action Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["updateForm"] != "") {
		$output .= "\t". "function ". $post["updateForm"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Update Form Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["deleteAction"] != "") {
		$output .= "\t". "function ". $post["deleteAction"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Delete Action Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	if ($post["deleteForm"] != "") {
		$output .= "\t". "function ". $post["deleteForm"]. "() {" ." \n";
		$output .= "\t\t". "// Add Your Delete Form Code here"."\n";		
		$output .= "\t". "}". "\n\n";
	}
	$output .= "} \n\n";
	$output .= "/* End of file $filename in " . config_item('controllers_path') . "   */";
	return $output;
}
