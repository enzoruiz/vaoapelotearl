$(document).on('ready', function(){
	$("#frmPeriodos").validate({
	    rules: {
	        cboLocal: {                
	            required: true 
	        },
	        cboCancha: {
	            required: true
	        }        
	    },
	    submitHandler: function(form){
	      	if(validarHoras()){
	      		// $.ajax({
		       //      type: "POST",
		       //      url: "misperiodos/" + dias,
		       //      data: $(form).serialize()
		       //  });
		        // $.post('misperiodos/' + dias, function(form){
		        // 	data: $(form).serialize()
		        // });
				form.submit();
	      	}
		    else{
		    	alert('Seleccione un rango de horas correcto porfavor.');
		    }
	    }
	}); 
});

function dameCanchas(){
	$('#cboCancha').empty();
	$('#cboCancha').append("<option value=''>Cancha</option>");
	$.ajax({
        type: "POST",
        dataType: "json",
        url: "damecanchas/" + $('#cboLocal option:selected').val(),
        success: function(data) {
            for (var i = 0; i < data.length ; i++) {
        		$('#cboCancha').append("<option value='" + data[i].idcancha + "'>" + data[i].descripcion + "</option>");
        	}
        }
    });
}

function validarHoras(){
	var res = true;
	var valInicio = parseInt($('#cboHoraInicio').val());
	var valFin = parseInt($('#cboHoraFin').val());

	if (valFin <= valInicio) {
		res = false;
	}

	return res;
}