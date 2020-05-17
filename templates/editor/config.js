/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'fr';
	//config.uiColor = '#AADC6E';
	
	config.toolbar = 'Page';
	config.height = '500px';
    
    config.toolbar_Page =
    [
	    { name: 'document', items : [ 'Source','-'/*,'Save','NewPage'*/,'DocProps','Preview','Print','-','Templates' ] },
	    { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	    { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
	    /*{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
            'HiddenField' ] },*/
	    '/',
	    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	    { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
	    '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	    { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
	    { name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'/*,'PageBreak','Iframe'*/ ] },
	    '/',
	    { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	    { name: 'colors', items : [ 'TextColor','BGColor' ] },
	    { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
    ];
    
    config.smiley_descriptions = ["smiley", "triste", "clin d'oeil", "rire", "desempare", "effronte", "rouge", "surprit", "indecit", "colere", "ange", "cool", "demon", "pleure", "éclairé", "oui", "non", "coeur", "coeur brise", "baiser", "mail"];
	
	config.stylesSet = 'my_styles:/templates/editor/adStyles.js';
};
