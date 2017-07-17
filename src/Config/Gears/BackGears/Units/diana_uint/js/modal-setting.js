
     tinymce.init({
      selector: '#panelcontent',
      height: 200,
      setup: function(ed) {
        ed.on('keyup', function(e) {
               tinyMCE.triggerSave();
        });
		  }
    });

