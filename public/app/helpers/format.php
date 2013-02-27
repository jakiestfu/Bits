<?PHP

class Format{
	
	
	
	public function bitsList($bits){
		
		$html = '<ul>';
		
		$count = 2;
		
		foreach($bits as $bit){
		
			$settings = json_decode($bit->meta);
			
			$sampleCode = $bit->javascript ? $bit->javascript : ( $bit->html ? $bit->html : ( $bit->css ? $bit->css : false ) );
			
			if($sampleCode){
				$compressed = preg_replace("/\n/", '', preg_replace("/\t/", '', substr(base64_decode($sampleCode), 0, 200) ));
				$sampleCode = '<pre class="sample-code">'._html( $compressed ).'</pre>';
			} else {
				$sampleCode = '';
			}
			
			if($settings->bit_description){
				$sampleCode = '<pre class="sample-code">'._html( $settings->bit_description ).'</pre>';
			}
			
			$klass = $count%2==0 ? 'even' : 'odd';
			
			$html .= '<li class="'.$klass.'"><a href="'.home_url('code/bit/'.$bit->slug.'/'.$bit->latestVersion).'" class="block-link">';
				$html .= '<div class="bit-title group">';
					$html .= '<p class="pull-left code-font">'.$settings->bit_title.' <span>v'.$bit->latestVersion.'</span></p>';
					$html .= '<time class="pull-right" datetime="'.$bit->created.'">'.timeAgo($bit->created).'</time>';
				$html .= '</div>';
				$html .= '<div class="bit-sample">';
					$html .= ($sampleCode);
				$html .='</div>';
			$html .= '</a></li>';
			$count++;
		}
		
		$html .= '</ul>';
		
		return $html;
		
	}
	
	
	
	
}