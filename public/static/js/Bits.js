// Serialize Object
$.fn.serializeObject = function(){ var o = {}; var a = this.serializeArray(); $.each(a, function() { if (o[this.name]) { if (!o[this.name].push) { o[this.name] = [o[this.name]]; } o[this.name].push(this.value || ''); } else { o[this.name] = this.value || ''; } }); return o; }

//Inject Object
$.fn.injectObject=function(data){var els=this.find(':input').get();if(arguments.length===0){data={};$.each(els,function(){if(this.name&&!this.disabled&&(this.checked||/select|textarea/i.test(this.nodeName)||/text|hidden|password/i.test(this.type))){if(data[this.name]==undefined){data[this.name]=[]}data[this.name].push($(this).val().toString())}});return data}else{$.each(els,function(){if(this.name&&data[this.name]){var names=data[this.name];var $this=$(this);if(Object.prototype.toString.call(names)!=='[object Array]'){names=[names]}if(this.type=='checkbox'||this.type=='radio'){var val=$this.val();var found=false;for(var i=0;i<names.length;i++){if(names[i]==val){found=true;break}}$this.attr("checked",found)}else{$this.val(names[0])}}});return this}};

// Hotkeys
(function(jQuery){jQuery.hotkeys={version:"0.8",specialKeys:{8:"backspace",9:"tab",13:"return",16:"shift",17:"ctrl",18:"alt",19:"pause",20:"capslock",27:"esc",32:"space",33:"pageup",34:"pagedown",35:"end",36:"home",37:"left",38:"up",39:"right",40:"down",45:"insert",46:"del",96:"0",97:"1",98:"2",99:"3",100:"4",101:"5",102:"6",103:"7",104:"8",105:"9",106:"*",107:"+",109:"-",110:".",111:"/",112:"f1",113:"f2",114:"f3",115:"f4",116:"f5",117:"f6",118:"f7",119:"f8",120:"f9",121:"f10",122:"f11",123:"f12",144:"numlock",145:"scroll",191:"/",224:"meta"},shiftNums:{"`":"~","1":"!","2":"@","3":"#","4":"$","5":"%","6":"^","7":"&","8":"*","9":"(","0":")","-":"_","=":"+",";":": ","'":"\"",",":"<",".":">","/":"?","\\":"|"}};function keyHandler(handleObj){if(typeof handleObj.data!=="string"){return}var origHandler=handleObj.handler,keys=handleObj.data.toLowerCase().split(" ");handleObj.handler=function(event){if(this!==event.target&&(/textarea|select/i.test(event.target.nodeName)||event.target.type==="text")){return}var special=event.type!=="keypress"&&jQuery.hotkeys.specialKeys[event.which],character=String.fromCharCode(event.which).toLowerCase(),key,modif="",possible={};if(event.altKey&&special!=="alt"){modif+="alt+"}if(event.ctrlKey&&special!=="ctrl"){modif+="ctrl+"}if(event.metaKey&&!event.ctrlKey&&special!=="meta"){modif+="meta+"}if(event.shiftKey&&special!=="shift"){modif+="shift+"}if(special){possible[modif+special]=true}else{possible[modif+character]=true;possible[modif+jQuery.hotkeys.shiftNums[character]]=true;if(modif==="shift+"){possible[jQuery.hotkeys.shiftNums[character]]=true}}for(var i=0,l=keys.length;i<l;i++){if(possible[keys[i]]){arguments[0].preventDefault();return origHandler.apply(this,arguments)}}}}jQuery.each(["keydown","keyup","keypress"],function(){jQuery.event.special[this]={add:keyHandler}})})(jQuery);

/*
 *
 *
 */

