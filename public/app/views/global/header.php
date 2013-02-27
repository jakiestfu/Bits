<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <title><?PHP echo $settings->bit_title.' | '; ?>Bits</title>

    <meta name="app-route" 	content="<?PHP echo get_controller().'/'.get_action(); ?>">
    <meta name="app-url" 	content="<?PHP echo home_url(); ?>">

    <?PHP echo asset( 'Bits.css' ); ?>
    <?PHP echo asset( 'codemirror/codemirror.css' ); ?>
    <?PHP echo asset( 'codemirror/theme/'.$editor_settings->theme.'.css', array('id'=>'syntax-theme') ); ?>

    <!--[if IE]>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
	<![endif]-->

    <script type="text/javascript">
    	var currentBit = {},
    		editorSettings = <?PHP echo json_encode($editor_settings); ?>;
    	<?PHP if(isset($bit)){ ?>currentBit.bit = <?PHP echo json_encode(array( 'slug' => $bit->slug, 'version' => $bit->version )); ?>; <?PHP } ?>

    	currentBit.meta = <?PHP echo json_encode($settings); ?>;
    </script>

</head>
<body class="controller-<?PHP echo get_controller(); ?> action-<?PHP echo get_action(); ?>">
	<div class="data-wrap">
		<div id="top-bar">
			<nav>
				<ul>
					<li class="brand">
						<a href="<?PHP echo home_url(); ?>"><span class="bit-embed"></span> Bits</a>
					</li>
					<li>
						<a href="#">File</a>
						<ul>
							<li class="seperator" data-event="code.action.new"><a href="#" class="key-new">New</a></li>
							<li class="seperator" data-event="code.action.open"><a href="#" class="key-open">Open...</a></li>
							<li><a href="#" data-event="code.action.save" class="key-save">Save</a></li>
							<li><a href="#" data-event="code.action.saveAsNew" class="key-save-as-new">Save As New</a></li>
							<li class="seperator" data-event="code.action.revert"><a href="#" class="key-revert-to-saved">Revert to Saved</a></li>
						</ul>
					</li>
					<li>
						<a href="#">View</a>
						<ul id="mode-toggle">
							<li><a href="#" data-event="code.mode.toggle" data-mode="html" class="toggle-html key-toggle-html"><span class="bit-checkmark"></span> HTML</a></li>
							<li><a href="#" data-event="code.mode.toggle" data-mode="css" class="toggle-css key-toggle-css"><span class="bit-checkmark"></span> CSS</a></li>
							<li><a href="#" data-event="code.mode.toggle" data-mode="javascript" class="toggle-javascript key-toggle-js"><span class="bit-checkmark"></span> JavaScript</a></li>
							<li><a href="#" data-event="code.mode.toggle" data-mode="result" class="toggle-result key-toggle-result"><span class="bit-checkmark"></span> Result</a></li>
						</ul>
					</li>
					
					<li>
						<a href="#">Source</a>
						<ul>
							<li><a href="#" data-event="code.action.jshint">JSHint</a></li>
							<li><a href="#" data-event="code.action.format">Format</a></li>
						</ul>
					</li>

					<li>
						<a href="#">Preferences</a>
						<ul>
							<li class="seperator"><a href="#" data-event="code.action.preferences.bit.get">Bit Preferences</a></li>
							<li><a href="#" data-event="code.action.preferences.html.get" data-pref="html">HTML Preferences</a></li>
							<li><a href="#" data-event="code.action.preferences.javascript.get" data-pref="javascript">Javascript Preferences</a></li>
							<li><a href="#" data-event="code.action.preferences.css.get" data-pref="css">CSS Preferences</a></li>
							<li class="seperator"><a href="#" data-event="code.action.preferences.editor.get" data-pref="editor" class="key-preferences">Editor Preferences</a></li>
							<li><a href="#" data-event="code.shortcuts">Keyboard Shortcuts</a></li>
						</ul>
					</li>
					
					<?PHP if(isset($bit)){ ?>
					<li>
						<a href="#">Share</a>
						<ul>
							<li><a href="<?= home_url('code/share/'.$bit->slug.'/'.$bit->version); ?>" target="_blank">Result + Bits Bar</a></li>
							<li><a href="<?= home_url('code/show/'.$bit->slug.'/'.$bit->version); ?>" target="_blank">Result Only</a></li>
						</ul>
					</li>
					<?PHP } ?>
					<li><a href="<?= home_url('auth/logout'); ?>">Logout</a></li>
				</ul>
				<header>
					<div><span class="bit-radio-unchecked"></span> <p data-event="code.action.preferences.bit.get"><?PHP echo _html($settings->bit_title); ?></p><?PHP if(isset($bit->version)){ echo '<span class="version"> &middot; Version '.$bit->version.'</span>'; }?> </div>
				</header>
			</nav>
		</div>
		<div id="files-bar"></div>