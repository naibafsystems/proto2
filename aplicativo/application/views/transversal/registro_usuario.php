<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <?php echo $retornoExito ?>
    </div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
    <div class="alert alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <?php echo $retornoError ?>
    </div>
    <?php
}
?>
<script>
$(document).ready(function() {

    $("#inputEmailConf").bind('paste', function(e) {
        e.preventDefault();
    });

});

$(document).ready(function() {

    $("#inputEmail").bind('paste', function(e) {
        e.preventDefault();
    });
});

$(document).ready(function() {

    $("#inputClaveConf").bind('paste', function(e) {
        e.preventDefault();
    });

});

$(document).ready(function() {

    $("#inputClave").bind('paste', function(e) {
        e.preventDefault();
    });
});
</script>

<div class="section" style="background-image: url(<?php echo base_url('assets/img/banco_hv.png');?>); background-size: 100% 100%; background-repeat: no-repeat;">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
        	<div class="row" style="background-color: #A1134D; opacity: 0.9; z-index: -10000;">
        		<p><center><h1 style="color: #FFFFFF">BANCO</h1></center></p>
        		<p><center><h1 style="color: #FFFFFF"><b>DE HOJAS DE VIDA</b></h1></center></p>
        	</div>
            <div class="row" style="background-color: white; opacity: 0.9; z-index: 10000;">
                <div class="col-md-12 text-center">
                    <center><h4 class="text-center">&Uacute;nete al <b>banco de hojas de vida</b> y podr&aacute;s participar de las convocatorias del personal operativo de las <b>investigaciones del DANE</b></h4></center>
                </div>
                <div class="col-md-12">
                    <form class="form-horizontal" role="form" id="formCrearUsuario" action="<?php echo base_url('transversal/registro_usuario/guardarUsuario') ?>" name="formCrearUsuario" method="post" autocomplete="off">
                        <div class="form-group has-feedback">
                            <div class="col-sm-6 text-left">
                                <label for="inputTipoIden" class="control-label">Tipo identificaci&oacute;n:</label>
                                <select class="validate[required] form-control select2-select" id="tipo_iden" name="tipo_iden">
                                    <option value=''>Seleccione...</option>
                                    <option value='CC'>C&eacute;dula de Ciudadan&iacute;a</option>                                
                                </select>
                            </div>
                            <div class="col-sm-6 text-left">
                                <label for="inputNombres" class="control-label">N&uacute;mero identificaci&oacute;n:</label>
                                <input type="text" class="validate[required, custom[onlyNumberSp], minSize[4]] form-control" id="inputNumeIden" name="inputNumeIden" placeholder="N&uacute;mero de identificaci&oacute;n">
                                <span class="fa fa-check form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="col-sm-6 text-left">
                                <label for="inputNombres" class="control-label">Nombres:</label>
                                <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="inputNombres" name="inputNombres" placeholder="Nombres">
                                <span class="fa fa-check form-control-feedback"></span>
                            </div>
                            <div class="col-sm-6 text-left">
                                <label for="inputApellidos" class="control-label">Apellidos:</label>
                                <input type="text" class="validate[required, custom[onlyLetterSp]] form-control" id="inputApellidos" name="inputApellidos" placeholder="Apellidos">
                                <span class="fa fa-check form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="col-sm-6 text-left">
                                <label for="inputEmail" class="control-label">Correo electr&oacute;nico:</label>
                                <input type="text" class="validate[required, custom[email]] form-control" id="inputEmail" name="inputEmail" placeholder="Correo electr&oacute;nico">
                                <span class="fa fa-check form-control-feedback"></span>
                            </div>
                            <div class="col-sm-6 text-left">
                                <label for="inputEmail" class="control-label">Confirmar correo electr&oacute;nico:</label>
                                <input type="text" class="validate[required, custom[email]] form-control" id="inputEmailConf" name="inputEmailConf" placeholder="Confirmar correo electr&oacute;nico">
                                <span class="fa fa-check form-control-feedback"></span>
                            </div>
                        </div>                    
                        <div class="form-group has-feedback">
                            <div class="col-sm-6 text-left">
                                <label for="inputClave" class="control-label">Contrase&ntilde;a:</label>
                                <input type="password" class="validate[required, minSize[6]] form-control" id="inputClave" name="inputClave" placeholder="Clave de acceso">
                                <span class="fa fa-check form-control-feedback"></span>
                            </div>
                            <div class="col-sm-6 text-left">
                                <label for="inputClave" class="control-label">Confirmar contrase&ntilde;a:</label>
                                <input type="password" class="validate[required, minSize[6]] form-control" id="inputClaveConf" name="inputClaveConf" placeholder="Confirmar clave de acceso">
                                <span class="fa fa-check form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <div class="col-sm-6 text-left">
                                <label class="control-label">Fecha de nacimiento:</label>
                                <div class="input-group input-append date" id="datePicker">
                                    <input type="text" class="form-control validate[required]" name="fechaNaci" id="fechaNaci" data-date-end-date="-18y"/>
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-6 text-left">
                                <label class="control-label">Sexo:</label>
                                <br>
                                <input class="validate[required]" type="radio" name="sexo" id="sexo" value="F">   Mujer
                                <input class="validate[required]" type="radio" name="sexo" id="sexo" value="M">   Hombre
                            </div>
                        </div>	
                        <div class="form-group has-feedback">
                            <div class="col-sm-12 text-center">
                                Al hacer <b>clic</b> en <b>"Registrarse"</b>, aceptas las condiciones y confirmas que leiste los <a href="#" data-toggle="modal" data-target="#modalConvocatoria">t&eacute;rminos y condiciones de uso</a>
                            </div>                        
                        </div>	
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2 text-center">
                                <button class="btn btn-success" style="background-color: #AD124B; color: #FFFFFF" type="submit"><i class="fa fa-fw fa-check"></i>Registrarse</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Formacion Academica -->
