$(document).on('ready', function(){
	$.ajax({
		type: "POST",
		dataType: 'json',
        url: "damedepartamentos",
        success: function(data) {
        	for (var i = 0; i < data.length ; i++) {
        		$('#cboDepartamentos').append("<option value='" + data[i].iddepartamento + "'>" + data[i].nombre + "</option>");
        	}
        }
    });
    $('#cboDepartamentos').change(function(){
    	$('#cboProvincias, #cboDistritos').empty();
        $('#cboProvincias').append("<option value=''>PROVINCIA</option>");
        $('#cboDistritos').append("<option value=''>DISTRITO</option>");
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "dameprovincias/" + $('#cboDepartamentos option:selected').val(),
            success: function(data) {
                for (var i = 0; i < data.length ; i++) {
                    $('#cboProvincias').append("<option value='" + data[i].idprovincia + "'>" + data[i].nombre + "</option>");
                }
            }
        });
    });
    $('#cboProvincias').change(function(){
        $('#cboDistritos').empty();
        $('#cboDistritos').append("<option value=''>DISTRITO</option>");
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "damedistritos/" + $('#cboProvincias option:selected').val(),
            success: function(data) {
                for (var i = 0; i < data.length ; i++) {
                    $('#cboDistritos').append("<option value='" + data[i].iddistrito + "'>" + data[i].nombre + "</option>");
                }
            }
        });
    });
});