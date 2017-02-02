/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
        
    $('#tb-conv_abiertas').DataTable();

	$('#tb-conv_cerradas').DataTable();
	
	$('#tb_inscritos').DataTable();
	
	$('#formInscritosCoor').validationEngine({
        promptPosition: "topRight",
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });
	
    $('#formInscritosCoor').submit(function () {
        var $resultado = $('#formInscritosCoor').validationEngine("validate");
    });

	$('#tabs').tab();
	
	$("#ciudad").change(function () {
        $("#ciudad option:selected").each(function () {
            ciudad = $('#ciudad').val();
            $.post(baseurl + "coordinador/principal/cambiaCiudad", {
                ciudad: ciudad
            }, function (data) {
                location.replace(baseurl);
            });
        });
    });
});
