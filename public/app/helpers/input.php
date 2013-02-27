<?php

class Input {
	
	private $data;
	
	function __construct(){
		
		if(isset($_POST) && !empty($_POST))
		{
			$this->set_data( 'post', $this->sanitize($_POST) );
		}
		
		if(isset($_GET) && !empty($_GET))
		{
			$this->set_data( 'get', $this->sanitize($_GET) );
		}
		
	}
	
	private function set_data($type, $data)
	{
		$this->data->$type = (object)$data;
	}
	
	private function get_data($type, $key=false)
	{
		
		if($key){
			return $this->data->$type->$key;
		} else {
			return $this->data->$type;
		}
		
	}
	
	private function sanitize($in)
	{
		return $in;
	}
	
	public function post($key=false){
		return $this->get_data('post', $key);
	}
	
	public function get($key=false){
		return $this->get_data('get', $key);
	}
}

?>