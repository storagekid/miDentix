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
            width: 800px;
            display: block;
            margin: 0 auto;
        }
        .button {
            background-color: #753470;
            color:#FFFFFF; 
        }
        .button:hover, .button:active, .button:visited {
            background-color: #F1EAF0;
            color: #753470
        }
    </style>
</head>
<body style="background-color: #FFFFFF">
    <div id="header" style="background-color: #753470; width: 100%; height: 100px; display: block;">
        <div class="fixed-width" style="height: inherit;">
            <img height="50px" src="{{asset('img/logo_claim_white.png')}}" alt="Dentix. La Nueva Odontología" style="margin-top: 20px">
        </div>
    </div>
    <div class="fixed-width" style="height: 100%;">
        <div style="padding: 100px 0">
            <h1 style="color: #753470">¡Muchas gracias por tu autorización!</h1>
            <p style="color: #333333;">Para nosotros es importante saber tu opinión, y mantenerte informado de nuestras novedades y promociones.</p>
        </div>
        <div>
             <a class="button" href="#" style="padding: 12px 30px; border-radius: 20px; text-decoration: none; font-size: 1.3em">Ir a la página de Dentix</a>
        </div>
    <div id="header" style="position: fixed; bottom: 0; left: 0; background-color: #F1EAF0; width: 100%; height: 50px; display: block; text-align: center">
        <p style="font-size: 0.8em; color: #753470; margin-top: 20px">Dentix® 2018. Todos los derechos reservados.</p>
    </div>
</body>
</html>