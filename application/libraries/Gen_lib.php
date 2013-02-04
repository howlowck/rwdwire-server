<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of gen_lib
 *
 * @author haoluo
 */
class Gen_lib {
    function __construct()
	{
		$this->_ci =& get_instance();
		log_message('debug', 'General Lib Class Initialized');
	}

    /** Crucial Helper Functions **/
    public function display_messages() {
        if ($this->_ci->session->flashdata('error') != NULL) {
            $output = "<div class=\"alert alert-block alert-error\">";
            $output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>"; 
            $output .= "<h4>Error!</h4>";
            $output .= $this->_ci->session->flashdata('error');
            $output .= "</div>";
            echo $output;
        }
        if ($this->_ci->session->flashdata('success') != NULL) {
            $output = "<div class=\"alert alert-block alert-success\">";
            $output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>"; 
            $output .= "<h4>Success!</h4>";
            $output .= $this->_ci->session->flashdata('success');
            $output .= "</div>";
            echo $output;
        }
        if ($this->_ci->session->flashdata('notice') != NULL) {
            $output = "<div class=\"alert alert-block\">";
            $output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>"; 
            $output .= "<h4>Notice!</h4>";
            $output .= $this->_ci->session->flashdata('notice');
            $output .= "</div>";
            echo $output;
        }
        if (isset($this->_ci->data['error_explanation']) and $this->_ci->data['error_explanation']) {
            $output = "<div class=\"alert alert-block alert-error\">";
            $output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>"; 
            $output .= "<h4>Error!</h4>";
            $output .= $this->_ci->data['error_explanation'];
            $output .= "</div>";
            echo $output;
        }
    }

    /** Redirect Helper Function **/
    public function redirect($url=FALSE, $command=FALSE){
        $this->_ci->load->helper("url");
        if (strtolower($command) == "save" and !empty($url)) {
            $this->_ci->session->set_userdata(array("savedURL"=>current_url()));
        }
        elseif (strtolower($command) == "resume" and $this->_ci->session->userdata("savedURL")) {
            $url = $this->_ci->session->userdata("savedURL");
            $this->_ci->session->unset_userdata("savedURL");
        }
        if (!$url and !$command) {
           $url = current_url();
        }
        return redirect($url);
    }

    /** Form Data Helper Function **/
    public function flashFormData($postData, $exclude = array()){
        if (!is_array($exclude)) {
            $exclude = array($exclude);
        }
        foreach ($postData as $name => $value) {
            if (in_array($name, $exclude)) {
                continue;
            }
            $this->_ci->session->set_flashdata($name, $value);
        }
    }

    public function getFormData($name){
        if ($this->_ci->session->flashdata($name)) {
            return $this->_ci->session->flashdata($name);
        }
        return "";
    }
    /**JSON Encode Helper **/
    function my_to_json($models){
        return json_encode(array_map(function($m) { return $m->to_array();}, $models));
    }
    /** Include Functions, non-crucial **/    
    public function include_js($type, $path){
        if ($type == 'short') {
            return $this->_ci->template->append_metadata("<script src=\"".base_url("/public/js/{$path}")."\"></script>");
        }
        else if ($type == 'vendor') {
            return $this->_ci->template->append_metadata("<script src=\"".base_url("/public/vendors/{$path}")."\"></script>");
        }
        else if ($type == 'url') {
            return $this->_ci->template->append_metadata("<script src=\"".$path."\"></script>");
        }
    }

    public function include_datatables($style = ""){
        $datatable = "<script src=\"".base_url('public/vendors/datatables/media/js/jquery.dataTables.min.js')."\"></script>";
        if ($style=="bootstrap") {
            $css = "<link rel=\"stylesheet\" href=\"".base_url('public/css/datatables-bootstrap.css')."\" />";
        }
        else{
            $css = "<link rel=\"stylesheet\" href=\"".base_url('public/vendors/jquery/datatables/media/css/demo_table.css')."\" />";
        }
        return $this->_ci->template->append_metadata($datatable.$css);
    }


    public function include_colorbox($version = 1){
        $css_url = base_url("public/vendors/colorbox/example{$version}/colorbox.css");
        $js_url = base_url("public/vendors/colorbox/colorbox/jquery.colorbox-min.js");
        return $this->_ci->template->append_metadata("<link rel=\"stylesheet\" href=\"{$css_url}\" /><script src=\"{$js_url}\"></script>");
    }
    
    public function include_j_gmap(){
        $googlemaps_url = "http://maps.google.com/maps/api/js?sensor=false";
        $gmap3_url = base_url("public/vendors/jquery/gmap3.min.js");
        return $this->_ci->template->append_metadata("<script src=\"{$googlemaps_url}\"></script><script src=\"{$gmap3_url}\"></script>");
    }

    public function bytesToSize1024($bytes, $precision = 2) {
        $unit = array('B','KB','MB');
        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
    }


    /** Misc Helper functions **/
    public function geocode($string){
       $string = str_replace (" ", "+", urlencode($string));
       $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";
     
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $details_url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $response = json_decode(curl_exec($ch), true);
     
       // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
            $this->_ci->session->set_flashdata('error','Sorry, we cannot find the address :(');
            return FALSE;
        }

       //print_r($response);
        $geometry = $response['results'][0]['geometry'];
        $address = $response['results'][0]['address_components'];

        $longitude = $geometry['location']['lat'];
        $latitude = $geometry['location']['lng'];
        
        if (isset($address[7])) {
            $array = array(
                'latitude' => $geometry['location']['lat'],
                'longitude' => $geometry['location']['lng'],
                'location_type' => $geometry['location_type'],
                'mail_street' => $address[0]['long_name'].' '.$address[1]['long_name'],
                'mail_city' => $address[3]['long_name'].', '.$address[5]['short_name'],
                'mail_zip' => $address[7]['long_name'],
            );
        }
        else{
            $array = array(
                'latitude' => $geometry['location']['lat'],
                'longitude' => $geometry['location']['lng'],
                'location_type' => $geometry['location_type'],
                'mail_street' => '',
                'mail_city' => '',
                'mail_zip' => '',
            );
            $this->_ci->session->set_flashdata('error','Sorry, we cannot find the address :(');
        }
        
     
        return $array;
    }
    public function makedir($path, $destructive=0){
        if ($destructive == 0) {
            if(!is_dir($path)){
                if(!mkdir($path)){
                    echo "Failed to create $path !";
                    return FALSE;
                }
                else{
                    return TRUE;
                }
            }
            
        }
        else{
            if (is_dir($path)){
                $this->rrmdir($path);
            }
            if(!mkdir($path)){
                echo "Failed to create $path !";
                return FALSE;
            }
            else{
                return TRUE;
            }
        }
    }
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                
                if ($object != "." and $object != "..") {
                    if (filetype($dir."/".$object) == "dir"){
                        $this->rrmdir($dir."/".$object);
                    }
                    else {
                        unlink($dir."/".$object);
                    }
                } 
            }
            reset($objects);
            rmdir($dir);
        }
        return TRUE;
    }


}

