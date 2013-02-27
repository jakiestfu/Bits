<?php

class Main extends Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function index()
	{
		if(!$this->session->authed() ){
			$this->redirect( 'auth/new' );
		} else {
			$this->redirect( 'code/new' );
		}
	}
    
}

?>
