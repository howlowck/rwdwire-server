<?php
/**
 * Generator spark
 * @todo Input validation-> if type is create but name is already in table, then fail
 * @todo Input validation-> if column names in the key is not one of the columns listed, then fail
 */
class Generator{
	
	public function __construct()
	{
		return $this->Generator();
	}

	function Generator(){
		return;
	}
	/**
	 * Creates Migration File
	 * @uses ../helpers/generator_helper.php
	 * @var mixed[] Input has two sub arrays, type and name. name has the column informations
	 * @return boolean Retures if migration was completed correctly
	 */
	function migration($data){
		$filename = render_migration_filename($data['type'], $data['name']);  //from generator helper
		$file = fopen(config_item('migrations_path').$filename,'x') or die("Can't open file");
		$stringData = render_migration_content($data['type'],$data['name'],$data['columns']);
		fwrite($file,$stringData);
		fclose($file);
		return TRUE;
	}
	
}