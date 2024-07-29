<?php
namespace App\Helpers;
use \Auth;
use App\Weight;
class Helper{
    public static function storeWeight($qty)
    {
        $weight=Weight::where('base',1)->first();
        $storeqty=$qty*$weight->value;
        return($storeqty); 
    }
    public static function getWeight($qty)
    {
        $weight=Weight::where('base',1)->first();
        $getqty=$qty/$weight->value;
        return(round($getqty,2)); 
    }
    public static function defaultWeight()
    {
        $weight=Weight::where('base',1)->first();
        return($weight->value);
    }
    
}
?>