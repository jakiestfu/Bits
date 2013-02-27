<?PHP

class Code extends Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		$this->redirect('code/new');
	}
	
	private function overloadBitSettings($settings, $base, $yesNoToBool=false){
		
		$obj = (object)array_extend($base, (array)$settings);
		
		if($yesNoToBool){
			$conversion = array(
				'true' => true,
				'false' => false
			);
			foreach($obj as $k=>$v){
				if(isset($conversion[$obj->$k])){
					$obj->$k = $conversion[$obj->$k];
				}
			}
		}
		return $obj;
	}
	
	function reserved_new()
	{
		
		if(!$this->session->authed() ){
			$this->redirect( 'auth/new' );
		}
		
		global $config;
		$this->template = $this->loadView('code/ide');
		
		$bitSettings = $this->overloadBitSettings(array(), $config['base_bit_settings']);
		$editorSettings = $this->overloadBitSettings( $this->session->get('editor_settings'), $config['base_editor_settings'], true);
		
		$this->template->set(array(
			'settings' => $bitSettings,
			'editor_settings' => $editorSettings
		));
		
		$this->template->render();
	}
	
	function render_editor($slug, $version, $template){
		
		
		
		global $config;
		
		$this->template = $this->loadView($template);
		$code = $this->loadModel('code_model');
		
		$bit = $code->getBitBySlug($slug, $version);
		
		if($bit){
			
			$bitSettings = !empty($bit->meta) ? json_decode($bit->meta) : array();
			$bitSettings = $this->overloadBitSettings($bitSettings, $config['base_bit_settings']);
			
			$editorSettings = $this->overloadBitSettings( $this->session->get('editor_settings'), $config['base_editor_settings'], true);
			
			$this->template->set(array(
				'bit' => $bit,
				'settings' => $bitSettings,
				'editor_settings' => $editorSettings,
				'libs' => $config['libraries']
			));
			
			$this->template->render();
		}
	}
	
	function bit($slug=false, $version=1){
		
		if(!$this->session->authed() ){
			$this->redirect( 'auth/new' );
		}
		
		$this->render_editor($slug, $version, 'code/ide');
	}
	
	
	function show($slug=false, $version=1){
		$this->render_editor($slug, $version, 'code/show/default');
	}
	
	
	
	function share($slug=false, $version=1){
		$this->render_editor($slug, $version, 'code/show/share');
	}
	
}