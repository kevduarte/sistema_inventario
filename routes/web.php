<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Página principal del sistema/muestra el login de acceso---*/
Route::get('/', 'HomePag@homepage')->name('welcome');

//registrar usuarios
Route::get('registro_docente_datos','login\RegistrarController@registro_docente_datos')->name('registro_docente_datos');
Route::post('solicitar_cuenta','login\CuentaController@solicitar_cuenta_docente')->name('solicitar_cuenta');

Route::get('detalles_cuenta/{id_cuenta}', 'AdminController@detalles_cuenta')->name('detalles_cuenta');

//registro de estudiantes
Route::get('registro_estudiante','login\RegistrarController@registro_estudiante_datos')->name('registro_estudiante');
Route::post('registro_estudiante_login','login\CuentaController@registro_cuenta_estudiante')->name('registro_estudiante_login');




//login
//Route::post('usuarios','login\LoginUsuariosController@postLogin')->name('usuarios');
Route::post('login_usuarios', ['as' =>'login_usuarios', 'uses' => 'Auth\LoginController@postLogin']);
Route::post('logout_system', ['as' => 'logout_system', 'uses' => 'Auth\LoginController@getLogout']);

//rutas del admin del sistema. 
Route::group(['middleware' => 'auth'], function () {
Route::get('admin', 'AdminController@home')->name('admin');
//Route::get('seguimiento_material/{id_material}','AdminController@seguimiento_material')->name('seguimiento_material');
//cuenta admin
Route::get('cuenta_admin', 'AdminController@cuenta_admin')->name('cuenta_admin');
Route::post('changePassword_admin','AdminController@changePassword')->name('changePassword_admin');
Route::post('changeUser_admin','AdminController@changeuser')->name('changeUser_admin');
//Route::post('changeEmail_admin','AdminController@changemail')->name('changeEmail_admin');
Route::post('changedatos_admin','AdminController@datos_personales_admin')->name('changedatos_admin');
//Route::get('eliminar_unidad/{codigo_unidad}/{id_material}', 'AdminController@eliminar_unidad')->name('eliminar_unidad');

//Route::get('material_activo', 'AdminController@material_activo')->name('material_activo');//se volvio busqueda

Route::get('registro_materias','AdminController@registro_materias')->name('registro_materias');
Route::post('registrar_materias','AdminController@registrar_materias')->name('registrar_materias');
Route::get('desactivar_materia/{id_materia}', 'AdminController@desactivar_materia')->name('desactivar_materia');
Route::get('activar_materia/{id_materia}', 'AdminController@activar_materia')->name('activar_materia');





//REGISTRO DE tipos de materiales
Route::get('registro_tipo','AdminController@registro_tipo')->name('registro_tipo');
Route::post('registrar_tipos','AdminController@registrar_tipos')->name('registrar_tipos');
//REGISTRO DE AREAS
Route::get('registro_area','AdminController@registro_area')->name('registro_area');
Route::post('registrar_areas','AdminController@registrar_areas')->name('registrar_areas');
Route::get('desactivar_area/{id_area}', 'AdminController@desactivar_area')->name('desactivar_area');
Route::get('activar_area/{id_area}', 'AdminController@activar_area')->name('activar_area');
//REGISTRO DE PERSONAL DEL DPTO de ciencias de la tierra
Route::get('registro_personal','AdminController@registro_personal')->name('registro_personal');
Route::post('registrar_personal','AdminController@registrar_personal')->name('registrar_personal');
Route::get('personal_registrado', 'AdminController@personal_registrado')->name('personal_registrado');
//actualizar personas
Route::get('actualizar_personas/{id_persona}', 'AdminController@actualizar_personas')->name('actualizar_personas');
Route::post('actualizar_personas_datos','AdminController@actualizar_personas_datos')->name('actualizar_personas_datos');

//alta de puestos del personal
Route::get('alta_personal', 'AdminController@alta_personal')->name('alta_personal');
Route::post('alta_personal_nueva','AdminController@alta_personal_nueva')->name('alta_personal_nueva');

//docentes
Route::get('docente_activo', 'AdminController@docente_activo')->name('docente_activo');
Route::get('desactivar_docente/{id_user}', 'AdminController@desactivar_docente')->name('desactivar_docente');
Route::get('docente_inactivo', 'AdminController@docente_inactivo')->name('docente_inactivo');
Route::get('activar_docente/{id_user}', 'AdminController@activar_docente')->name('activar_docente');

Route::get('restablecer_contra/{id_user}', 'AdminController@restablecimiento_pass')->name('restablecer_contra');

//encargados de area
Route::get('encargado_activo', 'AdminController@encargado_activo')->name('encargado_activo');
Route::get('desactivar_encargado/{id_user}', 'AdminController@desactivar_encargado')->name('desactivar_encargado');
Route::get('encargado_inactivo', 'AdminController@encargado_inactivo')->name('encargado_inactivo');
Route::get('activar_encargado/{id_user}', 'AdminController@activar_encargado')->name('activar_encargado');

//jefe de laboratorio
Route::get('jefe_lab', 'AdminController@jefe_lab')->name('jefe_lab');
Route::get('desactivar_jefelab/{id_user}', 'AdminController@desactivar_jefelab')->name('desactivar_jefelab');
Route::get('activar_jefelab/{id_user}', 'AdminController@activar_jefelab')->name('activar_jefelab');


//jefe de dpto
Route::get('jefe_departamento', 'AdminController@jefe_departamento')->name('jefe_departamento');
Route::get('desactivar_jefedpto/{id_user}', 'AdminController@desactivar_jefedpto')->name('desactivar_jefedpto');
Route::get('activar_jefedpto/{id_user}', 'AdminController@activar_jefedpto')->name('activar_jefedpto');

//REGISTRO DE estudiantes
Route::get('registro_estudianteadmin','AdminController@registro_estudianteadmin')->name('registro_estudianteadmin');
Route::post('registrar_estudiantes','AdminController@registrar_estudiantes')->name('registrar_estudiantes');
//estudiante INACTIVOS Y ACTIVOS
Route::get('estudiante_inactivo', 'AdminController@estudiante_inactivo')->name('estudiante_inactivo');
Route::get('estudiante_activo', 'AdminController@estudiante_activo')->name('estudiante_activo');
//correos a enviar
Route::get('cuenta_aprobar/{id_cuenta}', 'AdminController@cuenta_aprobar')->name('cuenta_aprobar');
Route::post('aprobar_cuenta_docente','NotificacionController@envio_notificacion')->name('aprobar_cuenta_docente');
Route::get('cuenta_rechazar/{id_cuenta}', 'NotificacionController@cuenta_rechazar')->name('cuenta_rechazar');
Route::post('rechazar_cuenta_docente','NotificacionController@envio_rechazo')->name('rechazar_cuenta_docente');
Route::get('notificaciones', 'NotificacionController@notifaciones')->name('notificaciones');

Route::get('foto_ito', 'AdminController@foto_ito')->name('foto_ito');
Route::get('nuevo_formato', 'AdminController@formatos')->name('nuevo_formato');
Route::post('actualizar_formato_prueba','AdminController@nuevo_formato')->name('actualizar_formato_prueba');

});


