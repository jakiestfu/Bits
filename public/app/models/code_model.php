<?php

class Code_model extends Model {
	
	
	public function getBitBySlug($slug, $version){
		
		$res = $this->query("select * from `bits` WHERE slug = ? AND version = ? ", array( $slug, $version ));
		
		return ($res) ? $res[0] : false;
	}
	
	
	public function insertBit($payload, $tiny)
	{
		
		$code = array(
			$payload['html'],
			$payload['css'],
			$payload['javascript'],
			$payload['meta']
		);
		
		$res = $this->execute("INSERT INTO `bits` (version, html, css, javascript, meta) VALUES (1, ?, ?, ?, ?) ", $code);
		
		if($res){
			$lastID = $this->lastID();
			$slug = $tiny->toTiny( $lastID );
			
			$slugRes = $this->execute("UPDATE `bits` SET `bits`.slug=? WHERE `bits`.id=?", array($slug, $lastID));
			
			$finalRes = array(
				'inserted' => $slugRes, 
				'slug'=> $slug
			);
			
			return $finalRes;
			
		}
		
	}
	
	
	public function updateBit($bit, $payload)
	{
		
		$newVersion = ( intval($bit['version']) + 1 );
		
		$code = array(
		
			$bit['slug'],
			
			$newVersion,
		
			$payload['html'],
			$payload['css'],
			$payload['javascript'],
			$payload['meta']
		);
		
		$res = $this->execute("INSERT INTO `bits` (slug, version, html, css, javascript, meta) VALUES (?, ?, ?, ?, ?, ?) ", $code);
		
		if($res){
			return array('updated'=>true, 'version'=>$newVersion);
		}
		
	}
	
	
	function listBits($allVersions = true){
		
		if($allVersions){
			$sql = 'select * from `bits` ORDER BY created DESC';
		} else {
			$sql = 'select *, MAX(`bits`.version) as latestVersion from `bits` GROUP BY `bits`.slug ORDER BY created DESC';
		}
		$res = $this->query($sql);
		if($res){
			return $res;
		}
	}
	
}

?>