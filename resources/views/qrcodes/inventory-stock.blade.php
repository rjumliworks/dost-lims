<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            html * {
                font-family:Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 0;
            }
            body {
                text-align: center;
                padding-top: 40pt;
            }
            .image {
                width: 30pt;
                height: 30pt;
            }
            .name {
                font-size: 9pt;
                font-weight: bold;
                margin-top: 8pt;
                padding: 0 12pt;
                word-wrap: break-word;
            }
            .code {
                font-size: 7pt;
                color: #333333;
                margin-top: 3pt;
            }
        </style>
    </head>

    <body>
        <img class="image" src="<?php echo $qrCodeImage; ?>" alt="QR Code"/>
        <div class="name">{{ $name }}</div>
        <div class="code">{{ $code }}</div>
    </body>
</html>
