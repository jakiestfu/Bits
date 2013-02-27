<?php 



$config = array(
	'relative_url'			=> RELATIVE_URL,
	'base_url' 				=> 'http://coolbitsbro.com/',
	'code_url' 				=> 'http://code.coolbitsbro.com/',
	
	'default_controller' 	=> 'main',
	'error_controller' 		=> 'error',
	
	'db_host' 				=> '',
	'db_name' 				=> '',
	'db_username' 			=> '',
	'db_password' 			=> '',
	
	'users' => array(
		'myUsername' => 'myPassword'
	),
	
	'autoload' => array(
		'plugins' => array( 'misc' ),
		'helpers' => array( 'session', 'input', 'format' )
	),
	
	'reserved_translate' => array(
		'new' => 'reserved_new'
	),
	
	'base_bit_settings' => array(
		
		// Bit Settings
		'bit_title' 			=> 'Untitled',
		'bit_description' 		=> '',
		
		// HTML Settings
		'html_bodyTag' 			=> '<body>',
		'html_docType' 			=> '<!doctype html>',
		
		// Javascript Settings
		'javascript_location' 	=> 'onLoad',
		'javascript_lib' 		=> 'none',
		'javascript_external' 	=> '',
		
		// CSS Settings
		'css_framework' 		=> 'none',
		'css_prefixFree' 		=> 'yes',
		'css_external' 			=> ''
	),
	
	'base_editor_settings' 	=> array(
		'theme' 			=> 'bits',
		'tabSize' 			=> 4,
		'electricChars' 	=> 'yes',
		'lineWrapping' 		=> 'no',
		'lineNumbers' 		=> 'yes',
		'undoDepth' 		=> 40,
		'closeBrace'		=> 'yes',
		'showTabs'			=> 'no',
		
		'smartIndent'		=> 'yes',
		
		'matchBrackets'		=> 'yes'
	),
	
	
	'libraries' => array(
	
		'js' => array(
			'jQuery' 		=> array( 'http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js' ),
			'MooTools'		=> array( 'http://cdnjs.cloudflare.com/ajax/libs/mootools/1.4.5/mootools-core-full-compat-yc.js' ),
			'Zepto' 		=> array( 'http://cdnjs.cloudflare.com/ajax/libs/zepto/1.0rc1/zepto.min.js' ),
			'Prototype' 	=> array( 'http://cdnjs.cloudflare.com/ajax/libs/prototype/1.7.1.0/prototype.js' ),
			'PrefixFree' 	=> array( 'http://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js' ),
			'YUI'			=> array( 'http://cdnjs.cloudflare.com/ajax/libs/yui/3.3.0/yui-min.js' ),
			'ExtJS'			=> array( 'http://cdnjs.cloudflare.com/ajax/libs/ext-core/3.1.0/ext-core.js' ),
			'Dojo'			=> array( 'http://cdnjs.cloudflare.com/ajax/libs/dojo/1.8.1/dojo.js' )
		),
	
	
		'css' => array(
			'Normalize' 	=> array( 'http://cdn.jsdelivr.net/normalize/2.0.1/normalize.css' ),
			'Bootstrap' 	=> array( 'http://cdn.jsdelivr.net/bootstrap/2.2.2/css/bootstrap.min.css' ),
			'Foundation' 	=> array( 'http://cdn.jsdelivr.net/foundation/3.2.4/stylesheets/foundation.min.css' )
		)
	)
);

?>