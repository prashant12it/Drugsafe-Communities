/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

//CKEDITOR.editorConfig = function( config ) {
//	// Define changes to default configuration here. For example:
//	// config.language = 'fr';
//	// config.uiColor = '#AADC6E';
//};

CKEDITOR.editorConfig = function (config) {

config.removePlugins = 'elementspath,save,image,flash,iframe,anchor,tabletools,find,pagebreak,templates,about,maximize,showblocks,newpage,language';

config.removeButtons = 'Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,RadioButton,Checkbox,Textarea,Button,SelectAll,NumberedList,BulletedList,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField';

};
