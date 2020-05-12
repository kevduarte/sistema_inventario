<style>
body{
  margin: 0;
}
#firma { position: fixed; left: 10px; bottom: : 400px; right: 50px; height: 300px; color:#0B0B3B; }
    
    #footer { position: fixed; left: 10px; bottom: 10px; right: 50px; height: 50px; color:#0B0B3B;  }
    #footer .page:after { }

#datos {border:2px solid; width:50%; text-align:center}
#datos tr {border:2px solid;}
#datos tr td{border:2px solid;}



</style>
<body style="background:url(/image/logos_ito/fondo1.png); background-size:cover; background-position:center; background-repeat:no-repeat; background-color: transparent ;">



<?php
$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
              'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
     $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
                 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
   ?>

<table id="encabezado" >

  <tr>
  <td id="col_1" ><img width="320" height="85" src="image/logos_ito/edu.png"></td>

  <td id="col_2"><img width="380" height="100" src="image/logos_ito/dpto.png"></td>
  </tr>

  <tr >
 
    <td colspan="2" align="center" ><span align="center" style="font-size:11px; color:#757575;">{{$cabecera}}</span></td>

  </tr>

 


  <tr>
  <td id="col_3"><td colspan="2" align="right"><span style="font-size:12px;">Oaxaca de Ju&aacute;rez,Oax, 
    <span style="background-color:black; color:#FFFFFF;"><?php

  $fechaActual = date('d-m-Y');
 echo $fechaActual;
?></span> </span></td></td>
  </tr>

   
  
  <td id="col_5">
  <td colspan="2" align="right"><span style="font-size:12px; font-family: 'Arial, Helvetica', sans-serif;"><strong>Laboratorio de ingenier&iacute;a civil.
    </td>

</table>


<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">

<h4><center>Relaci&oacute;n de estudiantes inscritos durante el semestre: {{$semestre->nombre_semestre}}</center></h4>

<table align="left"  >
    <tr>
      <td colspan="1" style="font-size: 14px;"><strong>Grupo:</strong> </td>
      <td style="font-size: 11px;">{{$datos_extra->grupo}}</td>
        <td colspan="1" style="font-size: 14px;"><strong>Materia:</strong> </td>
      <td style="font-size: 11px;">{{$datos_extra->materia}}</td>

      
    </tr>
    <br/><br/><br/>
   <tr>
    <td colspan="1" style="font-size: 15px;"><strong>Horario:</strong> </td>
    <td style="font-size: 14px;">{{date("H:i ", strtotime($datos_extra->hora_inicio))}}-{{date("H:i ", strtotime($datos_extra->hora_fin))}}</td>
    <td colspan="1" style="font-size: 14px;"><strong>Docente:</strong></td>
      <td  style="font-size: 11px;"> {{$datos_extra->nombre}} {{$datos_extra->apellido_paterno}} <?php if(empty($datos_extra->apellido_materno)){$vacio= null; echo $vacio;}else {echo $datos_extra->apellido_materno; }?> </td>
   
  </tr>
</table>
<br /> 


<div class="table">
  <table align="center"class="table table-bordered table-info" border="1" style="font-size:20px; font-family: 'Arial, Helvetica', sans-serif; border:1px solid #0E003C; max-width: auto;">

  <thead>
    <tr>
	    <th style="width:10px; font-size: 11px;">N°</th>
        <th style="width:15; font-size: 11px;">N° CONTROL</th>
        <th style="width:100px; font-size: 11px;">NOMBRE</th>
        <th style="width:150px; font-size: 11px;">OBSERVACIONES</th>
        <th style="width:50px; font-size: 11px;">ESTADO</th>
        <th width="1" style="width:1px; font-size: 10px;" colspan="7">PR&Aacute;CTICAS</th>
    </tr>
  </thead>
  <tbody>
      @foreach($dato as $indice => $datos)
      <tr>
	    <th style="width:10px; font-size: 12px;" scope="row">{{$indice+1}}</th>
        <th style="width:15; font-size: 12px;" scope="row">{{$datos->num_control }}</th>
        <td style="width:100px; font-size: 11px;">{{$datos->apellido_paterno }} {{$datos->apellido_materno }} {{$datos->nombre }}</td>
            <td style="width:150px; font-size: 11px;"> </td>
        <td style="width:50px; font-size: 12px;">{{$datos->estado}} </td>
        <td>  <a ></a></td>
        <td>  <a ></a></td>
        <td>  <a ></a></td>
        <td>  <a ></a></td>
        <td>  <a ></a></td>
        <td>  <a ></a></td>
        <td>  <a ></a></td>

   
         
           </tr>
  @endforeach
    </tbody>
  </table>

</div>
<br/>




<div id="footer">
  <hr style="height:1px; border:none; color:#FFCA7E; background-color:#FFCA7E; width:100%; text-align:center;">
    <img width="100" height="80" src="image/ito.png" align="left">
    <p class="page" align="center">
    <span style="font-size:12px">
    Av. Ing. Víctor Bravo Ahuja # 125 esq. Clz. Tecnol&oacute;gico. C.P. 68030. Oaxaca, Oax..  <BR />
    Tels. {{$telef}} <BR />
    
   <strong>P&aacute;gina oficial: {{$pagina}}</strong>
    </span>
    </p>
  </div>

  </body>