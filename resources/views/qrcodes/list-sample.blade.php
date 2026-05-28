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
                margin-top: 0px;
                margin-left: 40px;
                margin-right: 40px;
            }
            .code {
                position: absolute;
                top: -30; /* 4 cm from the top */
                left: 10; /* 7 cm from the left */
                font-size: 10pt; /* Adjust font size as needed */
                width: 170px;
                /* background-color: red; */
            }
            .received {
                position: absolute;
                top: -17; /* 4 cm from the top */
                left: 10; /* 7 cm from the left */
                font-size: 7pt; /* Adjust font size as needed */
                width: 170px;
            }
            .due {
                position: absolute;
                top: -9; /* 4 cm from the top */
                left: 10; /* 7 cm from the left */
                font-size: 7pt; /* Adjust font size as needed */
                width: 170px;
            }
            .names {
                position: absolute;
                top: 10; /* 4 cm from the top */
                left: -15; /* 7 cm from the left */
                font-size: 7.5pt; /* Adjust font size as needed */
            }
            .breakline {
                position: absolute;
                width: 210px; /* or any desired width */
                top: 5; /* 4 cm from the top */
                left: -21; /* 7 cm from the left */
                border-top: 1px solid black; /* Thickness and color of the line */
            }
            .image {
                position: absolute;
                width: 30;
                height: 30;
                margin-top: -39px; 
                margin-left: -30px;
            }
            .desc {
                position: absolute;
                width: 175;
                height: 30;
                margin-top: 2px; 
                margin-left: -30px;
            }
            .page-break {
                page-break-after: always;
            }
            .names2 {
                position: absolute;
                top: 18; /* 4 cm from the top */
                left: -15; /* 7 cm from the left */
                font-size: 7.5pt; /* Adjust font size as needed */
            }
            .breakline2 {
                position: absolute;
                width: 210px; /* or any desired width */
                top: 14; /* 4 cm from the top */
                left: -21; /* 7 cm from the left */
                border-top: 1px solid black; /* Thickness and color of the line */
            }
            .label-header {
                position: relative;
                margin-left: 0px; /* change this when needed */
            }
                        .label-header.shifted {
                margin-left: 20px; 
                margin-top: -10px;
                margin-bottom: 15px; /* adjust as needed */
            }
        </style>
    </head>

    <body>
        @php 
            $count = count($lists);
            $count = $count - 1;
        @endphp
        @foreach($lists as $index2=>$list)
            <img class="image" src="<?php echo $list['qrCodeImage']; ?>" alt="QR Code"/>
            <div class="code">{{$list['sample_code']}}  @if (strlen($list['sample_name']) <= 15)<span style="font-size: 10px;">({{$list['sample_name']}})</span>@endif</div>
            <div class="received">Received: {{$list['created_at']}}</div>
            <div class="due">Due at: {{$list['due_at']}}</div>
            @if (strlen($list['sample_name']) > 15)
                <div class="desc"><span style="font-size: 10px;">{{$list['sample_name']}}</span></div>
                <div class="breakline2"></div>
                <div class="names2">
                    <ul>
                        @php
                            $chunks = array_chunk($list['testnames'], 12);
                        @endphp

                        @foreach($chunks as $chunkIndex => $chunk)
                                @foreach($chunk as $name)
                                    <li>{{$name}}</li>
                                @endforeach

                            @if($chunkIndex < count($chunks) - 1)
                                <div class="page-break"></div>
                                
                            @endif
                        @endforeach
                    </ul>
                </div>
                @if($index2 < ($count))
                <div class="page-break"></div>
                @endif
            @else
                <div class="breakline"></div>
                <div class="names">
                    <ul>
                        @php
                            $chunks = array_chunk($list['testnames'], 13);
                        @endphp

                        @foreach($chunks as $chunkIndex => $chunk)
                                @foreach($chunk as $name)
                                    <li>{{$name}}</li>
                                @endforeach
                            @if($chunkIndex < count($chunks) - 1)
                                <div class="page-break"></div>
                              
                                <div class="label-header shifted">
                                    <img class="image" src="<?php echo $list['qrCodeImage']; ?>" alt="QR Code"/>
                                    <div class="code">
                                        {{$list['sample_code']}}
                                        @if (strlen($list['sample_name']) <= 15)
                                            <span style="font-size: 10px;">({{$list['sample_name']}})</span>
                                        @endif
                                    </div>
                                    <div class="received">Received: {{$list['created_at']}}</div>
                                    <div class="due">Due at: {{$list['due_at']}}</div>
                                    <div class="breakline"></div>
                                </div>
                              
                            @endif
                        @endforeach
                    </ul>
                </div>
                @if($index2 < ($count))
                <div class="page-break"></div>
                @endif
            @endif
        @endforeach
    </body>
</html>

