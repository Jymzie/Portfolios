<!DOCTYPE html>

<html>

<head>

    <title>Material Issuance Slip</title>

</head>

    <style scoped>

    @font-face {
    font-family: 'Unicodefix';
    src: url('{{ storage_path('fonts/Unicodefix.ttf') }}') format('truetype');
    }
    
    .footer {
        position: fixed;
        width:100%;
    }

    .jap{
        font-family:"myFont";
    }

    h1{
        text-align: center;
        margin-top: -10px;


    }
    tbody tr td, thead tr th{
        font-size: 12px;
    }
    table, th, td {
        border: 1px solid;
    }
    .noncell{
        border: none;
        font-size: 15px;
    }

    
    </style >

<body>
    <div class="footer">
        <div  style="bottom:0;position: absolute;font-size:11px;margin-bottom:-20px">
            PRINTED DATE: {{$info[0]['DateToday']}}
        </div>
    </div>


    <h1>Material Issuance Slip</h1>
 
    <div style="text-align: center;margin-top: -20px;">
        <u style="font-size:20px">PVC/ARUKU/BOUKA SASH, REGULAR GLASS</u>
    </div>

    <table class="noncell" style="width:100%; margin: 20px 0 20px 0;">
        <tr >
            <td class="noncell" style="width: 130px">
                ISSUE DATE :
            </td>
            <td class="noncell" style="width: 80px">
                <u>{{$info[0]['IssueDate']}}</u>
            </td>
            <td rowspan="2" style="width: 120px; text-align:center;font-size:25px;font-weight:bold">
                {{$info[0]['Line']}}
            </td>
            <td class="noncell" style="text-align: right;">
                SLIP CONTROL NO : _________________
            </td>
        </tr>
        <tr>
            <td class="noncell">
                PRODUCT DATE :
            </td>
            <td class="noncell">
                <u>{{$info[0]['ProductionScheduledDate']}}</u>
            </td>
        </tr>

    </table>

    <div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: center;background-color:#ff9900">
                    <th>NO</th>
                    <th>CDNO</th>
                    <th>NAME CD</th>
                    <th>REQUEST</th>
                    <th colspan="2">UNIT NAME</th>
                    <th>EXIST</th>
                    <th>KIND</th>
                    <th>ITEM ID</th>
                    <th>HINBAN</th>
                    <th>QTY</th>
                    <th>UOM</th>
                    <th>RECEIVED BY</th>
                    <th>REMARKS</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach($data as $rec)
                    <tr>
                        <td>{{$rec->ProductionOrder}}</td>
                        <td style="background-color:#ffcc99">{{$rec->CDNO}}</td>
                        <td style="background-color:#ffcc99">{{$rec->NameCode}}</td>
                        <td>{{$rec->REQUEST}}</td>
                        <td>{{$rec->MAT_NAME}}</td>
                        <td>{{isset($rec->cUNIT)? $rec->cUNIT:''}}</td>
                        <td>{{$rec->EXIST}}</td>
                        <td>{{$rec->Kind}}</td>
                        <td style="background-color:#ffcc99">{{isset($rec->ItemId)? $rec->ItemId:'Not Found'}}</td>
                        <td style="background-color:#ffcc99">{{$rec->Hinban}}</td>
                        <td style="background-color:#ffcc99">{{$rec->Qty}}</td>
                        <td>{{isset($rec->SupplierQtyUnit)? $rec->SupplierQtyUnit:''}}</td>
                        <td></td>
                        <td>{{$rec->Remarks}}</td>
                    </tr>
                @endforeach
            </tbody>
           
      
        </table>
    </div>

   
    <table class="noncell" style="margin: 25px 0 0 70px;">
        <tr>
            <td class="noncell">
                CHECKED BY :
            </td>
            <td class="noncell">
                ____________________________
            </td>
        </tr>
        <tr>
            <td class="noncell"></td>
            <td class="noncell" style="font-size: 11px; text-align:center">
                WUKONG MATERIAL QC <br/>
                (SIGNATURE OVER PRINTED NAME) 
            </td>
        </tr>
    </table>

    
    

    <div style="bottom:0;left:48%;position: absolute;font-size:11px;margin-bottom:-20px">
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_script('
                    $text = __(":pageNum / :pageCount Page ", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
                    $font = null;
                    $size = 9;
                    $color = array(0,0,0);
                    $word_space = 0.0;  //  default
                    $char_space = 0.0;  //  default
                    $angle = 0.0;   //  default
     
                    // Compute text width to center correctly
                    $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
     
                    $x = ($pdf->get_width() - $textWidth) / 2;
                    $y = $pdf->get_height() - 30;
     
                    $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                ');
            }
        </script>
    </div>

   
    
  

</body>

</html>