$(document).ready(function(){

		$(".dropp").droppable({
			accept: ".drag",
			activeClass: "gris",
			tolerance: "fit",
			drop:function(event,ui){								
				if(!$(this).data("ocupado")){					
					ui.draggable.draggable("option","revert",false);
					$("#"+event.target.id).data("ocupado",true);					
				}else{
					ui.draggable.draggable("option","revert",true);
					ocupa();					
				}
				origen=true;								
			},

			out:function(event,ui){	
				if(origen){
					inicio=event.target.id;
					origen=false;									
				}				
				$("#"+event.target.id).data("ocupado",false);									
			},			
		});

		function ocupa(){
			$("#"+inicio).data("ocupado",true);
		}

		$(".dropp").data("ocupado",false);		

		$(".drag").draggable({
			containment:"#matriz",
			opacity: 0.7,
			revert: false,
			cursor:"move",			
			create:function(){
				$("#"+$(this).parent().get(0).id).data("ocupado",true);
			},			
		});

		var origen=true;
		var inicio="";

	});