<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="format-detection" content="date=no">
  <meta name="format-detection" content="telephone=no">
  <style type="text/CSS"></style>
  <style @import url('https://dopplerhealth.com/fonts/BasierCircle/basiercircle-regular-webfont.woff2');></style>
  <title></title>
  <!--[if mso]>
  <style>
    table {border-collapse:collapse;border-spacing:0;border:none;margin:0;}
    div, td {padding:0;}
    div {margin:0 !important;}
	</style>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table,
    td,
    div,
    h1,
    p {
      font-family: 'Basier Circle', 'Roboto', 'Helvetica', 'Arial', sans-serif;
    }

    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: #FFEADA;
        text-decoration: none !important;
        font-weight: bold;
      }

      .button {
        min-height: 42px;
        line-height: 42px;
      }

      .col-lge {
        max-width: 100% !important;
      }
    }

    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }

      .col-lge {
        max-width: 73% !important;
      }
    }

  a {
    text-decoration: none;
  }
  
  .-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 216px;
    height: 56px;
    text-align: center;
    border-radius: 12px;
  }
  
  .-btn:hover {
    opacity: .8;
  }
  
  .-bg {
    background: #7B1001;
  }
  
  .-txt {
    color: #fff;
  }
  
  .-xs {
    font-size: 12px;
  }
  </style>
</head>

<body style="margin:0;padding:0;word-spacing:normal;background-color: #199bce;">
  <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#FDF8F4;">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
      <tr>
        <td align="center" style="padding:0;">
          <!--[if mso]>
          <table role="presentation" align="center" style="width:600px;">
          <tr>
          <td>
          <![endif]-->
          <table role="presentation" style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:'Basier Circle', 'Roboto', 'Helvetica', 'Arial', sans-serif;font-size:1em;line-height:1.37em;color:#384049;">
            <!--  Logo headder -->
            <tr>
              <td style="padding:30px 20px 20px 20px;text-align:center;font-size:1.5em;font-weight:bold; background: #111213;">
                <a href="https://bridgetrustfinance.co.zm" style=" text-decoration:none;">
                  <img style="width:120px; height:90px" alt="Bridge Trust Finance" src="https://asmarahotelzm.com/img/logo.png">
                </a>
              </td>
            </tr>
            <!--  Intro Section -->
            <tr>
              <td style="padding:30px;background-color:#ffffff;">
                <h4>Dear {{ $data['name'] }}</h4>
                <h3 style="margin-top:0;margin-bottom:1.38em;font-size:1.953em;line-height:1.3;font-weight:bold;letter-spacing:-0.02em;">
                   {{  $data['subject']  }}
                </h3>
                
                <p style="text-align: left;">
                    {{  $data['msg']  }}
                </p>
                <br>
                <p>Best Regards</p>
                <p>Asmara Hotel Zambia</p>
                <p>(+260) 9756 546 690</p>
              </td>
            </tr>
            <tfoot>
                <p>Plot No. 5494, Lunsemfwa Road, Kalundu, Lusaka</p>
            </tfoot>
          </table>
          <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->

        </td>
      </tr>
    </table>
  </div>
</body>

</html>