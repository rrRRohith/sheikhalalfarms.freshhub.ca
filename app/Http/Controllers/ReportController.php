<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use App\Order;
use App\Category;
use DB;

class ReportController extends Controller
{
    public function product()
    {
        $id=Auth::id();
        $where='';
        // $productquery=Product::with(['category','orderitem'=>function($query) use($id){$query->with(['invoice'=>function($query1) use($id){$query1->where('status','>=',0);$query1->where('customer_id',$id);}]);}]);
        if(Request()->duration==2)
        {
            $weeks=Request()->week;
            $week=explode('to',$weeks);
            $where.=" AND date(oi.created_at) >='". $week[0] . "'AND date(oi.created_at) <='". $week[1]."'";
            // $productquery->whereHas('orderitem',function($query)use($week){$query->whereDate('created_at','>=',$week[0]);$query->whereDate('created_at','<=',$week[1]);});
        }
        else if(Request()->duration==3)
        {
            $day=Request()->day;
            $where.=" AND date(oi.created_at) >='". $day . "'";
            // $productquery->whereHas('orderitem',function($query)use($day){$query->whereDate('created_at',$day);});
        }
        else if(Request()->duration==4)
        {
            $days=Request()->custom;
            $day=explode('to',$days);
            $where.=" AND date(oi.created_at) >='". $day[0] . "'AND date(oi.created_at) <='". $day[1]."'";
            // $productquery->whereHas('orderitem',function($query)use($day){$query->whereDate('created_at','>=',$day[0]);$query->whereDate('created_at','<=',$day[1]);});
        }
        if(Request()->has('status') && Request()->status !='')
        {
            $status=Request()->status;
            $where.=" and p.status='". $status. "'";
            // $productquery->where('status',Request()->status);
        }
        if(Request()->has('category') && Request()->category !='')
        {
            $category=Request()->category;
            $where.=" and p.category_id='". $category ."'";
            // $productquery->where('category_id',Request()->category);
        }
        // $products=$productquery->get();
        $products=DB::select("SELECT oi.product_id as id,oi.product_name as name,oi.product_sku as sku,sum(oi.quantity) as quantity,oi.rate as price,oi.price_by,sum(oi.weight) as weight FROM products p 
                join order_items oi on oi.product_id=p.id 
                JOIN invoices i on i.order_id=oi.order_id 
                where i.customer_id=".$id. " and i.status >=0" .$where. " GROUP BY p.id
                ");
        $categories=Category::get();
        $submenu="ReportByProduct";
        $title="Reports";
        return view('customers.reports.products',compact('products','submenu','title','categories'));
    }
    
    
    public function sale()
    {
        if(Request()->reporttype==2)
            $sales=$this->sales_weekly(request()->all());
        else if(Request()->reporttype==3)
            $sales=$this->sales_monthly(request()->all());
        else if(Request()->reporttype==4)
            $sales=$this->sales_invoice(request()->all());
        else
            $sales=$this->sales_daily(request()->all());
        $categories=Category::where('status',1)->get();
        $submenu="ReportBySale";
        $title="Reports";
        return view('customers.reports.sales',compact('sales','submenu','title','categories'));
    }
    
    public function sales_daily($filters) {
        $id=Auth::id();
        $where = '';
        
        if(!empty($filters['status']) && $filters['status'] != '')  {
            $where .= ' AND orders.status ='. $filters['status'];
        }
        if(!empty($filters['duration']) && $filters['duration'] != 1)  {
            if($filters['duration'] == 2)
            {
                $weeks=$filters['week'];
                $week=explode('to',$weeks);
                $where .=" AND date(invoices.created_at) >='". $week[0] . "'AND date(invoices.created_at) <='". $week[1]."'";
            }
            elseif($filters['duration'] == 3)
            {
                $day=$filters['day'];
                $where .=" AND date(invoices.created_at) ='". $day."'";
            }
            elseif($filters['duration'] == 4)
            {
                $days=$filters['custom'];
                $day=explode('to',$days);
                $where .=" AND date(invoices.created_at) >='". $day[0] . "'AND date(invoices.created_at) <='". $day[1]."'";
            }
        }

        
        $sales=DB::select("SELECT date(invoices.created_at) AS invoice_date, COUNT(orders.id) AS orders, SUM(items.totals) AS items,SUM(invoices.sub_total) as sub_total,sum(invoices.grand_total) as grand_total,sum(invoices.discount) as discount,sum(invoices.tax) as tax FROM `invoices`
                        LEFT JOIN orders ON invoices.order_id=orders.id
                        LEFT JOIN (SELECT *,SUM(quantity) AS totals FROM order_items GROUP BY order_id) AS items ON invoices.order_id=items.order_id
                        WHERE orders.user_id = ".$id." AND invoices.status >= 0 ".$where.
                        " GROUP BY invoice_date");
        return $sales;
        
    }
    
    public function sales_weekly($filters) {
        $id=Auth::id();
        $where = '';
        if(!empty($filters['status']) && $filters['status'] != '')  {
            $where .= ' AND orders.status ='. $filters['status'];
        }
        if(!empty($filters['duration']) && $filters['duration'] != 1)  {
            if($filters['duration'] == 2)
            {
                $weeks=$filters['week'];
                $week=explode('to',$weeks);
                $where .=" AND date(invoices.created_at) >='". $week[0] . "'AND date(invoices.created_at) <='". $week[1]."'";
            }
            elseif($filters['duration'] == 3)
            {
                $day=$filters['day'];
                $where .=" AND date(invoices.created_at) ='". $day ."'";
            }
            elseif($filters['duration'] == 4)
            {
                $days=$filters['custom'];
                $day=explode('to',$days);
                $where .=" AND date(invoices.created_at) >='". $day[0] . "'AND date(invoices.created_at) <='". $day[1]."'";
            }
        }
        $sales = DB::select("SELECT week(invoices.created_at) AS week, COUNT(orders.id) AS orders, SUM(items.totals) AS items,SUM(invoices.sub_total) as sub_total,sum(invoices.grand_total) as grand_total,sum(invoices.discount) as discount,sum(invoices.tax) as tax FROM `invoices`
                        LEFT JOIN orders ON invoices.order_id=orders.id
                        LEFT JOIN (SELECT *,SUM(quantity) AS totals FROM order_items GROUP BY order_id) AS items ON invoices.order_id=items.order_id
                        WHERE orders.user_id = ".$id." AND invoices.status >= 0 ".$where.
                        " GROUP BY week");
        
        return $sales;
    }
    
    public function sales_monthly($filters) {
        $id=Auth::id();
        $where = '';
        if(!empty($filters['status']) && $filters['status'] != '')  {
            $where .= ' AND orders.status ='. $filters['status'];
        }
        if(!empty($filters['duration']) && $filters['duration'] != 1)  {
            if($filters['duration'] == 2)
            {
                $weeks=$filters['week'];
                $week=explode('to',$weeks);
                $where .=" AND date(invoices.created_at) >='". $week[0] . "'AND date(invoices.created_at) <='". $week[1]."'";
            }
            elseif($filters['duration'] == 3)
            {
                $day=$filters['day'];
                $where .=" AND date(invoices.created_at) ='". $day."'";
            }
            elseif($filters['duration'] == 4)
            {
                $days=$filters['custom'];
                $day=explode('to',$days);
                $from=trim($day[0]);
                $to=trim($day[1]);
                $where .=" AND date(invoices.created_at) >= '". $from . "' AND date(invoices.created_at) <= '". $to ."'";
            }
        }
        $sales = DB::select("SELECT month(invoices.created_at) AS month, COUNT(orders.id) AS orders, SUM(items.totals) AS items,SUM(invoices.sub_total) as sub_total,sum(invoices.grand_total) as grand_total,sum(invoices.discount) as discount,sum(invoices.tax) as tax FROM `invoices`
                        LEFT JOIN orders ON invoices.order_id=orders.id
                        LEFT JOIN (SELECT *,SUM(quantity) AS totals FROM order_items GROUP BY order_id) AS items ON invoices.order_id=items.order_id
                        WHERE orders.user_id = ".$id." AND invoices.status >= 0 ".$where.
                        " GROUP BY month");
        
        return $sales;
    }
    
    public function sales_invoice($filters) {
        $id=Auth::id();
         $where = '';
        if(!empty($filters['status']) && $filters['status'] != '')  {
            $where .= ' AND orders.status ='. $filters['status'];
        }
        if(!empty($filters['duration']) && $filters['duration'] != 1)  {
            if($filters['duration'] == 2)
            {
                $weeks=$filters['week'];
                $week=explode('to',$weeks);
                $where .=" AND date(invoices.created_at) >='". $week[0] . "'AND date(invoices.created_at) <='". $week[1]."'";
            }
            elseif($filters['duration'] == 3)
            {
                $day=$filters['day'];
                $where .=" AND date(invoices.created_at) ='". $day."'";
            }
            elseif($filters['duration'] == 4)
            {
                $days=$filters['custom'];
                $day=explode('to',$days);
                $from=trim($day[0]);
                $to=trim($day[1]);
                $where .=" AND date(invoices.created_at) >= '". $from . "' AND date(invoices.created_at) <= '". $to ."'";
            }
        }
        $sales = DB::select("SELECT invoice_number AS invno, COUNT(orders.id) AS orders, (SELECT SUM(order_items.quantity) AS items FROM order_items WHERE order_id=invoices.order_id GROUP BY order_items.order_id) AS items,SUM(invoices.sub_total) as sub_total,sum(invoices.grand_total) as grand_total,sum(invoices.discount) as discount,sum(invoices.tax) as tax FROM `invoices` 
                    LEFT JOIN orders ON invoices.order_id=orders.id
                    WHERE orders.user_id = ".$id." AND invoices.status >= 0 ".$where.
                    " GROUP BY invoices.id");
        
        return $sales;
    }
    
    
    
    
    
}
?>

