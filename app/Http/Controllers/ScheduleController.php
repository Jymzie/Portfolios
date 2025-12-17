<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportScheduledProducts;
// use App\Models\ScheduleModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CommonException;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    // public  $Schedule_model;

    // public function __construct(){
    //     $this->Schedule_model = new ScheduleModel();
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
       
        //ANCHOR Schedule Table
        try{
            if($req->has('type')){
                session_start();
                $raw = $_SESSION['scheddata'];
                
                $data = array_filter($raw, function($item) use($req) {
                    return isset($item['Line']) && $item['Line'] == $req->line;
                });

                
                // $data = $raw;
                usort($data, function($a, $b) {
                    // If both are undefined, keep current order
                    if (is_null($a['ProductionOrder']) && is_null($b['ProductionOrder'])) {
                        return 0;
                    }
                    
                    // If a is undefined, move it after b
                    if (is_null($a['ProductionOrder'])) {
                        return 1;
                    }
                    
                    // If b is undefined, move it after a
                    if (is_null($b['ProductionOrder'])) {
                        return -1;
                    }
                    
                    // Regular numeric comparison
                    return $a['ProductionOrder'] - $b['ProductionOrder'];
                });
              
                $count = count($data);
                //NOTE tile
                if($req->type == 'tilechecklist'){
                    $pdf = Pdf::loadView('tilechecklist', compact('data','count'))->setPaper('A4','landscape');
                    return $pdf->stream('TileCuttingChecklist.pdf');
                }  


                $info[0]['Line'] = $data[0]['Line'];
                $proddate = new DateTime($data[0]['ProductionScheduledDate']);
                $info[0]['ProductionScheduledDate'] = $proddate->format('Y/m/d');
                $info[0]['IssueDate'] = $proddate->modify('-1 day')->format('Y/m/d');
                $datetoday = new DateTime();
                $info[0]['DateToday'] = $datetoday->format('Y/m/d H:i:s');
                //NOTE setting schedule
                if($req->type == 'setsched'){
                    $pdf = Pdf::loadView('settingschedule', compact('data','count','info'))->setPaper('A4','landscape')->setOptions(['enable_php' => true]);
                    return $pdf->stream($req->line.'SettingSchedule.pdf');
                }
                 //NOTE cutting schedule
                if($req->type == 'cutsched'){
                    $pdf = Pdf::loadView('tilecuttingschedule', compact('data','count','info'))->setPaper('A4','portrait')->setOptions(['enable_php' => true]);
                    return $pdf->stream($req->line.'TileCuttingSchedule.pdf');
                }

                 //NOTE mis file
                // if($req->type == 'mis'){
                //     $sashrelated = [];
                //     $itemid = [];
                //     for($a=0;$a<$count;$a++){
                //         $get = $this->Schedule_model->GetSashRelatedHinban($data, $a);
                        
                
                //         if(count($get) != 0){
                //             for($b=0;$b<count($get);$b++){
                //                 $get[$b]->ProductionOrder = $data[$a]->ProductionOrder;
                //                 $get[$b]->NameCode = $data[$a]->NameCode;
                //                 $get[$b]->REQUEST = $data[$a]->REQUEST;
                //                 $get[$b]->cUNIT = $data[$a]->cUNIT;
        
                //                 // $compare = ["ZH-", "EH-", "ZHC", "EHC",
                //                 // "ZD-", "ED-", "ZB-", "EB-",
                //                 // "ZBC", "EBC", "ZS-", "ES-",
                //                 // "ZSC", "ESC", "YH-", "YHC",
                //                 // "YD-", "YB-", "YBC"];
                //                 // for($c=0;$c<count($compare);$c++){
                //                 //     if(substr($get[$a]->Hinban,0,3) == $compare[$c]){
                //                 //         $isSashTypeXL = True;
                //                 //     }
                //                 // }
        
                //                 $item = $this->Schedule_model->ItemId($get, $b);
                                
                //                 if(count($item) != 0){
                //                     $get[$b]->ItemId = $item[0]->ItemId;
                //                     $get[$b]->SupplierQtyUnit = $item[0]->SupplierQtyUnit;
                //                 }

        
                //             }
                //             $sashrelated = array_merge($sashrelated, $get);
                //         }
                            
                //     }
                //     if(count($sashrelated) == 0)
                //         return response()->json("Material Issuance Slip - No Issuance Request Data Found!", 400);
                
                //     $_SESSION['sashrelated'] = $sashrelated;
                //     return $sashrelated;
                // }
        
                // if($req->type == 'mis2'){
                //     $data =  $_SESSION['sashrelated'];
                //     $pdf = Pdf::loadView('mis', compact('data','info'))->setPaper('A4','landscape')->setOptions(['enable_php' => true]);
                //     return $pdf->stream('MaterialIssuanceSlip.pdf');
                // }
            }
            // else
            //     return $this->Schedule_model->ScheduleTable($req);
        }
        catch (\Exception $e) {
            $err_data = ['Parameters' => $req->all(), 'Functions' => __FUNCTION__];
            // throw new CommonException($e, $err_data, 500);
        }
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
        
        try{
            $data = $req->data;
           
            if($req->type == 'tempsession'){
                session_start();
                $_SESSION['scheddata'] = $data;
                return 1;
            }
            // if($req->type == 'editsched'){
            //     $new = '';
            //     if($req->has('newDate'))
            //         $new = $req->newDate;
            //     // return $new;
            //     return $this->Schedule_model->EditSched($data, $new);
            // }
            // if($req->type == 'editline'){
            //     return $this->Schedule_model->EditLine($data);
            // }
            // if($req->type == 'editorder'){
            //     return $this->Schedule_model->EditOrder($data);
            // }

            // if($req->type == 'addproductid'){
            //     return $this->Schedule_model->AddProductId($data);

            // }

            //NOTE export
            if($req->type == 'export'){
                return Excel::download(new ExportScheduledProducts($data), 'excel file for export.xls');
            }  
            
            if($req->has('count'))
            $count = $req->count;
        
            if($req->type == 'tilechecklist'){
                $pdf = Pdf::loadView('tilechecklist', compact('data','count'))->setPaper('A4','landscape');
                return $pdf->stream('tilecuttingchecklist.pdf');
            }  

            $info[0]['Line'] = $data[0]['Line'];
            $proddate = new DateTime($data[0]['ProductionScheduledDate']);
            $info[0]['ProductionScheduledDate'] = $proddate->format('Y/m/d');
            $info[0]['IssueDate'] = $proddate->modify('-1 day')->format('Y/m/d');
            $datetoday = new DateTime();
            $info[0]['DateToday'] = $datetoday->format('Y/m/d H:i:s');

             //NOTE setting schedule
            if($req->type == 'setsched'){
                $pdf = Pdf::loadView('settingschedule', compact('data','count','info'))->setPaper('A4','landscape')->setOptions(['enable_php' => true]);
                return $pdf->stream('SettingSchedule.pdf');
            }

             //NOTE cutting schedule
            if($req->type == 'cutsched'){
                $pdf = Pdf::loadView('tilecuttingschedule', compact('data','count','info'))->setPaper('A4','portrait')->setOptions(['enable_php' => true]);
                return $pdf->stream('tilecuttingschedule.pdf');
            }
           
             //NOTE mis file
            // if($req->type == 'mis'){
            //     $sashrelated = [];
            //     $itemid = [];
            //     for($a=0;$a<$count;$a++){
            //         $get = $this->Schedule_model->GetSashRelatedHinban($data, $a);
                    
              
            //         if(count($get) != 0){
            //             for($b=0;$b<count($get);$b++){
            //                 $get[$b]->ProductionOrder = $data[$a]['ProductionOrder'];
            //                 $get[$b]->NameCode = $data[$a]['NameCode'];
            //                 $get[$b]->REQUEST = $data[$a]['REQUEST'];
            //                 $get[$b]->cUNIT = $data[$a]['cUNIT'];
    
                            // $compare = ["ZH-", "EH-", "ZHC", "EHC",
                            // "ZD-", "ED-", "ZB-", "EB-",
                            // "ZBC", "EBC", "ZS-", "ES-",
                            // "ZSC", "ESC", "YH-", "YHC",
                            // "YD-", "YB-", "YBC"];
                            // for($c=0;$c<count($compare);$c++){
                            //     if(substr($get[$a]->Hinban,0,3) == $compare[$c]){
                            //         $isSashTypeXL = True;
                            //     }
                            // }
    
                    //         $item = $this->Schedule_model->ItemId($get, $b);
                            
                    //         if(count($item) != 0){
                    //             $get[$b]->ItemId = $item[0]->ItemId;
                    //             $get[$b]->SupplierQtyUnit = $item[0]->SupplierQtyUnit;
                    //         }

    
                    //     }
                    //     $sashrelated = array_merge($sashrelated, $get);
                    // }
                        
                // }
                // if(count($sashrelated) == 0)
                //     return response()->json("Material Issuance Slip - No Issuance Request Data Found!", 400);
              
                // $data = $sashrelated;
    
    
                // $pdf = Pdf::loadView('mis', compact('data','info'))->setPaper('A4','landscape')->setOptions(['enable_php' => true]);
                // return $pdf->stream('mis.pdf');
            // }
           
          
        }

        catch (\Exception $e) {
            DB::rollBack();
            $err_data = ['Parameters' => $req->all(), 'Functions' => __FUNCTION__];
            // throw new CommonException($e, $err_data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $id)
    {

        try{
            if($id == 'reqcode')
                return $this->Schedule_model->GetReqCode();
            if($id == 'line')
                return $this->Schedule_model->GetLine();
            if($id == 'productline')
                return $this->Schedule_model->GetProductLine();
        }
        catch (\Exception $e) {
            $err_data = ['Parameters' => $req->all(), 'Functions' => __FUNCTION__];
            throw new CommonException($e, $err_data, 500);
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
        //
    }
}
