<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no"> <!-- Tell iOS not to automatically link certain text strings. -->
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Bankia - Endesa X. Financiación Sostenible</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 23 - 41 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
		<!--[if !mso]><!-->
			<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
			<link href="https://www.bankia.es/estaticos/Portal-unico/css/fonts.css" rel="stylesheet">
    <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Tells the email client that only light styles are provided but the client can transform them to dark. A duplicate of meta color-scheme meta tag above. */
        :root {
          color-scheme: light;
          supported-color-schemes: light;
        }

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: forces Samsung Android mail clients to use the entire viewport */
        #MessageViewBody, #MessageWebViewDiv{
            width: 100% !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Replaces default bold style. */
        th {
        	font-weight: normal;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        a[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links a,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
           display: none !important;
           opacity: 0.01 !important;
		}
		/* If the above doesn't work, add a .g-img class to any image in question. */
		img.g-img + div {
		   display: none !important;
		}

        /* ol {
            margin: 0;
            padding-left: 20px;
            padding-top: 10px;
            counter-reset: item;
        }

        ol > li {
            margin: 0;
            padding: 0 0 0 2em;
            text-indent: -1.5em;
            list-style-type: none;
            counter-increment: item;
        }

        ol > li:before {
            display: inline-block;
            width: 1em;
            padding-right: 0.5em;
            font-family: 'BankiaMedium', 'Source Sans Pro', 'Tahoma', 'Verdana', 'Segoe', 'sans-serif';
            font-weight: 700;
            text-align: right;
            content: counter(item) ".";
        } */

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }

    </style>
    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
	    .button-td-primary:hover,
	    .button-a-primary:hover {
	        background: #FF9E1B !important;
	        border-color: #FF9E1B !important;
	    }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 17px !important;
            }
        }

    </style>
		<!-- Progressive Enhancements : END -->

