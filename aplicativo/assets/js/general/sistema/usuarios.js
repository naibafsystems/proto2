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
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
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

}
    
    $("#tabs").tabs();
    //$('#usuarios1').dataTable();
    //$('#usuarios2').dataTable();
    //$('#usuarios3').dataTable();
    
    $('#usuarios1').DataTable( {
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
                    "sPdfMessage": "Listado de usuarios administradores de la RTC",
                    "sFileName": "administradores.pdf",
                    "sButtonText": textoPDF
                }
            ]
        },
        language: textoTablas    
    } );
    
    $('#usuarios2').DataTable( {
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
                    "sPdfMessage": "Listado de usuarios administradores de la RTC",
                    "sFileName": "administradores.pdf",
                    "sButtonText": textoPDF
                }
            ]
        },
        language: textoTablas 
    } );
    
    $('#usuarios3').DataTable( {
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
                    "sPdfMessage": "Listado de usuarios administradores de la RTC",
                    "sFileName": "administradores.pdf",
                    "sButtonText": textoPDF
                }
            ]
        },
        language: textoTablas 
    } );
    
	$("#formCrearUsuario").validationEngine({
     promptPosition: "centerRight",
     scroll: true,
     autoHidePrompt: true,
     autoHideDelay: 3000
     });
     
     
     $("#formCrearUsuario").submit(function () {
     var $resultado = $("#formCrearUsuario").validationEngine("validate");
     });
	 
	 $('#pais').select2();
		
	$('#rol_usuario').select2();
	
     $("#formEditarUsuario").validationEngine({
     promptPosition: "centerRight",
     scroll: true,
     autoHidePrompt: true,
     autoHideDelay: 3000
     });
     
     
     $("#formEditarUsuario").submit(function () {
     var $resultado = $("#formEditarUsuario").validationEngine("validate");
     });   
     
	
     $("#formActualizarPass").validationEngine({
     promptPosition: "centerRight",
     scroll: true,
     autoHidePrompt: true,
     autoHideDelay: 3000
     });
     
     
     $("#formActualizarPass").submit(function () {
     var $resultado = $("#formEditarUsuario").validationEngine("validate");
     });   
     
     $( "#borrar-confirm" ).dialog({
            autoOpen: false, 
            resizable: false,
            height:200,
            modal: true,
            buttons: {
              "Borrar": function() {
                  var id = $(this).data('idUsuario');
                  $.ajax({
                    url:"usuarios/borrarUsuario/"+id,
                    type:'POST',
                    dataType: "json",
                    data:{is_ajax:1},
                    success:function(msg){

                    }
                })
              },
              "Cancelar": function() {
                $( this ).dialog( "close" );
              }
            }
          });
     
     
        

});


function borrarUsuario(idUsuario)
     {
         $( "#borrar-confirm" ).data("idUsuario",idUsuario).dialog( "open" );
     }

