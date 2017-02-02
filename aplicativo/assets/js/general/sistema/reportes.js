$(document).ready(function () {

    
    /*$('#tablaReportes').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        language: textoTablas    
    } );
	*/
	$('#tablaReportes').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
        ]
    } );
	

});