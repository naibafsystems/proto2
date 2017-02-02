/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
	
	$(".select2").select2();
	
    $("select#ciudades").treeMultiselect({sortable: false, collapsible: true, startCollapsed: true});
    
    $('#formConvocatoriaActA').validationEngine({
        promptPosition: "bottomLeft",
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });
    $('#formConvocatoriaActA').submit(function () {
        var $resultado = $('#formConvocatoriaActA').validationEngine("validate");
    });
    
    $('#formConvocatoriaActC').validationEngine({
        promptPosition: "bottomLeft",
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });
    $('#formConvocatoriaActC').submit(function () {
        var $resultado = $('#formConvocatoriaActC').validationEngine("validate");
    });
    
	$("input:radio[name=cambDC]").change(function() {
			
			if($('input:radio[name=cambDC]:checked').val() == 'S')
				{
					$("#actSopConv").css("display", "block");
				}else if($('input:radio[name=cambDC]:checked').val() == 'N')
				{
					$("#actSopConv").css("display", "none");
				}
		});
    
    $('#formConvocatoria').validationEngine({
        promptPosition: "bottomLeft",
        scroll: false,
        autoHidePrompt: true,
        autoHideDelay: 3000
    });
    $('#formConvocatoria').submit(function () {
        var $resultado = $('#formConvocatoria').validationEngine("validate");
    });
    $('#fechaInicio').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es'
    });
    $('#fechaFin').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es'
    });
    $("select#area").treeMultiselect({
        sortable: false,
        collapsible: true,
        hideSidePanel: true,
        sectionDelimiter: '/',
        startCollapsed: true
    });
    $("#nivel").change(function () {
        $("#nivel option:selected").each(function () {
            nivel = $('#nivel').val();
            $.post(baseurl + "administrador/convocatorias/cargaPrograma", {
                nivel: nivel
            }, function (data) {
                $("#area").html(data);
            });
        });
    });
    
    $("#investigacion").change(function () {
        $("#investigacion option:selected").each(function () {
            
            investigacion = $('#investigacion').val();
            rol = $('#rol').val();
            
            $.post(baseurl + "administrador/convocatorias/cargaInfoPerfil", {
                investigacion: investigacion,
                rol: rol
            }, function (data) {
                $("#perfil").html(data);
            });
            
            
            $.post(baseurl + "administrador/convocatorias/cargaInfoObjeto", {
                investigacion: investigacion,
                rol: rol
            }, function (data) {
                $("#objeto").html(data);
            });
        });
    });

    
    $("#rol").change(function () {
        $("#rol option:selected").each(function () {
            
            investigacion = $('#investigacion').val();
            rol = $('#rol').val();
            
            $.post(baseurl + "administrador/convocatorias/cargaInfoPerfil", {
                investigacion: investigacion,
                rol: rol
            }, function (data) {
                $("#perfil").html(data);
            });
            
            
            $.post(baseurl + "administrador/convocatorias/cargaInfoObjeto", {
                investigacion: investigacion,
                rol: rol
            }, function (data) {
                $("#objeto").html(data);
            });
        });
    });
    /*
    $('#tb-invitaciones tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#tb-invitaciones').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            
                that.search( this.value, true, true ).draw();
            
        } );
    } );
    */
    
    //$('#my-table').DataTable();
    
    $('#tb-invitaciones').DataTable( {
	    dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,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'
                    } );
                }
            }
        ]
	} );
 
    $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    } );
 
    $('input.column_filter').on( 'keyup click', function () {
        filterColumn( $(this).parents('tr').attr('data-column') );
    } );
    
    //$('#tb_inscritos').DataTable();
    
    $('#tb-resultado').DataTable();

	$('#tablaUsuarios').DataTable();
	
	/*$('#tablaReportesNOOOOOOOOOOOOO').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                // Loop over the cells in column `F`
                $('row c[r^="F"]', sheet).each( function () {
                    // Get the value and strip the non numeric characters
                    if ( $('is t', this).text().replace(/[^\d]/g, '') * 1 >= 500000 ) {
                        $(this).attr( 's', '20' );
                    }
                });
            }
        }]
    });*/	
    
    
	
	$('.fechaConv').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es'
    });
	
	
	// Setup - add a text input to each footer cell
    $('#admin_abier tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#admin_abier').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
    
    // Setup - add a text input to each footer cell
    $('#admin_cerra tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#admin_cerra').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
    
    $(".modal-wide").on("show.bs.modal", function() {
	  var height = $(window).height() - 200;
	  $(this).find(".modal-body").css("max-height", height);
	});
	
	
	$("#btn-buscar").click(function() {
	  	documento = $('#documento').val();
        nombres = $('#nombres').val();
        apellidos = $('#apellidos').val();
        correo = $('#correo').val();
        
        $('#modalCargando').modal('show');
        
        $.post(baseurl + "administrador/usuarios/cargaDatosUsuario", {
            documento: documento,
            nombres: nombres,
            apellidos: apellidos,
            correo: correo
        }, function (data) {
            $("#informacion").html(data);
            $('#modalCargando').modal('hide');
        });
	});
	
	$("#btn-administrar").click(function() {
	  	documento = $('#documento').val();
        nombres = $('#nombres').val();
        apellidos = $('#apellidos').val();
        correo = $('#correo').val();
        
        $('#modalCargando').modal('show');
        
        $.post(baseurl + "administrador/adm_usuarios/cargaDatosUsuario", {
            documento: documento,
            nombres: nombres,
            apellidos: apellidos,
            correo: correo
        }, function (data) {
            $("#informacion").html(data);
            $('#modalCargando').modal('hide');
        });
	});
	
	$("#btn-reporte").click(function() {
	  	operativo = $('#operativo').val();
        encuesta = $('#encuesta').val();
        rol = $('#rol').val();
        ciudad = $('#city').val();
        convocatoria = $( "input:checked" ).val();
        
        //input:radio[name=edad]:checked'
        
        $('#modalCargando').modal('show');
        
        $.post(baseurl + "administrador/reportesTotalizados/cargaReporte", {
            operativo: operativo,
            encuesta: encuesta,
            rol: rol,
            ciudad: ciudad,
            convocatoria: convocatoria
        }, function (data) {
            $("#informacion").html(data);
            $('#modalCargando').modal('hide');
        });
	});
	
	
	$("#btn-reporteHistorico").click(function() {
	  	operativo = $('#operativo').val();
        encuesta = $('#encuesta').val();
        rol = $('#rol').val();
        experiencia = $('#experiencia').val();
        cedula = $('#cedula').val();
        nombreC = $('#nombreC').val();
        
        $('#modalCargando').modal('show');
        
        $.post(baseurl + "coordinador/reporteHistorico/cargaReporte", {
            operativo: operativo,
            encuesta: encuesta,
            rol: rol,
            experiencia: experiencia,
            cedula: cedula,
            nombreC: nombreC
        }, function (data) {
            $("#informacion").html(data);
            $('#modalCargando').modal('hide');
        });
	});
	
	$("#btn-reporteConvCerrada").click(function() {
	  	operativo = $('#operativo').val();
        encuesta = $('#encuesta').val();
        rol = $('#rol').val();
        cedula = $('#cedula').val();
        nombreC = $('#nombreC').val();
        
        $('#modalCargando').modal('show');
        
        $.post(baseurl + "coordinador/reporteConvCerradas/cargaReporte", {
            operativo: operativo,
            encuesta: encuesta,
            rol: rol,
            cedula: cedula,
            nombreC: nombreC
        }, function (data) {
            $("#informacion").html(data);
            $('#modalCargando').modal('hide');
        });
	});
	
	$("#btn-reporteHistoricoAdmin").click(function() {
	  	operativo = $('#operativo').val();
        encuesta = $('#encuesta').val();
        rol = $('#rol').val();
        experiencia = $('#experiencia').val();
        cedula = $('#cedula').val();
        nombreC = $('#nombreC').val();
        ciudad = $('#city').val();
        
        $('#modalCargando').modal('show');
        
        $.post(baseurl + "administrador/reporteHistorico/cargaReporte", {
            operativo: operativo,
            encuesta: encuesta,
            rol: rol,
            experiencia: experiencia,
            cedula: cedula,
            nombreC: nombreC,
            ciudad: ciudad,
        }, function (data) {
            $("#informacion").html(data);
            $('#modalCargando').modal('hide');
        });
	});
	
	$("#btn-reporteConvCerradaAdmin").click(function() {
	  	operativo = $('#operativo').val();
        encuesta = $('#encuesta').val();
        rol = $('#rol').val();
        cedula = $('#cedula').val();
        nombreC = $('#nombreC').val();
        ciudad = $('#city').val();
        
        $('#modalCargando').modal('show');
        
        $.post(baseurl + "administrador/reporteConvCerradas/cargaReporte", {
            operativo: operativo,
            encuesta: encuesta,
            rol: rol,
            cedula: cedula,
            nombreC: nombreC,
            ciudad: ciudad,
        }, function (data) {
            $("#informacion").html(data);
            $('#modalCargando').modal('hide');
        });
	});
	
	$('#btnAgregarNivel').click(function () {

        var $totalExtA = $("#divNuevoNivel .row").length;

        var $nuevoDivExtA = $totalExtA + 1;

        if ($totalExtA < 6) {
            var $clon = $('#div_nivel_ext').clone().appendTo('#divNuevoNivel');
            $clon.show();

            $('#divNuevoNivel .row:last-child :input').each(function (index)
            {
                var idAtrr = $(this).attr("id");

                switch (idAtrr) {
                    case 'nivel-1':
                        $(this).attr("id", "nivel-" + $nuevoDivExtA);
                        $("#nivel-" + $nuevoDivExtA).val('');
                        break;
                    case 'semestres-1':
                        $(this).attr("id", "semestres-" + $nuevoDivExtA);
                        break;
                    case 'experiencia-1':
                        $(this).attr("id", "experiencia-" + $nuevoDivExtA);
                        break;                    
                }
            });
        }
    });

    $('#btnBorrarNivel').click(function () {

        var $totalExt = $("#divNuevoNivel .row").length;
        var $totalAnt = document.getElementById("tam").value;
        if ($totalExt > $totalAnt) {
            $("#divNuevoNivel .row:last-child").remove()
        }
    });

});
function ifSelectNotEmpty(field, rules, i, options) {
    if ($(field).find("option").length > 0 &&
            $(field).find("option:selected").length == 0) {
        // this allows the use of i18 for the error msgs
        return "* This field is required";
    }
}

function filterGlobal () {
    $('#tb-invitaciones').DataTable().search(
        $('#global_filter').val(),true,false
    ).draw();
}
 
function filterColumn ( i ) {
    $('#tb-invitaciones').DataTable().column( i ).search(
        $('#col'+i+'_filter').val(),true,false
    ).draw();
}
