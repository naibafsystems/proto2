/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

if(lenguaje == 'spanish')
{
    var textoTablas =  { "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ning&uacute;n dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        }};
    
    var textoExcel = "Guardar Excel";
    var textoPDF = "Guardar PDF";
    var textoBorrar = "Borrar";
    var textoCancelar = "Cancelar";

}else
{
    var textoTablas =  { "sProcessing":    "Processing...",
        "sLengthMenu":    "Show _MENU_ records",
        "sZeroRecords":   "No results found",
        "sEmptyTable":    "No data available at this table",
        "sInfo":          "Showing records of _START_ to _END_ a total of _TOTAL_ records",
        "sInfoEmpty":     "Showing records of 0 to 0 a total of 0 records",
        "sInfoFiltered":  "(filtering total _MAX_ records)",
        "sInfoPostFix":   "",
        "sSearch":        "Search:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Loading...",
        "oPaginate": {
            "sFirst":    "First",
            "sLast":    "Latest",
            "sNext":    "Next",
            "sPrevious": "Previous"
        }};
    
    var textoExcel = "Save Excel";
    var textoPDF = "Save PDF";
    var textoBorrar = "Delete";
    var textoCancelar = "Cancel";

}

    $("#tabsExperto").tabs();

    $('#experto1').DataTable({
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "multi",
            "aButtons": [
                {
                    "sExtends": "xls",
                    "oSelectorOpts": {
                        page: 'current'
                    },
                    "sButtonText": textoExcel
                },
                {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sPdfMessage": "RTC",
                    "sFileName": "archivo_rtc.pdf",
                    "sButtonText": textoPDF
                }
            ]
        },
        language: textoTablas 
    });

    
    $("#formCrearExperto").validationEngine({
        promptPosition: "bottomLeft",
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });


    $("#formCrearExperto").submit(function () {
        var $resultado = $("#formCrearExperto").validationEngine("validate");
    });
        
    $('#pais').select2();

	$('#btnAgregarFormacion').click(function(){
		var $clon = $('#div_formacion').clone().appendTo('#divNuevoFormacion');
		$clon.show();
    });
	
	$('#btnBorrarFormacion').click(function(){
		
		var $total = $("#divNuevoFormacion .row").length;
		
		if($total > 1)
		{
			$("#divNuevoFormacion .row:last-child").remove()
		}		
    });
	
	$('#btnAgregarTema').click(function(){
		var $clon = $('#div_tema').clone().appendTo('#divNuevoTema');
		$clon.show();
    });
	
	$('#btnBorrarTema').click(function(){
		
		var $totalTema = $("#divNuevoTema .row").length;
		
		if($totalTema > 1)
		{
			$("#divNuevoTema .row:last-child").remove()
		}		
    });
	
		
});