//rutas del jefe de departamento
Route::group(['middleware' => 'auth'], function () {
Route::get('departamento', 'DepartamentoController@home')->name('departamento');
Route::any('buscar_material_home', 'DepartamentoController@buscar_material_home')->name('buscar_material_home');

Route::get('registro_tipo_dpto','DepartamentoController@registro_tipo_dpto')->name('registro_tipo_dpto');
Route::post('registrar_tiposdpto','DepartamentoController@registrar_tiposdpto')->name('registrar_tiposdpto');


//RUTAS DE EDITAR MATERIALES 
Route::get('actualiza_material/{id_material}', 'DepartamentoController@actualiza_material')->name('actualiza_material');
Route::post('actualizar_material_prueba','MaterialesController@editar_mat')->name('actualizar_material_prueba');
Route::post('actualizar_material_insumo','MaterialesController@editar_mate')->name('actualizar_material_insumo');


//REGISTRO DE UN NUEVO MATERIAL
Route::get('registro_material','DepartamentoController@registro_material')->name('registro_material');
Route::post('registrar_materiales','MaterialesController@registrar_materiales')->name('registrar_materiales');

//nuevo semestre 
Route::get('nuevo_semestre', 'DepartamentoController@nuevo_semestre')->name('nuevo_semestre');
Route::post('agregar_semestre','DepartamentoController@agregar_semestre')->name('agregar_semestre');

//VER UNIDADES
Route::get('ver_unidades/{id_material}','DepartamentoController@ver_unidad')->name('ver_unidades');

//desactivar unidades
Route::get('desactivar_unidad/{codigo_unidad}', 'DepartamentoController@desactivar_unidad')->name('desactivar_unidad');
Route::post('baja_unidad_prueba','DepartamentoController@baja_unidad')->name('baja_unidad_prueba');

Route::get('activar_unidad/{codigo_unidad}', 'DepartamentoController@activar_unidad')->name('activar_unidad');
//BAJA DEFINITIVA UNIDAD
Route::get('baja_unidad_def/{codigo_unidad}', 'DepartamentoController@baja_unidad_def')->name('baja_unidad_def');
Route::post('baja_unidad_definitiva','DepartamentoController@baja_definitiva_unidad')->name('baja_unidad_definitiva');

//reportes
Route::get('ver_temporales/{id_material}','DepartamentoController@ver_temporales')->name('ver_temporales');
Route::get('reporte_temporal', 'DepartamentoController@reporte_temporales')->name('reporte_temporal');
Route::get('ver_eliminados/{id_material}','DepartamentoController@ver_eliminados')->name('ver_eliminados');
//reportes
Route::get('reporte_eliminados', 'DepartamentoController@reporte_eliminar')->name('reporte_eliminados');

//reporte de bajapdf
Route::get('baja_reporte/{codigo_unidad}/{id_material}','ListasPdf@baja_reporte');



//reporte baja def
Route::get('baja_definitiva_reporte/{codigo_unidad}/{id_material}','ListasPdf@baja_reporte_definitiva');

//BUSQUEDAS material ADMIN de ACTIVOS
Route::get('materiales_activos', 'DepartamentoController@busqueda_material')->name('materiales_activos');
Route::any('buscar_material', 'DepartamentoController@buscar_materiales')->name('buscar_material');
Route::any('buscar_materialtipo', 'DepartamentoController@buscar_materialest')->name('buscar_materialtipo');
Route::any('buscar_materialarea', 'DepartamentoController@buscar_materialesa')->name('buscar_materialarea');



//detalles del material una vez que los buscas
Route::get('detalles_material/{id_material}','DepartamentoController@detalles_material')->name('detalles_material');


Route::get('desactivar_material/{id_material}', 'DepartamentoController@desactivar_material')->name('desactivar_material');
Route::get('activar_material/{id_material}', 'DepartamentoController@activar_material')->name('activar_material');


//MATERIALES INACTIVOS
Route::get('material_inactivo', 'DepartamentoController@material_inactivo')->name('material_inactivo');
Route::any('buscar_material_inac', 'DepartamentoController@buscar_materiales_inac')->name('buscar_material_inac');
Route::any('buscar_materialtipo_inac', 'DepartamentoController@buscar_materialest_inac')->name('buscar_materialtipo_inac');
Route::any('buscar_materialarea_inac', 'DepartamentoController@buscar_materialesa_inac')->name('buscar_materialarea_inac');

//REGISTRO DE PERSONAL DEL DPTO de ciencias de la tierra
Route::get('registro_personal_dpto','DepartamentoController@registro_personal')->name('registro_personal_dpto');
Route::post('registrar_personal_dpto','DepartamentoController@registrar_personal')->name('registrar_personal_dpto');
Route::get('personal_registrado_dpto', 'DepartamentoController@personal_registrado')->name('personal_registrado_dpto');
//actualizar personas
Route::get('actualizar_personas_dpto/{id_persona}', 'DepartamentoController@actualizar_personas')->name('actualizar_personas_dpto');
Route::post('actualizar_personas_datos_dpto','DepartamentoController@actualizar_personas_datos')->name('actualizar_personas_datos_dpto');


//alta de puestos del personal
Route::get('alta_personal_dpto', 'DepartamentoController@alta_personal')->name('alta_personal_dpto');
Route::post('alta_personal_nueva_dpto','DepartamentoController@alta_personal_nueva')->name('alta_personal_nueva_dpto');
//docentes
Route::get('docente_activo_dpto', 'DepartamentoController@docente_activo')->name('docente_activo_dpto');
Route::get('desactivar_docente_dpto/{id_user}', 'DepartamentoController@desactivar_docente')->name('desactivar_docente_dpto');
Route::get('docente_inactivo_dpto', 'DepartamentoController@docente_inactivo')->name('docente_inactivo_dpto');
Route::get('activar_docente_dpto/{id_user}', 'DepartamentoController@activar_docente')->name('activar_docente_dpto');


//encargados de area
Route::get('encargado_activo_dpto', 'DepartamentoController@encargado_activo')->name('encargado_activo_dpto');
Route::get('desactivar_encargado_dpto/{id_user}', 'DepartamentoController@desactivar_encargado')->name('desactivar_encargado_dpto');
Route::get('encargado_inactivo_dpto', 'DepartamentoController@encargado_inactivo')->name('encargado_inactivo_dpto');
Route::get('activar_encargado_dpto/{id_user}', 'DepartamentoController@activar_encargado')->name('activar_encargado_dpto');

//jefe de laboratorio
Route::get('jefe_lab_dpto', 'DepartamentoController@jefe_lab')->name('jefe_lab_dpto');
Route::get('desactivar_jefelab_dpto/{id_user}', 'DepartamentoController@desactivar_jefelab')->name('desactivar_jefelab_dpto');
Route::get('activar_jefelab_dpto/{id_user}', 'DepartamentoController@activar_jefelab')->name('activar_jefelab_dpto');

Route::get('restablecer_contra_dpto/{id_user}', 'DepartamentoController@restablecimiento_pass')->name('restablecer_contra_dpto');



});


