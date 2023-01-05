$(document).ready(function(){
	tinymce.init({
		selector: ".tiny,.tiny2,.tiny3,.tiny4",
		theme: "modern",
		height: 300,
		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons paste textcolor responsivefilemanager code fullscreen"
		],
		toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
		toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code fullscreen",
		image_advtab: true ,

		theme_advanced_fonts : "Tahoma=tahoma",

		relative_urls : false,
		remove_script_host : false,
		document_base_url : $baseUrl+'/',

		directionality : "rtl",
		language: 'fa',
		theme: 'modern',
		external_filemanager_path:$baseUrl+"/uploads/filemanager/",
		filemanager_title:"مدیریت فایل" ,
		external_plugins: { "filemanager" : $baseUrl+"/uploads/filemanager/plugin.min.js"}
	});
	
});