var Bits = Bits || (function($, win, doc) {

    var Utils   = {}, // Your Toolbox  
        Ajax    = {}, // Your Ajax Wrapper
        Events  = {}, // Event-based Actions      
        Routes  = {}, // Your Page Specific Logic   
        App     = {}, // Your Global Logic and Initializer
        Public  = {}; // Your Public Functions

    Utils = {
        settings: {
            debug: true,
            meta: {},
            init: function() {
                $('meta[name^="app-"]').each(function(){
	            	Utils.settings.meta[ this.name.replace('app-','') ] = this.content;
	            });
            }
        },
        cache: {
            window: win,
            document: doc,
            _body: $(doc.body),
            editors: {},
            _blanket: $('#blanket'),
            _title: $('head title')
        },
        home_url: function(path){
            if(typeof path=="undefined"){
                path = '';
            }
            return Utils.settings.meta.url+path+'/';            
        },
        log: function(what) {
            if (Utils.settings.debug) {
                console.log(what);
            }
        },
        push: function(path, canPush){
        
        	var usePush = false;
        
	        if(history.pushState && usePush){
		        history.pushState({}, Utils.cache._title.text(), Utils.home_url(path));
		        if(typeof canPush == 'function'){
			        canPush.call(null);
		        }
	        } else {
	        	win.onbeforeunload = undefined;
		        win.location.href = Utils.home_url(path);
	        }
        },
        load: {
        	 // Used for previewing IDE themes
	        css: function(href, returnFunc){
	        	$('<link rel="stylesheet" type="text/css">').appendTo('head');
	        	
	        	$('head link:last').load(returnFunc);
	        	$('head link:last').attr('href', href);
	        }
        },
        parseRoute: function(input) {
		    var delimiter = input.delimiter || '/',
		        paths = input.path.split(delimiter),
		        check = input.target[paths.shift()],
		        exists = typeof check != 'undefined',
		        isLast = paths.length == 0;
		    input.inits = input.inits || [];
		    
		    if (exists) {
		    	if(typeof check.init == 'function'){
	    			input.inits.push(check.init);
	    		}
		    	if (isLast) {
		            input.parsed.call(undefined, {
		                exists: true,
		                type: typeof check,
		                obj: check,
		                inits: input.inits
		            });
		        } else {
		            Utils.parseRoute({
		                path: paths.join(delimiter), 
		                target: check,
		                delimiter: delimiter,
		                parsed: input.parsed,
		                inits: input.inits
		            });
		        }
		    } else {
		        input.parsed.call(undefined, {
		            exists: false
		        });
		    }
		},
		route: function(){
           
            Utils.parseRoute({
	            path: Utils.settings.meta.route,
			    target: Routes,
			    delimiter: '/',
			    parsed: function(res) {
			    	if(res.exists && res.type=='function'){
			    		if(res.inits.length!=0){
			        		for(var i in res.inits){
			        			res.inits[i].call();
			        		}
			        	}
			        	res.obj.call();
			        }
			    }
	        });
            
        } 
    };
    var _log = Utils.log;
	
    Ajax = {
	    send: function(type, method, data, returnFunc){
	    	// User Feedback
	    	$('.bit-radio-checked, .bit-radio').attr('class', 'bit-spinner');
	    	$.ajax({
	            type: type,
	            url: Utils.home_url('ajax')+method,
	            dataType:'json',
	            data: data,
	            success: function(data){
		            $('.bit-spinner').removeClass('bit-spinner').addClass('bit-radio-unchecked');
		            // Reset User Feedback
		            returnFunc.call(null, data);
	            }
	        });
	    },
	    call: function(method, data, returnFunc){
	        Ajax.send('POST', method, data, returnFunc);
	    },
	    get: function(method, data, returnFunc){
			Ajax.send('GET', method, data, returnFunc);
	    }
	};

    Events = {
        endpoints: {
	        
	        
	        // Modal functions
	        modal: {
	        	position: function(){
		        	setTimeout(function(){
			        	
			        	var modal = $('.modal:visible'),
			        		modalHeight = modal.height();
			        	modal.css({
				        	opacity:1,
				        	marginTop: ( modalHeight / 2 ) *-1
			        	});
			        	
		        	}, 0);
	        	},
	        	open: function(id, returnFunc){
			        Utils.cache._body.addClass('modal-open');
			        var modal = Utils.cache._blanket.find('#'+id+'-modal');
			        
			        modal.css({
			        	display:'block',
			        	opacity:1
		        	});
			        
			        Events.endpoints.modal.position();
			        
		        	if(returnFunc){
				    	returnFunc.call(null, modal);
				    }
			        
		        },
		        close: function(){
		        	$('.modal:visible').css({
			        	opacity:1,
			        	display: 'none'
		        	});
			        Utils.cache._body.removeClass('modal-open');
		        },
		        toggle: function(){
			        Utils.cache._body.toggleClass('modal-open');
		        },
	        },
	        
	        
	        code: {
	        
	        	// Open shortcuts Modal
	        	shortcuts: function(e){
	        		e.preventDefault();
	        		Events.endpoints.modal.open('shortcuts');
	        	},
	        	
	        	// Core "actions" related to bits
	        	action: {
	        	
	        		/*
	        		 * new is a reserved keywork, string that bitch.
	        		 * This merely redirects to the New Bit URL, after
	        		 * checking save state of course
	        		 */
		        	'new': function(e){
			        	e.preventDefault();
			        	if(!App.logic.code.states.current.saved){
				        	Events.endpoints.modal.open('unsaved');
			        	} else {
			        		win.onbeforeunload = undefined;
				        	window.location.href = Utils.home_url('code/new');
			        	}
		        	},
		        	
		        	// Save
		        	save: function(e){
			        	e.preventDefault();
			        	
			        	if(App.logic.code.states.current.saved){
				        	alert('Modify your code, yo');
				        	return;
			        	}
			        	
			        	// Get Code, Current Bit, and Bit settings
			        	var code = {
					        	html: win.btoa( Utils.cache.editors.html.getValue() ),
					        	css: win.btoa( Utils.cache.editors.css.getValue() ),
					        	javascript: win.btoa( Utils.cache.editors.javascript.getValue() ),
				        	},
				        	bit = App.logic.code.states.current.bit,
				        	meta = $('.bit-prefs').serializeObject();
			        	
			        	// Save 
			        	Ajax.call('saveBit', {
				        	payload: code,
				        	bit: bit,
				        	preferences: meta,
			        	}, function(res){
				        	if(res.status=="success"){
					        	Utils.push('code/bit/'+res.slug);
				        	} else {
					        	alert('Err, son');
				        	}
			        	});
		        	},
		        	
		        	// Ingenious! Just remove Current Bit data before save
		        	saveAsNew: function(e){
			        	e.preventDefault();
			        	App.logic.code.states.current.bit = null;
			        	Events.endpoints.code.action.save(e);
		        	},
		        	
		        	// Reload teh page
		        	revert: function(){
			        	win.onbeforeunload = undefined;
			        	win.location.reload()
		        	},
		        	
		        	// Query our Bits and show Open modal
		        	open: function(){
			        	Events.endpoints.modal.open('open', function(modal){
				        	Ajax.get('openBit', {}, function(res){
					        	if(res.status=="success"){
						        	modal.find('.bit-list').html(res.bits);
					        	}
				        	});
			        	});
		        	},
		        	
		        	format: function(){
		        		
		        		var i;
		        		for(i in Utils.cache.editors){
		        			var editor = Utils.cache.editors[i],
		        				totalLines = editor.lineCount(),
						    	totalChars = editor.getTextArea().value.length;
						    editor.autoFormatRange({line:0, ch:0}, {line:totalLines, ch:totalChars});
						    editor.setCursor(1e8,0);
		        		}
		        		
		        		
		        	},
		        	
		        	jshint: function(){
		        		
		        		var editor = Utils.cache.editors.javascript,
		        			res = JSHINT( editor.getValue() ),
		        			i;
		        			
		        		if(res===false){
		        			_log(JSHINT.errors);
		        			
		        			editor.setOption("gutters", ((editor.getOption("gutters") || []).concat(["note-gutter"])).reverse()  );
		        			
		        			for(i in JSHINT.errors){
		        				var error = JSHINT.errors[i];
		        				
		        				editor.clearGutter();
				                // show markers in the code edit window against lines with Jslint errors
				                editor.setGutterMarker((error.line) - 1, "note-gutter", $('<span class="CodeMirror-line-error" data-title="'+error.reason+'">●</span>')[0]);
				                //editor.setLineClass(+(e.line) - 1, null, "errorLine");                    
				            }
		        		}
		        	},
		        	
		        	/*
		        	 * 'Exports' to JSFiddle.
		        	 * Considering removal, not sure if this
		        	 * would be accepted or appreciated
		        	 */
		        	doExport: {
			        	jsfiddle: function(e){
				        	e.preventDefault();
				        	
				        	Ajax.call('export/jsfiddle', {
			        			params: [
					        		{ name: 'code_html', 	value: ( Utils.cache.editors.html.getValue() ) },
					        		{ name: 'code_js', 		value: win.btoa( Utils.cache.editors.javascript.getValue() ) },
					        		{ name: 'code_css', 	value: win.btoa( Utils.cache.editors.css.getValue() ) },
					        		{ name: 'js_wrap', value: 'l'},
					        		{ name: 'js_lib', value: '11'},
					        		{ name: 'normalize_css', value: 'on'},
					        		{ name: 'panel_css', value: '0'},
					        		{ name: 'panel_js', value: '0'},
					        		{ name: 'body_tag', value: '<body>'},
					        		{ name: 'doctype', value: '3'},
					        		{ name: 'version', value: '0'},
					        		{ name: 'username', value: 'jakie8'},
					        		{ name: 'js_lib_option', value: ''},
					        		{ name: 'add_external_resources', value: ''},
					        		{ name: 'title', value: ''},
					        		{ name: 'description', value: ''},
					        		{ name: 'slug', value: ''}
					        	],
					        	url: 'http://jsfiddle.net/_save/'
					        }, function(res){
					        	if(res.status=="success"){
						        	win.open(
						        		'http://jsfiddle.net/jakie8'+res.pastie_url_relative,
						        		'JSFiddle',
						        		"menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes"
						        	);
					        	}
				        	});
			        	},
		        	},
		        	
		        	// Preferences related schwag
		        	preferences: {
		        		
		        		editor: {
		        			// Show Editor Settings Modal
		        			get: function(e){
			        			e.preventDefault();
				        		Events.endpoints.modal.open('pref-editor');
		        			},
		        			theme: function(){
		        				Events.endpoints.code.action.preferences.editor.set_theme(this.value);
			        			$('#blanket').addClass('trans');
		        			},
		        			// Changes our theme in the Editor modal
			        		set_theme: function(theme){
				        		var i;
				        		
				        		Utils.load.css(Utils.home_url('static/css/codemirror/theme')+theme+'.css', function(){
					        		$('#syntax-theme').remove();
					        		$('head link:last').attr('id', 'syntax-theme');
					        		
					        		for(i in Utils.cache.editors){
					        			var debug = {
						        			editor: i,
						        			beforeTheme: Utils.cache.editors[i].getOption('theme'),
						        			toTheme: theme
						        		};
						        		
						        		(function(themeName){
						        			Utils.cache.editors[i].setOption('theme', themeName);
						        			_log(themeName);
						        		})(theme);
					        		}
				        		});
			        		},
			        		
			        		/*
			        		 * $.fn.injectObject works best with strings
			        		 * Codemirror works with native variable types
			        		 * This converts strings to CodeMirror settings
			        		 */
			        		formatEditorSettings: function(res, doObject){
			        			
			        			var localObj = {};
			        			
			        			for(var i in res){
		        					var resVal = doObject ? res[i] : res[i].val;
		        					
		        					if( parseInt(resVal) ){
		        						resVal = parseInt(resVal);
		        					} else {
		        						
		        						if(resVal=="yes"){
		        							resVal = true;
		        						} else if(resVal=="no"){
		        							resVal = false;
		        						} else {
		        							resVal = resVal;
		        						}
		        					}
		        					if(doObject){
		        						localObj[i] = resVal;
		        					} else {
		        						localObj[i].val = resVal;
		        					}
		        				}
		        				
		        				return localObj;
			        		},
			        		
			        		/*
			        		 * Save Editor settings
			        		 */
			        		set_settings: function(e){
			        			e.preventDefault();
			        			var _button = $(this);
			        			
			        			_button.attr({
			        				'class': 'pull-right btn',
			        				value: 'Wait',
			        				disabled: 'disabled'
			        			});
			        			
			        			Utils.cache._blanket.removeClass('trans');
			        			
			        			Ajax.call('saveEditorSettings', { prefs: $('#pref-editor-modal form').serializeObject() }, function(res){
			        				Events.endpoints.modal.close();
			        				Events.endpoints.modal.open('settings-reload-message');
			        			});
			        		}
		        		},
		        		
		        		// Get HTML, Javascript, and CSS Modals
		        		html: {
			        		get: function(e){
				        		e.preventDefault();
				        		Events.endpoints.modal.open('pref-html');
			        		},
			        		set: function(){}
		        		},
		        		javascript: {
			        		get: function(e){
				        		e.preventDefault();
				        		Events.endpoints.modal.open('pref-javascript');
			        		},
			        		set: function(){}
		        		},
		        		css: {
			        		get: function(e){
				        		e.preventDefault();
				        		Events.endpoints.modal.open('pref-css');
			        		},
			        		set: function(){}
		        		},
		        		
			        	bit: {
			        		set: function(e){
				        		
				        		/* Set new Bit settings temporarily
				        		 * These settings are snagged on save
				        		 */
				        		App.logic.code.states.current.meta = Utils.cache.currentModalEditor.getValue();
				        		
				        		Events.endpoints.code.action.save(e);
				        		
			        		},
					        get: function(e){
					        	
					        	e.preventDefault();
				        		Events.endpoints.modal.open('pref-bit');
					        
				        	}
			        	}
		        	},
	        	},
	        
	        	mode: {
	        		// Handles the toggle biz
	        		toggle: function(e, toToggle){
			        	e.preventDefault();
			        	var link = $(this),
			        		mode = link.data('mode') || toToggle;
			        	
			        	var modes = App.logic.code.modes.get();
			        	
			        	if(modes[mode]){
				        	modes[mode] = false;
				        	link.find('span').removeClass('active');
			        	} else {
				        	modes[mode] = true;
				        	link.find('span').addClass('active');
			        	}
			        	App.logic.code.modes.set(modes);
			        	App.logic.code.modes.update();
		        	},
		        	
		        	// Allows us to cycle editors from key events
		        	cycle: function(forward){
		        		var curEditor = App.logic.code.states.lastFocused,
		        			map = {
		        				forward: {
		        					htmlmixed: 'javascript',
		        					javascript: 'css',
		        					css: 'html'
		        				},
		        				backward: {
		        					htmlmixed: 'css',
		        					javascript: 'html',
		        					css: 'javascript'
		        				}
		        			};
		        		
		        		var toFocus = (forward) ? Utils.cache.editors[ map.forward[curEditor] ] : Utils.cache.editors[ map.backward[curEditor] ];
		        		
		        		toFocus.focus();
		        		toFocus.setCursor(1e8,0);
		        	}
	        	},
	        	
	        	// Editor events
	        	editor: {
			        changed: function(){
			        	if(App.logic.code.states.current.saved){
			        		App.logic.code.states.update.saved(false);
				        }
			        },
			        focused: function(editor){
			        	App.logic.code.states.lastFocused = editor.getMode().name;
			        }
		        }
	        }
	        
        },
        bindEvents: function(){
            
            /*
             * Bind all of our DOM related events.
             * There are really no additions to the
             * DOM, so this never needs to be called again
             */
            
            $('[data-event]').each(function(){
        		var _this = $(this),
        			method = _this.attr('data-method') || 'click',
        			name = _this.attr('data-event'),
        			bound = _this.attr('data-bound');
        		
        		if(!bound){
	        		Utils.parseRoute({
			            path: name,
					    target: Events.endpoints,
					    delimiter: '.',
					    parsed: function(res) {
					    	if(res.exists){
					    		_this.attr('data-bound', true);
					    		_this.on(method, function(e){ 
					        		res.obj.call(_this[0], e);
					        	});
					       }
					    }
			        });
		        }
        	});
            
        },
        global: {
        	
        	onBeforeUnload: function(){
	        	
	        	// Warn the user if they havent saved their doc
	        	if(!App.logic.code.states.current.saved){
	        		Events.endpoints.modal.open('unsaved');
	        		return false;
	        	}
        	},
        
	        init: function(){
		        
		        win.onbeforeunload = Events.global.onBeforeUnload;
		        
	        }
        },
        init: function(){
            Events.bindEvents();
            Events.global.init();
        }
    };
    
    Routes = {
    	
    	// Code Controller
	    code: {
	    
	    	// Any action on Code Controller
		    init: function(){
		    	
		    	/*
		    	 * This is where we start up CodeMirros
		    	 */
		    	
		    	// Save Current Bit, Bit Settings, and Editor Settings
		    	App.logic.code.states.current.bit = win.currentBit.bit;
			    App.logic.code.states.current.meta = win.currentBit.meta;
			    App.logic.code.states.current.editorSettings = JSON.parse( JSON.stringify( win.editorSettings ) );
		    	
		    	// Initialize Editors
			    App.logic.code.initializeEditors();
			    
			    // Bind Editor Events
			    App.logic.code.initializeEditorEvents();
			    
			    // Toggle/Reinstate Editor modes (HTML/JS/CSS/Result)
			    App.logic.code.modes.update();
			    
			    // Repopulate our Settings Modals with current settings
			    App.logic.code.injectFormData();
			    
		    },
		    reserved_new: function(){},
		    bit: function(){},
	    }
    };
    
    App = {
        logic: {
        	code: {
        	
        		// Modes: Functions used to Update Editing Modes. Not to be confused with CodeMirror modes
		        modes: {
		        	get: function(){
			        	var data = JSON.parse(localStorage.getItem('modes'));
			        	if(!data){
			        		App.logic.code.modes.set({
					        	html: true,
					        	css: true,
					        	javascript: true,
					        	result: true
				        	});
				        	data = JSON.parse(localStorage.getItem('modes'));
			        	}
			        	return data;
		        	},
		        	set: function(data){
			        	App.logic.code.states.current.modes = data;
			        	localStorage.setItem('modes', JSON.stringify(data));
		        	},
		        	
		        	/*
		        	 * This update method is dirty, but it's used to
		        	 * cycle through a modes object, and in turn
		        	 * creates a class for our body element to show the
		        	 * approproate editors, as well as toggle the proper
		        	 * items in the View list
		        	 */
			        update: function(){
				        var data = App.logic.code.modes.get(),
				        	num = 0, klasses = [];
				        if(data.html){
					        num++;
					        klasses.push('html-visible');
					        $('#mode-toggle .toggle-html span').addClass('active');
				        }
				        if(data.css){
					        num++;
					        klasses.push('css-visible');
					        $('#mode-toggle .toggle-css span').addClass('active');
				        }
				        if(data.javascript){
					        num++;
					        klasses.push('javascript-visible');
					        $('#mode-toggle .toggle-javascript span').addClass('active');
				        }
				        if(data.result){
					        klasses.push('result-visible');
					        $('#mode-toggle .toggle-result span').addClass('active');
				        }
				        klasses.push('editors-'+num);
				        Utils.cache._body.attr('class', klasses.join(' '));
				        
				        // We changed our editor display, refresh yo
				        App.logic.code.refresh();
			        }
		        },
		        
		        // Store information about current affairs, i.e. The Bit, Editor Settings, Save State, etc
		        states: {
			        current: {
				        saved: true
			        },
			        update: {
				        saved: function(saved){
				        	if(saved){
				        		App.logic.code.states.current.saved = true;
					        	$('.bit-radio-checked').removeClass('bit-radio-checked').addClass('bit-radio-unchecked');
				        	} else {
				        		App.logic.code.states.current.saved = false;
					        	$('.bit-radio-unchecked').removeClass('bit-radio-unchecked').addClass('bit-radio-checked');
				        	}
				        }
			        }
		        },
		        
		        /*
		         * Repopulate Modals and schtuff.
		         * $.fn.injectObject: Associative Object to HTML form elements (via name)
		         */
		        injectFormData: function(){
		        	$('.modal form:not(#pref-editor-modal)').injectObject(App.logic.code.states.current.meta);
				    $('#pref-editor-modal form').injectObject(App.logic.code.states.current.editorSettings);
				    
				    $('.modal :input').on('change', Events.endpoints.code.editor.changed);
		        },
		        
		        // Editor Instantiation
		        initializeEditors: function(){
			        
			        $('.editor').each(function(){
			        	
			        	// Collect settings for our editors
			        	var settings = Events.endpoints.code.action.preferences.editor.formatEditorSettings( App.logic.code.states.current.editorSettings, true );
			        	var _this = $(this),
		        			mode = _this.attr('data-mode');
		        		settings.mode = 'text/'+mode;
		        		
		        		
		        		/*
		        		 * Save each editor as Utils.cache.editors.javascript,
		        		 * Utils.cache.editors.css, and Utils.cache.editors.html
		        		 */
		        		Utils.cache.editors[ mode ] = CodeMirror.fromTextArea(_this[0], settings);
		        		
		        		// Used for custom autoclosing of braces and the likes
		        		App.logic.code.bindKeyMaps(mode);
			    	});
			    	
			    	// Hawt Keys
			    	App.logic.code.bindShortcuts();
			    	
			    	// Showing tabs is a CSS functionality, so toggle a class meow
			    	if(App.logic.code.states.current.editorSettings.showTabs=="yes"){
			    		$('.CodeMirror').addClass('show-tabs');
			    	}
			    	
			    	win.editors = Utils.cache.editors;
			    	
			    	// Refresh Errthang and we're golden
			    	App.logic.code.refresh();
			    },
			    
			    /*
			     * Brace Autoclosing, adapted from @author Dimitar Spiroski
			     * Added closing character overwrite. ( is entered, then an
			     * extra ) is added to give us (|), if you were to press )
			     * again, it will not output ()|), rather, ()|
			     */
			    bindKeyMaps: function(editorMode){
			    	Utils.cache.editors[ editorMode ].addKeyMap({
					    "'\"'": function (instance) { instance.closeElement(instance, "\""); },
			            "'\''": function (instance) { instance.closeElement(instance, "'"); },
			            "'('": function (instance) { instance.closeElement(instance, "("); },
			            "'['": function (instance) { instance.closeElement(instance, "["); },
			            "'{'": function (instance) { instance.closeElement(instance, "{"); },
			            
			            "')'": function (instance) { instance.closeElement(instance, ")"); },
			            "']'": function (instance) { instance.closeElement(instance, "]"); },
			            "'}'": function (instance) { instance.closeElement(instance, "}"); }
		            });
			    },
			    
			    /*
			     * Bind all editor and document shortcuts.
			     * Also, inject shortcut helpers throughout the app
			     */
			    bindShortcuts: function(){
			    	var toBind = $('body, .CodeMirror :input');
			    	
			    	var Shortcuts = [
			    		{name: 'Save', 				shortcut: 'ctrl+s', action: Events.endpoints.code.action.save},
			    		{name: 'Save as New', 		shortcut: 'ctrl+shift+s', action: Events.endpoints.code.action.saveAsNew},
			    		{name: 'Revert to Saved',	shortcut: 'ctrl+shift+r', action: Events.endpoints.code.action.revert},
			    		{name: 'New', 				shortcut: 'ctrl+n', action: Events.endpoints.code.action['new']},
			    		{name: 'Open', 				shortcut: 'ctrl+o', action: Events.endpoints.code.action.open},
			    		{name: 'Preferences', 		shortcut: 'ctrl+p', action: Events.endpoints.code.action.preferences.editor.get},
			    		
			    		{name: 'Next Editor', shortcut: 'ctrl+right', action: function(e){
			    			e.preventDefault();
			    			Events.endpoints.code.mode.cycle(true);
			    		}},
			    		{name: 'Prev Editor', shortcut: 'ctrl+left', action: function(e){
			    			e.preventDefault();
			    			Events.endpoints.code.mode.cycle(false);
			    		}},
			    		
			    		{name: 'Toggle HTML', 	shortcut: 'ctrl+1', action: function(e){ Events.endpoints.code.mode.toggle(e, 'html'); }},
			    		{name: 'Toggle JS', 	shortcut: 'ctrl+2', action: function(e){ Events.endpoints.code.mode.toggle(e, 'javascript'); }},
			    		{name: 'Toggle CSS', 	shortcut: 'ctrl+3', action: function(e){ Events.endpoints.code.mode.toggle(e, 'css'); }},
			    		{name: 'Toggle Result', shortcut: 'ctrl+4', action: function(e){ Events.endpoints.code.mode.toggle(e, 'result'); }}
			    		
			    	], i, hkList = $('.shortcutList');

			    	for(i in Shortcuts){
			    		toBind.bind('keydown', Shortcuts[i].shortcut, Shortcuts[i].action);
			    		hkList.append('<li><p>'+Shortcuts[i].name+'</p><span class="key">'+Shortcuts[i].shortcut+'</span></li>');
			    		var classSelector = '.key-'+(Shortcuts[i].name).replace(/\s+/g, '-').toLowerCase();
			    		$(classSelector).append('<span class="key">'+Shortcuts[i].shortcut+'</span>');
			    	}
			    	
			    },
			    
			    /*
			     * Change event: For Save State warning.
			     * TODO: Implement editor.isDirty() 
			     * [ or editor.isClean(), not sure ]
			     *
			     * Focus event: Keep track of our current
			     * editor so we may cycle editors with
			     * our hawt keys later.
			     */
		        initializeEditorEvents: function(){
			        var i;
			        for(i in Utils.cache.editors){
				        Utils.cache.editors[i].on('change', Events.endpoints.code.editor.changed);
				        Utils.cache.editors[i].on('focus', Events.endpoints.code.editor.focused);
			        }
		        },
		        
		        // An editor refresh for safe measure
		        refresh: function(){
			        setTimeout(function(){
				    	Utils.cache.editors.html.refresh();
				    	Utils.cache.editors.javascript.refresh();
				    	Utils.cache.editors.css.refresh();
			    	},0);
		        }
		        
	        }
        },
        init: function() {
            
            // Gather Base Settings
            Utils.settings.init();
            
            // Bind Events
            Events.init();
            
            // Start
            Utils.route();
            
        }
    };
    
    Public = {
        init: App.init  
    };

    return Public;

})(window.jQuery, window, document);

jQuery(document).ready(Bits.init);