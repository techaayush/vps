<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico"> -->
    
    <!-- others css -->
    
    <!-- modernizr css -->
</head>

<body style="background: #fff; font-weight: normal;
font-family: sans-serif;">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
   
    <!-- page container area end -->
    <!-- jquery latest version -->

    <div style="width: 90%; margin: auto">
        <div style="min-height: .01%; overflow-x: auto;">
            <table style=" width: 100%;  max-width: 100%; margin-bottom: 20px; border-collapse: collapse; border-spacing: 0;">
                <tbody>
                    <tr>
                        <td style="text-transform: uppercase; text-align: center;">
                            <h4 style="margin: 5px 0px;">Vidhya Public School</h4>
                            <h5 style="margin: 5px 0px;">Shree ram colony , RAU (INDORE)</h5>
                            <h6 style="margin: 5px 0px;">Fee receipt for Session {{$session}}</h6>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="    border: 2px solid #000;">
                <div style="padding: 10px;">
                    <div style="min-height: .01%; overflow-x: auto;">
                        <table style="font-weight: bold; width: 100%; max-width: 100%; margin-bottom: 20px; border-collapse: collapse; border-spacing: 0;">
                            <tbody>
                                <tr>
                                    <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 0px solid #fff; border-top: 0px solid #fff;">
                                        <span style="margin-right: 30px;">Receipt No.</span>
                                        <span>{{$receiptNo}}</span>
                                    </td>
                                    <td style="text-align: right;padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 0px solid #fff; border-top: 0px solid #fff; ">
                                        <span style="margin-right: 30px;">Date</span>
                                        <span>{{$date}}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="min-height: .01%; overflow-x: auto;">
                        <table style="width: 100%; max-width: 100%; margin-bottom: 20px; border-collapse: collapse; border-spacing: 0; border: 1px solid #000;" class=" ">
                            <thead style="font-weight: bold;"> 
                                <tr >
                                    <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 2px solid #000; border-right: 1px solid #000;">
                                        Student Name
                                    </td>
                                    <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 2px solid #000; border-right: 1px solid #000;">
                                       Father Name
                                    </td>
                                    <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 2px solid #000;">
                                        Class
                                     </td>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($studentsDetail) && count($studentsDetail))
                                    @foreach($studentsDetail as $studentDetail)
                                        <tr>
                                            <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 0px solid #fff; border-top: 0px solid #fff; border-right: 1px solid #000;">
                                                {{$studentDetail->studentName}}
                                            </td>
                                            <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 0px solid #fff; border-top: 0px solid #fff; border-right: 1px solid #000;">
                                                {{$studentDetail->fatherName}}
                                            </td>
                                            <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 0px solid #fff; border-top: 0px solid #fff;">
                                                {{$studentDetail->class}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="min-height: .01%; overflow-x: auto;" class="table-responsive fee-table">
                    <!-- <header>
                        <div class="text-uppercase">Details</div>
                        <div class="text-uppercase">Amount</div>
                    </header>
                    <div class="">

                    </div> -->
                    <table class="" style="width: 100%; max-width: 100%; margin-bottom: 20px; border-collapse: collapse; border-spacing: 0; border: 1px solid #000;">
                        <thead style="font-weight: bold;">
                            <tr style="text-align: center;">
                                <td style=" padding:0px 8px; line-height: 1.42857143; vertical-align: top;border-bottom: 2px solid #000; border-right: 1px solid #000;">Details</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 2px solid #000; ">Amount (Rs.)</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style=" padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000;">Old Remaining</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; text-align: center;">{{$oldRemaining}}</td>
                            </tr>
                            <tr>
                                <td  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000;">Fee for session {{$session}}</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; text-align: center;">{{$sessionFee}}</td>
                            </tr>
                            <tr>
                                <td  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000;">Previous Deposited</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; text-align: center;">{{$previousDeposited}}</td>
                            </tr>
                            <tr>
                                <td  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000;">Surcharge *</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; text-align: center;">0</td>
                            </tr>
                            <tr>
                                <td  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000;">Discount **</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; text-align: center;">{{$discount}}</td>
                            </tr>
                            <tr>
                                <td  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000;">Total Balance ***</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; text-align: center;">{{$totalBalance}}</td>
                            </tr>
                            <tr>
                                <td  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000; border-bottom: 1px solid #000;">Received Fee***</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 1px solid #000; text-align: center;">{{$receivedFee}}</td>
                            </tr>
                            <!-- <tr class="not">
                                <td colspan="2"  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-bottom: 1px solid #000;"><span>Rupees</span> five hundred only</td>
                            </tr> -->
                            <tr>
                                <td  style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; border-right: 1px solid #000;">Remaining Fee***</td>
                                <td style="padding:0px 8px; line-height: 1.42857143; vertical-align: top; text-align: center;">{{$remainingFee}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
   
</body>

</html>
