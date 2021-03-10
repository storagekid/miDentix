<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    </style>
</head>
<body style="background-color: #FFFFFF; text-align: center">
    <div id="header" style="background-color: #753470; width: 100%; height: 100px; display: block;">
        <div class="fixed-width" style="height: inherit;">
            <img height="50px" src="{{asset('img/logo_claim_white.png')}}" alt="Dentix. La Nueva Odontología" style="margin-top: 20px">
        </div>
    </div>
    <div class="" style="height: 100%;">
        <h1 style="color: #753470">Templates</h1>
        <div style="padding: 10px 0">
             <!-- <a class="button" href="{{route('sendemailing', ['name' => 'templates.cerberus-responsive'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">Send Cerberus Responsive</a>
             <a class="button" href="{{route('showemail', ['name' => 'templates.cerberus-responsive'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Cerberus Responsive</a> -->
        </div>
        <h1 style="color: #753470; margin: 40px 0 10px 0">Emailings</h1>
        <div style="padding: 10px 0;">
            <h4 style="margin-top: 0">Webminar. El Gran Confinamiento</h4>
            <div style=" display: flex; justify-content: center">
             <a class="button" href="{{route('showemail', ['name' => 'webminar-confinamiento-mirror'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Webminar EGC</a>
             <a class="button" href="{{route('showemail', ['name' => 'webminar-confinamiento-improved'])}}" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.1em">View Webminar EGC Improved</a>
             </div>
        </div>
    <div id="header" style="position: fixed; bottom: 0; left: 0; background-color: #F1EAF0; width: 100%; height: 50px; display: block; text-align: center">
        <p style="font-size: 0.8em; color: #753470; margin-top: 20px">Dentix® 2018. Todos los derechos reservados.</p>
    </div>
</body>
</html>