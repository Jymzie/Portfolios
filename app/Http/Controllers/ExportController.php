<?php

namespace App\Http\Controllers;
// use App\Models\ExportModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ExportSummary;
use App\Exceptions\CommonException;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // public  $export_model;

    // public function __construct(){
    //     $this->export_model = new ExportModel();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $req)
    {
 
       try{

        //   $count = $req['ex'];          
        // if($count == 1){     
        //     return $this->export_model->DSTNLinestList(); 
        // }else{
            session_start();
            $data = $_SESSION['scheddata'];
    
            $SummaryData = array_filter($data, function($item) use($req) {
                return $item['Line'] == $req->line && substr($item['REQUEST'], 2, 2) == $req->ww
                && substr($item['REQUEST'], 5, 2) == $req->yy && substr($item['REQUEST'], 7, 2) == $req->dstn;
            });
            if(count($SummaryData))
                return Excel::download(new ExportSummary($SummaryData), 'ExportSummaryPDF.xls');
            else{
                return response()->json("No data", 400);
            // }
        }         
       
    }catch (\Exception $e) {
        $err_data = ['Parameters' => $req->all(), 'Functions' => __FUNCTION__];
        // throw new CommonException($e, $err_data, 500);
    }
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return dd('create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return dd('store');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return dd('Show');
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
        return dd('Edit');
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
        return dd('Update');
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
