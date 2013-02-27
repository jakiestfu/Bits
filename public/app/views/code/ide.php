<?PHP get_header(array('bit'=>$bit, 'settings'=>$settings, 'editor_settings' => $editor_settings)); ?>



<div id="editor">
	<div class="editor-wrap tiny-text">
		<div class="html-editor editor-house">
			<div class="tag code-font">HTML</div>
			<a href="#" class="opts" data-event="code.action.preferences.html.get" data-pref="html"><span class="bit-cog"></span></a>
			<textarea class="editor" data-mode="html"><?PHP echo htmlentities(base64_decode($bit->html)); ?></textarea>
		</div>
		<div class="javascript-editor editor-house">
			<div class="horiz-resizer"></div>
			<div class="tag code-font">Javascript</div>
			<a href="#" class="opts" data-event="code.action.preferences.javascript.get" data-pref="javascript"><span class="bit-cog"></span></a>
			<textarea class="editor" data-mode="javascript"><?PHP echo htmlentities(base64_decode($bit->javascript)); ?></textarea>
		</div>
		<div class="css-editor editor-house">
			<div class="horiz-resizer"></div>
			<div class="tag code-font">CSS</div>
			<a href="#" class="opts" data-event="code.action.preferences.css.get" data-pref="css"><span class="bit-cog"></span></a>
			<textarea class="editor" data-mode="css"><?PHP echo htmlentities(base64_decode($bit->css)); ?></textarea>
		</div>
	</div>
	<div class="result-wrap">
		<div class="vert-resizer"></div>
		<div class="iframe-wrap">
			<iframe src="<?PHP if(!$bit->slug){$bit->slug='new';} echo code_url('code/show/'.$bit->slug.'/'.$bit->version); ?>"></iframe>
		</div>
	</div>
</div>


<?PHP get_footer(); ?>