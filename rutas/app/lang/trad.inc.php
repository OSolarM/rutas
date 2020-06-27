<?php

$_trad = array(
    "chof_rut" => "Rut",
    "chof_nombres" => "Nombres",
    "chof_apellidos" => "Apellidos",
    "chof_direccion" => "Direcci&oacute;n",
    "chof_comuna" => "Comuna",
    "chof_ciudad" => "Ciudad",
    "chof_region" => "Regi&oacute;n",
    "chof_telefono" => "Tel&eacute;fonos",
    "chof_email" => "E-Mail",
    "chof_celular" => "Celular",
    "chof_bloqueo" => "Bloqueo",
    "pnta_rut" => "Rut",
    "pnta_apellidos" => "Apellidos",
    "pnta_nombres" => "Nombres",
    "pnta_direccion" => "Direcci&oacute;n",
    "pnta_comuna" => "Comuna",
    "pnta_ciudad" => "Ciudad",
    "pnta_region" => "Regi&oacute;n",
    "pnta_telefono" => "Tel&eacute;fono",
    "pnta_celular" => "Celular",
    "pnta_email" => "E-Mail",
    "pnta_bloqueo" => "Bloqueo",
    "cami_patente" => "Patente",
    "cami_marca" => "Marca",
    "cami_agno" => "Año",
    "cami_descripcion" => "Descripci&oacute;n",
    "cami_bloqueo" => "Bloqueo",
    "acop_patente" => "Patente",
    "acop_descripcion" => "Descripci&oacute;n",
    "acop_bloqueo" => "Bloqueo",
    "ciud_nombre" => "Nombre",
    "ciud_region" => "Regi&oacute;n",
    "ciud_bloqueo" => "Bloqueo",
    "institucion_id" => "Instituci&oacute;n",
    "autorizado_id" => "Autorizado",
    "orna_numero" => "N&uacute;mero",
    "orna_fecha" => "Fecha",
    "orden_id" => "Orden",
    "orna_m3" => "Mts3",
    "orna_grado" => "Grado",
    "orna_cliente" => "Cliente",
    "orna_rut" => "Rut",
    "orna_tipo_em" => "Transporta",
    "orna_auto" => "Autom&oacute;vil",
    "orna_carta_no" => "Carta autorizaci&oacute;n",
    "orna_carta_m3" => "Mts3",
    "orna_carta_no_2" => "Carta autorizaci&oacute;n 2",
    "orna_carta2_m3" => "Mts3",
    "orna_deposito" => "Dep&oacute;sito",
    "orna_origen" => "Origen",
    "orna_destino" => "Destino",
    "orna_repo_fecha" => "Fecha",
    "orna_repo_direccion" => "Dire
cci&oacute;n",
    "orna_repo_comuna" => "Comuna",
    "orna_repo_ciudad" => "Ciudad",
    "orna_repo_region" => "Regi&oacute;n",
    "orna_repo_observa" => "Observaciones",
    "orna_direc_despacho" => "Direcci&oacute;n Despacho",
    "orna_comuna_despacho" => "Comuna",
    "orna_datos_contacto" => "Contacto",
    "orna_estado" => "",
);

function trad($key) {
    global $_trad;

    if (isset($_trad[$key]))
        return rtrim($_trad[$key]);
    else
        return $key;
}
