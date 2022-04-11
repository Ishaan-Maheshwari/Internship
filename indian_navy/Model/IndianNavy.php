<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class IndianNavy extends Model
{
    //Collection Name
    protected $collection = 'indian_navy';

    public function get_data($org_id){

    //callback function for raw query
       $func = function ($collection) use ($org_id) {
        return $collection->aggregate([
                [
                    '$match'=> ['ORG_ID'=> $org_id]
                ], [
                    '$group'=> ['_id'=> '$DOC_TYPE', 'Count'=> ['$sum'=> 1], 'YEAR'=> ['$addToSet'=> '$YEAR'] ]
                ]
            ]);
        };

    //Raw Mongo Aggregation Query 
    return $this->raw($func);
    }


    public function get_yearwise_data($org_id,$year){

        //callback function for raw query
        $func = function ($collection) use ($org_id,$year) {
         return $collection->aggregate([
                 [
                     '$match'=> ['ORG_ID'=> $org_id,'YEAR'=>$year]
                 ], [
                     '$group'=> ['_id'=> '$DOC_TYPE', 'Count'=> ['$sum'=> 1], 'YEAR'=> ['$addToSet'=> '$YEAR'] ]
                 ]
             ]);
        }; 

        return $this->raw($func);
     }

    
}