//rutas del jefe de laboratorio

Route::group(['middleware' => 'auth'], function () {

Route::get('jefe', 'JefeController@home')->name('jefe');
Route::any('buscar_material_home_jefe', 'JefeController@buscar_material_home')->name('buscar_material_home_jefe');


//REGISTRO DE UN NUEVO MATERIAL
Route::get('registro_material_jefe','JefeController@registro_material')->name('registro_material_jefe');
Route::post('registrar_materiales_jefe','JefeController@registrar_materiales')->name('registrar_materiales_jefe');


//RUTAS DE EDITAR MATERIALES 
Route::get('actualiza_material_jefe/{id_material}', 'JefeController@actualiza_material')->name('actualiza_material_jefe');
Route::post('actualizar_material_prueba_jefe','MaterialesController@editar_mat_jefe')->name('actualizar_material_prueba_jefe');
Route::post('actualizar_material_insumo_jefe','MaterialesController@editar_mate_jefe')->name('actualizar_material_insumo_jefe');

//VER UNIDADES
Route::get('ver_unidades_jefe/{id_material}','JefeController@ver_unidad')->name('ver_unidades_jefe');


//desactivar unidades
Route::get('desactivar_unidad_jefe/{codigo_unidad}', 'JefeController@desactivar_unidad')->name('desactivar_unidad_jefe');
Route::post('baja_unidad_prueba_jefe','JefeController@baja_unidad')->name('baja_unidad_prueba_jefe');

Route::get('activar_unidad_jefe/{codigo_unidad}', 'JefeController@activar_unidad')->name('activar_unidad_jefe');

Route::get('baja_unidad_def_jefe/{codigo_unidad}', 'JefeController@baja_unidad_def')->name('baja_unidad_def_jefe');
Route::post('baja_unidad_definitiva_jefe','JefeController@baja_definitiva_unidad')->name('baja_unidad_definitiva_jefe');


 //reportes
Route::get('ver_temporales_jefe/{id_material}','JefeController@ver_temporales')->name('ver_temporales_jefe');
Route::get('reporte_temporal_jefe', 'JefeController@reporte_temporales')->name('reporte_temporal_jefe');

Route::get('ver_eliminados_jefe/{id_material}','JefeController@ver_eliminados')->name('ver_eliminados_jefe');

Route::get('reporte_eliminados_jefe', 'JefeController@reporte_eliminar')->name('reporte_eliminados_jefe');

//BUSQUEDAS material ADMIN de ACTIVOS
Route::get('materiales_activos_jefe', 'JefeController@busqueda_material')->name('materiales_activos_jefe');
Route::any('buscar_material_jefe', 'JefeController@buscar_materiales')->name('buscar_material_jefe');
Route::any('buscar_materialtipo_jefe', 'JefeController@buscar_materialest')->name('buscar_materialtipo_jefe');
Route::any('buscar_materialarea_jefe', 'JefeController@buscar_materialesa')->name('buscar_materialarea_jefe');



//detalles del material una vez que los buscas
Route::get('detalles_material_jefe/{id_material}','JefeController@detalles_material')->name('detalles_material_jefe');
Route::get('desactivar_material_jefe/{id_material}', 'JefeController@desactivar_material')->name('desactivar_material_jefe');
Route::get('activar_material_jefe/{id_material}', 'JefeController@activar_material')->name('activar_material_jefe');


//MATERIALES INACTIVOS
Route::get('material_inactivo_jefe', 'JefeController@material_inactivo')->name('material_inactivo_jefe');
Route::any('buscar_material_inac_jefe', 'JefeController@buscar_materiales_inac')->name('buscar_material_inac_jefe');
Route::any('buscar_materialtipo_inac_jefe', 'JefeController@buscar_materialest_inac')->name('buscar_materialtipo_inac_jefe');
Route::any('buscar_materialarea_inac_jefe', 'JefeController@buscar_materialesa_inac')->name('buscar_materialarea_inac_jefe');

//reporte de bajapdf
Route::get('baja_reporte_jefe/{codigo_unidad}/{id_material}','ListasPdf@baja_reporte_jefe');

//reporte baja def
Route::get('baja_definitiva_reporte_jefe/{codigo_unidad}/{id_material}','ListasPdf@baja_reporte_definitiva_jefe');

Route::get('registro_tipo_jefe','JefeController@registro_tipo_jefe')->name('registro_tipo_jefe');
Route::post('registrar_tipos_jefe','JefeController@registrar_tiposdpto')->name('registrar_tipos_jefe');


Route::get('adeudos_material_jefe','JefeController@adeudos_material_jefe')->name('adeudos_material_jefe');

Route::get('adeudo_solicitud_jefe/{id_solicitud}','JefeController@adeudo_solicitud_jefe')->name('adeudo_solicitud_jefe');





});


