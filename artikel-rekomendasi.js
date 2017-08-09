(function(){
	tinymce.PluginManager.add('artikel_rekomendasi',function(editor,url){
		editor.addButton('artikel_rekomendasi',{
			tooltip :  'Artikel Rekomendasi',
			image : url+'rekomendasi.ico',
			onclick : function(){
				editor.insertCOntent('[artikel-rekomendasi]');
			}
		});
	});
}) ();