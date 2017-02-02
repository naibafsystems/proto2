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

    $("#tabsGrupo").tabs();

    $('#grupos1').DataTable({
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "multi",
            "aButtons": [
                {
                    "sExtends": "xls",
                    "oSelectorOpts": {
                        page: 'current'
                    },
                    "sButtonText": "Guardar Excel"
                },
                {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sPdfMessage": "RTC",
                    "sFileName": "archivo_rtc.pdf",
                    "sButtonText": "Guardar PDF"
                }
            ]
        },
        language: textoTablas 
    });

    $('#grupos2').DataTable({
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "multi",
            "aButtons": [
                {
                    "sExtends": "xls",
                    "oSelectorOpts": {
                        page: 'current'
                    },
                    "sButtonText": "Guardar Excel"
                },
                {
                    "sExtends": "pdf",
                    "sPdfOrientation": "landscape",
                    "sPdfMessage": "RTC",
                    "sFileName": "archivo_rtc.pdf",
                    "sButtonText": "Guardar PDF"
                }
            ]
        },
        language: textoTablas 
    });

    $("#formCrearGrupo").validationEngine({
        promptPosition: "centerRight",
        scroll: true,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });


    $("#formCrearGrupo").submit(function () {
        var $resultado = $("#formCrearGrupo").validationEngine("validate");
    });

    $("#formCrearActividad").validationEngine({
        promptPosition: "centerRight",
        scroll: true,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });


    $("#formCrearActividad").submit(function () {
        var $resultado = $("#formCrearActividad").validationEngine("validate");
    });

    $('#inputfechini').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#inputfechfin').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#miembros').multiSelect({
        selectableHeader: "<div class='custom-header'>Miembros</div>",
        selectionHeader: "<div class='custom-header'>Miembros Seleccionados</div>",
    });
	
	$("#borrarGrupo-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Borrar": function () {
                var idGrupo = $(this).data('idGrupo');
                window.location.href = baseurl + "administrador/grupos_trabajo/borrarGrupo/" + idGrupo;
            },
            "Cancelar": function () {
                $(this).dialog("close");
            }
        }
    });


    $("#borrarAct-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        modal: true,
        buttons: {
            "Borrar": function () {
                var idActividad = $(this).data('idActividad');
                var idGrupo = $(this).data('idGrupo');
                window.location.href = baseurl + "coordinador/grupos_trabajo/borrarActividad/" + idActividad + "/" + idGrupo;
            },
            "Cancelar": function () {
                $(this).dialog("close");
            }
        }
    });

    tinymce.init({
        selector: "#acta",
        language: "es",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });

    $("#formActa").validationEngine({
        promptPosition: "centerRight",
        scroll: true,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });


    $("#formActa").submit(function () {
        var $resultado = $("#formActa").validationEngine("validate");
    });
    
    $("#formRespuestaForo").validationEngine({
        promptPosition: "centerRight",
        scroll: true,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });


    $("#formRespuestaForo").submit(function () {
        var $resultado = $("#formRespuestaForo").validationEngine("validate");
    });
    
    $("#formCrearForo").validationEngine({
        promptPosition: "centerRight",
        scroll: true,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });


    $("#formCrearForo").submit(function () {
        var $resultado = $("#formCrearForo").validationEngine("validate");
    });
    
    //$('#multiOpenAccordion').multiAccordion({active: 'all' });
    $( "#detalleForosResp" ).accordion();

});

function borrarActividad(idActividad, idGrupo)
{
    $("#borrarAct-confirm").data("idActividad", idActividad).data("idGrupo", idGrupo).dialog("open");
}

function borrarGrupo(idGrupo)
{
    $("#borrarGrupo-confirm").data("idGrupo", idGrupo).dialog("open");
}

function preliminar()
{
    $("#preli").val("1");
    document.formActa.submit();
    $("#preli").val("0");
}