//rutas del personal personal
//home personal
Route::group(['middleware' => 'auth'], function () {

Route::get('personal', 'PersonalController@home')->name('personal');
//VER UNIDADES AREA
Route::get('ver_unidades_area/{id_material}','PersonalController@ver_unidad_area')->name('ver_unidades_area');
Route::any('buscar_material_homep', 'PersonalController@buscar_material_home')->name('buscar_material_homep');
//material activopersonal
Route::get('material_activo_personal', 'PersonalController@material_activo_personal')->name('material_activo_personal');
Route::get('material_inactivo_personal', 'PersonalController@material_inactivo_personal')->name('material_inactivo_personal');


Route::get('busqueda_material_per', 'PersonalController@busqueda_material_per')->name('busqueda_material_per');
Route::any('buscar_material_per', 'PersonalController@buscar_materiales_per')->name('buscar_material_per');
//detalles del material una vez que los buscas
Route::get('detalles_material_per/{id_material}','PersonalController@detalles_material_per')->name('detalles_material_per');

//desactivar unidades por area
Route::get('desactivar_unidad_area/{codigo_unidad}', 'PersonalController@desactivar_unidad_area')->name('desactivar_unidad_area');
Route::post('baja_unidad_area','PersonalController@baja_unidad')->name('baja_unidad_area');


Route::get('solicitudes_area', 'PersonalController@solicitudes_area')->name('solicitudes_area');
Route::get('detalles_solicitud/{id_solicitud}','PersonalController@detalles_solicitud')->name('detalles_solicitud');

Route::get('detalles_vale/{id_vale}','PersonalController@detalles_vale')->name('detalles_vale');

Route::get('entregar_vale/{id_vale}','PersonalController@entregar_vale')->name('entregar_vale');

Route::get('liberar_vale/{id_vale}','PersonalController@liberar_vale')->name('liberar_vale');

Route::get('retener_vale/{id_vale}','PersonalController@retener_vale')->name('retener_vale');


Route::get('adeudos_material','PersonalController@adeudos_material')->name('adeudos_material');

Route::get('adeudo_solicitud/{id_solicitud}','PersonalController@adeudo_solicitud')->name('adeudo_solicitud');

Route::get('detalles_vale_adeudo/{id_vale}','PersonalController@detalles_vale_adeudo')->name('detalles_vale_adeudo');


Route::get('solicitudes_area_fin', 'PersonalController@solicitudes_area_fin')->name('solicitudes_area_fin');







/////////////////////////////////////////////

Route::get('prestamos_aprobados', 'PersonalController@prestamos_aprobados')->name('prestamos_aprobados');

Route::get('ver_practicas_grupos', 'PersonalController@ver_practicas_grupos')->name('ver_practicas_grupos');

});




