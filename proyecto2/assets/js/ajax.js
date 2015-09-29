function cambioVista(contenido){

		$.ajax({
		url : base+'Dashboard_c/'+contenido+,//Esta es mi ruta donde se encuentra la vista (carpeta/controlador/nombreFuncion)
		data : '',
		type : 'POST',		
		success : function(data) {
			$('#principal').html(data);//En el data viene la vista, es como una cajita donde se guarda lo que recojiste del controlador
		},
		error : function() {
			alert("Error al cargar el contenido Url: "+url);
			
		}
	});	
}
