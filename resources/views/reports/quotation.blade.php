<!doctype html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        /* Styles for the footer */
        @page {
           
        }

        html * {
            font-family:Arial, Helvetica, sans-serif;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }

        .content {
            margin-bottom:55px; /* Space for the footer */
        }

        table,
        td,
        th {
            border: .5px solid black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            padding: 3px;
            vertical-align: top;
        }
        td {
            padding: 3px;
            /* vertical-align: top; */
            /* text-align: center; */
        }
        input[type=checkbox] {
            transform: scale(.7);
        }
        .a {
            width: 55px; 
            height: 55px;
        }
        label {
            display: block;
            padding-left: 15px;
            text-indent: -15px;
        }
        input {
            width: 13px;
            height: 13px;
            padding: 0;
            margin:0;
            vertical-align: bottom;
            position: relative;
            top: -5px;
            left: 7px;
            *overflow: hidden;
        }
        input[type=checkbox] { display: inline; }
        input[type=checkbox]:before { font-family: DejaVu Sans; }
        label {
            display: inline-block;
        }
        .footer {
            position: fixed;
            bottom: -10;
            width: 100%;
            left: 0;
            margin-left: auto;
            margin-right: auto;
        }
        .page-break {
            page-break-after: always;
        }
        .letter-p {
        position: relative;
        font-size: 100px;
        font-weight: bold;
        display: inline-block;
        color: black;
    }

    /* First line */
    .letter-p::before {
        content: '';
        position: absolute;
        width: 60%; /* adjust length */
        height: 5px; /* line thickness */
        background-color: red; /* line color */
        top: 20%; /* vertical position */
        left: 20%; /* horizontal start */
        transform: rotate(-10deg); /* optional tilt */
    }

    /* Second line */
    .letter-p::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 5px;
        background-color: blue;
        top: 50%;
        left: 25%;
        transform: rotate(5deg);
    }
        </style>
    </head>

    <body>
        <?php 
            $form = $configuration['form'] = $configuration['form'];

            $quotation = json_encode($quotation); 
            $quotation = json_decode($quotation, true);   

            $samples = json_encode($samples); 
            $samples = json_decode($samples, true);   
            
        ?>

        <div class="footer">
            <table style="border-bottom-style: hidden; border-right-style: hidden; border-top-style: hidden; border-left-style: hidden;">
                <tr>
                    <td style="width: 40%; text-align: left; font-weight: bold; color: black;"><hr/></td>
                </tr>
            </table>
            <table style="margin-top: -5px; border-bottom-style: hidden; border-right-style: hidden; border-top-style: hidden; border-left-style: hidden;">
                <tr>
                    <td style="border-right-style: hidden; width: 3%; text-align: right;"> <img src="<?php echo $qrCodeImage; ?>"  width="30" height="30" alt="QR Code"></td>
                    <td style="border-right-style: hidden;" style="width: 50%; text-align: left; font-size: 10px;"><br/> <span style="font-weight: bold; color: #072388;">{{$quotation['code']}}</span></td>
                    @if($configuration['agency']['member']['name'] == 'Department of Science and Technology - VI')
                    <td style="border-left-style: hidden; width: 50%; text-align: right; font-size: 10px;">OP-006-F1 (front page) <br/>Rev 3 | October 20, 2025</td>
                    @else
                    <td style="border-left-style: hidden; width: 50%; text-align: right; font-size: 10px;">OP-006-F2 (front page) <br/>Rev 4 | September 9, 2024</td>
                    @endif
                </tr>   
            </table>
        </div>

        <div class="content">
            <div style="font-family:Arial;">
                <img src="{{ public_path('images/logo-sm.png') }}" alt="tag" style="position: absolute; top: -4; left: 60; width: 50px; height: 50px;">
                <center style="font-size: 10px; margin-bottom: 0px; text-transform: uppercase;">{{$configuration['agency']['member']['name']}}</center>
                <center style="font-size: 11px; margin-bottom: 0px; font-weight: bold;">REGIONAL STANDARDS AND TESTING LABORATORIES</center>
                <center style="font-size: 11px; width: 400px; margin: 0 auto; text-align: center;">{{$form['address']}} | {{$form['contact']}} | {{$form['email']}}</center>
                <br/>
                
                <center style="margin-top: 8px; font-size: 12px; color:#000; font-weight: bold; padding: 2px;">QUOTATION</center>
                <center style="font-size: 10px; background-color: #1fdf62; color:#fff; font-weight: bold; padding: 2px;">CUSTOMER COPY</center>
            </div>

            <table style="border: 1px solid black; font-size: 10px; margin-top: 15px;">
                <tbody>
                    <tr>
                        <td width="25%">Quotation Code : </td>
                        <td width="25%"><span style="font-weight: bold; color: #072388;">{{$quotation['code']}}</span></td>
                        <td width="25%">Date and Time :</td>
                        <td width="25%"><span style="color: #072388;">{{$quotation['created_at']}}</span></td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black; font-size: 10px; margin-top: 10px;">
                <tbody>
                    <tr>
                        <td width="25%">Customer : </td>
                        <td colspan="3" width="75%"><span style="font-weight: bold; text-transform: uppercase; color: #072388;">{{$quotation['customer']['name']}}</span></td>
                    </tr>
                    <tr>
                        <td width="25%">Address : </td>
                        <td colspan="3" width="75%"><span style="text-transform: uppercase; color: #072388;">{{$quotation['customer']['address']['name']}}</span></td>
                    </tr>
                    <tr>
                        <td width="25%">Contact Number : </td>
                        <td width="25%"><span style="color: #072388;">{{$quotation['customer']['contact_no']}}</span></td>
                        <td width="25%">Email : </td>
                        <td width="25%"><span style="color: #072388;">{{$quotation['customer']['email']}}</span></td>
                    </tr>
                </tbody>
            </table>
            <h6 style="font-size: 10px; margin-top: 12px;">1.TESTING OR CALIBRATION SERVICES</h6>
            <table style="border: 1px solid black; font-size: 10px; margin-top: -22px;">
                <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
                    <tr>    
                        <th style="vertical-align: middle;" width="20%">Sample</th>
                        <th style="vertical-align: middle;" width="25%">Test/Calibration Requested</th>
                        <th style="vertical-align: middle;" width="25%">Test/Calibration Method</th>
                        <th style="vertical-align: middle;" width="10%">No. of Samples</th>
                        <th style="vertical-align: middle;" width="10%">Unit Cost</th>
                        <th style="vertical-align: middle;" width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($group as $index=>$sample)
                    <tr style="text-align: center; font-size: 9px; color: #072388;">
                        <td style="text-align: left;">{{$sample['samplename']}}</td>
                        <td>{{$sample['testname']}}</td>
                         <td>{{(isset($sample['methodShort'])) ? $sample['methodShort'] : $sample['method']}}</td>
                        <td>{{$sample['count']}}</td>
                        <td style="text-align: right;">
                            <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                P
                            </span> {{number_format(trim(str_replace(',','',$sample['fee']),'₱ '),2,".",",")}}</td>
                        <td style="text-align: right;">
                            <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                P
                            </span> {{number_format(trim(str_replace(',','',$sample['fee']),'₱ ')*$sample['count'],2,".",",")}}</td>
                    </tr>
                    @if(isset($sample['additional']))
                        @foreach($sample['additional'] as $index=>$add)
                        <tr style="text-align: center; font-size: 9px; color: #072388;">
                            <td colspan="3" style="text-align: left;">{{$add['name']}}</td>
                            <td>{{$add['quantity']}}</td>
                            <td style="text-align: right;">
                                <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                    <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    P
                                </span> {{number_format(trim($add['fee'],'₱ '),2,".",",")}}
                            </td>
                            <td style="text-align: right;">
                                <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                    <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    P
                                </span> {{number_format(trim(str_replace(',','',$add['fee']),'₱ ')*$add['quantity'],2,".",",")}}
                            </td>
                        </tr>
                        @endforeach
                    @endif
                @endforeach
                @if(isset($services) && count($services) > 0)
                    @foreach($services as $service)
                        <tr style="text-align: center; font-size: 9px; color: #072388;">
                            <td style="text-align: left;" colspan="3">
                                {{ $service['name'] }} ({{ $service['description'] }})
                            </td>
                            <td>{{ $service['quantity'] }}</td>
                            <td style="text-align: right;">
                                <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                    <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    P
                                </span> {{number_format(trim(str_replace([',','₱'],'',$service['fee'])), 2, ".", ",")}}
                            </td>
                            <td style="text-align: right;">
                                <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                    <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                    P
                                </span> {{ number_format(trim(str_replace([',','₱'],'',$service['fee'])) * $service['quantity'], 2, ".", ",") }}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot style="text-align: center; padding: 3px; font-weight: bold; background-color:#c8c8c8;">
                    <tr>
                        <td colspan="4"></td>
                        <td style="font-size: 8px;">SUBTOTAL</td>
                        <td style="text-align: right;">
                            <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                P
                            </span> {{number_format(trim(str_replace(',','',$quotation['subtotal']),'₱ '),2,".",",")}}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td style="font-size: 8px;">DISCOUNT</td>
                        <td style="text-align: right;">
                            <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                P
                            </span> {{number_format(trim(str_replace(',','',$quotation['discount']),'₱ '),2,".",",")}}
                        </td>
                    </tr>
                    @php
                        $walletAmount = (float) preg_replace('/[^0-9.]/', '', $wallet);
                        $quotationTotal = (float) preg_replace('/[^0-9.]/', '', $quotation['total']);

                        $netTotal = max($quotationTotal - $walletAmount, 0); // Never less than 0
                        $newWalletBalance = $walletAmount > $quotationTotal
                            ? $walletAmount - $quotationTotal
                            : 0;
                    @endphp
                    @if($wallet != 0)
                    <tr>
                        <td colspan="4"></td>
                        <td style="font-size: 8px;">WALLET</td>
                        <td style="text-align: right;">
                           <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                P
                            </span>{{number_format(trim(str_replace(',','',$wallet),'₱ '),2,".",",")}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td style="font-size: 8px;">TOTAL</td>
                        <td style="text-align: right;">
                            <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                P
                            </span>{{number_format(trim(str_replace(',','',$netTotal),'₱ '),2,".",",")}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td style="font-size: 8px;">NEW WALLET BALANCE</td>
                        <td style="text-align: right;">
                            <span style="font-family: DejaVu Sans;">&#8369;</span>{{ number_format($newWalletBalance, 2, ".", ",") }}
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="4"></td>
                        <td style="font-size: 8px;">TOTAL</td>
                        <td style="text-align: right;">
                            <span style="position: relative; display: inline-block; margin-bottom: -2px; margin-right: -2px;">
                                <span style="position: absolute; top: 4.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                <span style="position: absolute; top: 3.5px; left: 1.78; width: .68em; border-top: .65px solid #072388"></span>
                                P
                            </span> {{number_format(trim(str_replace(',','',$quotation['total']),'₱ '),2,".",",")}}
                        </td>
                    </tr>
                    @endif
                </tfoot>
            </table>
            <h6 style="font-size: 10px; margin-top: 12px;">2. DESCRIPTION OF THE SAMPLE(S) / REMARK(S)</h6>
            <table style="border: 1px solid black; font-size: 9px; margin-top: -22px;">
                <tbody>
                    <tr>
                        <td>
                            <ul style="margin-left: -30px; list-style: none;">
                                @foreach($descs as $desc)
                                    <li>&#62; {{$desc['name']}} : <i>{{$desc['customer_description']}}</i>, {{$desc['description']}}</li>
                                @endforeach
                            </ul>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="page-break-inside: avoid;">
                <h6 style="font-size: 10px; margin-top: 12px;">3. TERMS AND CONDITIONS</h6>
                <table style="border: 1px solid black; font-size: 9px; margin-top: -22px;">
                    <tbody>
                        <tr>
                            <td>
                                @if($configuration['agency']['member']['name'] == 'Department of Science and Technology - VI')
                                    <ul style="margin-left: -20px; margin-right: 20px;">
                                        <li>Payments can be made in the form of cash or Managers Check. Please make check payment payable to DOST VI or DEPARTMENT OF SCIENCE AND TECHNOLOGY VI. Also, please be informed that as a National Government Agency, DOST VI is not subject to Expanded Witholding Tax pursuant to section 2.57.5 of BIR Revenue Regulation No. 2-98.</li>   
                                    </ul> 
                                @else
                                    <ul style="margin-left: -20px;">
                                        @foreach($quotation['terms'] as $index=>$term)
                                        <li>{{ is_array($term) && isset($term['name']) ? $term['name'] : (is_string($term) ? $term : '') }}</li>
                                        @endforeach
                                        <!-- <li>DOST IX Trust Fund 1952101052 Landbank of the Philippines.</li>
                                        <li>Cash payment should be made directly to the cashier or deposit to DOST IX account.</li>
                                        <li>This quotation is valid only until <b>{{$quotation['due_at']}}</b></li> -->
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="page-break-inside: avoid;">
                <h6 style="font-size: 10px; margin-top: 12px;">4. SIGNATORIES</h6>
                <table style="text-align: center; border: 1px solid black; font-size: 10px; margin-top: -22px; page-break-inside: avoid;">
                    <tbody>
                        <tr>
                            <td style="min-height: 50px; padding: 20px; border-bottom-style: hidden;"></td>
                            <td style="min-height: 50px; padding: 20px; border-bottom-style: hidden;"></td>
                            <td style="min-height: 50px; padding: 20px; border-bottom-style: hidden;"></td>
                        </tr>
                        <tr>
                            <td width="33.3%" style="vertical-align: bottom; position: relative; height: 40px; text-align: center;">
                                <div style="position: relative; height: 40px;">
                                    <div style="position: absolute; bottom: 13px; left: 50%; transform: translateX(-50%);">
                                        @if(!empty($signatory['received']['profile']['signature']))
                                            <img 
                                                src="{{ public_path('storage/profile-signatures/' . $sign['prepared']['profile']['signature']) }}" 
                                                alt="Signature" 
                                                style="height: 60px; width: auto;"
                                            >
                                        @endif
                                    </div>
                                </div>
                                <div style="position: absolute; bottom: 2; width: 100%;">
                                    <span style="font-weight: bold; font-size: 11px; color: #072388; text-transform: uppercase;">{{$quotation['conforme']}}</span><hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 80%;">Customer / Authorized Representative </br> <span style="font-size:9px; color: #606060;">(Received by)</span>
                                </div>
                            </td>
                            <td width="33.3%" style="vertical-align: bottom; position: relative; height: 40px; text-align: center;">
                                <div style="position: relative; height: 40px;">
                                    <div style="position: absolute; bottom: 13px; left: 50%; transform: translateX(-50%);">
                                        @if($signatory['prepared']['profile']['signature'] === 'no-esig.png')
                                            <img 
                                                src="{{ public_path('images/avatars/no-esig.png') }}" 
                                                alt="Signature" 
                                                style="height: 60px; width: auto;"
                                            >
                                        @else
                                            <img 
                                                src="{{ public_path('storage/profile-signatures/' . $signatory['prepared']['profile']['signature']) }}" 
                                                alt="Signature" 
                                                style="height: 60px; width: auto;"
                                            >
                                        @endif
                                    </div>
                                </div>
                                <div style="position: absolute; bottom: 2; width: 100%;">
                                    <span style="font-weight: bold; font-size: 11px; color: #072388; text-transform: uppercase;">{{$user}}</span><hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 80%;">Laboratory Personnel </br> <span style="font-size:9px; color: #606060;">(Prepared by)</span>
                                </div>
                            </td>
                            <td width="33.3%" style="vertical-align: bottom; position: relative; height: 40px; text-align: center;">
                                <div style="position: relative; height: 40px;">
                                    <div style="position: absolute; bottom: 13px; left: 50%; transform: translateX(-50%);">
                                        @if(!empty($signatory['approved']['profile']['signature']))
                                            <img 
                                                src="{{ public_path('storage/profile-signatures/' . $sign['prepared']['profile']['signature']) }}" 
                                                alt="Signature" 
                                                style="height: 60px; width: auto;"
                                            >
                                        @endif
                                    </div>
                                </div>
                                <div style="position: absolute; bottom: 2; width: 100%;">
                                    <span style="font-weight: bold; font-size: 11px; color: #072388; text-transform: uppercase;">{{$manager}}</span><hr style="margin-top: 0px; margin-bottom: 1px; border: .1px solid black; width: 80%;">Technical Manager </br> <span style="font-size:9px; color: #606060;">(Approved by)</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<!-- style="border-bottom-style: hidden;" -->