//rutas docente
Route::group(['middleware' => 'auth'], function () {
Route::get('docente', 'DocenteController@home')->name('docente');

Route::get('solicitar_material', 'DocenteController@solicitar_material')->name('solicitar_material');
Route::get('solicitud_grupo/{id_grupo}','DocenteController@solicitud_grupo')->name('solicitud_grupo');
Route::any('solicitud_enviar', 'DocenteController@enviar_solicitud')->name('solicitud_enviar');


Route::get('seleccionar_material/{id_solicitud}','DocenteController@seleccionar_material')->name('seleccionar_material');
Route::post('agregar_material', 'DocenteController@agregar_material')->name('agregar_material');

Route::get('quitar_carro/{id_material}','DocenteController@quitar_carro')->name('quitar_carro');

Route::post('solicitud_enviada', 'DocenteController@solicitud_enviada')->name('solicitud_enviada');
Route::get('mis_solicitudes', 'DocenteController@mis_solicitudes')->name('mis_solicitudes');

Route::get('mis_solicitudes_fin', 'DocenteController@mis_solicitudes_fin')->name('mis_solicitudes_fin');


//nuevo grupo
Route::get('registrar_grupo', 'DocenteController@registrar_grupo')->name('registrar_grupo');
Route::post('registrar_grupos','DocenteController@registrar_grupos')->name('registrar_grupos');

//mis grupos
Route::get('mis_grupos', 'DocenteController@mis_grupos')->name('mis_grupos');
Route::get('actualizar_grupo/{id_grupo}','DocenteController@actualizar_grupo')->name('actualizar_grupo');
Route::post('actualiza_grupos', 'DocenteController@actualizar_g')->name('actualiza_grupos');
//brigadas grupos
Route::get('brigadas_grupos', 'DocenteController@mis_grupos_brigadas')->name('brigadas_grupos');
Route::get('formar_brigadas/{id_grupo}/{id_docente}','DocenteController@formar_brigadas')->name('formar_brigadas');
Route::get('brigadas_formadas/{id_grupo}/{id_docente}','DocenteController@brigadas_formadas')->name('brigadas_formadas');

Route::get('llenar_brigadas/{id_brigada}','DocenteController@llenar_brigada')->name('llenar_brigadas');
Route::get('inscritos_brigada/{id_brigada}', 'DocenteController@inscritos_brigada')->name('inscritos_brigada');
Route::get('brigada_completar/{id_brigada}', 'DocenteController@brigada_completar')->name('brigada_completar');
Route::get('nombrar_jefe/{id_brigada}/{num_control}', 'DocenteController@nombrar_jefe')->name('nombrar_jefe');
Route::get('cambio_brigada/{id_brigada}/{num_control}', 'DocenteController@cambio_brigada')->name('cambio_brigada');
Route::post('cambiar_estudiante_brigada', 'DocenteController@cambiar_estudiante_brigada')->name('cambiar_estudiante_brigada');

Route::post('completar_estudiante_brigada', 'DocenteController@completar_estudiante_brigada')->name('completar_estudiante_brigada');

Route::get('registro_brigada/{deta}/{doce}','DocenteController@registro_brigada')->name('registro_brigada');
Route::post('registrar_brigadas', 'DocenteController@nombrar_jefe')->name('registrar_brigadas');

Route::get('inscritos_grupo/{id_grupo}/{id_docente}', 'DocenteController@inscritos_grupo')->name('inscritos_grupo');
Route::get('lista_inscritos/{id_grupo}/{id_docente}','ListasPdf@lista_grupo');
Route::get('desactivar_estudiante_grupo/{id_grupo}/{num_control}', 'DocenteController@desactivar_estudiante_grupo');
Route::get('activar_estudiante_grupo/{id_grupo}/{num_control}', 'DocenteController@activar_estudiante_grupo');

//rutas exposicion





});


//RUTAS ESTUDIANTE
Route::group(['middleware' => 'auth'], function () {
Route::get('nueva_contraseña', 'EstudianteController@nueva_contraseña')->name('nueva_contraseña');
Route::post('cambio_contraseña', 'EstudianteController@cambio')->name('cambio_contraseña');
Route::get('estudiante','EstudianteController@home')->name('estudiante');

Route::get('grupos_disponibles', 'EstudianteController@grupos_disponibles')->name('grupos_disponibles');
Route::get('inscripcion_grupo/{id_grupo}', 'EstudianteController@inscripcion')->name('inscripcion_grupo');
Route::post('nueva_inscripcion', 'EstudianteController@nueva_inscripcion')->name('nueva_inscripcion');
Route::get('mis_cursos', 'EstudianteController@cursos')->name('mis_cursos');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
