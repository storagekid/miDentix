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
    <title>Bankia - Esta Navidad pide un deseo.</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
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
                padding-right: 0 !important;
                padding-left: 0 !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }
            .g-img {
              width: 100% !important;
              max-width: 100% !important;
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
            .icon-text {
              font-size: 16px !important;
              line-height: 18px !important;
              padding-left: 10px !important;
              padding-right: 10px !important;
            }
            .m-padding {
              padding-left: 10px !important;
              padding-right: 10px !important;
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
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #eeeeee;">
  <center role="article" aria-roledescription="email" lang="es" style="width: 100%; background-color: #eeeeee;">
    <!--[if mso | IE]>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff;">
    <tr>
    <td>
    <![endif]-->

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="max-height:0; overflow:hidden; mso-hide:all; font-size: 1px" aria-hidden="true">
            Bankia - Esta Navidad pide un deseo.
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Create white space after the desired preview text so email clients don???t pull other distracting text into the inbox preview. Extend as necessary. -->
        <!-- Preview Text Spacing Hack : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
          &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        <!-- Preview Text Spacing Hack : END -->

        <!-- Email Body : BEGIN -->
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: auto; font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif" class="email-container">
        <tr>
            <td style="padding: 10px 0; text-align: center">
              <span style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size:9px; color:#000000;"><b>Publicidad. </b>&iquest;<a href="mirror.html" target="_blank" style="color:#000000; text-decoration:none;cursor: pointer;"><u>No ve correctamente este e-mail</u></a>?</span>
            </td>
        </tr>
        <!-- Hero Image, Flush : BEGIN -->
        <tr>
          <td style="background-color: #ffffff; padding-left: 30px; padding-right: 30px">
              <img src="https://imagenes.vdshop.es/bankia-shop-header.jpg" width="540" height="" alt="Bankia Shop" border="0" style="width: 100%; max-width: 540px; height: auto; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #000000; margin: auto; display: block;" class="g-img">
          </td>
        </tr>
        <!-- Hero Image, Flush : END -->
        <!-- Hero Image, Flush : BEGIN -->
        <tr>
          <td style="background-color: #ffffff; padding-left: 30px; padding-right: 30px">
          <!--[if gte mso 9]>
               <img src="https://imagenes.vdshop.es/main-hero-navidad.jpg" width="540" height="" alt="alt_text" border="0" style="width: 100%; max-width: 540px; height: auto; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #000000; margin: auto; display: block;" class="g-img">
              <div style="width:0px; height:0px; max-height:0; max-width:0; overflow:hidden; display:none; visibility:hidden; mso-hide:all;">
              <![endif]-->
              <img src="https://imagenes.vdshop.es/main-hero-navidad.gif" width="540" height="" alt="Black Friday Week" border="0" style="width: 100%; max-width: 540px; height: auto; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #000000; margin: auto; display: block;" class="g-img">
              <!--[if gte mso 9]>
              </div>
              <![endif]-->
          </td>
        </tr>
        <!-- Hero Image, Flush : END -->
        <!-- Clear Spacer : BEGIN -->
        <tr>
          <td aria-hidden="true" height="20" style="font-size: 0px; line-height: 0px; background-color: #FFFFFF; min-width: 500px">
          </td>
        </tr>
        <!-- Clear Spacer : END -->
        <!-- 2 Columns : BEGIN -->
        <tr>
          <td style="padding: 0 30px; background-color: #ffffff">
              <!--[if mso | IE]>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="540" style="background-color: #ffffff;">
                <tr>
                <td>
              <![endif]-->
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tr>
                    <td valign="top" width="240" class="stack-column-center left" style="background-color: #ffffff; padding-right: 15px;">
                      <!--[if mso | IE]>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="240" style="background-color: #ffffff;">
                        <tr>
                        <td>
                      <![endif]-->
                      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                          <tr>
                            <td style="padding: 0; text-align: center">
                                <img class="g-img" src="https://imagenes.vdshop.es/offer-wishes-img.jpg" width="255" height="" alt="Cumple tus Deseos" title="Cumple tus Deseos" border="0" style="display: block; width: 255px; max-width: 255px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                            </td>
                          </tr>
                          <tr>
                            <td class="" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 27px; line-height: 27px; color: #000000; padding: 0; text-align: center; padding: 15px 0 5px 0;" class="">
                                <span style="margin: 0;">Haz que ellos <br>cumplan los suyos</span>
                            </td>
                          </tr>
                          <tr>
                            <td valign="bottom" style="padding: 5px 50px 0; text-align: center">
                              <table width="100%" align="center">
                                  <tr>
                                    <td>
                                      <img class="icon" src="https://imagenes.vdshop.es/offer-wishes-lego-logo.png" width="40" height="" alt="Lego" title="Lego" border="0" style="width: 40px; max-width: 40px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                    </td>
                                    <td>
                                      <img class="icon" src="https://imagenes.vdshop.es/offer-wishes-barbie-logo.png" width="68" height="" alt="Barbie" title="Barbie" border="0" style="width: 68px; max-width: 68px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                    </td>
                                  </tr>
                                </table>
                            </td>
                          </tr>
                          <tr>
                            <td class="icon-text" style="font-family:'BankiaLight','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 22px; font-weight: 300; color: #000000; padding: 10px 30px 15px 30px; text-align: center;" class="">
                                <span style="margin: 0;">Este a??o lo merecen m??s que nunca, se han ganado un juguete o dos. Bankia Shop te ofrece esta selecci??n de juguetes para ti y los tuyos. ??Disfr??talos!</span>
                            </td>
                          </tr>
                      </table>
                      <!--[if mso]>
                        </td>
                        </tr>
                        </table>
                      <![endif]-->
                    </td>
                    <td valign="top" width="240" class="stack-column-center right" style="background-color: #ffffff; padding-left: 15px;">
                      <!--[if mso | IE]>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="240" style="background-color: #ffffff;">
                        <tr>
                        <td>
                      <![endif]-->
                      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                          <tr>
                            <td style="padding: 0; text-align: center">
                                <img class="g-img" src="https://imagenes.vdshop.es/offer-whims-img.jpg" width="255" height="" alt="Date un Capricho" title="Date un Capricho" border="0" style="display: block; width: 255px; max-width: 255px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                            </td>
                          </tr>
                          <tr>
                            <td class="" style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 27px; line-height: 27px; color: #000000; padding: 0; text-align: center; padding: 15px 0 5px 0;" class="">
                                <span style="margin: 0;">Date<br>un capricho</span>
                            </td>
                          </tr>
                          <tr>
                            <td valign="bottom" style="padding: 0; text-align: center; height: 44px">
                              <table width="100%" align="center">
                                <tr>
                                  <td>
                                    <img class="icon" src="https://imagenes.vdshop.es/offer-whims-lg-logo.png" width="55" height="" alt="LG" title="LG" border="0" style="width: 55px; max-width: 55px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                  </td>
                                  <td>
                                    <img class="icon" src="https://imagenes.vdshop.es/offer-whims-fagor-logo.png" width="67" height="" alt="Fagor" title="Fagor" border="0" style="width: 67px; max-width: 67px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                  </td>
                                  <td>
                                    <img class="icon" src="https://imagenes.vdshop.es/offer-whims-foreo-logo.png" width="75" height="" alt="Foreo Sweden" title="Foreo Sweden" border="0" style="width: 75px; max-width: 75px; height: auto; background: #FFFFFF; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td class="icon-text" style="font-family:'BankiaLight','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 22px; font-weight: 300; color: #000000; padding: 15px 20px; text-align: center;" class="">
                                <span style="margin: 0;">Lo estabas esperando y ahora es el momento. T?? tambi??n mereces un regalo, Bankia Shop te lo pone f??cil financiando tus compras. Est??s a un clic de darte un capricho.</span>
                            </td>
                          </tr>
                      </table>
                      <!--[if mso]>
                        </td>
                        </tr>
                        </table>
                      <![endif]-->
                    </td>
                  </tr>
              </table>
              <!--[if mso]>
                </td>
                </tr>
                </table>
              <![endif]-->
          </td>
        </tr>
        <!-- 2 Columns : END -->
        <!-- Hero Image, Flush : BEGIN -->
        <tr>
          <td style="background-color: #ffffff; padding-left: 30px; padding-right: 30px">
              <img src="https://imagenes.vdshop.es/footer-hero-navidad.jpg" width="540" height="" alt="Nueva Secci??n Gourmet" border="0" style="width: 100%; max-width: 540px; height: auto; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #000000; margin: auto; display: block;" class="g-img">
          </td>
        </tr>
        <!-- Hero Image, Flush : END -->
        <tr>
          <td style="padding: 0; color: #000000; background-color: #ffffff;">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tr>
                      <td style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; font-size: 27px; line-height: 27px; color: #000000; padding: 0; text-align: center; padding-top: 20px;">
                        Ll??vate los mejores productos para tu mesa
                      </td>
                  </tr>
                  <tr>
                      <td class="m-padding" style="font-family:'BankiaLight','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 20px; line-height: 23px; font-weight: 300; color: #000000; padding: 5px 60px 0; text-align: center;">
                        Nueva <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-weight: 600; color: #e4a935;">secci??n Gourmet</span> de Bankia Shop, con la garant??a de Aula Espa??ola del Vino
                      </td>
                  </tr>
                  <tr>
                      <td class="icon-text" style="font-family:'BankiaLight','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 18px; line-height: 22px; font-weight: 300; color: #000000; padding: 20px 60px 0px; text-align: center;">
                        Lo veo, lo quiero, lo disfruto. As?? de f??cil. Productos delicatessen sin salir de casa. Bankia Shop te quiere alegrar la vida y la mesa. Productos pensados para ti y tu familia.<br class="hide-on-mobile">Para una Navidad especial.
                      </td>
                  </tr>
              </table>
          </td>
        </tr>
        <!-- Email Header : BEGIN -->
        <tr>
          <td style="padding: 30px; text-align: center; background-color: #ffffff">
            <a href="https://www.bankiashop.es/" target="_blank" title="Bankia Shop">
              <img src="https://imagenes.vdshop.es/bk-shop-btn.png" width="200" height="50" alt="Ir a Bankia Shop" border="0" style="height: auto; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
            </a>
          </td>
        </tr>
        <!-- Email Header : END -->
        <tr>
          <td style="padding: 0 0 25px 0; color: #000000; background-color: #ffffff;">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tr>
                      <td class="m-padding" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 25px; font-weight: 400; line-height: 29px; color: #000000; padding: 0 40px; text-align: center;">
                        Financia tu compra al <span style="font-family:'BankiaBold','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 25px; font-weight: 600;">0*% TAE</span> ofrecida por Bankia, sin intereses ni comisiones.
                      </td>
                  </tr>
              </table>
          </td>
        </tr>
        <!-- Hero Image, Flush : BEGIN -->
        <tr>
          <td style="background-color: #ffffff; padding-left: 30px; padding-right: 30px">
              <img src="https://imagenes.vdshop.es/free-shipping.jpg" width="540" height="" alt="Env??o Gratis" border="0" style="width: 100%; max-width: 540px; height: auto; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #000000; margin: auto; display: block;" class="g-img">
          </td>
        </tr>
        <!-- Hero Image, Flush : END -->
        <tr>
          <td style="background-color: #FFFFFF; padding: 20px 30px; color: #333333; text-align: left">
              <table align="left"  role="presentation" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; text-align: left; padding: 0">
                            <a href="https://www.bankia.es/es/particulares/privacidad" target="_blank" title="privacidad" style="padding-top: 0; padding-bottom: 0; margin-top: 1px; margin-bottom: 0; color: #333333;">
                            Bankia Shop es una tienda virtual de la mercantil BANKIA COMMERCE, S.L. Bankia colabora exclusivamente si hay financiaci??n para la adquisici??n de los bienes en la tienda.<br>
                            *Financiaci??n sujeta a la aprobaci??n de Bankia.
                            </a>
                        </td>
                    </tr>
              </table>
          </td>
        </tr>
        <tr>
            <td aria-hidden="true" height="3" style="font-size: 0px; line-height: 0px; background-color: #b9c800; min-width: 500px">
            </td>
        </tr>
        <tr>
              <td style="background-color: #FFFFFF; padding: 20px 30px; color: #333333; text-align: left">
	                <table align="left"  role="presentation" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; color: #333333; text-align: left; padding: 0">
                                <a href="https://www.bankia.es/es/particulares/privacidad" target="_blank" title="privacidad" style="font-family:'BankiaRegular','Source Sans Pro',Tahoma,Verdana,Segoe,sans-serif; font-size: 13px; line-height: 15px; padding-top: 0; padding-bottom: 0; margin-top: 1px; margin-bottom: 0; color: #333333;">
                                ??2020 bankiashop.es. Todos los derechos reservados. 
                                </a>
                            </td>
                        </tr>
                  </table>
	            </td>
            </tr>
            <tr>
                <td aria-hidden="true" height="30" style="font-size: 0px; line-height: 0px; background-color: #eeeeee;">
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
