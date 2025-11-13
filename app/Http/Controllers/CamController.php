<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\JpegEncoder;
use Illuminate\Support\Facades\Storage;

class CamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = collect(Storage::disk('public')->allFiles('images'))
            ->filter(function ($file) {
                return Str::endsWith($file, '.jpg');
            })
            ->map(function ($file) {
                return basename($file,'.jpg');
            });

        return $files;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {

        $params = json_decode($req->params);
        $val = number_format(substr(substr($params->title, 7, 8),0,-4));
        $panelnum = substr($params->title, 0, 6);
       
       $success = 0;

        for($y=0; $y<$params->count;$y++){
            $image = file_get_contents($req['file'.$y]->getRealPath());
    //        $image =Image::read($req['file'.$y]->getRealPath())
    // ->encode(new JpegEncoder(100));
    // ->autoOrient();
             if($params->isretake){
          
                return Storage::disk('public')->put('images/'.$params->title, $image);
            
            }

            if(!Storage::disk('public')->exists('images/'.$params->title)){
                $success = Storage::disk('public')->put('images/'.$params->title, $image);
                continue;
            }

            for($x=1 ; $x < 9 ; $x++){
                    if(!Storage::disk('public')->exists('images/'.$panelnum.'_'.$x.'.jpg')){
                        $success = Storage::disk('public')->put('images/'.$panelnum.'_'.$x.'.jpg', $image);
                        break;
                    
                    }
            }
           
        }
           
        return $success;      

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $id)
    {   
        $process = json_decode($req->data);
        

        if ($id == 'preview') {
            $pdf = Pdf::loadView('process', compact('process'))
                ->setPaper('A4', 'landscape');
            // Storage::path('public/pdf/' . $imagepath . '/' . $nameCode . '.pdf', $pdf->output());
            return $pdf->stream('Sample' . '.pdf');
        } 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Storage::disk('public')->delete('images/'.$id.'.jpg');
        return $res;
    }
}
