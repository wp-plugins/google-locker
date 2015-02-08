(function() {  
    tinymce.create('tinymce.plugins.g_locker', {  
            plugin_url: null,
            editor: null,
		
        init : function(ed, url) {  

			this.plugin_url = url;
			this.editor = ed;
        },
        createControl : function(n, cm) {  
			var self = this;
			
			if ( n == 'g_locker' )
			{
				var c = cm.createSplitButton('g_locker', {
                    title : 'Google Locker',
                    image : self.plugin_url + '/../img/g-locker-shortcode-icon.png',
                    onclick : function() {
                        self.editor.selection.setContent('[g_locker type="social"]' +  self.editor.selection.getContent() + '[/g_locker]');
                    }
                });
				
                c.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Google Lockers', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

                    m.add({title : 'Social Locker', onclick : function() {
                        self.editor.selection.setContent('[g_locker type="social"]' +  self.editor.selection.getContent() + '[/g_locker]');
                    }});

                    m.add({title : 'Content Locker', onclick : function() {
                        self.editor.selection.setContent('[g_locker type="content"]' +  self.editor.selection.getContent() + '[/g_locker]');
                    }});

                    m.add({title : 'Time Locker', onclick : function() {
                        self.editor.selection.setContent('[g_locker type="timer"]' +  self.editor.selection.getContent() + '[/g_locker]');
                    }});
                });

                // Return the new splitbutton instance
                return c;
			}
			
			return null;
        }
    });  
    
    tinymce.PluginManager.add('g_locker', tinymce.plugins.g_locker);  
})();  