</head>
<!--
	The email background color (#FFFFFF) is defined in three places:
	1. body tag: for most email clients
	2. center tag: for Gmail and Inbox mobile apps and web versions of Gmail, GSuite, Inbox, Yahoo, AOL, Libero, Comcast, freenet, Mail.ru, Orange.fr
	3. mso conditional: For Windows 10 Mail
-->
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #FFFFFF;">
  <center role="article" aria-roledescription="email" lang="en" style="width: 100%; background-color: #FFFFFF;">
    <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF;">
    <tr>
    <td>
    <![endif]-->

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="max-height:0; overflow:hidden; mso-hide:all; font-size: 1px" aria-hidden="true">
            Bankia - Endesa X.
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Create white space after the desired preview text so email clients don’t pull other distracting text into the inbox preview. Extend as necessary. -->
        <!-- Preview Text Spacing Hack : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
          Financiación Sostenible.
        </div>
        <!-- Preview Text Spacing Hack : END -->

        <!-- Email Body : BEGIN -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: auto; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;" class="email-container">
	        <!-- Email Header : BEGIN -->
            <tr>
                <td style="padding: 10px 0; text-align: center">
                  <span style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size:9px; color:#000000;"><b>Publicidad. </b>&iquest;<a href="#" target="_blank" style="color:#000000; text-decoration:none;cursor: pointer;"><u>No ve correctamente este e-mail</u></a>?</span>
                </td>
            </tr>
          <!-- Email Header : END -->
          
          <!-- Hero Image, Flush : BEGIN -->
          <tr>
                <td style="background-color: #ffffff;">
                  <a href="https://www.bankia.es/es/banca-privada" target="_blank" title="Bankia"><img style="display:block; cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/BK_EndesaX_oct20/header_easy_endesa.jpg" width="600" height="130" alt="Bankia - Endesa X" title="Bankia - Endesa X" border="0" /></a>
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td style="background-color: #ffffff;">
                    <img src="http://www.storagekid.com/mozodealmacen/images/BK_EndesaX_oct20/main-picture.jpg" width="600" height="" title="Bankia - Endesa. Energía Sostenible." alt="Bankia - Endesa. Energía Sostenible." border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

          <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="background-color: #FFFFFF;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify; padding: 30px 60px 0 60px;">
                        Buenos días <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600;">XXXXXXXXX,</span><br>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify; padding: 20px 60px 0 60px;">
                        Desde la Dirección de Financiación Sostenible de Bankia hemos llegado a un acuerdo de colaboración con Endesa X para ofrecer, a clientes como vosotros, soluciones energéticas más eficientes.
                      </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
            <!-- Thumbnail Left, Text Right : BEGIN -->
            <tr>
                <td style="padding: 30px 60px;">
                    <table valign="top">
                        <tr>
                            <td height="100%" valign="top" width="80">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="font-size:0; background-color: #ffffff; padding-top: 4px">
                                            <img src="http://www.storagekid.com/mozodealmacen/images/BK_EndesaX_oct20/battery-and-background.jpg" width="90" height="" border="0" alt="Energía Sostenible" title="Energía Sostenible" class="" style="width: 100%; max-width: 90px; height: auto; background: #dddddd; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify; padding-left: 10px" class="">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify;">
                                            En concreto, nos han hecho llegar una propuesta, que os adjuntamos, para una <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; color: #b9c800">instalación de energía solar fotovoltaica</span> para vuestras instalaciones en xxxxxxxxx xxxxx xx. Con el autoconsumo fotovoltaico podéis conseguir eficientar vuestra factura, aprovechando al máximo las instalaciones de vuestra empresa, reduciendo el uso de combustibles fósiles y las emisiones de gases de efecto invernadero, dentro de vuestros objetivos de Responsabilidad Social Corporativa. En vuestro caso, han <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; color: #b9c800">estimado un ahorro potencial de hasta xxx €/año con una inversión orientativa de xxx €.</span>
                                        </td>
                                    </tr>
                                </table>
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify; padding-top: 20px"">
                                            Si os parece interesante, podemos organizar una reunión (virtual/presencial) con un especialista de <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600;">Endesa X</span> para que os amplíe información, evalúe la propuesta técnica en detalle adaptándola a vuestras necesidades de consumo, y resuelva cualquier cuestión técnica que os genere dudas.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Thumbnail Left, Text Right : END -->
          <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="background-color: #FFFFFF;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify; padding: 0 60px;">
                        Muchas gracias, y recibe un cordial saludo.
                      </td>
                    </tr>
                    <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify; padding: 30px 60px 0 60px;">
                        Xxx Xxx Xxxx
                      </td>
                    </tr>
                    <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 18px; line-height: 23px; color: #000000; text-align:justify; padding: 80px 60px 30px 60px; border-bottom: solid 3px #b9c800;">
                        GERENTE xxxxx <span style="color: #b9c800; font-size: 24px; vertical-align: middle">|</span> +34 91 602 20 20 <span style="color: #b9c800; font-size: 24px; vertical-align: middle">|</span> <a href="mailto:xxxx@bankia.com" style="color:#000000; text-decoration:none; word-break: break-word;">xxxx@bankia.com</a>
                      </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->

        <!-- Clear Spacer : BEGIN -->
        <!-- <tr>
            <td aria-hidden="true" height="3" style="font-size: 0px; line-height: 0px; background-color: #b9c800;">
            </td>
        </tr> -->
        <!-- Clear Spacer : END -->
          <!-- 1 Column Text : BEGIN -->
          <tr>
                <td width="100%" style="background-color: #555555;">
                    <span style="color: #FFFFFF;">Some Text</span>
                </td>
          </tr>
          <tr>
              <td style="background-color: #FFFFFF; padding: 20px 30px; color: #333333; text-align: justify">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; text-align: justify">
                                <a href="https://www.bankia.es/es/particulares/privacidad" target="_blank" title="privacidad" style="padding-top: 0; padding-bottom: 0; margin-top: 1px; margin-bottom: 0;">
                                    <p style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; text-align: justify; margin-top: 0; margin-bottom: 0">
                                        © Bankia SA 2020. Prohibida la reproducción total o parcial. Todos los derechos reservados.
                                    </p>
                                    <p style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; text-align: justify; margin-top: 0; margin-bottom: 0; border-bottom: solid #FFFFFF 10px; border-top: solid #FFFFFF 10px">
                                        Le informamos que sus datos personales serán tratados, en todo momento, por Bankia. S.A con domicilio social en C/Pintor Sorolla, 8, 46002 de Valencia, con la finalidad del envío de comunicaciones comerciales de Bankia.
                                    </p>
                                    <p style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; text-align: justify; margin-top: 0; margin-bottom: 0">
                                        Si no desea seguir recibiendo estas comunicaciones comerciales, puede solicitarlo enviando un correo electrónico a la dirección protecciondedatos@bankia.com. Usted podrá ejercitar sus derechos de acceso, rectificación, limitación de tratamiento, supresión, portabilidad y oposición al tratamiento de sus datos de carácter personal, dirigiendo su petición a la dirección protecciondedatos@bankia.com o al Apartado de correos 61076, 28080 de Madrid acompañando fotocopia de su documento identificativo. Puede consultar la información adicional y detallada sobre protección de datos en política de privacidad Bankia.
                                    </p>
                                </a>
                            </td>
                        </tr>
                  </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            <!-- Clear Spacer : BEGIN -->
            <tr>
                <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px; background-color: #FFFFFF;">
                    &nbsp;
                </td>
            </tr>
            <!-- Clear Spacer : END -->

	    </table>
	    <!-- Email Body : END -->

    <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
    </center>
</body>
</html>
