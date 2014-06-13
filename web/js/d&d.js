$(function() {
var verif = false;	
	$( "#sortable1" ).sortable({
		connectWith: ".connectedSortable",
		remove: function(event, ui) {
			var idMat = ui.item.attr('id');
			var idProd = $("#prod").val();
			var val = prompt("Entrer le pourcentage de matière utilisée dans la recette");
			if(val == null || val == 0 || isNaN(val)){	
			$( "#sortable1" ).sortable( "cancel" );
			}else{
				$.ajax({
                	
               		
                    //On lui indique le type d'envoie des informations
                    type: 'POST',
                    //On lui indique le chemin de la fonction
                    url:  Routing.generate('dev_add_matiere_produit'),
					cache: "false",
       				dataType: "html",
                    data: {'mat' : idMat, 
                    'quant' : val,
                    'prod' : idProd},

                    success: function(response)
                    {
                    	if(response == "ok"){
                    location.reload()
                    }else{
                    	alert('Dépassement du taux de remplissage');
                    	$( "#sortable1" ).sortable( "cancel" );
                    }
                    },
                    error: function(){
                    	$( "#sortable1" ).sortable( "cancel" );
                    }
                    
                }
            )
				
			}
		}
		
	}).disableSelection();
	
	$( "#sortable2" ).sortable({
		connectWith: ".connectedSortable1",
		remove: function(event, ui) {
			var idMat = ui.item.attr('id');
			var idProd = $("#prod").val();
		var val = confirm('retirer ' + ui.item.text() + '?');
		if (val == false){
			$( "#sortable2" ).sortable( "cancel" );
		}else{
			$.ajax({
                	
               		
                    //On lui indique le type d'envoie des informations
                    type: 'POST',
                    //On lui indique le chemin de la fonction
                    url:  Routing.generate('dev_del_matiere_produit'),
					cache: "false",
       				dataType: "html",
                    data: {'mat' : idMat, 'prod': idProd},

                    success: function(response)
                    {
                    location.reload();
                    },
                    error: function(){
                    	$( "#sortable2" ).sortable( "cancel" );
                    }
                    
                }
            )
			
		}
		}
	}).disableSelection();
});

$("#search").keyup(function() {
		var idProd = $("#prod").val();
		var name= $("#search").val();
		
		$.ajax({

			type : "POST",
			url : Routing.generate('dev_matiere_homepage', {id : idProd}),
			cache : "false",
			dataType : 'html',
			data :{ 'nom' : name},
			success : function(result) {
				$("#sortable1").empty();
				$("#sortable1").append(result);
			}
		});
	}); 