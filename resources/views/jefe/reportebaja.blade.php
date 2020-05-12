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

   <tr>
  <td id="col_4"><td colspan="2" align="right"><span style="font-size:11px;">OFICIO N°:{{$ofi}}</span></td></td>
  </tr>
  
  <td id="col_5">
  <td colspan="2" align="right"><span style="font-size:12px; font-family: 'Arial, Helvetica', sans-serif;"><strong>Asunto:</strong>Baja temporal</span></td>
    </td>

</table>



<h4><center>Reporte de baja de material del laboratorio de ingenier&iacute;a civil.</center></h4>

<table align="left"  >
    <tr>
      <td colspan="1" style="font-size: 14px;"><strong>Clave del material:</strong> </td>
      <td style="font-size: 11px;">{{$datos->id_material}}</td>
       
      <td colspan="1" style="font-size: 14px;"><strong>Nombre:</strong> </td>
    <td style="font-size: 14px;">{{$datos->nombre_material}}</td>

     <td colspan="1" style="font-size: 14px;"><strong>Num. de serie:</strong> </td>
    <td style="font-size: 14px;">{{$datos->num_serie ?? 's/n'}}</td>


      
    
    </tr>
    <br/><br/><br/>

     <tr>
        <td colspan="1" style="font-size: 14px;"><strong>Area del material:</strong></td>
      <td  style="font-size: 11px;"> {{$datos->area}}</td>
       <td colspan="1" style="font-size: 14px;"><strong>Categoría:</strong></td>
      <td  style="font-size: 11px;"> {{$datos->tipo}}</td>
       <td colspan="1" style="font-size: 14px;"><strong>Semestre:</strong> </td>
    <td style="font-size: 14px;">{{$semestre}}</td>
   
  </tr>
  
</table>
<br /> 



<div class="table">
  <span><center>Detalles</center></span>
  <table align="center"class="table table-bordered table-info" border="1" style="font-size:20px; font-family: 'Arial, Helvetica', sans-serif; border:1px solid #0E003C; max-width: auto;">

  <thead>
    <tr>
	    <th style="width:auto; font-size: 12px;">N°</th>
        <th style="width:auto; font-size: 12px;">CODIGO UNIDAD</th>
                <th style="width:auto; font-size: 12px;">NOMBRE</th>
                                <th style="width:auto; font-size: 12px;">MOTIVO DE LA BAJA</th>
                                <th style="width:auto; font-size: 12px;">ESTADO</th>


      
    </tr>
  </thead>
  <tbody>
      @foreach($dato as $indice => $datos)
      <tr>
	    <th style="width:auto; font-size: 12px;" scope="row">{{$indice+1}}</th>
        <th style="width:auto; font-size: 12px;" scope="row">{{$datos->codigo_unidad }}</th>
        <td style="width:100px; font-size: 11px;">{{$datos->nombre_material }} </td>
        <td style="width:350px; font-size: 11px;">{{$datos->observaciones}} </td>
        <td style="width:80px; font-size: 12px;"> {{$datos->estado}}</td>
      
           </tr>
  @endforeach
    </tbody>

  </table>

  
</div>

<div id="firma" >


    <p class="page" align="left">
    <span style="font-size:12px; font-family: 'Arial, Helvetica';">
   <strong>A T E N T A M E N T E <BR /></strong> </span>
   <span style="font-size:10px; font-family: 'Arial, Helvetica'; font-style: italic;">
   {{$ate1}}
    <BR />
    {{$ate2}}<br/>
  </span>
    </p>
    <BR/>


     <p class="page" align="left">
    <span style="font-size:12px">
    <strong>{{$nom}}</strong><BR />
   <strong>JEFE DE LABORATORIO DE INGENIER&Iacute;A CIVIL</strong><BR />
    </span>
    </p>
</div>



<div id="footer">
  <hr style="height:1px; border:none; color:#FFCA7E; background-color:#FFCA7E; width:100%; text-align:center;">
    <img width="100" height="80" src="image/ito.png" align="left">
    <p class="page" align="center">
    <span style="font-size:12px">
    Av. Ing. Víctor Bravo Ahuja # 125 esq. Clz. Tecnol&oacute;gico. C.P. 68030. Oaxaca, Oax..  <BR />
    Tels.{{$telef}}<BR />
    
   <strong>P&aacute;gina oficial: {{$pagina}}</strong>
    </span>
    </p>
  </div>

</body>