<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class IndianNavy extends Model
{
    //Collection Name
    protected $collection = 'indian_navy';

    //method to get total award count on an org_id
    public function get_data($org_id){
        return $this->where('ORG_ID',$org_id)->groupBy('DOC_TYPE')->aggregate('count',['DOC_TYPE'])->get();
    }


    //method to get yearwise total award count on an org_id
    public function get_yearwise_data($org_id,$year){
        return $this->where(['ORG_ID'=> $org_id,'YEAR'=>$year])->groupBy('DOC_TYPE')->aggregate('count',['DOC_TYPE'])->get();
     }

    
}
