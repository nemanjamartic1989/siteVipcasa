$().ready(function() {
		var opts = {
			cssClass : 'el-rte',
			lang     : 'en',
			allowSource : 1,  // allow user to view source
			height   : 450,   // height of text area
			toolbar  : 'normal',   // Your options here are 'tiny', 'compact', 'normal', 'complete', 'maxi', or 'custom'
			cssfiles : ['css/elrte-inner.css'],
			// elFinder
			fmAllow  : 1,
			fmOpen : function(callback) {
				$('<div id="myelfinder" />').elfinder({
					url : 'connectors/php/connector.php', // elFinder configuration file.
					lang : 'en',
					dialog : { width : 900, modal : true, title : 'Files' }, // Open in dialog window
					closeOnEditorCallback : true, // Close after file select
					editorCallback : callback     // Pass callback to file manager
				})
			}
			//end of elFinder
		}
		$('#editor').elrte(opts); // id of textarea you want rich edit on
	})