<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $files = collect(Storage::disk('public')->allFiles('image'))
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
        // $val = number_format(substr(substr($params->title, 7, 8),0,-4));
        $panelnum = substr($params->title, 0, 6);
        if($params->isretake){
          
            return Storage::disk('public')->put($params->path.'/'.$params->title, file_get_contents($req->file->getRealPath()));
        
        }else{
            if(!Storage::disk('public')->exists($params->path.'/'.$params->title) && strlen($params->title)>=7)
                return Storage::disk('public')->put($params->path.'/'.$params->title, file_get_contents($req->file->getRealPath()));
            for($x=1 ; $x < 9 ; $x++){
                if(!Storage::disk('public')->exists($params->path.'/'. $panelnum.'_'.$x.'.jpg')){
                    return Storage::disk('public')->put($params->path.'/'. $panelnum.'_'.$x.'.jpg', file_get_contents($req->file->getRealPath()));
                    break;
                
                }
        }

       
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