<div class="modal fade bs-example-modal-lg" id="modalConvocatoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">T&eacute;rminos y Condiciones</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-md-10 col-md-offset-1">
                		
<P ALIGN="center"><b>Responsabilidad y T&eacute;rminos de uso</b></P>
<BR>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">En
raz&oacute;n a la exigencia legal consagrada en el art&iacute;culo 15 de la
Constituci&oacute;n Pol&iacute;tica de Colombia y en la Ley 1266 de 2008, Ley
1581 de 2012, Ley 80 de 1993 y dem&aacute;s normas que la modifiquen
reglamenten o desarrollen, el Departamento Administrativo Nacional de
Estad&iacute;stica DANE, presenta los siguientes t&eacute;rminos y condiciones
del proceso y del uso de la informaci&oacute;n:</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><U><b>1.Definiciones previas</b></U></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">Esta
p&aacute;gina establece los "T&eacute;rminos y Condiciones de Uso" que
regulan las pol&iacute;ticas frente al tratamiento de la informaci&oacute;n que
ingresen los aspirantes a iniciar el proceso de selecci&oacute;n celebrar
contrato de prestaci&oacute;n de servicios con el Departamento
Administrativo Nacional de Estad&iacute;stica.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">Por
favor, lea esta p&aacute;gina atentamente. Si no acepta estas Condiciones
Generales, no utilice este Sitio Web. Al utilizar este Sitio, usted
declara la aceptaci&oacute;n de las Condiciones Generales del proceso de
selecci&oacute;n con miras a la celebraci&oacute;n de contrato de prestaci&oacute;n de
servicios para desarrollar actividades dentro de los diferentes
operativos mediante los cuales el DANE &ndash; FONDANE cumple con su
objeto misional y legal. DANE - FONDANE puede revisar estos T&eacute;rminos
y Condiciones de Uso en cualquier momento, actualizando esta p&aacute;gina.
Usted deber&iacute;a visitar esta p&aacute;gina cada vez que acceda al Sitio para
revisar los T&eacute;rminos y Condiciones de Uso, puesto que le vinculan.
Enti&eacute;ndase de la lectura la sigla "DANE" el nombre
"Departamento Administrativo Nacional de Estad&iacute;stica" y
FONDANE â€œFondo Rotatorio del DANEâ€�. El presente aplicativo est&aacute;
conformado por el conjunto de candidatos que han inscrito su hoja de
vida en el sistema. Los candidatos son las personas naturales que
inscriben su curr&iacute;culo en el aplicativo, con el fin de postularse a
la selecci&oacute;n de contratistas que corresponden con su perfil
ocupacional.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><U><b>2. Objeto</b></U></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">Establecer
los principios y los mecanismos para el ingreso de datos en el
aplicativo, las normas que rigen el proceso de selecci&oacute;n y la forma
de proteger los derechos de los ciudadanos cuya informaci&oacute;n reposa
en el aplicativo del DANE &ndash; FONDANE y fijar el procedimiento que se
seguir&aacute; para el manejo de la informaci&oacute;n contenida en dicho banco
de datos.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><U><b>3. &Aacute;mbito de aplicaci&oacute;n</b></U></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">Estos
t&eacute;rminos de uso se aplicar&aacute;n a las personas que tienen el acceso al
aplicativo del DANE &ndash; FONDANE, ya sean funcionarios de la entidad,
personal de entidades en acceso a sus fuentes de informaci&oacute;n y
ciudadanos inscritos en el mismo.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><U><b>4. Ley aplicable y jurisdicci&oacute;n</b></U></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">El
usuario no podr&aacute; manifestar ante el Departamento Administrativo
Nacional de Estad&iacute;stica - DANE &ndash; FONDANE o ante una autoridad
judicial o administrativa, la aplicaci&oacute;n de condici&oacute;n, norma o
convenio que no est&eacute; expresamente incorporado en las presentes
condiciones de uso, salvo las excepciones constitucionales
correspondientes. - Estas condiciones ser&aacute;n gobernadas por las leyes
de la Rep&uacute;blica de Colombia, en los aspectos que no est&eacute;n
expresamente regulados en ellas. - Si cualquier disposici&oacute;n de estas
condiciones pierde validez o fuerza obligatoria, por cualquier raz&oacute;n,
todas las dem&aacute;s disposiciones, conservan su fuerza obligatoria,
car&aacute;cter vinculante y generar&aacute;n todos sus efectos. - Para cualquier
efecto legal o judicial, el domicilio  de las presentes condiciones
es la ciudad de Bogot&aacute;, Rep&uacute;blica de Colombia, y cualquier
controversia que surja de su interpretaci&oacute;n o aplicaci&oacute;n se
someter&aacute; a los jueces de la Rep&uacute;blica de Colombia.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><U><b>5. Principios que rigen los t&eacute;rminos y condiciones de uso</b></U></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">En el
desarrollo, interpretaci&oacute;n y aplicaci&oacute;n del presente documento, se
tendr&aacute;n en cuenta los siguientes principios: Calidad de los
Registros o Datos. En virtud de este principio la informaci&oacute;n a que
se refiere este documento y suministrada por los ciudadanos inscritos
debe ser veraz, exacta, actualizada, comprobable y comprensible, de
tal manera que refleje la situaci&oacute;n real presente de los
intervinientes en los procesos de selecci&oacute;n, si esta informaci&oacute;n no
cumple con alguna de las condiciones aqu&iacute; descritas se aplicar&aacute;n
las sanciones que determine el reglamento de este aplicativo.
Circulaci&oacute;n restringida (limitaci&oacute;n de su uso al objeto del DANE &ndash;
FONDANE). Al no estar expresamente autorizada la divulgaci&oacute;n de la
informaci&oacute;n, por parte del titular de los datos, es imposible el uso
para otros fines diferentes al que motiv&oacute; el suministro de los
datos. Principio del Respeto de los Derechos Constitucionales. Las
actividades de inscripci&oacute;n, recepci&oacute;n, almacenamiento,
procesamiento y suministro de la informaci&oacute;n deben respetar las
normas y principios constitucionales. Libertad. En virtud del cual
los datos personales que no tienen naturaleza p&uacute;blica, a los que se
refiere el presente documento s&oacute;lo pueden ser registrados y
divulgados con el consentimiento libre, previo y expreso del titular,
en los t&eacute;rminos previstos en el presente documento. Respeto al Buen
Nombre. En desarrollo del cual corresponde tanto a las fuentes y
usuarios como al DANE &ndash; FONDANE, respetar el derecho al buen nombre
de los titulares de la informaci&oacute;n. En tal sentido, la informaci&oacute;n
que reporten, utilicen o administren deber&aacute; cumplir con las
condiciones de calidad se&ntilde;aladas en el presente documento. .
Garant&iacute;a al Acceso de la Informaci&oacute;n. Seg&uacute;n el cual se garantiza a
los titulares de la informaci&oacute;n a que se refiere este documento, en
todo tiempo, el conocimiento, actualizaci&oacute;n y rectificaci&oacute;n de la
informaci&oacute;n registrada en las bases de datos del DANE &ndash; FONDANE
con las limitaciones propias de la din&aacute;mica del proceso de
selecci&oacute;n. Seguridad. En virtud del cual la informaci&oacute;n que reposa
en las fuentes de informaci&oacute;n y en el aplicativo DANE &ndash; FONDANE,
se manejar&aacute; con las medidas t&eacute;cnicas necesarias para garantizar la
seguridad de los registros, evitando su adulteraci&oacute;n, p&eacute;rdida,
consulta o uso no autorizado. Gratuidad. En atenci&oacute;n a este
principio, los servicios prestados por el aplicativo corresponden a
un servicio p&uacute;blico, gratuito e indiscriminado, bajo lo cual se
entiende que la inscripci&oacute;n, recepci&oacute;n, almacenamiento,
procesamiento y uso de la informaci&oacute;n que reposa en el aplicativo no
constituye ninguna clase de erogaci&oacute;n econ&oacute;mica a los usuarios que
utilicen el sistema. 
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><U><b>6. Normas de uso general</b></U></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b>6.1Postulaci&oacute;n.</b> La postulaci&oacute;n de candidatos se realiza mediante el
proceso de auto consulta, donde los candidatos eval&uacute;an desde su
consulta personalizada las convocatorias que se ajustan a su
formaci&oacute;n acad&eacute;mica y experiencia laboral.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b>6.2 Informaci&oacute;n incluida en el aplicativo por los usuarios en general.</b>
Como usuario usted es responsable de la informaci&oacute;n suministrada en
las bases de datos del aplicativo DANE -FONDANE y ser&aacute;n los usuarios
los &uacute;nicos responsables de la veracidad, actualizaci&oacute;n,
consolidaci&oacute;n, complementaci&oacute;n y afirmaciones propias que reposan
en la hoja de vida y por las consecuencias de incluir o colocar dicha
informaci&oacute;n en el aplicativo.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b>6.3 Obligaciones de los usuarios en general.</b> Los usuarios est&aacute;n
obligados a lo siguiente: (1) registrar informaci&oacute;n veraz, seria, y
verificable de la exigida dentro del aplicativo, fuese personal,
laboral, de formaci&oacute;n. (2) mantener actualizada la informaci&oacute;n,
verificar la existencia real y actual de los documentos y dem&aacute;s
requisitos afirmados en la informaci&oacute;n personal y empresarial de los
usuarios so pena de inactivar la permanencia de la informaci&oacute;n
contenida en el aplicativo y las consecuencias que se establecen en
el reglamento expedido  parte del DANE. (3) autorizar el acceso de
los funcionarios del DANE &ndash; FONDANE para que conozca el contenido
de las hojas de vida del aplicativo. Los usuarios no podr&aacute;n: (i)
incluir o colocar en aplicativo cualquier clase de informaci&oacute;n o
herramientas que est&eacute;n protegidos por las leyes sobre derechos de
autor, a menos que sea el propietario de tales derechos o haya
obtenido permiso del propietario de tales derechos para incluir tal
material en el aplicativo, (ii) incluir o colocar en el aplicativo
informaci&oacute;n confidencial que atente contra la reserva industrial o
comercial a menos que sea el propietario de los mismos o haya
obtenido autorizaci&oacute;n del propietario, (iii) incluir material
obsceno, difamatorio, abusivo, amenazante u ofensivo que pudiese
atentar contra los derechos de otro usuario o cualquier otra persona
o entidad, (iv) incluir en el aplicativo im&aacute;genes o declaraciones
pornogr&aacute;ficas o que incluyan sexo expl&iacute;cito, (v) incluir o colocar
en el aplicativo cualquier clase de informaci&oacute;n que pudiese
considerarse publicidad o anuncios publicitarios o pol&iacute;ticos,
cadenas de cartas, virus, caballos de Troya, bombas de tiempo o
cualquier programa de computador o herramienta con la intenci&oacute;n de
da&ntilde;ar, interferir, interceptar o apropiarse de cualquier sistema,
datos o informaci&oacute;n.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b>6.4 Reglas de Seguridad del DANE &ndash; FONDANE:</b> Se proh&iacute;be a los usuarios
violar o intentar violar la seguridad del aplicativo, incluyendo pero
no limit&aacute;ndose a: (a) acceder a datos que no est&eacute;n destinados a tal
usuario o entrar en un servidor o cuenta cuyo acceso no est&aacute;
autorizado al usuario, (b) evaluar o probar la vulnerabilidad de un
sistema o red, o violar las medidas de seguridad o identificaci&oacute;n
sin la adecuada autorizaci&oacute;n, (c) intentar impedir el servicio a
cualquier usuario, anfitri&oacute;n o red, incluyendo sin limitaci&oacute;n,
mediante el env&iacute;o de virus al Sitio Web, o mediante saturaci&oacute;n,
env&iacute;os masivos ("flooding"), "spamming",
bombardeo de correo o bloqueos del sistema ("crashing"),
(d) enviar correos no pedidos, incluyendo promociones y/o publicidad
de productos o servicios. (e) falsificar cualquier cabecera de
paquete TCP/IP o cualquier parte de la informaci&oacute;n de la cabecera de
cualquier correo electr&oacute;nico o en mensajes de foros de debate. (f)
Borrar, adulterar, filtrar, deshabilitar o revisar cualquier material
e informaci&oacute;n anunciado por otra persona o entidad. En caso de que
un usuario administrador o el mismo DANE - FONDANE corrobore la
existencia de informaci&oacute;n que presuntamente no cumpla estas
obligaciones de los usuarios, DANE &ndash; FONDANE se reserva el derecho
de investigar y determinar de buena fe y, a su exclusiva discreci&oacute;n,
el derecho de retirar o solicitar que sean excluidas dichas
comunicaciones, as&iacute; como determinar las situaciones de suspensi&oacute;n o
la deshabilitaci&oacute;n definitiva del usuario infractor y siempre ser&aacute;
obligaci&oacute;n del DANE &ndash; FONDANE poner en conocimiento de las
autoridades competentes judiciales y administrativas los hechos
considerados como posibles faltas disciplinarias o punibles penales. 
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b> 6.5 El uso del Material.</b> La denominaci&oacute;n "material y herramientas"
comportan todos y cada uno de los contenidos de este aplicativo Web,
tales como textos, gr&aacute;ficos, im&aacute;genes, logotipos, s&iacute;mbolos,
informaciones e iconos de bot&oacute;n, software y cualquier otro material.
Queda prohibida la utilizaci&oacute;n de las marcas y nombres p&uacute;blicos
DANE &ndash; FONDANE, con intento de defraudar, desinformar, confundir u
obtener beneficios de la utilizaci&oacute;n de los mencionados nombres. La
utilizaci&oacute;n del material y las marcas de manera fraudulenta o
irregular podr&aacute; configurar faltas y delitos protegidos por la ley
colombiana vigente. 
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b>6.6 Registro y Contrase&ntilde;a.</b> Los usuarios del aplicativo en general  son
los responsables de mantener la confidencialidad y custodia de sus
datos y de su contrase&ntilde;a. Ser&aacute;n as&iacute; mismo, responsables de todos
los usos de su registro. En caso de olvido, manipulaci&oacute;n,
inactivaci&oacute;n o sospecha de fraude o utilizaci&oacute;n indebida los
usuarios deber&aacute;n notificar inmediatamente al DANE &ndash; FONDANE
cualquier uso sin autorizaci&oacute;n de su registro o contrase&ntilde;a. 
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b>7 Responsabilidades y garant&iacute;as del DANE &ndash; FONDANE</b></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">El
aplicativo del DANE &ndash; FONDANE es exclusivamente un Servicio
abierto, gratuito e indiscriminado que busca que los ciudadanos
interesados en prestar sus servicios al DANE-FONDANE ingresen sus
datos para participar en los diferentes procesos de selecci&oacute;n, los
cuales se rigen por la Ley 80 de 1993, Ley 1150 de 2007, Decreto 2474
de 2008, Decreto 1510 de 2013 y dem&aacute;s normas que conforman el
Estatuto General de la Contrataci&oacute;n P&uacute;blica, por lo cual al
ingresar sus datos no se genera ning&uacute;n tipo de obligaci&oacute;n de
vinculaci&oacute;n por parte del DANE &ndash; FONDANE o expectativas de orden
laboral. 
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><b>8. Causales de inactivaci&oacute;n</b></P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><A NAME="_GoBack"></A>
Cualquier clase de acceso, intervenci&oacute;n o manejo considerado como
fraudulento, da&ntilde;ino, malintencionado y malicioso, de los
reglamentados anteriormente en las obligaciones de los usuarios,
comprobado o sospechoso, ser&aacute; potestativo para que el DANE &ndash;
FONDANE de manera discrecional pueda suspender el acceso al
aplicativo. La suspensi&oacute;n o inactivaci&oacute;n del servicio al usuario
ser&aacute; potestativo del DANE &ndash; FONDANE y se determinara teniendo en
cuenta la gravedad de la situaci&oacute;n, el compromiso del DANE &ndash;
FONDANE y las consecuencias a terceras personas por la acci&oacute;n, de
igual forma, el DANE &ndash; FONDANE dar&aacute; traslado a las autoridades
competentes a fin de que apliquen las sanciones del caso si a esto
hubiere lugar.</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"> 
</P>
	</div>
                </div>
            </div>

        </div>
    </div>
</div>
