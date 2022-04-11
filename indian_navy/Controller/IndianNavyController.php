<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndianNavy;

class IndianNavyController extends Controller
{
    public function index(Request $request){

        $org_id = $request->input('org_id');
        $year = $request->input('year',-1);

        $navydb = new IndianNavy();
        $response = ["status" => 'failed'];

        if($org_id != null){
            $result = $navydb->get_data($org_id);

            //Response Format
            $response['status']='success';
            $response['data'] = ['Total_Certificate'=>0, 'Total_Marksheet'=>0, 'Total_Awards'=>0, 'Years'=>''];

            foreach($result as $resultline){
                if($resultline->_id == 'NVMST'){
                    $response['data']['Total_Marksheet'] = $resultline->Count;
                    $response['data']['Total_Awards'] += $resultline->Count;
                    $response['data']['Years'] = $resultline->YEAR;
                }

                if($resultline->_id == 'NVCER'){
                    $response['data']['Total_Certificate'] = $resultline->Count;
                    $response['data']['Total_Awards'] += $resultline->Count;
                }
            }

            if($year != -1 && $year != null){
                $yearwise_result = $navydb->get_yearwise_data($org_id,$year);
                $response['yearwise_data'] = ['Total_Certificate'=>0, 'Total_Marksheet'=>0, 'Total_Awards'=>0, 'Years'=>''];
                foreach($yearwise_result as $resultline){
                    if($resultline->_id == 'NVMST'){
                        $response['yearwise_data']['Total_Marksheet'] = $resultline->Count;
                        $response['yearwise_data']['Total_Awards'] += $resultline->Count;
                        $response['yearwise_data']['Years'] = $resultline->YEAR;
                    }
                    if($resultline->_id == 'NVCER'){
                        $response['yearwise_data']['Total_Certificate'] = $resultline->Count;
                        $response['yearwise_data']['Total_Awards'] += $resultline->Count;
                    }
                }
            }
        }
        
        
        return  response()->json($response);
    }
}
