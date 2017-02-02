/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
	
    var btnCust = '<button type="button" class="btn btn-default" title="Add picture tags" ' + 
    'onclick="alert(\'Call your custom code here.\')">' +
    '<i class="glyphicon glyphicon-tag"></i>' +
    '</button>'; 
	$("#avatar").fileinput({
		overwriteInitial: true,
		maxFileSize: 1500,
		showClose: false,
		showCaption: false,
		browseLabel: '',
		removeLabel: '',
		browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
		removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		removeTitle: 'Cancel or reset changes',
		elErrorContainer: '#kv-avatar-errors',
		msgErrorClass: 'alert alert-block alert-danger',
		defaultPreviewContent: '<img src="'  + baseurl + '/uploads/avatar.png" alt="Your Avatar" style="width:200px">',
		layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
		allowedFileExtensions: ["jpg", "png", "gif"]
	});
	
	$('#formFormacion').validationEngine({
		 promptPosition: "bottomLeft",
		 scroll: false,
		 autoHidePrompt: true,
		 autoHideDelay: 3000
     });
     
     $('#memberModal').modal('show');
     
     $('#formFormacion').submit(function () {
		var $resultado = $('#formFormacion').validationEngine("validate");
     });

	$('#formExperiencia').validationEngine({
		 promptPosition: "bottomLeft",
		 scroll: false,
		 autoHidePrompt: true,
		 autoHideDelay: 3000
     });
     
     
     $('#formExperiencia').submit(function () {
		var $resultado = $('#formExperiencia').validationEngine("validate");
     });
	 
	$('#formCargaAvatar').validationEngine({
		 promptPosition: "bottomLeft",
		 scroll: false,
		 autoHidePrompt: true,
		 autoHideDelay: 3000
     });
     
     
     $('#formCargaAvatar').submit(function () {
		var $resultado = $('#formCargaAvatar').validationEngine("validate");
     });
	 
	$('#fechaIng').datepicker({
            format: 'yyyy-mm-dd',
			language: 'es',
			endDate: '0d'
        });
		
	$('#fechaRet').datepicker({
            format: 'yyyy-mm-dd',
			language: 'es',
			endDate: '0d'
        });	 

	$('#fechaTerm').datepicker({
            format: 'yyyy-mm-dd',
			language: 'es',
			endDate: '0d'
        });
		
	$('#fechaTarj').datepicker({
            format: 'yyyy-mm-dd',
			language: 'es',
			endDate: '0d'
        });	
		
	
	$("#nivel").change(function() {
		$("#nivel option:selected").each(function() {
			nivel = $('#nivel').val();
			areas = $('#areas').val();
			$.post(baseurl+"ciudadano/principal/cargaPrograma", {
				nivel : nivel,
				areas : areas
			}, function(data) {
				$("#programa").html(data);
			});
		});
	});	
	
	$("#areas").change(function() {
		$("#areas option:selected").each(function() {
			nivel = $('#nivel').val();
			areas = $('#areas').val();
			$.post(baseurl+"ciudadano/principal/cargaPrograma", {
				nivel : nivel,
				areas : areas
			}, function(data) {
				$("#programa").html(data);
			});
		});
	});	
	
			
	$("input:radio[name=graduado]").change(function() {
		
		if($('input:radio[name=graduado]:checked').val() == 'S')
			{
				nivel = $('#nivel').val();

				if(nivel == 8 || nivel == 9 || nivel == 10 || nivel == 11)
				{
					$("#div_valGraduado").css("display", "none");
					$("#div_soptarje").css("display", "none");
				}else if(nivel == 2 || nivel == 3){
					$("#div_valGraduado").css("display", "block");			
					$("#div_fechatermi").css("display", "block");
				}else if(nivel == 4 || nivel == 5 || nivel == 6){
					$("#div_valGraduado").css("display", "block");			
					$("#div_fechatermi").css("display", "block");
					$("#div_soptarje").css("display", "none");
				}
				else{
					$("#div_valGraduado").css("display", "block");
					$("#div_fechatermi").css("display", "block");
					$("#div_fechatarje").css("display", "block");					
					$("#div_soptarje").css("display", "block");
					$("#actSopTarj").css("display", "block");
				}
			}else if($('input:radio[name=graduado]:checked').val() == 'N')
			{
				$("#div_valGraduado").css("display", "none");
				$("#div_soptarje").css("display", "none");
			}
	});		
	
	$("#pais").change(function() {
		$("#pais option:selected").each(function() {
			pais = $('#pais').val();
			$.post(baseurl+"ciudadano/principal/cargaDepto", {
				pais : pais
			}, function(data) {
				if(pais != 'COL')
				{
					$("#municipio").html('<option value="0">No existen municipios asociados</option>');
					$("#municipio").removeClass('validate[required]');
					$("#departamento").html('<option value="0">No existen departamentos asociados</option>');
					$("#departamento").removeClass('validate[required]');
				}else
				{
					$("#departamento").html(data);
					$("#municipio").addClass('validate[required]');
					$("#departamento").addClass('validate[required]');
				}				
			});
		});
	});	
	
	$("#departamento").change(function() {
		$("#departamento option:selected").each(function() {
			departamento = $('#departamento').val();
			$.post(baseurl+"ciudadano/principal/cargaMuni", {
				departamento : departamento
			}, function(data) {
				$("#municipio").html(data);
			});
		});
	});	
	
	$("input:checkbox[name=fechaAct]").change(function() {

		if($('input:checkbox[name=fechaAct]:checked').val() == 'on')
			{
				$("#fechaRet").removeClass("validate[required]");
			}else 
			{
				$("#fechaRet").addClass("validate[required]");
			}
	});
	
	if($('input:checkbox[name=fechaAct]:checked').val() == 'on')
	{
		$("#fechaRet").removeClass("validate[required]");
	}else 
	{
		$("#fechaRet").addClass("validate[required]");
	}
	
	$("#nivel").change(function() {
		$("#nivel option:selected").each(function() {
			nivel = $('#nivel').val();
			
			
			$("#div_valGraduado").css("display", "block");
            $("#div_graduado").css("display", "block");

            $("#div_semestres").css("display", "block");
            $("#div_modalidad").css("display", "block");
            $("#div_areacono").css("display", "block");
            $("#div_programa").css("display", "block");
            $("#div_fechatarje").css("display", "block");
            $("#div_soptarje").css("display", "block");
            $("#div_fechatermi").css("display", "block");
            $("#div_sopforma").css("display", "block");
            
			
			if(nivel == 8 || nivel == 9 || nivel == 10)
			{
	            $("#div_valGraduado").css("display", "none");
	            $("#div_soptarje").css("display", "none");
	            $("#div_graduado").css("display", "none");
	            
	            if(nivel == 8 || nivel == 9){
	            	$("#div_valGraduado").css("display", "block");
	            	$("#div_fechatermi").css("display", "block");
	            	$("#div_fechatarje").css("display", "none");
	            }
	            
			}else if(nivel == 11)
			{
	            $("#div_graduado").css("display", "none");
	            $("#div_modalidad").css("display", "none");
	            $("#div_areacono").css("display", "none");
	            $("#div_programa").css("display", "none");
	            $("#div_fechatarje").css("display", "none");
	            $("#div_soptarje").css("display", "none");
	        }else if(nivel == 2 || nivel == 3 || nivel == 4 || nivel == 5 || nivel == 6)
			{	           
	            $("#div_soptarje").css("display", "none");
	            $("#div_fechatarje").css("display", "none");
	        }else{
	            $("#div_valGraduado").css("display", "block");

	            $('input:radio[name=graduado][value=S]').click();
	            
	            $("#div_graduado").css("display", "block");
	
	            $("#div_semestres").css("display", "block");
	            $("#div_modalidad").css("display", "block");
	            $("#div_areacono").css("display", "block");
	            $("#div_programa").css("display", "block");
	            $("#div_fechatarje").css("display", "block");
	            $("#div_soptarje").css("display", "block");
	            $("#div_sopforma").css("display", "block");
			}			
		});
	});	
	
			
	$("input:radio[name=sexo]").change(function() {
		
		if($('input:radio[name=sexo]:checked').val() == 'M')
			{
				$("#div_libreta").css("display", "none");
			}else if($('input:radio[name=sexo]:checked').val() == 'F')
			{
				$("#div_libreta").css("display", "none");
			}
	});	
	
	
	$("input:radio[name=cambDI]").change(function() {
		
		if($('input:radio[name=cambDI]:checked').val() == 'S')
			{
				$("#div_docIden").css("display", "block");
			}else if($('input:radio[name=cambDI]:checked').val() == 'N')
			{
				$("#div_docIden").css("display", "none");
			}
	});	
	
	$("input:radio[name=cambLM]").change(function() {
		
		if($('input:radio[name=cambLM]:checked').val() == 'S')
			{
				$("#div_libretaCamb").css("display", "block");
			}else if($('input:radio[name=cambLM]:checked').val() == 'N')
			{
				$("#div_libretaCamb").css("display", "none");
			}
	});	
	
	$("input:radio[name=cambDF]").change(function() {
		
		if($('input:radio[name=cambDF]:checked').val() == 'S')
			{
				$("#actSopForm").css("display", "block");
			}else if($('input:radio[name=cambDF]:checked').val() == 'N')
			{
				$("#actSopForm").css("display", "none");
			}
	});
	 
	$("input:radio[name=cambDTP]").change(function() {
		
		if($('input:radio[name=cambDTP]:checked').val() == 'S')
			{
				$("#actSopTarj").css("display", "block");
			}else if($('input:radio[name=cambDTP]:checked').val() == 'N')
			{
				$("#actSopTarj").css("display", "none");
			}
	});
	
	$("input:radio[name=cambDE]").change(function() {
		
		if($('input:radio[name="cambDE"]:checked').val() == 'S')
			{
				$("#actSopExp").css("display", "block");
			}else if($('input:radio[name="cambDE"]:checked').val() == 'N')
			{
				$("#actSopExp").css("display", "none");
			}
	});
	
	
	$('#tabs').tab();
	
	
	// Setup - add a text input to each footer cell
    $('#ciud_abie tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#ciud_abie').DataTable();
 
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
    $('#ciud_part tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#ciud_part').DataTable();
 
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
    $('#ciud_cerra tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#ciud_cerra').DataTable();
 
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
	
	
	
	
});
