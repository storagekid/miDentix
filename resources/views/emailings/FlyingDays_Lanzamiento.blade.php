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
    <title>Bankia. Aprovecha ya los Flying Days.</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
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

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (max-width: 275px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
            .icon-holder {
              padding-top: 20px !important;
            }
            .icon {
              max-width: 50px !important;
            }
            .icon-text {
              padding: 20px 15px !important;
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
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #E7E9EA;">
  <center role="article" aria-roledescription="email" lang="en" style="width: 100%; background-color: #E7E9EA;">
    <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF;">
    <tr>
    <td>
    <![endif]-->

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="max-height:0; overflow:hidden; mso-hide:all;" aria-hidden="true">
          Bankia.
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Create white space after the desired preview text so email clients don’t pull other distracting text into the inbox preview. Extend as necessary. -->
        <!-- Preview Text Spacing Hack : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
          Aprovecha ya los Flying Days.
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
                <img style="display:block; cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/headers/bankia_iberia_header.jpg" width="600" height="" alt="Bankia e Iberia" title="Bankia e Iberia" border="0" />
              </td>
          </tr>
          <!-- Hero Image, Flush : END -->

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td style="background-color: #ffffff; padding: 0">
                    <img src="http://www.storagekid.com/mozodealmacen/images/main_image.jpg" width="600" height="" title="Flying Days. Hasta un 50% de descuento" alt="Flying Days. Hasta un 50% de descuento" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->
            <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="padding: 30px 0 0 0; color: #b9c800;background-color: #ffffff;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 34px; line-height: 36px; color: #b9c800; padding: 0 120px; text-align: center;">
                          Tus Avios te llevarán todavía más lejos
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
          <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="padding: 27px 0 30px 0; color: #000000;background-color: #ffffff;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td align="center" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 24px; color: #000000; padding: 0 60px; text-align: center;">
                          Compra con Avios tus vuelos en Iberia.com <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">desde el 5 hasta el 11 de octubre de 2020</span>. Obtendrás un <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">50% de descuento exclusivo</span> por ser cliente Iberia Icon, y un <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">25% de descuento exclusivo</span> por ser cliente Iberia Classic. Podrás beneficiarte de este descuento en los viajes que realices hasta el 30 de abril de 2021<sup style="line-height: 10px;">(1)</sup>.
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
          <!-- Button : BEGIN -->
          <tr>
            <td style="background-color: #FFFFFF; padding-bottom: 30px">
              <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                <tr>
                  <td class="button-td button-td-primary" style="border-radius: 6px; background: #FFFFFF;">
                    <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/flying-days" style="background: #FF9E1B; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 20px; text-decoration: none; padding: 13px 25px; color: #ffffff; display: block; border-radius: 6px;">COMPRAR</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- Button : END -->
          <!-- Hero Image, Flush : BEGIN -->
          <tr>
              <td style="background-color: #ffffff; padding: 0">
                  <img src="http://www.storagekid.com/mozodealmacen/images/1_2_image.jpg" width="600" height="" title="Compra y Vuela" alt="Compra y Vuela" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
              </td>
          </tr>
          <!-- Hero Image, Flush : END -->
          <!-- 2 Even Columns : BEGIN -->
	        <tr>
	            <td style="padding: 0; background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th valign="top" width="50%" class="">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                                <tr>
	                                    <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 21px; color: #000000; padding: 30px 80px; text-align: center;" class="">
	                                        <p style="margin: 0; font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">Compra</p>
	                                        <p style="margin: 0;">Consigue tu vuelo con un descuento exclusivo.</p>
	                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <th valign="top" width="50%" class="">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                                <tr>
                                    <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 21px; color: #000000; padding: 30px 75px; text-align: center;" class="">
                                        <p style="margin: 0; font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">Vuela</p>
                                        <p style="margin: 0;">Empieza a planificar tu escapada y vuelve a viajar.</p>
                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                    </tr>
	                </table>
	            </td>
	        </tr>
          <!-- 2 Even Columns : END -->
          <!-- Hero Image, Flush : BEGIN -->
          <tr>
            <td style="background-color: #ffffff; padding: 0">
                <img src="http://www.storagekid.com/mozodealmacen/images/cards_image.jpg" width="600" height="" title="Descuentos Exclusivos" alt="Descuentos Exclusivos" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
            </td>
          </tr>
          <!-- Hero Image, Flush : END -->
          <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="padding: 30px 0; color: #000000; background-color: #d8d9d9;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 31px; font-weight: 400; line-height: 33px; color: #000000; padding: 0 30px; text-align: center;">
                          Aprovecha ya los Flying Days
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
          <!-- 2 Even Columns : BEGIN -->
	        <tr>
	            <td style="padding: 0; background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th valign="top" width="50%" class="">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                                <tr>
                                    <td style="padding: 0; text-align: center">
                                      <img src="http://www.storagekid.com/mozodealmacen/images/girl_image.jpg" width="300" height="" title="Reserva tu vuelo del 5 al 11 de octubre" alt="Reserva tu vuelo del 5 al 11 de octubre" border="0" style="width: 100%; max-width: 300px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                        <!-- Column : BEGIN -->
	                        <th valign="top" width="50%" class="icon-holder" style="padding-top: 70px">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                  <tr>
                                    <td style="padding: 0; text-align: center">
                                        <img class="icon" src="http://www.storagekid.com/mozodealmacen/images/computer.png" width="300" height="" alt="Computer" title="Computer" border="0" style="width: 100%; max-width: 92px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                    </td>
	                                </tr>
	                                <tr>
                                    <td class="icon-text" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 21px; color: #000000; padding: 20px 30px; text-align: center;" class="">
                                        <p style="margin: 0;">Reserva tu vuelo del <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">5 al 11 de octubre</span> de 2020.</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #FFFFFF; padding-bottom: 30px">
                                      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                        <tr>
                                          <td class="button-td button-td-primary" style="border-radius: 6px; background: #FFFFFF;">
                                            <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/flying-days/" style="background: #FF9E1B; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 20px; text-decoration: none; padding: 13px 25px; color: #ffffff; display: block; border-radius: 6px;">COMPRAR</a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                    </tr>
	                </table>
	            </td>
	        </tr>
          <!-- 2 Even Columns : END -->
          <!-- 2 Even Columns : BEGIN -->
	        <tr>
	            <td style="padding: 0; background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <th valign="top" width="50%" class="icon-holder" style="padding-top: 70px">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                  <tr>
                                    <td style="padding: 0; text-align: center">
                                        <img class="icon" src="http://www.storagekid.com/mozodealmacen/images/tickets.png" width="300" height="" alt="Tickets" title="Tickets" border="0" style="width: 100%; max-width: 92px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                    </td>
	                                </tr>
	                                <tr>
                                    <td class="icon-text" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 21px; color: #000000; padding: 20px 60px; text-align: center;" class="">
                                        <p style="margin: 0;">Podrás viajar hasta el <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">30 de abril</span> de 2021.</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #FFFFFF; padding-bottom: 30px">
                                      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                        <tr>
                                          <td class="button-td button-td-primary" style="border-radius: 6px; background: #FFFFFF;">
                                            <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/flying-days/" style="background: #FF9E1B; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 20px; text-decoration: none; padding: 13px 25px; color: #ffffff; display: block; border-radius: 6px;">RESERVAR</a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
	                            </table>
	                        </th>
                          <!-- Column : END -->
                          <!-- Column : BEGIN -->
	                        <th valign="top" width="50%" class="">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                                <tr>
                                    <td style="padding: 0; text-align: center">
                                      <img src="http://www.storagekid.com/mozodealmacen/images/family_image.jpg" width="300" height="" title="Podrás viajar hasta el 30 de abril de 2021" alt="Podrás viajar hasta el 30 de abril de 2021" border="0" style="width: 100%; max-width: 300px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                        <!-- Column : END -->
	                    </tr>
	                </table>
	            </td>
	        </tr>
          <!-- 2 Even Columns : END -->
          <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="padding: 30px 0; color: #000000; background-color: #d8d9d9;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 22px; font-weight: 400; line-height: 25px; color: #000000; padding: 0 70px; text-align: center;">
                          ¿Conoces el resto de ventajas que obtendrás por comprar tu vuelo con Avios? <a href="https://www.iberiacards.es/ventajas-entidades/flying-days/" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; text-decoration: underline; color: #000000">Descúbrelas.</a>
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
          <tr>
            <td style="background-color: #FFFFFF; padding: 30px 30px 20px 30px; color: #333333; font-size: 13px; line-height: 15px; text-align: justify">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; color: #333333">
                    (1) Promoción válida para titulares de las tarjetas particulares Iberia Icon e Iberia Classic emitidas por Iberia Cards y
                    comercializadas tanto por ésta como por Bankia, Banco Santander y BBVA, y Tarjetas Personales de Empresa de Iberia
                    Cards. Será necesario que el cliente se identifique en www.iberia.com con la cuenta Iberia Plus vinculada a su tarjeta
                    Iberia Cards y acceder al apartado de reserva de vuelos con Avios. Se aplicará un 50% de descuento en Avios para los
                    clientes titulares de tarjetas Iberia Icon, así como un 25% de descuento en Avios para los clientes titulares de tarjetas
                    Iberia Classic, en la compra de billetes con cargo enteramente a Avios, entre los días 5 al 11 de octubre de 2020 (ambos
                    incluidos) para vuelos con código IB, I2 y YW directos, comercializados por Iberia y operados por Iberia, Air Nostrum e
                    Iberia Express para volar del 5 de octubre de 2020 al 30 de abril de 2021 (ambos incluidos). El cliente podrá
                    beneficiarse de esta promoción para adquirir ya sea un billete para él, o bien incluir además a un acompañante (que
                    debe ser beneficiario en su cuenta Iberia Plus) debiendo en este último caso, ser emitidos ambos billetes bajo el mismo
                    localizador. Los billetes de avión adquiridos en el marco de la presente promoción quedarán sometidos a las
                    condiciones generales del Programa Iberia Plus (consúltalas en www.iberia.com), si bien no se admitirán cambios fuera
                    del periodo de vuelo establecido en la presente comunicación. Promoción válida hasta agotar existencia de Avios
                    destinados a la misma (50 millones de Avios). Ofertas no acumulables a otras de utilización de Avios vigentes en el
                    mismo periodo y destino. Esta promoción es personal e intransferible, válida salvo error tipográfico u omisión. La
                    correcta aplicación de la presente promoción será responsabilidad de Iberia Líneas Aéreas. Para más información por
                    favor visita la página web www.iberia.com
                  </td>
                </tr>
                <tr>
                    <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; color: #333333; padding: 10px 0 10px 0;">
                    Quedan excluidas las tarjetas Iberia Icon Business, Iberia Icon Corporate, Iberia Business, y tarjetas Iberia Professional,
                    así como aquellas tarjetas bloqueadas, canceladas o en situación de impago. Quedan excluidas las compras con el
                    programa Avios&amp;Money, así como las compras de billetes de Puente Aéreo.
                  </td>
                </tr>
                <tr>
                    <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; color: #333333">
                    Iberia Cards, Sociedad Conjunta para la Emisión y Gestión de Medios de Pago E.F.C., S.A, es la entidad de pago emisora
                    de las tarjetas de crédito Iberia Cards, comercializadas por esta y por Bankia.
                  </td>
                </tr>
                <tr>
                    <td aria-hidden="true" height="18" style="font-size: 0px; line-height: 0px">
                        &nbsp;
                    </td>
                </tr>
              </table>
            </td>
          </tr>
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
