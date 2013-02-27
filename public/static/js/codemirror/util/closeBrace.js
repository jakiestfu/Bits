/**
 * Element-closer extension for CodeMirror.
 *
 * This extension adds a "closeElement" utility function that can be used with key bindings to 
 * insert a matching end element such as ", ' , {, [ (.  It can
 *
 *
 * See demos/closetag.html for a usage example.
 * 
 * @author Dimitar Spiroski 
 * Contributed under the same license terms as CodeMirror.
 */
(function() {
	/** Option that allows tag closing behavior to be toggled.  Default is true. */
	CodeMirror.defaults['closeBrace'] = true;
	
	/**
	 * Call during key processing to close tags.  Handles the key event if the tag is closed, otherwise throws CodeMirror.Pass.
	 * - cm: The editor instance.
	 * - ch: The character being processed.
	 * - indent: Optional.  An array of tag names to indent when closing.  Omit or pass true to use the default indentation tag list defined in the 'closeTagIndent' option.
	 *   Pass false to disable indentation.  Pass an array to override the default list of tag names.
	 * - vd: Optional.  An array of tag names that should not be closed.  Omit to use the default void (end tag forbidden) tag list defined in the 'closeTagVoid' option.  Ignored in xml mode.
	 */
	CodeMirror.defineExtension("closeElement", function(cm, ch) {
		if (!cm.getOption('closeBrace')) {
			throw CodeMirror.Pass;
		}
		
		var pos = cm.getCursor();
		
		console.log(ch, pos);
		
		if(overwriteClosingElement(ch)){
			var lineData = cm.getLine( pos.line );
			if( lineData.substring( pos.ch, pos.ch+1 ) == ch ){
				cm.setCursor({line: pos.line, ch: pos.ch + 1});
			} else {
				cm.replaceRange(ch, pos);
			}
		} else {
			var closingElement = getClosingElementFor(ch);
	        cm.replaceRange(ch + closingElement, pos);
	        cm.setCursor({line: pos.line, ch: pos.ch + 1}); // set cursor inbetween
		}
		
    });
    
    function getClosingElementFor(ch) {
		switch (ch){
        case "\"":
                return ch;
        case "'":
                return ch;
        case "{":
                return "}";
        case "[":
                return "]";
        case "(":
                return ")";
        }
	}
	
	function overwriteClosingElement(ch){
		
		switch (ch){
	        case "\"":
	        case "'":
	        case ")":
	        case "]":
	        case "}":
	        	return true;
	        default:
	        	return false;
        }
		
	}
	
})();