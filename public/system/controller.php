<?php

class Controller {
	
	function __construct(){
		$this->autoload();
	}
	
	private function autoload()
	{
		global $config;
		
		foreach( $config['autoload'] as $type => $payload )
		{
			$funcName = 'load' . ucfirst( substr($type, 0, -1) );
			
			if( is_array($payload) ){
				foreach($payload as $toLoad)
				{
					if(method_exists($this,$funcName))
					{
						if( $type == 'helpers' )
						{
							$this->$toLoad = call_user_func(array($this, $funcName), $toLoad);
							
						} 
						elseif( $type == 'plugins' ) 
						{
							call_user_func(array($this, $funcName), $toLoad);
						}
					}
				}
			}
		}
	}
	
	public function loadModel($name)
	{
		require(APP_DIR .'models/'. strtolower($name) .'.php');

		$model = new $name;
		return $model;
	}
	
	public function loadView($name)
	{
		$view = new View($name);
		return $view;
	}
	
	public function loadPlugin($name)
	{
		require(APP_DIR .'plugins/'. strtolower($name) .'.php');
	}
	
	public function loadHelper($name, $die=false)
	{
		if(file_exists(APP_DIR .'helpers/'. strtolower($name) .'.php')){
			require(APP_DIR .'helpers/'. strtolower($name) .'.php');
			$helper = new $name;
			return $helper;
		}
	}
	
	public function redirect($loc)
	{
		global $config;
		
		header('Location: '. $config['base_url'] . $loc);
	}
    
    public function api_put($status, $response=array(), $tipo='json'){
		$tipo = strtolower($tipo);
		
		$response['status'] = $status ? 'success' : 'error';
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
		
		if($tipo === 'json'){
			die(json_encode($response));
		}
		else if($tipo === 'jsonp'){
			die($_REQUEST['callback'] . '(' . json_encode($response) . ');' );
		}
		else{
			die($response);
		}
	}
    
}

?>