/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    
     /*$loginForm.on("keyup keypress", function (e) {
     var code = e.keyCode || e.which;
     if (code == 13) {
     e.preventDefault();
     return false;
     }
     });*/
     
     $('#login').validationEngine({
     promptPosition: "bottomLeft",
     scroll: false,
     autoHidePrompt: true,
     autoHideDelay: 3000
     });
     
     
     $('#login').submit(function () {
     var $resultado = $('#login').validationEngine("validate");
     });
	 
	$('#formCrearUsuario').validationEngine({
		 promptPosition: "topRight",
		 scroll: false,
		 autoHidePrompt: true,
		 autoHideDelay: 3000
     });
     
     
     $('#formCrearUsuario').submit(function () {
     var $resultado = $('#formCrearUsuario').validationEngine("validate");
     });

	$('#fechaNaci').datepicker({
            format: 'yyyy-mm-dd',
			language: 'es'
        });

});
