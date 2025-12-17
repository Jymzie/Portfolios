<!DOCTYPE html>

<html>

<head>

    <title>Tile Cutting Checklist</title>

</head>

    <style scoped>

    @font-face {
    font-family: 'Unicodefix';
    src: url('{{ storage_path('fonts/Unicodefix.ttf') }}') format('truetype');
    }
    
    

    .jap{
        font-family:"myFont";
    }

    h2{
        text-align: center;
        margin-top: -10px

    }
    /* .bordered th, .bordered td {
        border: 1px solid;
    } */
    .bordered {
        border: 1px solid;
        width: 100%;
        border-collapse: collapse;
    }
    .bright{
        border-right: 1px solid;
    }
    .bbot{
        border-bottom: 1px solid;
    }
    .spacif{
        padding-left: 2em !important;
    }

    
    </style >

<body>
    @for($a=0;$a<$count;$a++)
        @if($a != 0)
            <div style="page-break-after: always;"></div>
        @endif

        <p style="text-align: right; margin-right:100px; margin-top: -25px">SF026-00;April 22, 2024</p>
        <h2>TILE CUTTING CHECKLIST</h2>
        <p style="text-align: center; font-size:20px; margin-top:-20px">(Exterior Unit Material Category)</p>
        
        <div style="margin-top: -10px">
            <table class="bordered">
            
                <tr>
                    <td class="bordered" style="width: 90px">TILE</td>
                    <td class="bordered">{{isset($data[$a]['WALLTILE'])? $data[$a]['WALLTILE']:'-'}}</td>
                </tr>
                <tr>
                    <td class="bordered">UNIT</td>
                    <td class="bordered">{{isset($data[$a]['withwindow']) && isset($data[$a]['UNIT'])? $data[$a]['UNIT']:''}}</td>
                </tr>
                <tr>
                    <td class="bordered">SASH</td>
                    <td class="bordered">{{isset($data[$a]['SASHTYPE'])? $data[$a]['SASHTYPE']:'-'}}</td>
                </tr>
                <tr>
                    <td class="bordered">FLOOR</td>
                    <td class="bordered">{{isset($data[$a]['FLOOR'])? $data[$a]['FLOOR']:'-'}}</td>
                </tr>
                <tr>
                    <td class="bordered">AD_W</td>
                    <td class="bordered">{{isset($data[$a]['AD_W'])? $data[$a]['AD_W']:'-'}}</td>
                </tr>
                <tr>
                    <td class="bordered">WP</td>
                    <td class="bordered">{{$data[$a]['WallPanel']}}</td>
                </tr>
                <tr>
                    <td class="bordered">FB</td>
                    <td class="bordered">{{isset($data[$a]['FLOWERBOX'])? $data[$a]['FLOWERBOX']:'-'}}</td>
                </tr>
        
            </table>
        </div>


        <div>
            <table style="width: 100%">
                <tr>
                    <td class="bbot" style="width:370px">
                        TEAM/LINE:<span class="spacif">{{$data[$a]['Line']}}</span> 
                    </td>
                    <td style="width:300px"></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bbot">
                        CODE NO: <span class="spacif">{{$data[$a]['CDNO']}}</span>
                    </td>
                    <td></td>
                    <td class="bbot">
                        SETTING SCHEDULE
                    </td>
                </tr>
                <tr>
                    <td class="bbot">
                        OWNER NAME:
                    </td>
                    <td></td>
                    <td class="bbot">
                        DATE
                    </td>
                </tr>
                <tr>
                    <td class="bbot">
                            UNIT NAME: <span class="spacif">{{$data[$a]['MAT_NAME']}}</span>
                    </td>
                    <td></td>
                    <td class="bbot">
                        Shipment Schedule: <span class="spacif">{{$data[$a]['REQUEST']}}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <table style="width: 100%">
                <tr>
                    <td>
                        <table class="bordered" style="text-align: center">
                            <tr>
                                <td class="bordered">
                                    CUTTING LINES
                                </td>
                                <td  class="bordered" style="width: 270px">
                                    ACTUAL MEASUREMENT
                                </td>
                            </tr>
                            <tr >
                                <td class="bright" style="height: 10px"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>1. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>2. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>3. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>4. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>5. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>6. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>7. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>8. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>9. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>10. ___________________________</td>
                            </tr>

                            <tr>
                                <td class="bright"></td>
                                <td>11. ___________________________</td>
                            </tr>
                            <tr>
                                <td class="bright"></td>
                                <td>12. ___________________________</td>
                            </tr>
                            <tr >
                                <td class="bright" style="height: 25px"></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 200px">
                        <table style="justify-content: end;">
                            <tr>
                                <td class="bbot" style="width: 200px">
                                    Time Start
                                </td>
                            </tr>
                            <tr>
                                <td  style="height: 100px">
                                
                                </td>
                            </tr>
                            <tr>
                                <td class="bbot">
                                    Time Finish
                                </td>
                            </tr>
                            <tr>
                                <td  style="height: 30px">
                                
                                </td>
                            </tr>
                        </table>
                        {{-- <div style="padding-bottom: 110px">
                            
                        </div>
                        <div style="padding-bottom: 30px">
                            
                        </div> --}}
                    </td>
                </tr>
            </table>
        </div>

    
        

    
        <div style="position: absolute;bottom:0;margin-bottom: -35px;width:100%">
            <i>Note: Tolerance ± 1MM.</i>
            <table style="width: 100%">
                <tr>
                    <td class="bbot" style="width: 370px">Cut by:</td>
                    <td style="width: 270px"></td>
                    <td class="bbot">Received by:</td>
                </tr>
                <tr style="text-align: center">
                    <td>Signature over Printed Name/Date</td>
                    <td></td>
                    <td>Signature over Printed Name/Date</td>
                </tr>
            </table>
        
        <p style="text-align: right;margin-top:-0.5px">RETENTION PERIOD: 1 MONTH</p>
        </div>
    @endfor
</body>

</html>