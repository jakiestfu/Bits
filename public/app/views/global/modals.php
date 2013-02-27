		
		
		
		<div class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Simple Title</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">test</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-left btn" value="Close" data-event="modal.close">
					<input type="button" class="pull-right btn btn-positive" value="Save" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		
		<div id="unsaved-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Warning</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">You have unsaved changes to your code. If you continue, your changes will be discarded</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-left btn" value="Cancel" data-event="modal.close">
					<input type="button" class="pull-right btn btn-positive" value="Continue" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		
		<div id="open-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Open a Bit</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator"><div class="bit-list"></div></section>
				<footer class="modal-inner group">
					<input type="button" class="pull-left btn" value="Cancel" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		<div id="pref-bit-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Bit Preferences</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">
					<form id="pref-bit-form" class="bit-prefs">
						
						<label for="prefBitTitle">
							Title
							<input type="text" name="bit_title" id="prefBitTitle" placeholder="<?PHP echo _html('Untitled', true); ?>">
						</label>
						<label for="prefBitDescription">
							Description
							<textarea name="bit_description" id="prefBitDescription" placeholder="<?PHP echo _html('No Description', true); ?>"></textarea>
						</label>
						
					</form>
				</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-right btn btn-positive" value="OK" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		<div id="pref-html-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">HTML Preferences</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">
					<form id="pref-html-form" class="bit-prefs">
						<label for="prefBodyTag">
							Body Tag
							<input type="text" name="html_bodyTag" id="prefBodyTag" placeholder="<?PHP echo _html('<body>', true); ?>">
						</label>
						<label for="prefDocType">
							Doc Type
							<input type="text" name="html_docType" id="prefDocType" placeholder="<?PHP echo _html('<!doctype html>', true); ?>">
						</label>
					</form>
				</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-right btn btn-positive" value="OK" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		<div id="pref-javascript-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Javascript Preferences</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">
					<form id="pref-javascript-form" class="bit-prefs">
						<label for="prefJSLocation">
							Javascript Location
							<select name="javascript_location" id="prefJSLocation">
								<option value="head">no wrap (head)</option>
						        <option value="body">no wrap (body)</option>
						        <option value="domReady">onDomReady</option>
						        <option value="onLoad" selected="1">onLoad</option>
							</select>
						</label>
						<label for="prefJSLib">
							Javascript Library
							<select name="javascript_lib" id="prefJSLib">
								<?PHP echo select_list('js'); ?>
							</select>
						</label>
						<label for="prefJSExternal">
							External JS
							<input type="text" name="javascript_external" id="prefJSExternal">
						</label>
					</form>
				</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-right btn btn-positive" value="OK" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		<div id="pref-css-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">CSS Preferences</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">
					<form id="pref-css-form" class="bit-prefs">
						<label for="prefCSSFramework">
							CSS Framework
							<select name="css_framework" id="prefCSSFramework">
								<?PHP echo select_list('css'); ?>
							</select>
						</label>
						<label for="prefCSSPrefix">
							Prefix Free
							<select name="css_prefixFree" id="prefCSSPrefix">
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</label>
						<label for="prefCSSExternal">
							External CSS
							<input type="text" name="css_external" id="prefCSSExternal">
						</label>
					</form>
				</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-right btn btn-positive" value="OK" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		<div id="settings-reload-message-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Settings Saved</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">Your settings have been saved. They will come into effect upon reloading the page.</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-left btn" value="Close" data-event="modal.close">
					<input type="button" class="pull-right btn btn-positive" value="Reload" onclick="window.onbeforeunload=null;window.location.reload();">
				</footer>
			</div>
		</div>
		
		<div id="shortcuts-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Shortcuts</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator"><ul class="shortcutList"></ul></section>
				<footer class="modal-inner group">
					<input type="button" class="pull-right btn" value="Close" data-event="modal.close">
				</footer>
			</div>
		</div>
		
		<div id="pref-editor-modal" class="modal">
			<div>
				<header class="modal-inner seperator">
					<p class="code-font">Editor Preferences</p> <span class="bit-close pull-right" data-event="modal.close"></span>
				</header>
				<section class="modal-inner seperator">
					<form id="pref-editor-form" class="editor-prefs group">
						<div class="pull-left">
							
							<label for="editorThemes">
								Theme
								<select name="theme" id="editorThemes" data-event="code.action.preferences.editor.theme" data-method="change">
									<?PHP echo scan_themes(); ?>
								</select>
							</label>
							<label for="editorTabSize">
								Tab Size
								<input name="tabSize" type="text" id="editorTabSize">
							</label>
							<label for="editorElectricChars">
								Electric Characters
								<select name="electricChars" id="editorElectricChars">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
							</label>
							<label for="editorCloseBrace">
								Auto Close JS &amp; CSS
								<select name="closeBrace" id="editorCloseBrace">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
							</label>
						</div>
						<div class="pull-right">
						
							<label for="editorLineWrapping">
								Line Wrapping
								<select name="lineWrapping" id="editorLineWrapping">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
							</label>
							<label for="editorLineNumbers">
								Line Numbers
								<select name="lineNumbers" id="editorLineNumbers">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
							</label>
							<label for="editorUndoDepth">
								Undo Depth
								<input name="undoDepth" type="text" id="editorUndoDepth">
							</label>
							<label for="editorShowTabs">
								Show Tabs
								<select name="showTabs" id="editorShowTabs">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
							</label>
						</div>
					</form>
				</section>
				<footer class="modal-inner group">
					<input type="button" class="pull-right btn btn-positive" value="Save" data-event="code.action.preferences.editor.set_settings">
				</footer>
			</div>
		</div>
		
		