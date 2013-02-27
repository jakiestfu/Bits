<?PHP 

class Ajax extends Controller{
	
	function __construct(){
		parent::__construct();
		
		if( !( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) ){
			$this->api_put(false);
		}
	}
	
	function index(){
		$this->api_put(false);
	}
	
	
	function saveBit(){
		$data = $this->input->post();
		
		$code = $this->loadModel('code_model');
		
		$tiny = $this->loadHelper('tiny');
		
		$data->preferences['html_bodyTag'] = stripslashes($data->preferences['html_bodyTag']);
		
		$data->payload['meta'] = json_encode($data->preferences);
		
		if( $data->bit ){
			
			$res = $code->updateBit($data->bit, $data->payload);
			
			if($res['updated']){
				$this->api_put(true, array('slug' => $data->bit['slug'].'/'.$res['version']));
			}
			
		} else {
		
			$res = $code->insertBit($data->payload, $tiny );
			
			if($res['inserted']){
				$this->api_put(true, array('slug' => $res['slug']));
			}
		}
		
	}
	
	
	function bitMeta(){
		global $config;
		
		$data = $this->input->post();
		$code = $this->loadModel('code_model');
		
		
		$res = $code->getBitBySlug($data->slug, $data->version);
		
		$meta = $res->meta ? json_decode($res->meta) : array();
		
		$meta = array_merge($config['bitSettings'], (array)$meta);
		
		$this->api_put(true, array('meta' => pretty_json(json_encode($meta)) ));
		
	}
	
	function openBit(){
		
		$code = $this->loadModel('code_model');
		
		$bits = $code->listBits(false);
		
		$bitsList = $this->format->bitsList($bits);
		
		echo $this->api_put(true, array('bits'=>$bitsList));
	}
	
	
	
	function export($service=''){
		
		$data = $this->input->post();
		
		$url = $data->url;
		
		$fields = array();
		
		foreach($data->params as $p){
			$fields[ $p['name'] ] = $p['value'];
		}
		
		switch($service){
			case 'jsfiddle':
				$fields['code_html'] = stripslashes($fields['code_html']);
				break;
			case 'codepen':
				$fields['html'] = stripslashes(base64_decode($fields['html']));
				$fields['js'] = stripslashes(base64_decode($fields['js']));
				$fields['css'] = stripslashes(base64_decode($fields['css']));
				$fields = array('pen'=>json_encode($fields));
				break;
		}
		
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		
		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		
		$result = curl_exec($ch);
		print_r($result);die();
		curl_close($ch);
		
		switch($service){
			case 'jsfiddle':
				$data = (array)json_decode($result);
				break;
		}
		
		echo $this->api_put(true, $data);
		
	}
	
	
	function saveEditorSettings(){
		$data = $this->input->post();
		
		// save in DB
		
		$this->session->set('editor_settings', $data->prefs);
		
		$out = array();
		foreach($data->prefs as $k=>$v){
			$out[] = array('opt' => $k, 'val' => $v);
		}
		
		echo $this->api_put(true, $out);
	}
	
}