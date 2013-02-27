<?php

class View {

	private $pageVars = array();
	private $template;

	public function __construct($template)
	{
		$this->template = APP_DIR .'views/'. $template .'.php';
	}

	public function set($var='', $val='')
	{
		if($var!=''){
			if(is_array($var)){
				foreach($var as $k=>$v){
					$this->pageVars[$k] = $v;
				}
			} else {
				$this->pageVars[$var] = $val;
			}
		}
	}

	public function render()
	{
		extract($this->pageVars);
		
		require($this->template);
		echo ob_get_clean();
	}
	
    
}

?>