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
    <title>Webminar. El Gran Confinamiento</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
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
        <!-- <div style="max-height:0; overflow:hidden; mso-hide:all;" aria-hidden="true">
            (Optional) This text will appear in the inbox preview, but not the email body. It can be used to supplement the email subject line or even summarize the email's contents. Extended text preheaders (~490 characters) seems like a better UX for anyone using a screenreader or voice-command apps like Siri to dictate the contents of an email. If this text is not included, email clients will automatically populate it using the text (including image alt text) at the start of the email's body.
        </div> -->
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Create white space after the desired preview text so email clients don???t pull other distracting text into the inbox preview. Extend as necessary. -->
        <!-- Preview Text Spacing Hack : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
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
                  <a href="https://www.bankia.es/es/banca-privada" target="_blank" title="Bankia Banca Privada"><img style="display:block; cursor: default;" src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_LCDLP_01.jpg" width="600" height="130" alt="Bankia Banca Privada" border="0" /></a>
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td style="background-color: #ffffff;">
                    <img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_LCDLP_03.gif" width="600" height="" title="Webminar El Gran Confinamiento" alt="Webminar El Gran Confinamiento" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <!-- Thumbnail Left, Text Right : BEGIN -->
	        <tr>
	            <td dir="ltr" width="100%" style="padding: 30px; background-color: #ffffff;">
	                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th width="55" class="">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="" style="text-align: left; line-height: 0;">
	                                        <img src="http://www.storagekid.com/mozodealmacen/images/calendar.jpg" width="55" height="67" alt="alt_text" border="0" class="" style="height: auto; background: #dddddd; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
	                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <th width="" class="">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size:18px; color:#000000; padding: 13px; text-align: left;" class="">
	                                        <!-- Button : BEGIN -->
	                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" class="" style="float:left;">
	                                            <tr>
                                                    <td style="line-height: 19px">
                                                        <span>Lunes</span>
                                                    </td>
                                                </tr>
                                                <tr>
		                                            <td style="line-height: 19px">
                                                        <span>27 de abril de 2020</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="line-height: 19px">
                                                        <span>17:00 h.</span>
                                                    </td>
	                                            </tr>
	                                      </table>
	                                      <!-- Button : END -->
	                                    </td>
	                                </tr>
	                            </table>
	                        </th>
                          <!-- Column : END -->
                          <!-- Column : BEGIN -->
	                        <th width="99" class="" style="padding-right: 35px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td dir="ltr" valign="center" style="text-align: right; line-height: 0">
                                        <img src="http://www.storagekid.com/mozodealmacen/images/m-team.jpg" width="99" height="85" alt="alt_text" border="0" class="center-on-narrow" style="height: auto; background: #dddddd; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
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

            <!-- Hero Image, Flush : BEGIN -->
            <!-- <tr>
                <td style="background-color: #ffffff;">
                    <img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_LCDLP_02.jpg" width="600" height="" title="Lunes. 27 de abril de 2020. 17:00 h. Microsoft Teams." alt="Lunes. 27 de abril de 2020. 17:00 h. Microsoft Teams." border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr> -->
            <!-- Hero Image, Flush : END -->
            
            <!-- 1 Column Text : BEGIN -->
	        <tr>
	            <td style="background-color: #98a2ab;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <td style="padding: 30px; padding-bottom: 5px; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 36px; line-height: 36px; color: #FFFFFF;">
                                EL GRAN CONFINAMIENTO
	                        </td>
                        </tr>
                        <tr>
	                        <td style="padding: 30px; padding-top: 0; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 20px; line-height: 20px; color: #FFFFFF;">
                            Consecuencias econ??micas del COVID-19 y recomendaciones de asignaci??n de activos
	                        </td>
	                    </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            
            	        <!-- Clear Spacer : BEGIN -->
	        <tr>
	            <td aria-hidden="true" height="10" style="font-size: 0px; line-height: 0px;">
	                &nbsp;
	            </td>
	        </tr>
            <!-- Clear Spacer : END -->
            
            <!-- 1 Column Text : BEGIN -->
	        <tr>
	            <td style="background-color: #dadee0; padding: 30px 0; color: #352a20">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
	                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 22px; color: #352a20; padding: 0 30px; padding-bottom: 15px; ">
                                Estimado <<$nombre>>:
	                        </td>
                        </tr>
	                    <tr>
	                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 22px; color: #352a20; padding: 0 60px; text-align: justify; padding-bottom: 15px;">
                                Queremos invitarle a asistir a nuestro <strong style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700;">webinar</strong> de Bankia Banca Privada <strong style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700;">???El gran confinamiento: escenarios de salida y asignaci??n de activos???.</strong> En esta sesi??n, hablaremos de las consecuencias econ??micas del COVID-19 y c??mo mitigar su impacto, y la evoluci??n durante la crisis de los mercados financieros, con el objetivo de poder <strong style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700;">dar a nuestros clientes las mejores recomendaciones de cara al futuro de sus carteras.</strong>
	                        </td>
                        </tr>
                        <tr>
	                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 22px; color: #352a20; padding: 0 60px">
                                <span>En la sesi??n analizaremos los siguientes temas:</span>
                                <ol style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; margin-bottom: 0">
                                    <li><span style="padding-bottom: 15px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500">La extensi??n de la pandemia y su contenci??n</span></li>
                                    <li><span style="padding-bottom: 15px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500">Consecuencias econ??micas</span></li>
                                    <li><span style="padding-bottom: 15px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500">Mitigar el impacto y salir con fuerza: medidas de bancos centrales y gobiernos y medidas para la reactivaci??n</span></li>
                                    <li><span style="padding-bottom: 15px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500">El caso particular de la econom??a espa??ola</span></li>
                                    <li><span style="padding-bottom: 15px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500">Evoluci??n durante la crisis de los mercados financieros</span></li>
                                    <li><span style="padding-bottom: 15px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500">Impacto de la crisis Covid-19 en las valoraciones de losmercados financieros</span></li>
                                    <li><span style="padding-bottom: 15px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500">Recomendaciones de asignaci??n de activos</span></li>
                                </ol>
	                        </td>
	                    </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->

            <!-- Hero Image, Flush : BEGIN -->
            <!-- <tr>
                <td style="background-color: #FFFFFF;">
                    <img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_LCDLP_06.jpg" width="600" height="" title="Moderadora: Virginia Zafra. Directora de Comunicaci??n Externa de Bankia" alt="Moderadora: Virginia Zafra. Directora de Comunicaci??n Externa de Bankia" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr> -->
            <!-- Hero Image, Flush : END -->
            <!-- 1 Column Text : BEGIN -->
	        <tr>
	            <td style="background-color: #FFFFFF;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <td style="padding: 30px; padding-bottom: 5px; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 18px; line-height: 20px; color: #352a20;">
                                Moderadora:
	                        </td>
                        </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            <!-- Thumbnail Left, Text Right : BEGIN -->
	        <tr>
	            <td dir="ltr" width="100%" style="padding: 10px; background-color: #FFFFFF;">
	                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th width="109 class="stack-column-center">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="padding: 0 0 0 20px;">
	                                        <img src="http://www.storagekid.com/mozodealmacen/images/presenter.jpg" width="109" height="110" title="Moderadora: Virginia Zafra. Directora de Comunicaci??n Externa de Bankia" alt="Moderadora: Virginia Zafra. Directora de Comunicaci??n Externa de Bankia" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20;">
	                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <th width="66.66%" style="padding-left: 15px">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 18px; line-height: 22px; color: #352a20; font-weight: bold; text-align: left">
	                                        <span>Virginia Zafra</span>
	                                    </td>
                                    </tr>
                                    <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 15px; line-height: 20px; color: #352a20; text-align: left;">
	                                        <span>Directora de Comunicaci??n Externa de Bankia</span>
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
            <!-- 1 Column Text : BEGIN -->
	        <tr>
	            <td style="background-color: #FFFFFF;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <td style="padding: 30px; padding-bottom: 5px; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 18px; line-height: 20px; color: #352a20;">
                                Ponentes:
	                        </td>
                        </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            <!-- Thumbnail Left, Text Right : BEGIN -->
	        <tr>
	            <td dir="ltr" width="100%" style="padding: 10px; background-color: #FFFFFF;">
	                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th width="109 class="stack-column-center">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="padding: 0 0 0 20px;">
	                                        <img src="http://www.storagekid.com/mozodealmacen/images/speaker-1.jpg" width="109" height="110" title="Ponente: Jose Ram??n D??ez Guijarro. Director de Estudios de Bankia" alt="Ponente: Jose Ram??n D??ez Guijarro. Director de Estudios de Bankia" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20;">
	                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <th width="66.66%" style="padding-left: 15px">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 18px; line-height: 22px; color: #352a20; font-weight: bold; text-align: left">
	                                        <span>Jose Ram??n D??ez Guijarro</span>
	                                    </td>
                                    </tr>
                                    <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 15px; line-height: 20px; color: #352a20; text-align: left;">
	                                        <span>Director de Estudios de Bankia</span>
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
            <!-- Hero Image, Flush : BEGIN -->
            <!-- <tr>
                <td style="background-color: #FFFFFF;">
                    <img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_LCDLP_07.jpg" width="600" height="" title="Ponente: Jose Ram??n D??ez Guijarro. Director de Estudios de Bankia" alt="Ponente: Jose Ram??n D??ez Guijarro. Director de Estudios de Bankia" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr> -->
            <!-- Hero Image, Flush : END -->
            <!-- Thumbnail Left, Text Right : BEGIN -->
	        <tr>
	            <td dir="ltr" width="100%" style="padding: 10px; background-color: #FFFFFF;">
	                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th width="109 class="stack-column-center">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="padding: 0 0 0 20px;">
	                                        <img src="http://www.storagekid.com/mozodealmacen/images/speaker-2.jpg" width="109" height="110" title="Ponente: Ignacio Ezquiaga Dom??nguez. Director Corporativo Banca Privada y Gesti??n de Activos" alt="Ponente: Ignacio Ezquiaga Dom??nguez. Director Corporativo Banca Privada y Gesti??n de Activos" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20;">
	                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <th width="66.66%" style="padding-left: 15px">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 18px; line-height: 22px; color: #352a20; font-weight: bold; text-align: left">
	                                        <span>Ignacio Ezquiaga Dom??nguez</span>
	                                    </td>
                                    </tr>
                                    <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 15px; line-height: 20px; color: #352a20; text-align: left;">
	                                        <span>Director Corporativo Banca Privada y Gesti??n de Activos</span>
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
            <!-- Hero Image, Flush : BEGIN -->
            <!-- <tr>
                <td style="background-color: #FFFFFF;">
                    <img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_LCDLP_08.jpg" width="600" height="" title="Ponente: Ignacio Ezquiaga Dom??nguez. Director Corporativo Banca Privada y Gesti??n de Activos" alt="Ponente: Ignacio Ezquiaga Dom??nguez. Director Corporativo Banca Privada y Gesti??n de Activos" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr> -->
            <!-- Hero Image, Flush : END -->
            <!-- Thumbnail Left, Text Right : BEGIN -->
	        <tr>
	            <td dir="ltr" width="100%" style="padding: 10px; background-color: #FFFFFF;">
	                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th width="109 class="stack-column-center">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="padding: 0 0 0 20px;">
	                                        <img src="http://www.storagekid.com/mozodealmacen/images/speaker-3.jpg" width="109" height="110" title="Ponente: C??sar Mart??nez Mart??n. Director Asesoramiento y An??lisis de Producto de Bankia Banca Privada" alt="Ponente: C??sar Mart??nez Mart??n. Director Asesoramiento y An??lisis de Producto de Bankia Banca Privada" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20;">
	                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <th width="66.66%" style="padding-left: 15px">
	                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
	                                <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 18px; line-height: 22px; color: #352a20; font-weight: bold; text-align: left">
	                                        <span>C??sar Mart??nez Mart??n</span>
	                                    </td>
                                    </tr>
                                    <tr>
	                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 15px; line-height: 20px; color: #352a20; text-align: left;">
	                                        <span>Director Asesoramiento y An??lisis de Producto de Bankia Banca Privada</span>
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
            <!-- Hero Image, Flush : BEGIN -->
            <!-- <tr>
                <td style="background-color: #FFFFFF;">
                    <img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_LCDLP_09.jpg" width="600" height=""  title="Ponente: C??sar Mart??nez Mart??n. Director Asesoramiento y An??lisis de Producto de Bankia Banca Privada" alt="Ponente: C??sar Mart??nez Mart??n. Director Asesoramiento y An??lisis de Producto de Bankia Banca Privada" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr> -->
            <!-- Hero Image, Flush : END -->

            <!-- 1 Column Text : BEGIN -->
	        <tr>
	            <td style="background-color: #98a2ab; padding: 30px 60px; color: #FFFFFF">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
	                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 22px; color: #FFFFFF;">
                            <span>Para confirmar asistencia escriba un correo a <a href="mailto:galtamuro@bankia.com" target="_blank" style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; color:#FFFFFF; text-decoration: underline">galtamuro@bankia.com</a> con la siguiente informaci??n:</span>
                                <ul>
                                    <li>Nombre y apellidos</li>
                                    <li>Empresa</li>
                                    <li>Direcci??n de correo electr??nico</li>
                                </ul>
                            <span><a href="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/BK_instruccioneswebinar_BBP_LaCrisisDeLaPandemia_v2.pdf" target="_blank" style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; color:#FFFFFF; text-decoration: underline">Consulte aqu?? las instrucciones para conectarse al webinar.</a></span>
	                        </td>
	                    </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            
            <!-- 1 Column Text : BEGIN -->
	        <tr>
	            <td style="background-color: #FFFFFF; padding: 30px; color: #FFFFFF; border-bottom: 2px solid #98a2ab">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 22px; color: #FFFFFF; text-align: center;">
                                <a href="https://www.facebook.com/bankia.es" target="_blank" title="Facebook"><img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/ico-fb.png" width="41" height="46" border="0" alt="Facebook"></a>
                                <a href="https://twitter.com/bankia" target="_blank" title="Twitter"><img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/ico-tw.png" width="46" height="46" border="0" alt="Twitter"></a>
                                <a href="https://www.youtube.com/c/bankia" target="_blank" title="YouTube"><img src="https://www.bankia.es/estaticos/Portal-unico/imagenes/mailing/BBP/webinar/ico-yt.png" width="45" height="46" border="0" alt="YouTube"></a>
	                        </td>
	                    </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->

            <tr>
	            <td style="background-color: #FFFFFF; padding: 30px; color: #352a20; text-align: justify">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #352a20; padding-bottom: 5px">
                                ?? Bankia SA 2020. Prohibida la reproducci??n total o parcial. Todos los derechos reservados.
	                        </td>
                        </tr>
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #352a20; padding-bottom: 5px">
                                Le informamos que sus datos personales ser??n tratados, en todo momento, por Bankia. S.A con domicilio social en C/Pintor Sorolla, 8, 46002 de Valencia, con la finalidad del env??o de comunicaciones comerciales de Bankia.
	                        </td>
                        </tr>
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #352a20;">
                                Si no desea seguir recibiendo estas comunicaciones comerciales, puede solicitarlo enviando un correo electr??nico a la direcci??n protecciondedatos@bankia.com. Usted podr?? ejercitar sus derechos de acceso, rectificaci??n, limitaci??n de tratamiento, supresi??n, portabilidad y oposici??n al tratamiento de sus datos de car??cter personal, dirigiendo su petici??n a la direcci??n protecciondedatos@bankia.com o al Apartado de correos 61076, 28080 de Madrid acompa??ando fotocopia de su documento identificativo. Puede consultar la informaci??n adicional y detallada sobre protecci??n de datos en pol??tica de privacidad Bankia.
	                        </td>
                        </tr>
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->

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
