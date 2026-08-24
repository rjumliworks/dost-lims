<!doctype html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            @page {
                margin: 0;
            }
            html * {
                font-family:Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 0;
            }
            body {
                text-align: center;
                padding: 4pt 6pt 2pt 6pt;
            }
            .image {
                width: 155pt;
                height: 155pt;
            }
            .name {
                font-size: 6pt;
                font-weight: normal;
                margin-top: -5pt;
                line-height: 1.15;
                word-wrap: break-word;
            }
            .code {
                font-size: 7pt;
                color: #333333;
                margin-top: 0pt;
            }
        </style>
    </head>

    <body>
        <img class="image" src="<?php echo $qrCodeImage; ?>" alt="QR Code"/>
        <div class="name">{{ $name }}</div>
        <div class="code">{{ $code }}</div>
    </body>
</html>
