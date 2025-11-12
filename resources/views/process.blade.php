<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAMPLE PDF</title>
    <style>
      
        .image-br {
            position: absolute;
            /* justify-content: flex-start; */
            /* display:flex; */
            bottom: 0;
            right: 0;
        }
        .image-bl {
            position: absolute;
            /* justify-content: flex-start; */
            /* display:flex; */
            bottom: 0;
            left: 0;
        }
        .image-tr {
            position: absolute;
            /* justify-content: flex-start; */
            /* display:flex; */
            top: 0;
            right: 0;
        }
        .image-tl {
            position: absolute;
            /* justify-content: flex-start; */
            /* display:flex; */
            top: 0;
            left: 0;
        }
        .image-container img{
            width: 500px;
            height: 340px;
            margin-left: 5px;
            margin-bottom: 10px;
            bottom: 0;
        }
    </style>
</head>
<?php
    $direction = 0;
    $totalpic = 0;
  ?>
<body>
    
   
    @if(count($process) > 0)
        @for ($x=0;$x<count($process);$x++)
            @php
                $totalpic = $totalpic+$process[$x]->count;
            @endphp
        @endfor
        @for ($x=0;$x<count($process);$x++)
      
                @for($i=1;$i<=8;$i++)
                    @php
                        $propertyName = 'no' . $i;
                    @endphp
                    @if(isset($process[$x]->$propertyName))
                        @if( $direction == 0)
                            <div class="image-tl image-container">   
                                <img src="{{ public_path('images/'.$process[$x]->$propertyName.'.jpg') }}" alt="Image {{$i}}">                                             
                            </div>
                        @elseif($direction == 1)
                            <div class="image-bl image-container">
                                <img src="{{ public_path('images/'.$process[$x]->$propertyName.'.jpg') }}" alt="Image {{$i}}">
                            </div>
                        @elseif($direction == 2)
                            <div class="image-tr image-container">
                                <img src="{{ public_path('images/'.$process[$x]->$propertyName.'.jpg') }}" alt="Image {{$i}}">
                            </div>
                        @elseif($direction == 3)
                            <div class="image-br image-container">
                                <img src="{{ public_path('images/'.$process[$x]->$propertyName.'.jpg') }}" alt="Image {{$i}}">
                            </div>
                        @endif
                        @php
                            $direction++;
                            $totalpic--;
                        @endphp
                        @if($direction == 4 && $totalpic != 0)
                        <div style="page-break-after: always;"></div> 
                            @php
                                $direction = 0;
                            @endphp
                        @endif
                    @endif
                @endfor
                    
        @endfor
    @else
    <p>No process data available.</p>
    @endif


</body>
</html>
