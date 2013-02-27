<?php

class Auth extends Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function logout(){
		$this->session->destroy();
		$this->redirect('auth/new?loggedout');
	}
	
	function reserved_new()
	{
		
		if(isset($_POST['username'])){
			global $config;
			
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			if(
				isset($config['users'][$username]) && 
				$config['users'][$username] == $password
			){
				$this->session->set('authed', $username);
				$this->redirect('');
			} else {
				$this->redirect('auth/new?invalid');
			}
			
		} else {
			$this->template = $this->loadView('login');
			$this->template->set();
			$this->template->render();
		}

		
	}
    
}

?>
