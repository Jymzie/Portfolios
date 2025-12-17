<!DOCTYPE html>

<html>

<head>

    <title>Tile Cutting Schedule</title>

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
        font-size: 50px;
        text-align: center;
        margin-top: -20px;


    }
    table, th, td {
        border: 1px solid;
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    .title{
        background-color: gray;
        color: white;
        font-size: 30px;
        margin-bottom: 5px;
        margin-top: -10px;
    }

    tbody tr td, thead tr th{
        font-size: 11px;
        text-align:center;
    }
    .blacktd{
        background-color: black; 
        color:white;
    }

    
    </style >
    {{-- @php
        return dd($data)
    @endphp --}}

<body>
    


    <div class="footer">
        <hr style="bottom:0;position: absolute;width:100%;margin-bottom:-4px"/>
        <div style="bottom:0;position: absolute;color:blue;margin-bottom:-25px;font-weight:bold;font-style:italic;font-size:20px;">
            {{$info[0]['DateToday']}}
        </div>  
       
    </div>


    <p style="text-align: right">Schedule Date: {{$info[0]['ProductionScheduledDate']}}</p>
   
    <div class="title">
        <table>
            <tr>
                <td  style="border:none;text-align-left;font-size:20;width: 10px">
                    {{$info[0]['Line']}}
                </td>
                <td  style="border:none;text-align-left;font-size:20">
                    TILE CUTTING SCHEDULE 13.5
                </td>
            </tr>
        </table>
    
       
    </div>
    @php
    $limit = 14;
    $break = 12;
    @endphp
    <div>
        <table>
            <thead>
                <tr style="text-align: center">
                    <th rowspan="2">NO.</th>
                    <th>CDNO/NameCd</th>
                    <th rowspan="2">Floor</th>
                    <th rowspan="2">Sash</th>
                    <th rowspan="2">Ad Wood</th>
                    <th rowspan="2">Wall Panel</th>
                    <th rowspan="2">Flower Box</th>
                    <th>Request</th>
                    <th>Window Name</th>
                    <th colspan="2">UNIT</th>
                    <th>UNUR</th>
                    <th>Exist</th>
                    <th rowspan="2">REMARKS</th>
                </tr>
                <tr style="text-align: center">
                    <th>Unit Name</th>
                   
                    <th>WallTile</th>
                    <th colspan="2">LIGHT</th>
                    <th colspan="3">INTERPHONE</th>
                </tr>
            </thead>
          
            <tbody>
                @for($a=0;$a<$count;$a++)
                    <tr>
                        <td rowspan="3">{{$data[$a]['ProductionOrder']}}</td>
                        <td rowspan="1" style="height: 30px; width:150px">{{$data[$a]['CDNO'].'/'.$data[$a]['NameCode']}}</td>
                        <td rowspan="3">{{isset($data[$a]['FLOOR'])? $data[$a]['FLOOR']:'-'}}</td>
                        <td rowspan="3">{{isset($data[$a]['SASHTYPE'])? $data[$a]['SASHTYPE']:'-'}}</td>
                        <td rowspan="3">{{isset($data[$a]['AD_W'])? $data[$a]['AD_W']:'-'}}</td>
                        <td rowspan="3">{{$data[$a]['WallPanel']}}</td>
                        <td rowspan="3">{{isset($data[$a]['FLOWERBOX'])? $data[$a]['FLOWERBOX']:'-'}}</td>
                        <td rowspan="1" style="width: 70px">{{$data[$a]['REQUEST']}}</td>
                        <td rowspan="1">{{substr($data[$a]['WINDOWTYPE'],0,2) == 'AW'? $data[$a]['MAT_NAME']: $data[$a]['WINDOWTYPE']}}</td>
                        <td colspan="2" style="width: 120px">{{isset($data[$a]['UNIT']) && isset($data[$a]['withwindow']) ? $data[$a]['UNIT']:''}}</td>
                        <td rowspan="1" style="width: 60px">{{isset($data[$a]['UNUR']) && isset($data[$a]['UnitKind'])? $data[$a]['UNUR']:'-'}}</td>
                        <td rowspan="1">{{isset($data[$a]['Exist'])? $data[$a]['Exist']:'-'}}</td>
                        <td rowspan="1">{{ $data[$a]['WallPanel'] == 'Y' 
                            && ($data[$a]['UNIT'] == 'JK90-O' || $data[$a]['UNIT'] == 'JK90-S' || $data[$a]['UNIT'] == 'PC60--' || $data[$a]['UNIT'] == 'PC90--')
                            || (isset($data[$a]['NOTE']) && $data[$a]['NOTE'] != '*Ver1*') 
                            ? 'OLD TYPE': ''}}
                            </td>
                    
                    </tr>
                    <tr>
                        <td rowspan="1" class="blacktd">{{$data[$a]['MAT_NAME']}}</td>
                        <td rowspan="2" class="blacktd">{{isset($data[$a]['WALLTILE'])? $data[$a]['WALLTILE']:'-'}}</td>
                        <td rowspan="2" colspan="2">{{isset($data[$a]['LIGHT'])? $data[$a]['LIGHT']:'-'}}</td>
                        <td rowspan="2" colspan="3">{{isset($data[$a]['INTERPHONE'])? $data[$a]['INTERPHONE']:'-'}}</td>
                         <td rowspan="1"></td>
                        {{-- <td rowspan="1">{{isset($data[$a]['NOTE']) && $data[$a]['NOTE'] == 'EPS180'? 'EPS180': isset($data[$a]['NOTE']) ? $data[$a]['NOTE']:''}}</td> --}}
                    </tr>
                    <tr>
                        <td rowspan="1" class="blacktd">{{isset($data[$a]['cUNIT'])? $data[$a]['cUNIT']:'-'}}</td>
                        <td rowspan="1"></td>
                        {{-- <td rowspan="1">{{isset($data[$a]['NOTE']) && $data[$a]['NOTE'] == 'SMALL'? 'SMALL TA': isset($data[$a]['NOTE']) ? $data[$a]['NOTE']:''}}</td> --}}
                    </tr>


                    @if($a == $break)
                        @php
                            $break = $break+$limit;
                        @endphp
                        
                        <tr style="page-break-after: always;"><td colspan="14" style="background-color:black"></td></tr>
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