<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Autorización RGPD</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif
        }
        .fixed-width {
            width: 1200px;
            display: block;
            margin: 0 auto;
        }
        .button {
            background-color: #753470;
            color:#FFFFFF; 
        }
        .button:hover, .button:active {
            background-color: #F1EAF0;
            color: #753470
        }
        .mail-titles {
            font-size: .8em;
        }
    </style>
</head>
<body style="background-color: #FFFFFF; text-align: center; overflow: auto">
    <!-- <div id="header" style="background-color: #753470; width: 100%; height: 100px; display: block;">
        <div class="fixed-width" style="height: inherit;">
            <img height="50px" src="{{asset('img/logo_claim_white.png')}}" alt="Dentix. La Nueva Odontología" style="margin-top: 20px">
        </div>
    </div> -->
    <div class="mail-titles" style="height: 100%;">
        <h1 style="color: #753470">Templates</h1>
        <div style="padding: 10px 0">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'templates.cerberus-responsive'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Cerberus Responsive</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'test'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Test</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'templates.cerberus-responsive'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Cerberus Responsive</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'test'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Test</a>
        </div>
        <h1 style="color: #753470; margin: 40px 0 10px 0">Emailings</h1>
        <div class="row" style="padding: 10px 0;">
            <h4>Newsletter Hipoteca SC</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_Leads_HipotecaSC_ene21_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Newsletter Hipoteca SC CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_Leads_HipotecaSC_ene21_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Newsletter Hipoteca SC Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Newsletter Hipoteca Bonificada</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_Leads_HipotecaSCBonificada_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Newsletter Hipoteca Bonificada CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_Leads_HipotecaSCBonificada_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Newsletter Hipoteca Bonificada Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Newsletter Autónomos ene21</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_Autonomos_Newsletter_ene21_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Newsletter Autónomos ene21 CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_Autonomos_Newsletter_ene21_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Newsletter Autónomos ene21 Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Navidades 26-31 Dic</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <!-- <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_Navidades_OfertaGourmet_26_31dic'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Navidades 26-31 Dic</a> -->
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_Navidades_OfertaGourmet_26_31dic_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Navidades 26-31 Dic CLEAN</a>
             <!-- <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_Navidades_OfertaGourmet_26_31dic'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Navidades 26-31 Dic</a> -->
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_Navidades_OfertaGourmet_26_31dic_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Navidades 26-31 Dic Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Navidades 14-23 Dic</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_Navidades_14_23dic'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Navidades 14-23 Dic</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_Navidades_14_23dic_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Navidades 14-23 Dic CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_Navidades_14_23dic'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Navidades 14-23 Dic</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_Navidades_14_23dic_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Navidades 14-23 Dic Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Carné Joven</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <!-- <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_carne_joven'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Carné Joven</a> -->
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_carne_joven_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Carné Joven CLEAN</a>
             <!-- <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_carne_joven'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Carné Joven</a> -->
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_carne_joven_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Carné Joven Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Black Friday</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_BShop_BlackFriday'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Black Friday</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_BShop_BlackFriday_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Black Friday CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_BShop_BlackFriday'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Black Friday</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_BShop_BlackFriday_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Black Friday Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>BK_EndesaX_oct20</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_EndesaX_oct20'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send BK_EndesaX_oct20</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BK_EndesaX_oct20_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send BK_EndesaX_oct20 CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_EndesaX_oct20'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View BK_EndesaX_oct20</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BK_EndesaX_oct20_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View BK_EndesaX_oct20 Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>BBP Inversion Diversificada</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BBP_InversionAlternativaDiversificada'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send BBP Inversion Diversificada</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'BBP_InversionAlternativaDiversificada_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send BBP Inversion Diversificada CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BBP_InversionAlternativaDiversificada'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View BBP Inversion Diversificada</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'BBP_InversionAlternativaDiversificada_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View BBP Inversion Diversificada Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>FlyingDays Lanzamiento</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'FlyingDays_Lanzamiento'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send FlyingDays Lanzamiento</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'FlyingDays_Lanzamiento_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send FlyingDays Lanzamiento CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'FlyingDays_Lanzamiento'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View FlyingDays Lanzamiento</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'FlyingDays_Lanzamiento_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View FlyingDays Lanzamiento Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Newsletter Autónomos oct20</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_Autonomos_Newsletter_oct20'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Newsletter Autónomos oct20</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_Autonomos_Newsletter_oct20_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Newsletter Autónomos oct20 CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_Autonomos_Newsletter_oct20'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Newsletter Autónomos oct20</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_Autonomos_Newsletter_oct20_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Newsletter Autónomos oct20 Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Titularidad Real</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_TitularidadReal'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Titularidad Real</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_TitularidadReal_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Titularidad Real CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_TitularidadReal'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Titularidad Real</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_TitularidadReal_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Titularidad Real Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Aceptación Promos oct20</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_emailing_AceptacionPromociones_oct20'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Aceptación Promos oct20</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_emailing_AceptacionPromociones_oct20_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Aceptación Promos oct20 CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_emailing_AceptacionPromociones_oct20'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Aceptación Promos oct20</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_emailing_AceptacionPromociones_oct20_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Aceptación Promos oct20 Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Pago Tributos Alicante</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_PagoTributosAlicante'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Pago Tributos Alicante</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_PagoTributosAlicante_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Pago Tributos Alicante CLEAN</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_PagoTributosAlicante_VAL_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Pago Tributos Alicante VAL CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_PagoTributosAlicante'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Pago Tributos Alicante</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_PagoTributosAlicante_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Pago Tributos Alicante Clean</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_PagoTributosAlicante_VAL_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Pago Tributos Alicante VAL Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>New Manager</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_new_manager'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Nuevo Gestor</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'bk_new_manager_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Nuevo Gestor CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_new_manager'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Nuevo Gestor</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'bk_new_manager_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Nuevo Gestor Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Iberia Paradores</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'iberia_paradores'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Iberia Paradores</a>
             <a class="btn-primary" href="{{route('sendemailing', ['name' => 'iberia_paradores_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Iberia Paradores CLEAN</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'iberia_paradores'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Iberia Paradores</a>
             <a class="btn-primary" href="{{route('showemail', ['name' => 'iberia_paradores_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Iberia Paradores Clean</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Webminar. El Gran Confinamiento</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'webminar-confinamiento'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Webminar EGC</a>
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'webminar-confinamiento-clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Webminar EGC CLEAN</a>
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'webminar-confinamiento-improved'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Webminar EGC Improved</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'webminar-confinamiento'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Webminar EGC</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'webminar-confinamiento-clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Webminar EGC CLEAN</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'webminar-confinamiento-improved'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Webminar EGC Improved</a>
        </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Webminar. Megatendencias</h4>
        </div>
        <div class="row" style="margin-bottom: 20px;">
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'webminar-megatendencias'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Megatendencias</a>
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'webminar-megatendencias-clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Megatendencias Clean</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'webminar-megatendencias'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Megatendencias</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'webminar-megatendencias-clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Megatendencias Clean</a>
             </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Seguros Amazon</h4>
        </div>
            <div class="row" style="margin-bottom: 20px;">
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'seguro-vida-amazon-50'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Seguro Amazon 50€</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'seguro-vida-amazon-50'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Seguro Amazon 50€</a>
             </div>
        <div class="row" style="padding: 10px 0;">
            <h4>Covid Ayuda Tarjetas</h4>
        </div>
            <div class="row" style="margin-bottom: 20px;">
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'covid_ayuda_tarjetas'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Covid Ayuda Tarjeta</a>
             <a class="btn-warning" href="{{route('sendemailing', ['name' => 'covid_ayuda_tarjetas_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Covid Ayuda Tarjeta CLEAN</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'covid_ayuda_tarjetas'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Covid Ayuda Tarjeta</a>
             <a class="btn-warning" href="{{route('showemail', ['name' => 'covid_ayuda_tarjetas_clean'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Covid Ayuda Tarjeta Clean</a>
             </div>
    <div style="background-color: #F1EAF0; width: 100%; height: 50px; display: block; text-align: center">
        <p style="font-size: 0.8em; color: #753470; padding-top: 20px">Dentix® 2018. Todos los derechos reservados.</p>
    </div>
</body>
</html>