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
    <title>Promoción Bankia-Iberia-Paradores</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
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
          Promoción exclusiva para clientes Iberia Cards.
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Create white space after the desired preview text so email clients don’t pull other distracting text into the inbox preview. Extend as necessary. -->
        <!-- Preview Text Spacing Hack : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
          Alójate por solo 8.000 Avios la noche
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
                <img style="display:block; cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/bankia_iberia_header.jpg" width="600" height="" alt="Bankia e Iberia" title="Bankia e Iberia" border="0" />
              </td>
          </tr>
          <!-- Hero Image, Flush : END -->

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td style="background-color: #ffffff; padding: 0 30px">
                    <img src="http://www.storagekid.com/mozodealmacen/images/hero_header.jpg" width="600" height="" title="Alójate por solo 8.000 Avios la noche" alt="Alójate por solo 8.000 Avios la noche" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->
            <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="padding: 30px 0; color: #333333;background-color: #ffffff;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 36px; line-height: 38px; color: #333333; padding: 0 60px; text-align: center;">
                        Promoción exclusiva para clientes Iberia Cards
                        </td>
                    </tr>
                    <tr>
                        <td aria-hidden="true" height="15" style="font-size: 0px; line-height: 0px;">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 24px; color: #333333; padding: 0 60px; text-align: center;">
                        Ha llegado el momento de vivir nuevas experiencias, y nosotros queremos contribuir a que tus días y tus noches sean inolvidables con esta promoción exclusiva.
                        </td>
                    </tr>
                    <tr>
                        <td aria-hidden="true" height="15" style="font-size: 0px; line-height: 0px;">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 24px; color: #333333; padding: 0 60px; text-align: center;">
                        Alójate en una selección de Paradores por solo <strong style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700;">8.000 Avios la noche</strong>, o si lo prefieres, por <strong style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700;">10.500 Avios la noche</strong> con alojamiento y desayuno buffet incluido. Solo tienes que registrarte y hacer tu reserva hasta el 28 de diciembre<span style="font-size: 12px; line-height: 10px; vertical-align: super;">(1)</span>.
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
            <!-- 1 Column Text : BEGIN -->
            <tr>
	            <td style="padding: 30px 0 0 0; color: #333333; background-image: linear-gradient(#F5F5F5, #FFFFFF);">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
	                        <td style="font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 24px; line-height: 26px; color: #333333; padding: 0 150px; text-align: center;">
                          ¿Cómo acceder a la promoción de Paradores?
	                        </td>
                      </tr>
                      <tr>
                          <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px;">
                              &nbsp;
                          </td>
                      </tr>
	                    <!-- Thumbnail Left, Text Right : BEGIN -->
                      <tr>
                          <td dir="ltr" width="100%" style="padding: 0 80px;">
                              <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                  <tr>
                                      <!-- Column : BEGIN -->
                                      <th width="50" class="stack-column-center">
                                          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td dir="ltr" valign="top">
                                                      <img src="http://www.storagekid.com/mozodealmacen/images/icon_laptop.png" width="50" height="" title="Acceso descuento online" alt="Acceso descuento online" border="0" class="center-on-narrow" style="height: auto; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20;">
                                                  </td>
                                              </tr>
                                          </table>
                                      </th>
                                      <!-- Column : END -->
                                      <!-- Column : BEGIN -->
                                      <th width="350" style="padding-left: 25px">
                                          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 18px; line-height: 24px; color: #352a20; text-align: left">
                                                  Accede al descuento a través del botón, y al registrarte en esta promoción obtendrás un cupón con tus datos que tendrás que presentar en el Parador.
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
                          <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px;">
                              &nbsp;
                          </td>
                      </tr>
	                    <!-- Thumbnail Left, Text Right : BEGIN -->
                      <tr>
                          <td dir="ltr" width="100%" style="padding: 0 80px;">
                              <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                  <tr>
                                      <!-- Column : BEGIN -->
                                      <th width="50" class="stack-column-center">
                                          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td dir="ltr" valign="top">
                                                      <img src="http://www.storagekid.com/mozodealmacen/images/icon_headset.png" width="50" height="" title="Teléfono de atención al clinete" alt="Teléfono de atención al clinete" border="0" class="center-on-narrow" style="height: auto; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 15px; line-height: 15px; color: #352a20;">
                                                  </td>
                                              </tr>
                                          </table>
                                      </th>
                                      <!-- Column : END -->
                                      <!-- Column : BEGIN -->
                                      <th width="350" style="padding-left: 25px">
                                          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 18px; line-height: 24px; color: #352a20; text-align: left">
                                                  Consulta el listado de la selección de Paradores, y cuando lo hayas elegido, haz tu reserva en el teléfono de la Central de Paradores 913 742 500.
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
                          <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px;">
                              &nbsp;
                          </td>
                      </tr>
                      <!-- Thumbnail Left, Text Right : BEGIN -->
                      <tr>
                          <td dir="ltr" width="100%" style="padding: 0 80px;">
                              <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                  <tr>
                                      <!-- Column : BEGIN -->
                                      <th width="50" class="stack-column-center">
                                          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td dir="ltr" valign="top">
                                                      <img src="http://www.storagekid.com/mozodealmacen/images/icon_house.png" width="50" height="" title="Alojamiento" alt="Alojamiento" border="0" class="center-on-narrow" style="height: auto; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 15px; line-height: 15px; color: #352a20;">
                                                  </td>
                                              </tr>
                                          </table>
                                      </th>
                                      <!-- Column : END -->
                                      <!-- Column : BEGIN -->
                                      <th width="350" style="padding-left: 25px">
                                          <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 18px; line-height: 24px; color: #352a20; text-align: left">
                                                  Cuando te alojes en el Parador, muestra el cupón y tu tarjeta Iberia Plus en la recepción y te descontarán los Avios de tu estancia en el propio Parador.
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
                          <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px;">
                              &nbsp;
                          </td>
                      </tr>
                      <tr>
                        <td style="background-color: #FFFFFF; padding: 0 30px; color: #333333; text-align: center">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                              <tr>
                                <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 24px; color: #333333">
                                    *Excepto del 9 al 11 de octubre y del 4 al 7 de diciembre de 2020; ambos días de inicio y finalización de cada periodo inclusive.
                                </td>
                              </tr>
                            </table>
                        </td>
                      </tr>
                      <!-- 1 Column Text : END -->

                      <!-- Button : BEGIN -->
                      <tr>
                        <td style="padding: 30px 0 0 0;">
                          <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                            <tr>
                              <td class="button-td button-td-primary" style="border-radius: 6px; background: #FF9E1B;">
                                <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/paradores/?utm_source=Bankia&utm_medium=Mail&utm_campaign=Bankia-Paradores-Julio" style="background: #FF9E1B; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 20px; text-decoration: none; padding: 13px 25px; color: #ffffff; display: block; border-radius: 6px;">Accede al descuento</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    <!-- Button : END -->
	                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td style="background-color: #ffffff;">
                    <img src="http://www.storagekid.com/mozodealmacen/images/paradores_logo.jpg" width="600" height="" title="Paradores" alt="Paradores" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td style="background-color: #ffffff;">
                    <img src="http://www.storagekid.com/mozodealmacen/images/hero_footer.jpg" width="600" height="" title="Alójate por 10.500 Avios la noche" alt="Alójate por 10.500 Avios la noche" border="0" style="width: 100%; max-width: 600px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <tr>
              <td style="background-color: #FFFFFF; padding: 30px 30px 20px 30px; color: #333333; text-align: justify">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      (1) Campaña exclusiva para Titulares de tarjetas emitidas por Iberia Cards, particulares y/o de
                      empresa, comercializadas por Bankia. Promoción válida del 5 de julio al 28 de diciembre de
                      2020, excepto del 9 al 11 de octubre y del 4 al 7 de diciembre de 2020 (días de inicio y
                      finalización de cada periodo igualmente excluidos) para estancias en Paradores, en habitación
                      estándar para 1 ó 2 personas, en régimen de solo alojamiento, o de alojamiento y desayuno
                      buffet incluido.  
                    </td>
                  </tr>
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      Para poder beneficiarse de la promoción de una noche de alojamiento en la selección de
                      Paradores incluidos, por 8.000 Avios o por 10.500 Avios con alojamiento y desayuno buffet
                      incluido, será necesario seguir el siguiente proceso:    
                    </td>
                  </tr>
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      1. El cliente deberá registrarse en el enlace web habilitado a tal fin por
                      Iberia Cards (www.iberiacards.com/paradores).  
                    </td>
                  </tr>
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      2. Una vez registrado, recibirá un documento personalizado que incluirá un código de acceso
                      para la promoción.  
                    </td>
                  </tr>
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      3. El cliente deberá efectuar la reserva previa del Parador en el teléfono de la Central de Paradores
                      913 742 500, y mencionar el Código promocional.  
                    </td>
                  </tr>
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      4. Finalmente, deberá presentar en la recepción del Parador, la tarjeta Iberia Plus y el documento
                      personalizado que incluye el código promocional que obtendrá con su registro. 
                    </td>
                  </tr>
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      Esta promoción no es acumulable a otro tipo de descuentos o precios especiales y está sujeta a un
                      número limitado de 500 habitaciones. No válida para grupos y sujeto a disponibilidad en cada
                      Parador.
                    </td>
                  </tr>
                  <tr>
                      <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333">
                      Iberia Cards, Sociedad Conjunta para la Emisión y Gestión de Medios de Pago E.F.C., S.A, es la
                      entidad de pago emisora de las tarjetas de crédito Iberia Cards, comercializadas por esta y
                      por Bankia, S.A.
                    </td>
                  </tr>
                  <tr>
                      <td aria-hidden="true" height="18" style="font-size: 0px; line-height: 0px; border-bottom: 1px solid #333333">
                          &nbsp;
                      </td>
                  </tr>
                </table>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->

            <tr>
              <td style="background-color: #FFFFFF; padding: 0 30px 15px 30px; color: #333333; text-align: justify">
                <a href="https://www.bankia.es/es/particulares/privacidad" target="_blank" title="privacidad">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333; padding-bottom: 5px">
                              © Bankia, S.A. 2020. Prohibida la reproducción total o parcial. Todos los derechos reservados.
	                        </td>
                        </tr>
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 10px; line-height: 13px; color: #333333;">
                            Le informamos que sus datos personales serán tratados, en todo momento, por Bankia, S.A. con domicilio social en c/ Pintor Sorolla, 8, 46002 de Valencia, con la finalidad del envío de comunicaciones comerciales de Bankia. Si no desea seguir recibiendo estas comunicaciones comerciales, puede solicitarlo enviando un correo electrónico a la dirección protecciondedatos@bankia.com. Usted podrá ejercitar sus derechos de acceso, rectificación, limitación de tratamiento, supresión, portabilidad y oposición al tratamiento de sus datos de carácter personal, dirigiendo su petición a la dirección protecciondedatos@bankia.com o al apartado de correos 61076, 28080 de Madrid acompañando fotocopia de su documento identificativo. Puede consultar la información adicional y detallada sobre protección de datos en política de privacidad Bankia.
	                        </td>
                        </tr>
                  </table>
                </a>
	            </td>
            </tr>
            <!-- 1 Column Text : END -->
            <tr>
                <td aria-hidden="true" height="20" style="font-size: 0px; line-height: 0px;">
                    &nbsp;
                </td>
            </tr>

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
