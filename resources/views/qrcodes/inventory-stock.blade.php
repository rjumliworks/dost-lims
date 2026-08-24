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
                margin-top: 5;
                padding: 0;
            }
            body {
                text-align: center;
                padding: 3pt 6pt 2pt 6pt;
            }
            .image {
                width: 155pt;
                height: 32pt;
            }
            .name {
                font-size: 7pt;
                font-weight: normal;
                margin-top: 2pt;
                line-height: 1.1;
                word-wrap: break-word;
            }
            .code {
                font-size: 6pt;
                color: #333333;
                margin-top: 1pt;
            }
        </style>
    </head>

    <body>
        <img class="image" src="<?php echo $barcodeImage; ?>" alt="Barcode"/>
        <div class="name">{{ $name }}</div>
        <div class="code">{{ $code }}</div>
    </body>
</html>
