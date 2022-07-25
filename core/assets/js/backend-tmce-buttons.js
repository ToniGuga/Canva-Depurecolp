(function () {
    /* Register the buttons */
    tinymce.create('tinymce.plugins.MyButtons', {
        init: function (ed, url) {

            /**
             * Inserts shortcode content
             */

            ed.addButton('studio42_shortcodes', {
                text: 'Shortcodes',
                type: 'menubutton',
                menu: [{
                    text: 'Button - Action Link',
                    title: '',
                    onclick: function () {
                        var selected_text = ed.selection.getContent();
                        ed.selection.setContent('[action_link class="button" title="Discover more" url="http:// or tel: or mailto:" target=""]');
                    }
                },
                {
                    text: 'Button Hollow - Action Link',
                    title: '',
                    onclick: function () {
                        var selected_text = ed.selection.getContent();
                        ed.selection.setContent('[action_link class="button hollow" title="Discover more" url="http:// or tel: or mailto:" target=""]');
                    }
                },
                {
                    text: 'Button',
                    title: '',
                    onclick: function () {
                        var selected_text = ed.selection.getContent();
                        ed.selection.setContent('[button  toptitle="" title="" subtitle="" url="" target="" class="" icon_name="" icon_type="" icon_class="" ]');
                    }
                },
                ]
            });

        },

        createControl: function (n, cm) {
            return null;
        },
    });
    /* Start the buttons */
    tinymce.PluginManager.add('my_button_script', tinymce.plugins.MyButtons);

})();