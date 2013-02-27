<?PHP

function home_url($path=''){
	global $config;
	return $config['base_url'].$path;
}
function code_url($path=''){
	global $config;
	return $config['code_url'].$path;
}

function get_header($inputs=array()){
	extract($inputs);
	include(APP_DIR.'views/global/header.php');
}

function get_sidebar($inputs=array()){
	include(APP_DIR.'views/global/sidebar.php');
}

function get_modals($inputs=array()){
	include(APP_DIR.'views/global/modals.php');
}

function get_footer($inputs=array()){
	include(APP_DIR.'views/global/footer.php');
}

function asset($file='', $atts=array()){
	
	$ext = $ext ? $ext : end( explode('.',$file) );
	
	$isLocal = (stripos($file, 'http')===0) ? $file : BASE_URL.'static/'.$ext.'/'.$file;
	
	$attHTML = '';
	foreach($atts as $attr=>$val){
		$attHTML .= $attr.'="'.$val.'" ';
	}
	
	switch( $ext ) {
		case 'js':
			return '<script type="text/javascript" src="'.$isLocal.'"'.$attHTML.'></script>' . "\n";
		case 'css':
			return '<link rel="stylesheet" href="'.$isLocal.'" type="text/css" '.$attHTML.'/>' . "\n";
	}
	
}

function get_controller(){
	global $config;
	return $config['controller'];
}

function get_action(){
	global $config;
	return $config['action'];
}


function _html($var, $inQuotes=false){
	return $inQuotes ? htmlentities($var) : htmlentities($var, ENT_QUOTES);
}


function timeAgo($time)
{
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	
	$time = is_numeric($time) ? $time : strtotime($time);
	
	$now = time();
	$difference = $now - $time;
	$tense = "ago";
	
	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
	}
	
	$difference = round($difference);
	
	if($difference != 1) {
		$periods[$j].= "s";
	}
	
	return "$difference $periods[$j] ago";
}




function compress_json($json){
	
	$json = stripslashes($json);
	
	$json = preg_replace("/\n/", '', $json);
	$json = preg_replace("/\t/", '', $json);
	
	return $json;
}
function pretty_json( $json )
{
    $result = '';
    $level = 0;
    $prev_char = '';
    $in_quotes = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if( $char === '"' && $prev_char != '\\' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
        $prev_char = $char;
    }

    return $result;
}








function array_extend($a, $b) {
    foreach($b as $k=>$v) {
        if( is_array($v) ) {
            if( !isset($a[$k]) ) {
                $a[$k] = $v;
            } else {
                $a[$k] = array_extend($a[$k], $v);
            }
        } else {
            $a[$k] = $v;
        }
    }
    return $a;
}


function scan_themes($return = false){
	$files = scandir(ASSETS_DIR.'css/codemirror/theme');
	
	if($return){ return $files; }
	
	$html = '';
	
	foreach($files as $file){
		if($file!='.' && $file!='..'){
			
			$val = str_ireplace('.css', '', $file);
			$name = ucwords(str_ireplace('-', '', $val));
			
			$html .= '<option value="'.$val.'">'.$name.'</option>';
		}
	}
	return $html;
}

function select_list($type=''){
	
	global $config;
	$html = '';
	
	if($type == 'css' || $type== 'js'){
		
		$html .= '<option value="none">None</option>';
		foreach($config['libraries'][$type] as $name=>$url){
			$html .= '<option value="'.$name.'">'.$name.'</option>';
		}
	}
	return $html;
}
