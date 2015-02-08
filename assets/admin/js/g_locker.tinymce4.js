(function() {
    tinymce.PluginManager.add( 'g_locker', function( editor, url ) {
        var menuCreated = false;
        
        editor.addButton( 'g_locker', {
            title: 'Google Locker',
            type: 'menubutton',
            icon: 'icon g-locker-shortcode-icon',
            
            onpostrender: function(e) {
                if ( menuCreated ) return;
                menuCreated = true;
                
                var self = this;

                var menu = [];
                
                menu.push({
                    text: 'Social Locker',
                    value: 'social',
                    onclick: function() {
                        editor.selection.setContent('[g_locker type="social"]' +  editor.selection.getContent() + '[/g_locker]');
                    }
                });
                
                menu.push({
                    text: 'Content Locker',
                    value: 'content',
                    onclick: function() {
                        editor.selection.setContent('[g_locker type="content"]' +  editor.selection.getContent() + '[/g_locker]');
                    }
                });
                
                menu.push({
                    text: 'Time Locker',
                    value: 'time',
                    onclick: function() {
                        editor.selection.setContent('[g_locker type="timer"]' +  editor.selection.getContent() + '[/g_locker]');
                    }
                });
                
                self.settings.menu = menu;
            }
        });
    });
})();