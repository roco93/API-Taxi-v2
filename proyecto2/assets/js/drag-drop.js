$(document).ready(function(){

	$(".drag1").draggable({
		containment:"#cuadro",
		opacity: 0.7,
		revert: false,				
	});

	$(".drop1").droppable({
		// accept:".drag",
		tolerance:"touch",
		drop:function(event,ui){				
			ui.draggable.draggable("option","revert",true);
		},
		out:function(event,ui){				
			ui.draggable.draggable("option","revert",false);
		},
	});

	$(".drag1").on("mousedown",function(event){			
		$("#"+event.target.id).draggable("option","revert",false);
	});

});