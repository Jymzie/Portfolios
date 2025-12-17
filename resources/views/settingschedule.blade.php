<!DOCTYPE html>

<html>

<head>

    <title>Setting Schedule</title>

</head>

    <style scoped>
 
    .footer {
        position: fixed;
        width:100%;
    }
     

    .bordered th,.bordered  td {
        border: 1px solid;
    }
    .bordered{
        margin-top: -30px;
        width: 100%;
        border-collapse:collapse ;
    }
    tbody tr td, thead tr th{
        font-size: 11px;
        text-align:center;
    }


   

    
    </style >


<body>
    {{-- NOTE Footer  --}}
    <div class="footer">
        <hr style="bottom:0;position: absolute;width:100%;margin-bottom:-4px"/>
        <div style="bottom:0;position: absolute;color:blue;margin-bottom:-25px;font-weight:bold;font-style:italic;font-size:20px;">
            {{$info[0]['DateToday']}} 
        </div>  
      
        
    </div>

    {{-- <div style="bottom:0;right:0;position: absolute; background-color:black;width:100px;height:100px;margin-bottom:-100px">
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_script('
                    $text = __(":pageNum/:pageCount Page", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
                    $font = null;
                    $size = 16;
                    $color = array(0,0,255);
                    $word_space = 0.0;  //  default
                    $char_space = 0.0;  //  default
                    $angle = 0.0;   //  default
    
                    // Compute text width to center correctly
                    $textWidth = $fontMetrics->getTextWidth($text, $font, $size);

                    $x = ($pdf->get_width() - $textWidth) -35;
                    $y = $pdf->get_height() - 33;
    
                    $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                ');
            }
        </script>
    </div> --}}

    {{-- NOTE CONTENT  --}}
    <table style="width: 100%;margin-top:-50px">
        <tr>
            <td style="text-align: left">
                <p style="font-size: 40px">
                    <b style="font-size: 45px;width:400px"> {{$info[0]['Line']}}</b> 
                </p>
            </td>
            <td>
                <p style="text-align: right; font-size:20px">Schedule Date:</p>
                <p style="text-align: right; font-size:20px; margin-top:-25px">{{$info[0]['ProductionScheduledDate']}}</p>
            </td>
        </tr>
    </table>

    <div style="font-size: 40px;top:0;position: absolute;left:20%;margin-top:-2px">
        Setting Schedule
    </div>
   
    
    <div>
        <table class="bordered">
           <thead>
                <tr style="text-align: center">
                    <th rowspan="2">No.</th>
                    <th rowspan="2">CDNO/NameCd</th>
                    <th rowspan="2">Request</th>
                    <th rowspan="2">Window Name</th>
                    <th rowspan="2">Exist</th>
                    <th rowspan="2">Unit Name</th>
                    <th rowspan="2">UN/UR</th>
                    <th rowspan="2">MOGOL COLOR</th>
                    <th rowspan="2">Add Wood</th>
                    <th rowspan="2">Wall Panel</th>
                    <th rowspan="2">Fire Proof</th>
                    <th rowspan="2">Tile</th>
                    <th>Specifics</th>
                    <th>Style</th>
                    <th>F-1F</th>
                    <th rowspan="2">F-2F</th>
                    <th colspan="2" style="width: 65px">T-Profile</th>
                    <th rowspan="2">Roof Tile</th>
                    <th rowspan="2">Remarks</th>
                </tr>
           
            
                <tr style="text-align: center">
                    <th>Color Siding</th>
                    <th>EPS</th>
                    <th>SASH</th>
                    <th>1F</th>
                    <th>2F</th>
                </tr>

                <tr></tr>
            </thead>
            @php
            $limit = 14;
            $break = 12;
            @endphp
            <tbody>
                
                @for($a=0;$a<$count;$a++)
                
                    <tr>
        
                        <td rowspan="3">{{$data[$a]['ProductionOrder']}}</td>
                        <td rowspan="3" style="width: 80px">{{$data[$a]['CDNO'].' / '.$data[$a]['NameCode']}}</td>
                        <td rowspan="3" style="width: 65px">{{$data[$a]['REQUEST']}}</td>
                        <td rowspan="3" style="width: 75px">{{substr($data[$a]['WINDOWTYPE'],0,2) == 'AW'? $data[$a]['MAT_NAME']: $data[$a]['WINDOWTYPE']}}</td>
                        <td rowspan="3">{{$data[$a]['Exist']}}</td>
                        <td rowspan="1" style="width: 120px">{{$data[$a]['MAT_NAME']}}</td>
                        <td rowspan="3" style="width: 55px">{{isset($data[$a]['UNUR'])? $data[$a]['UNUR']:''}}</td>
                        <td rowspan="3">{{isset($data[$a]['MOGOLCOLOR'])? $data[$a]['MOGOLCOLOR']:'-'}}</td>
                        <td rowspan="3">{{isset($data[$a]['AD_W'])? $data[$a]['AD_W']:'-'}}</td>
                        <td rowspan="3">{{$data[$a]['WallPanel']}}</td>
                        <td rowspan="3">{{isset($data[$a]['FIREPROOF'])? $data[$a]['FIREPROOF']:'-'}}</td>
                        <td rowspan="3" style="width: 43px">{{isset($data[$a]['WALLTILE'])? $data[$a]['WALLTILE']:'-'}}</td>
                        <td rowspan="1">{{isset($data[$a]['SHIPMENT'])? $data[$a]['SHIPMENT']:'-'}}</td>
                        <td rowspan="1" style="width: 70px">{{isset($data[$a]['STYLE'])? $data[$a]['STYLE']:'-'}}</td>
                        <td rowspan="1" style="width: 40px">{{isset($data[$a]['FURNITURECOLOR'])? $data[$a]['FURNITURECOLOR']:'-'}}</td>
                        <td rowspan="3">{{isset($data[$a]['FURNITURECOLOR2F'])? $data[$a]['FURNITURECOLOR2F']:'-'}}</td>
                        <td rowspan="3">{{isset($data[$a]['THINFRAME'])? substr($data[$a]['THINFRAME'],0,1):'-'}}</td>
                        <td rowspan="3">{{isset($data[$a]['THINFRAME2F'])? substr($data[$a]['THINFRAME2F'],0,1):'-'}}</td>
                        <td rowspan="3">{{isset($data[$a]['RoofTile'])? $data[$a]['RoofTile']:'-'}}</td>
                        <td style="width: 50px"></td>
                        
                    </tr>

                    <tr>
                        <td rowspan="2">{{isset($data[$a]['UNIT_T'])? $data[$a]['UNIT_T']:$data[$a]['UNIT']}}</td>
                        <td rowspan="2">{{isset($data[$a]['SIDINGCOLOR'])? $data[$a]['SIDINGCOLOR']:'-'}}</td>
                        <td rowspan="2">{{isset($data[$a]['EPS'])? $data[$a]['EPS']:'-'}}</td>
                        <td rowspan="2">{{isset($data[$a]['WINDOWSIZE']) && $data[$a]['WINDOWSIZE'] == '2545'? 'W25':'-'}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        {{-- <td>{{isset($data[$a]['NOTE']) && $data[$a]['NOTE'] == 'SMALL'? 'SMALL TA': isset($data[$a]['NOTE']) ? $data[$a]['NOTE']:''}}</td> --}}
                    </tr>

                    @if($a == $break)
                        @php
                            $break = $break+$limit;
                        @endphp
                        
                        <tr style="page-break-after: always;"><td colspan="20" style="background-color:black"></td></tr>
                    @endif

                @endfor
            </tbody>
            
           
      
        </table>
    </div>


    <div style="bottom:0;right:0;position: absolute;color:blue;font-weight:bold;font-style:italic;">
            
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_script('
                    $text = __(":pageNum/:pageCount Page", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
                    $font = null;
                    $size = 16;
                    $color = array(0,0,255);
                    $word_space = 0.0;  //  default
                    $char_space = 0.0;  //  default
                    $angle = 0.0;   //  default
        
                    // Compute text width to center correctly
                    $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
        
                    $x = ($pdf->get_width() - $textWidth) -35;
                    $y = $pdf->get_height() - 33;
        
                    $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                ');
            }
        </script>
        
    </div>
    
</body>

</html>