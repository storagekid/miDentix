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
    <title>Bankia. Newsletter Autónomos - Octubre 2020</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
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
			<link href="https://www.bankia.es/estaticos/Portal-unico/css/fonts.css" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
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

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
            .info {
              padding-right: 50px !important;
            }
            .icon {
              padding-left: 40px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
            .info {
              padding-right: 50px !important;
            }
            .icon {
              padding-left: 40px !important;
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
            Bankia.
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Create white space after the desired preview text so email clients don’t pull other distracting text into the inbox preview. Extend as necessary. -->
        <!-- Preview Text Spacing Hack : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
          Newsletter Autónomos - Octubre 2020.
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
                <td style="background-color: #ffffff; text-align: center">
                  <img style="display:block; cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/headers/bankia_header_pymes_autonomos_easy.jpg" width="600" height="" alt="Bankia" title="Bankia" border="0" />
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->
          <!-- Hero Image, Flush : BEGIN -->
          <tr>
            <td style="background-color: #ffffff; text-align: left">
              <img style="display:block; cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/main_info.jpg" width="600" height="" alt="Newsletter Octubre 2020" title="Newsletter Octubre 2020" border="0" />
            </td>
          </tr>
          <!-- Hero Image, Flush : END -->
          <!-- Thumbnail Left, Text Right : BEGIN -->
          <tr>
            <td dir="ltr" width="100%" style="padding: 30px 0; background-color: #FFFFFF;">
                <a href="https://www.bankia.es/es/pymes-y-autonomos/fiscalidad/calendario-fiscal-del-ultimo-trimestre-para-autonomos-y-pymes" style="text-decoration: none; color: #000000">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <th width="90" class="" style="padding-left: 37px" valign="middle">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="middle">
                                            <img src="http://www.storagekid.com/mozodealmacen/images/calculator.png" width="72" height="" title="Calendario" alt="Calendario" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                        </td>
                                    </tr>
                                </table>
                            </th>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <th width="473" style="padding-left: 15px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <!-- Thumbnail Left, Text Right : BEGIN -->
                                <tr>
                                    <td dir="ltr" width="100%">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <!-- Column : BEGIN -->
                                                <th width="58" class="s" valign="middle">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td dir="ltr" valign="middle">
                                                                <img src="http://www.storagekid.com/mozodealmacen/images/arrows.png" width="58" height="" title="Flechas" alt="Flechas" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <!-- Column : END -->
                                                <!-- Column : BEGIN -->
                                                <th width="415" style="padding-left: 5px;" valign="middle">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td dir="ltr" valign="top" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 20px; color: #b9c800; text-align: left; line-height: 0">
                                                            CALENDARIO
                                                        </td>
                                                    </tr>
                                                    </table>
                                                </th>
                                                <!-- Column : END -->
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Thumbnail Left, Text Right : END -->
                                <tr>
                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 16px; line-height: 20px; color: #352a20; text-align: left; padding-right: 121px; padding-top: 5px">
                                        <span>Recordamos el cumplimiento de las principales obligaciones tributarias estatales que nos quedan para este último trimestre del año.</span>
                                    </td>
                                </tr>
                                </table>
                            </th>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </a>
            </td>
          </tr>
          <!-- Thumbnail Left, Text Right : END -->
          <!-- Thumbnail Left, Text Right : BEGIN -->
          <tr>
            <td dir="ltr" width="100%" style="padding: 30px 0; background-color: #FFFFFF;">
                <a href="https://www.bankia.es/es/pymes-y-autonomos/fiscalidad/cuestiones-a-tener-en-cuenta-por-autonomos-y-pymes-para-el-cierre-fiscal" style="text-decoration: none; color: #000000">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <th width="90" class="" style="padding-left: 37px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="middle">
                                            <img src="http://www.storagekid.com/mozodealmacen/images/bullhorn.png" width="86" height="" title="Novedades" alt="Novedades" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                        </td>
                                    </tr>
                                </table>
                            </th>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <th width="473" style="padding-left: 15px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <!-- Thumbnail Left, Text Right : BEGIN -->
                                <tr>
                                    <td dir="ltr" width="100%">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <!-- Column : BEGIN -->
                                                <th width="58" class="" valign="middle">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td dir="ltr" valign="middle">
                                                                <img src="http://www.storagekid.com/mozodealmacen/images/arrows.png" width="58" height="" title="Flechas" alt="Flechas" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <!-- Column : END -->
                                                <!-- Column : BEGIN -->
                                                <th width="415" style="padding-left: 5px;" valign="middle">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td dir="ltr" valign="top" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 20px; color: #b9c800; text-align: left; line-height: 0">
                                                            <span>NOVEDADES</span>
                                                        </td>
                                                    </tr>
                                                    </table>
                                                </th>
                                                <!-- Column : END -->
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Thumbnail Left, Text Right : END -->
                                <tr>
                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 16px; line-height: 20px; color: #352a20; text-align: left; padding-right: 151px; padding-top: 5px">
                                        <span>Información relevante para el cierre fiscal, deducciones, gastos fiscalmente deducibles, reducciones y mucho más.</span>
                                    </td>
                                </tr>
                                </table>
                            </th>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </a>
            </td>
          </tr>
          <!-- Thumbnail Left, Text Right : END -->
          <!-- Thumbnail Left, Text Right : BEGIN -->
          <tr>
            <td dir="ltr" width="100%" style="padding: 30px 0 15px 0; background-color: #FFFFFF;">
                <a href="https://www.bankia.es/es/pymes-y-autonomos/fiscalidad/consultas-tributarias-emitidas-por-la-direccion-general-de-tributos" style="text-decoration: none; color: #000000">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <th width="90" class="" style="padding-left: 37px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="middle">
                                            <img src="http://www.storagekid.com/mozodealmacen/images/money.png" width="71" height="" title="Tributos" alt="Tributos" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                        </td>
                                    </tr>
                                </table>
                            </th>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <th width="473" style="padding-left: 15px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <!-- Thumbnail Left, Text Right : BEGIN -->
                                <tr>
                                    <td dir="ltr" width="100%">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <!-- Column : BEGIN -->
                                                <th width="58" class="" valign="middle">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td dir="ltr" valign="middle">
                                                                <img src="http://www.storagekid.com/mozodealmacen/images/arrows.png" width="58" height="" title="Flechas" alt="Flechas" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>
                                                <!-- Column : END -->
                                                <!-- Column : BEGIN -->
                                                <th width="415" style="padding-left: 5px;" valign="middle">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td dir="ltr" valign="top" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 20px; color: #b9c800; text-align: left; line-height: 21px">
                                                            <span>DIRECCIÓN GENERAL DE TRIBUTOS</span>
                                                        </td>
                                                    </tr>
                                                    </table>
                                                </th>
                                                <!-- Column : END -->
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Thumbnail Left, Text Right : END -->
                                <tr>
                                    <td class="info" dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 16px; line-height: 20px; color: #352a20; text-align: left; padding-right: 121px; padding-top: 5px">
                                        <span>Señalamos algunas de las recientes consultas emitidas por la Dirección General de Tributos que consideramos pueden resultar de interés.</span>
                                    </td>
                                </tr>
                                </table>
                            </th>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </a>
            </td>
          </tr>
          <!-- Thumbnail Left, Text Right : END -->
          <tr>
                <td aria-hidden="true" height="10" style="font-size: 0; line-height: 0; background-color: #FFFFFF;">
                    &nbsp;
                </td>
            </tr>
            <!-- Clear Spacer : END -->
          <!-- 1 Column Text : BEGIN -->
	        <tr>
	            <td style="background-color: #FFFFFF; padding: 10px 0 30px 0; color: #FFFFFF">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 22px; color: #FFFFFF; text-align: center;">
                                <a href="https://www.facebook.com/bankia.es" target="_blank" title="Facebook"><img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/ico-fb.png" width="41" height="46" border="0" alt="Facebook" title="Facebook"></a>
                                <a href="https://twitter.com/bankia" target="_blank" title="Twitter"><img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/ico-tw.png" width="46" height="46" border="0" alt="Twitter" title="Twitter"></a>
                                <a href="https://www.youtube.com/c/bankia" target="_blank" title="YouTube"><img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/ico-yt.png" width="45" height="46" border="0" alt="YouTube" title="YouTube"></a>
	                        </td>
	                    </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            <!-- 1 Column Text : BEGIN -->
            <tr>
              <td style="background-color: #FFFFFF; padding: 0 30px; color: #333333; text-align: justify">
                <a href="https://www.bankia.es/es/particulares/privacidad" target="_blank" title="privacidad">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; padding: 15px 0 10px 0; border-top: 3px solid #b9c800">
                            © Bankia SA 2020. Prohibida la reproducción total o parcial. Todos los derechos reservados. 
	                        </td>
                        </tr>
                        <tr>
                          <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; padding-bottom: 10px">
                            Le informamos que sus datos personales serán tratados, en todo momento, por Bankia. S.A con domicilio social en C/Pintor Sorolla, 8, 46002 de Valencia, con la finalidad del envío de comunicaciones comerciales de Bankia.
	                        </td>
                        </tr>
                        <tr>
                          <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333;">
                            Si no desea seguir recibiendo estas comunicaciones comerciales, puede solicitarlo enviando un correo electrónico a la dirección protecciondedatos@bankia.com. Usted podrá ejercitar sus derechos de acceso, rectificación, limitación de tratamiento, supresión, portabilidad y oposición al tratamiento de sus datos de carácter personal, dirigiendo su petición a la dirección protecciondedatos@bankia.com o al Apartado de correos 61076, 28080 de Madrid acompañando fotocopia de su documento identificativo. Puede consultar la información adicional y detallada sobre protección de datos en política de privacidad Bankia.
	                        </td>
                        </tr>
                  </table>
                </a>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            <!-- Clear Spacer : BEGIN -->
            <tr>
                <td aria-hidden="true" height="30" style="font-size: 0; line-height: 0; background-color: #FFFFFF;">
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
