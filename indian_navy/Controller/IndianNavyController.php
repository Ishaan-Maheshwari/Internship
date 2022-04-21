<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndianNavy;

class IndianNavyController extends Controller
{
    public function index(Request $request){

        //extracting request parameters
        $org_id = $request->input('org_id');
        $year = (string)$request->input('year',-1);

        //Model object
        $navydb = new IndianNavy();
        //Format for failed api response
        $response = ["status" => 'failed'];

        if($org_id != null){

            $result = $navydb->get_data($org_id);
           
            //Response Format
            $response['status']='success';
            $response['data'] = ['Total_Certificate'=>0, 'Total_Marksheet'=>0, 'Total_Awards'=>0];

            foreach($result as $resultline){
                if($resultline->DOC_TYPE == 'NVMST'){
                    $response['data']['Total_Marksheet'] = $resultline->aggregate;
                    $response['data']['Total_Awards'] += $resultline->aggregate;
                }

                if($resultline->DOC_TYPE == 'NVCER'){
                    $response['data']['Total_Certificate'] = $resultline->aggregate;
                    $response['data']['Total_Awards'] += $resultline->aggregate;
                }
            }

            //Total Awards yearwise
            if($year != "-1" && $year != null){
                $yearwise_result = $navydb->get_yearwise_data($org_id,$year);
                $response['yearwise_data'] = ['Total_Certificate'=>0, 'Total_Marksheet'=>0, 'Total_Awards'=>0];
                foreach($yearwise_result as $resultline){
                    if($resultline->DOC_TYPE == 'NVMST'){
                        $response['yearwise_data']['Total_Marksheet'] = $resultline->aggregate;
                        $response['yearwise_data']['Total_Awards'] += $resultline->aggregate;
                    }
                    if($resultline->DOC_TYPE == 'NVCER'){
                        $response['yearwise_data']['Total_Certificate'] = $resultline->aggregate;
                        $response['yearwise_data']['Total_Awards'] += $resultline->aggregate;
                    }
                }
            }
        }
        
        
        return  response()->json($response);
    }
}
