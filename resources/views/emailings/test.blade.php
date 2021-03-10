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
            .hide-on-mobile {
              display: none;
              height: 0;
              width: 0;
            }
            .img-holder-mobile {
              height: 200px;
              overflow: hidden;
              position: relative;
            }
            .img-mobile {
              position: absolute;
              width: 100%;
              max-width: 100% !important;
              /* bottom: -60px; */
              margin-top: -250px !important;
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
  <center role="article" aria-roledescription="email" lang="es" style="width: 100%; background-color: #FFFFFF;">
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
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: auto; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif" class="email-container">
        <div style="letter-spacing: 396px; line-height: 0; mso-hide: all">&nbsp;</div>
          <!-- Multi Image Composition Tryout BEGIN-->
          <tr>
            <td>
              <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td style="background-color: #ffffff; text-align: left">
                  <!--[if gte mso 9]>
                    <img width="600" height="" alt="Bankia" title="Bankia" border="0" style="display:block; width: 600px: cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/BK_emailing_TitularidadReal_oct20/main_info_top.jpg"/>
                    <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                    <![endif]-->
                    <img width="100%" height="" alt="Bankia" title="Bankia" border="0" style="display:block; cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/BK_emailing_TitularidadReal_oct20/main_info_top.jpg"/>
                    <!--[if gte mso 9]>
                    </div>
                    <![endif]-->
                  </td>
                </tr>
                <!-- <tr>
                  <td style="background-color:#FFFFFF;">
                      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                          <tr>
                          <th valign="top" width="18.3%">
                                <img src="http://www.storagekid.com/mozodealmacen/images/BK_emailing_TitularidadReal_oct20/main_info_row2-left.jpg" width="18.3%" height="" alt="Titularidad Real" title="Titularidad Real" border="0" style="width: 100%; max-width: 110px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #333333; margin: auto; display: block;">
                              </th>

                              <th valign="top" width="63.4%" style="background-color: #FFFFFF;">
                                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                      <tr>
                                          <td height="" style="text-align: justify; background-color: #FFFFFF; color: #000000; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 19px;">
                                            Estimado cliente:
                                          </td>
                                      </tr>
                                  </table>
                              </th>

                              <th valign="top" width="18.3%">
                                <img src="http://www.storagekid.com/mozodealmacen/images/BK_emailing_TitularidadReal_oct20/main_info_row2-right.jpg" width="18.3%" height="" alt="Titularidad Real" title="Titularidad Real" border="0" style="width: 100%; max-width: 110px; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #333333; margin: auto; display: block;">
                              </th>
                          </tr>
                      </table>
                  </td>
                </tr> -->

                <tr>
                    <td style="background-color:#FFFFFF;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                               <!--[if gte mso 9]>
                                <th width="83" style="text-align: left; padding: 0; margin: 0; background-color:#FFFFFF;margin:0; padding:0;">
                                <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                                <![endif]-->
                                <th width="13.8%" style="text-align: left; padding: 0; margin: 0; background-color:#FFFFFF;margin:0; padding:0;">
                                </th>
                                <!--[if gte mso 9]>
                                </div>
                                </th>
                                <![endif]-->
                                <!--[if gte mso 9]>
                                <th width="380" style="text-align: left; padding: 0; margin: 0; background-color:#FFFFFF;margin:0; padding:0;">
                                <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                                <![endif]-->
                                <th valign="middle" width="" style="background-color: #FFFFFF; padding-top: 5px; border-left: 1px solid #b9c800; border-right: 1px solid #b9c800; padding-left: 20px; padding-right: 20px">
                                <!--[if gte mso 9]>
                                </div>
                                <![endif]-->
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td height="" width="" style="text-align: left; background-color: #FFFFFF; color: #000000; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 17px; line-height: 19px;">
                                              <span>Queremos recordarte que <span style="color: #b9c800; font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600;">es necesario actualizar la acreditación de la titularidad real de tu empresa,</span> que se encuentra incompleta o próxima a expirar, para poder seguir ofreciéndote nuestros servicios.</span>
                                            </td>
                                        </tr>
                                    </table>
                                </th>
                                <!--[if gte mso 9]>
                                <th width="85" style="text-align: left; padding: 0; margin: 0; background-color:#FFFFFF;margin:0; padding:0;">
                                <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                                <![endif]-->
                                <th width="14.2%" style="text-align: left; padding: 0; margin: 0; background-color:#FFFFFF;margin:0; padding:0;">
                                </th>
                                <!--[if gte mso 9]>
                                </div>
                                </th>
                                <![endif]-->
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                  <td style="background-color: #ffffff; text-align: left">
                  <!--[if gte mso 9]>
                    <img width="600" height="" alt="Bankia" title="Bankia" border="0" style="display:block; width: 600px: cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/BK_emailing_TitularidadReal_oct20/main_info_bottom.jpg"/>
                    <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                    <![endif]-->
                    <img width="100%" height="" alt="Bankia" title="Bankia" border="0" style="display:block; cursor: default;" src="http://www.storagekid.com/mozodealmacen/images/BK_emailing_TitularidadReal_oct20/main_info_bottom.jpg" height="" alt="Bankia" title="Bankia" border="0" />
                    <!--[if gte mso 9]>
                    </div>
                    <![endif]-->
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- Multi Image Composition Tryout END-->
          <!-- Clear Spacer : BEGIN -->
          <tr>
            <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px; background-color: #FFFFFF; min-width: 500px">
            </td>
          </tr>
          <!-- Clear Spacer : END -->
          <tr>
	            <td style="padding: 0; background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
                          <td valign="middle" width="300" class="stack-column-center">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                                <tr>
                                    <td style="padding: 0; text-align: center">
                                      <div class="img-holder-mobile">
                                        <img class="img-mobile" src="http://www.storagekid.com/mozodealmacen/images/girl_image.jpg" width="300" height="" title="Podrás viajar hasta el 30 de abril de 2021" alt="Podrás viajar hasta el 30 de abril de 2021" border="0" style="width: 100%; max-width: 300px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                                      </div>
                                    </td>
	                                </tr>
	                            </table>
	                        </td>
	                        <td valign="middle" width="300" class="stack-column-center" style="padding-top: 20px">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                  <tr>
                                    <td style="padding: 0; text-align: center">
                                        <img class="icon" src="http://www.storagekid.com/mozodealmacen/images/computer.png" width="92" height="" alt="Tickets" title="Tickets" border="0" style="width: 100%; max-width: 92px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                    </td>
	                                </tr>
	                                <tr>
                                    <td class="icon-text" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 21px; color: #000000; padding: 20px 60px; text-align: center;" class="">
                                        <p style="margin: 0;">Reserva tu vuelo del <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">5 al 11 de octubre</span> de 2020.</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #FFFFFF; padding-bottom: 30px">
                                    <!-- Button : BEGIN -->
                                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                        <tr>
                                            <td class="button-td button-td-primary" style="border-radius: 6px; background: #FF9E1B;">
                                                <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/flying-days/" style="background: #FF9E1B; border: 1px solid #FF9E1B; font-family: 'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 15px; text-decoration: none; padding: 13px 17px; color: #ffffff; display: block; border-radius: 6px;">RESERVAR</a>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- Button : END -->
                                      <!-- <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                        <tr>
                                          <td class="button-td button-td-primary" style="border-radius: 6px; background: #FFFFFF;">
                                            <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/flying-days/" style="background: #FF9E1B; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 20px; text-decoration: none; padding: 13px 25px; color: #ffffff; display: block; border-radius: 6px;">RESERVAR</a>
                                          </td>
                                        </tr>
                                      </table> -->
                                    </td>
                                  </tr>
	                            </table>
	                        </td>
	                    </tr>
	                </table>
	            </td>
	        </tr>
          <tr>
	            <td style="padding: 0; background-color: #ffffff;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <th dir="dtr" valign="middle" width="300" class="stack-column-center">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                  <tr>
                                    <td style="padding: 0; text-align: center">
                                        <img class="icon" src="http://www.storagekid.com/mozodealmacen/images/tickets.png" width="92" height="" alt="Tickets" title="Tickets" border="0" style="width: 100%; max-width: 92px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                    </td>
	                                </tr>
	                                <tr>
                                    <td class="icon-text" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 21px; color: #000000; padding: 20px 60px; text-align: center;" class="">
                                        <p style="margin: 0;">Podrás viajar hasta el <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600">30 de abril</span> de 2021.</p>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="background-color: #FFFFFF; padding-bottom: 30px">
                                    <!-- Button : BEGIN -->
                                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                        <tr>
                                            <td class="button-td button-td-primary" style="border-radius: 6px; background: #FF9E1B;">
                                                <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/flying-days/" style="background: #FF9E1B; border: 1px solid #FF9E1B; font-family: 'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 15px; text-decoration: none; padding: 13px 17px; color: #ffffff; display: block; border-radius: 6px;">RESERVAR</a>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- Button : END -->
                                      <!-- <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                        <tr>
                                          <td class="button-td button-td-primary" style="border-radius: 6px; background: #FFFFFF;">
                                            <a class="button-a button-a-primary" href="https://www.iberiacards.es/ventajas-entidades/flying-days/" style="background: #FF9E1B; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 15px; line-height: 20px; text-decoration: none; padding: 13px 25px; color: #ffffff; display: block; border-radius: 6px;">RESERVAR</a>
                                          </td>
                                        </tr>
                                      </table> -->
                                    </td>
                                  </tr>
	                            </table>
	                        </th>

	                        <th valign="middle" width="300"  class="stack-column-center">
	                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                                <tr>
                                    <td style="padding: 0; text-align: center">
                                      <div class="img-holder-mobile">
                                        <img class="img-mobile" src="http://www.storagekid.com/mozodealmacen/images/family_image.jpg" width="300" height="" title="Podrás viajar hasta el 30 de abril de 2021" alt="Podrás viajar hasta el 30 de abril de 2021" border="0" style="width: 100%; max-width: 300px; height: auto; background: #FFFFFF; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;; font-size: 15px; line-height: 15px; color: #FF9E1B; margin: auto; display: block;" class="g-img">
                                      </div>
                                    </td>
	                                </tr>
	                            </table>
	                        </th>
	                    </tr>
	                </table>
	            </td>
	        </tr>
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
          <tr>
            <td dir="ltr" width="100%" style="padding: 30px 0; background-color: #FFFFFF;">
                <a href="https://www.bankia.es/es/pymes-y-autonomos/fiscalidad/calendario-fiscal-del-ultimo-trimestre-para-autonomos-y-pymes" style="text-decoration: none; color: #000000">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <th width="25%" class="" style="padding-left: 37px" valign="middle">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td dir="ltr" valign="middle">
                                          <!--[if gte mso 9]>
                                            <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/calculator.png" alt="Insert Alt text here" width="90" border="0" style="display:block;" />
                                            <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                                            <![endif]-->
                                            <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/calculator.png" width="75%" height="" title="Calendario" alt="Calendario" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                            <!--[if gte mso 9]>
                                            </div>
                                            <![endif]-->
                                        </td>
                                    </tr>
                                </table>
                            </th>
                            <th width="75%" style="padding-left: 15px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td dir="ltr" width="100%">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <th width="58" class="s" valign="middle" align="left">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-left: 0 !important; margin-right: 0 !important">
                                                        <tr>
                                                            <td dir="ltr" valign="middle" align="left" width="58" >
                                                                <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/arrows.png" width="58" height="" title="Flechas" alt="Flechas" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; display: block">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>

                                                <th width="100%" style="padding-left: 5px;" valign="middle" align="left">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                      <tr>
                                                          <td width="100%" valign="middle" align="left" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 20px; color: #b9c800; text-align: left; line-height: 20px">
                                                              CALENDARIO
                                                          </td>
                                                      </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 16px; line-height: 20px; color: #352a20; text-align: left; padding-right: 60px; padding-top: 5px">
                                        <span>Recordamos el cumplimiento de las principales obligaciones tributarias estatales que nos quedan para este último trimestre del año.</span>
                                    </td>
                                </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                </a>
            </td>
          </tr>
          <tr>
            <td dir="ltr" width="100%" style="padding: 30px 0; background-color: #FFFFFF;">
                <a href="https://www.bankia.es/es/pymes-y-autonomos/fiscalidad/cuestiones-a-tener-en-cuenta-por-autonomos-y-pymes-para-el-cierre-fiscal" style="text-decoration: none; color: #000000">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <th width="25%" class="" style="padding-left: 37px" valign="middle">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td dir="ltr" valign="middle">
                                          <!--[if gte mso 9]>
                                            <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/bullhorn.png" alt="Insert Alt text here" width="90" border="0" style="display:block;" />
                                            <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                                            <![endif]-->
                                            <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/bullhorn.png" width="75%" height="" title="Calendario" alt="Calendario" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                            <!--[if gte mso 9]>
                                            </div>
                                            <![endif]-->
                                        </td>
                                    </tr>
                                </table>
                            </th>
                            <th width="75%" style="padding-left: 15px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td dir="ltr" width="100%">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <th width="58" class="s" valign="middle" align="left">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-left: 0 !important; margin-right: 0 !important">
                                                        <tr>
                                                            <td dir="ltr" valign="middle" align="left" width="58" >
                                                                <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/arrows.png" width="58" height="" title="Flechas" alt="Flechas" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; display: block">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>

                                                <th width="100%" style="padding-left: 5px;" valign="middle" align="left">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                      <tr>
                                                          <td width="100%" valign="middle" align="left" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 20px; color: #b9c800; text-align: left; line-height: 20px">
                                                              NOVEDADES
                                                          </td>
                                                      </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 16px; line-height: 20px; color: #352a20; text-align: left; padding-right: 60px; padding-top: 5px">
                                        <span>Información relevante para el cierre fiscal, deducciones, gastos fiscalmente deducibles, reducciones y mucho más.</span>
                                    </td>
                                </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                </a>
            </td>
          </tr>
          <tr>
            <td dir="ltr" width="100%" style="padding: 30px 0; background-color: #FFFFFF;">
                <a href="https://www.bankia.es/es/pymes-y-autonomos/fiscalidad/consultas-tributarias-emitidas-por-la-direccion-general-de-tributos" style="text-decoration: none; color: #000000">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <th width="25%" class="" style="padding-left: 37px" valign="middle">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td dir="ltr" valign="middle">
                                          <!--[if gte mso 9]>
                                            <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/money.png" alt="Insert Alt text here" width="90" border="0" style="display:block;" />
                                            <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
                                            <![endif]-->
                                            <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/money.png" width="75%" height="" title="Calendario" alt="Calendario" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; vertical-align: middle">
                                            <!--[if gte mso 9]>
                                            </div>
                                            <![endif]-->
                                        </td>
                                    </tr>
                                </table>
                            </th>
                            <th width="75%" style="padding-left: 15px">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td dir="ltr" width="100%">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <th width="58" class="s" valign="middle" align="left">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-left: 0 !important; margin-right: 0 !important">
                                                        <tr>
                                                            <td dir="ltr" valign="middle" align="left" width="58" >
                                                                <img src="http://www.storagekid.com/mozodealmacen/images/BK_Autonomos_Newsletter_oct20/arrows.png" width="58" height="" title="Flechas" alt="Flechas" border="0" class="center-on-narrow" style="height: auto; background: #FFFFFF; font-family:'BankiaMedium','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 700; font-size: 15px; line-height: 15px; color: #352a20; display: block">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </th>

                                                <th width="100%" style="padding-left: 5px;" valign="middle" align="left">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                      <tr>
                                                          <td width="100%" valign="middle" align="left" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 20px; color: #b9c800; text-align: left; line-height: 20px">
                                                            DIRECCIÓN GENERAL DE TRIBUTOS
                                                          </td>
                                                      </tr>
                                                    </table>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td dir="ltr" valign="top" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 500; font-size: 16px; line-height: 20px; color: #352a20; text-align: left; padding-right: 60px; padding-top: 5px">
                                        <span>Señalamos algunas de las recientes consultas emitidas por la Dirección General de Tributos que consideramos pueden resultar de interés.</span>
                                    </td>
                                </tr>
                                </table>
                            </th>
                        </tr>
                    </table>
                </a>
            </td>
          </tr>
          <!-- 1 Column Text : BEGIN -->
	        <tr>
            <td style="background-color: #FFFFFF; padding-top: 20px">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td style="padding:15px 60px 15px 60px; border-top: 1px dashed #b9c800">
                      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                          <td align="right" valign="middle" width="100" class="stack-column-center" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 17px; line-height: 23px; color: #000000;">
                            GERENTE xxxxx
                          </td>
                          <td width="130" valign="middle"  class="stack-column-center" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 17px; line-height: 23px; color: #000000; text-align:center;">
                            <span style="color: #b9c800; font-size: 24px; vertical-align: middle">|</span> <span style="vertical-align: middle">+34 91 602 20 20</span> <span style="color: #b9c800; font-size: 24px; vertical-align: middle">|</span>
                          </td>
                          <td align="left" valign="middle"  width="100" class="stack-column-center" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 400; font-size: 17px; line-height: 23px; color: #000000;">
                            <a href="mailto:xxxx@bankia.com" style="color:#000000; text-decoration:none; word-break: break-word;">xxxx@bankia.com</a>
                          </td>
                        </tr>
                      </table>

                      </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
        <!-- 1 Column Text : BEGIN -->
          <tr>
            <td style="background-color: #FFFFFF; padding: 40px 30px; color: #FFFFFF; border-top: 1px dashed #b9c800">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="text-align: center;">
                      <tr>
                        <td width="126">
                          <table>
                            <tr>
                              <td style="padding-right: 15px;">
                                <a href="https://www.facebook.com/bankia.es" target="_blank" title="Facebook" style="display: inline-block; width: 32px; height: 32px">
                                  <img src="http://www.storagekid.com/mozodealmacen/images/BK_BBP_InversionAlternativaDiversificada/facebook.png" width="32" height="32" border="0" alt="Facebook" title="Facebook">
                                </a>
                              </td>
                              <td style="padding-right: 15px;">
                                <a href="https://twitter.com/bankia" target="_blank" title="Twitter" style="display: inline-block; width: 32px; height: 32px">
                                  <img src="http://www.storagekid.com/mozodealmacen/images/BK_BBP_InversionAlternativaDiversificada/twitter.png" width="32" height="32" border="0" alt="Twitter" title="Twitter">
                                </a>
                              </td>
                              <td>
                                <a href="https://www.youtube.com/c/bankia" target="_blank" title="YouTube" style="display: inline-block; width: 32px; height: 32px">
                                  <img src="http://www.storagekid.com/mozodealmacen/images/BK_BBP_InversionAlternativaDiversificada/youtube.png" width="32" height="32" border="0" alt="YouTube" title="YouTube">
                                </a>
                              </td>
                            </tr>
                          </table>
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
          <!-- 1 Column Text : END -->
        <!-- Clear Spacer : BEGIN -->
          <tr>
              <td aria-hidden="true" height="3" style="font-size: 0px; line-height: 0px; background-color: #b9c800; min-width: 500px">
              </td>
          </tr>
        <!-- Clear Spacer : END -->
      </table>
          <!--[if mso | IE]>
    </td>
    </tr>
    </table>
    <![endif]-->
        <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF;">
    <tr>
    <td>
    <![endif]-->
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: auto; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif;" class="email-container">
          <!-- 1 Column Text : BEGIN -->
          <tr>
              <td style="background-color: #FFFFFF; padding: 20px 10%; color: #333333; text-align: justify">
	                <table align="center"  role="presentation" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; text-align: justify; padding: 0">
                                <a href="https://www.bankia.es/es/particulares/privacidad" target="_blank" title="privacidad" style="padding-top: 0; padding-bottom: 0; margin-top: 1px; margin-bottom: 0; color: #333333;">
                                  © Bankia SA 2020. Prohibida la reproducción total o parcial. Todos los derechos reservados.<br><br>
                                  Le informamos que sus datos personales serán tratados, en todo momento, por Bankia. S.A con domicilio social en C/Pintor Sorolla, 8, 46002 de Valencia, con la finalidad del envío de comunicaciones comerciales de Bankia.<br><br>
                                  Si no desea seguir recibiendo estas comunicaciones comerciales, puede solicitarlo enviando un correo electrónico a la dirección protecciondedatos@bankia.com. Usted podrá ejercitar sus derechos de acceso, rectificación, limitación de tratamiento, supresión, portabilidad y oposición al tratamiento de sus datos de carácter personal, dirigiendo su petición a la dirección protecciondedatos@bankia.com o al Apartado de correos 61076, 28080 de Madrid acompañando fotocopia de su documento identificativo. Puede consultar la información adicional y detallada sobre protección de datos en política de privacidad Bankia.
                                </a>
                            </td>
                        </tr>
                  </table>
	            </td>
            </tr>
            <!-- Clear Spacer : BEGIN -->
            <!-- <tr>
                <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px; background-color: #FFFFFF;">
                    &nbsp;
                </td>
            </tr> -->
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
