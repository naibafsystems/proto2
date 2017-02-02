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

    $("#tabsEvento").tabs();

    $('#evento1').DataTable({
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

    
    $('#evento2').DataTable({
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

    $("#formCrearEvento").validationEngine({
        promptPosition: "centerRight",
        scroll: true,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });


    $("#formCrearEvento").submit(function () {
        var $resultado = $("#formCrearEvento").validationEngine("validate");
    });

    $('#inputfechini').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#inputfechfin').datepicker({
        format: 'yyyy-mm-dd'
    });

    
    $("#borrarEveCoor-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: 
        [
            {
                text: textoBorrar,
                click: function () {
                    var idEvento = $(this).data('idEvento');
                    window.location.href = baseurl + "coordinador/eventos/borrarEvento/" + idEvento;
                }
            },
            {   
                text: textoCancelar,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
    
    $("#borrarEveNeceCoor-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: 
        [
            {
                text: textoBorrar,
                click: function () {
                    var idEvento = $(this).data('idEvento');
                    window.location.href = baseurl + "coordinador/eventos_necesidad/borrarEvento/" + idEvento;
                }
            },
            {   
                text: textoCancelar,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    
    $("#borrarEveAdm-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: 
        [
            {
                text: textoBorrar,
                click: function () {
                    var idEvento = $(this).data('idEvento');
                    window.location.href = baseurl + "administrador/eventos/borrarEvento/" + idEvento;
                }
            },
            {   
                text: textoCancelar,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
	
	
    $("#borrarEveMie-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: 
        [
            {
                text: textoBorrar,
                click: function () {
                    var idEvento = $(this).data('idEvento');
                    window.location.href = baseurl + "miembro/eventos/borrarEvento/" + idEvento;
                }
            },
            {   
                text: textoCancelar,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
    
    $("#borrarEveNeceMie-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: 
        [
            {
                text: textoBorrar,
                click: function () {
                    var idEvento = $(this).data('idEvento');
                    window.location.href = baseurl + "miembro/eventos_necesidad/borrarEvento/" + idEvento;
                }
            },
            {   
                text: textoCancelar,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
	
	
    $("#borrarEveNeceAdm-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: 
        [
            {
                text: textoBorrar,
                click: function () {
                    var idEvento = $(this).data('idEvento');
                    window.location.href = baseurl + "administrador/eventos_necesidad/borrarEvento/" + idEvento;
                }
            },
            {   
                text: textoCancelar,
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    $("#pais_organiza").select2({
      tags: true,
      tokenSeparators: [',', ' ']
    });
    
    $('[data-toggle="tooltip"]').tooltip();
});


function borrarEventoMie(idEvento)
{
    $("#borrarEveMie-confirm").data("idEvento", idEvento).dialog("open");
}

function borrarEventoAdm(idEvento)
{
    $("#borrarEveAdm-confirm").data("idEvento", idEvento).dialog("open");
}

function borrarEventoCoor(idEvento)
{
    $("#borrarEveCoor-confirm").data("idEvento", idEvento).dialog("open");
}

function borrarEventoMieNecesidad(idEvento)
{
    $("#borrarEveNeceMie-confirm").data("idEvento", idEvento).dialog("open");
}

function borrarEventoCoorNecesidad(idEvento)
{
    $("#borrarEveNeceCoor-confirm").data("idEvento", idEvento).dialog("open");
}

function borrarEventoAdmNecesidad(idEvento)
{
    $("#borrarEveNeceAdm-confirm").data("idEvento", idEvento).dialog("open");
}
