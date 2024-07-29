<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use App\Order;
use App\Category;
use App\Invoice;
use App\OrderItem;
use App\Stock;
use DB;

class ReportController extends Controller
{
    public function customer()
    {
        // $customers = DB::table('users')->select('users.firstname','users.lastname',DB::Raw('COUNT(orders.id) AS torders'),DB::Raw('COUNT(order_items.id) AS items'),DB::Raw('sum(orders.grand_total) as grandtotal')) 
                // ->leftJoin('orders','users.id','=','orders.user_id')->leftJoin('order_items','orders.id','=','order_items.order_id')->groupBy('users.id')->get();
                // $customers=User::with(['invoice'=>function($query){$query->with('item');}])->where(['type'=>'customer'])->get();
                // die(print_r($customers));
        $customerquery=User::with(['invoice'=>function($query){$query->with('item');$query->where('status','>=',0);},'order']);
        // $customerquery=User::with(['order'=>function($query){$query->with('item');}]);
        if(Request()->duration==2)
        {
            $weeks=Request()->week;
            $week=explode('to',$weeks);
            $customerquery->whereHas('order',function($query)use($week){$query->whereDate('order_date','>=',$week[0]);$query->whereDate('order_date','<=',$week[1]);});
            
        }
        else if(Request()->duration==3)
        {
            $day=Request()->day;
            $customerquery->whereHas('order',function($query)use($day){$query->whereDate('order_date',$day);$query->where('status','>=',0);});
        }
        else if(Request()->duration==4)
        {
            $days=Request()->custom;
            $day=explode('to',$days);
            $customerquery->whereHas('order',function($query)use($day){$query->whereDate('order_date','>=',$day[0]);$query->whereDate('order_date','<=',$day[1]);});
        }
        if(Request()->has('status') && Request()->status !='')
        {
            $customerquery->where('status',Request()->status);
        }
        
        $customers=$customerquery->where(['type'=>'customer'])->get();
        // die(print_r($customers));
        $categories=Category::where('status',1)->get();
        $submenu="ReportByCustomer";
        $title="Reports";
        return view('admin.reports.customers',compact('customers','submenu','title','categories'));
    }
    public function product()
    {
        $where='';
        // $productquery=Product::with(['category','orderitem'=>function($query){$query->with(['invoice'=>function($query1){$query1->where('status','>=',0);}]);}]);
        // if(Request()->duration==2)
        // {
        //     $weeks=Request()->week;
        //     $week=explode('to',$weeks);
        //     $productquery->whereHas('orderitem',function($query)use($week){$query->whereDate('created_at','>=',$week[0]);$query->whereDate('created_at','<=',$week[1]);});
        // }
        // else if(Request()->duration==3)
        // {
        //     $day=Request()->day;
        //     $productquery->whereHas('orderitem',function($query)use($day){$query->whereDate('created_at',$day);});
        // }
        // else if(Request()->duration==4)
        // {
        //     $days=Request()->custom;
        //     $day=explode('to',$days);
        //     $productquery->whereHas('orderitem',function($query)use($day){$query->whereDate('created_at','>=',$day[0]);$query->whereDate('created_at','<=',$day[1]);});
        // }
        // if(Request()->has('status') && Request()->status !='')
        // {
        //     $productquery->where('status',Request()->status);
        // }
        // if(Request()->has('category') && Request()->category !='')
        // {
        //     $productquery->where('category_id',Request()->category);
        // }
        // $products=$productquery->get();
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
        if(Request()->has('search') && Request()->search !='')
        {
            $search=Request()->search;
            $where.=" and oi.product_name LIKE '%". $search ."%'";
        }
        // $products=$productquery->get();
        $products=DB::select("SELECT oi.product_id as id,oi.product_name as name,oi.product_sku as sku,sum(oi.quantity) as quantity,oi.rate as price,oi.price_by,sum(oi.weight) as weight FROM products p 
                join order_items oi on oi.product_id=p.id 
                JOIN invoices i on i.order_id=oi.order_id 
                where i.status >= 0" .$where. " GROUP BY p.id
                ");
        // die(print_r($products));
        $categories=Category::get();
        $submenu="ReportByProduct";
        $title="Reports";
        return view('admin.reports.products',compact('products','submenu','title','categories'));
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
        return view('admin.reports.sales',compact('sales','submenu','title','categories'));
    }
    
    public function sales_daily($filters) {
        
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
                        WHERE invoices.status >= 0 ".$where.
                        " GROUP BY invoice_date");
        return $sales;
        
    }
    
    public function sales_weekly($filters) {
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
                        WHERE invoices.status >= 0 ".$where.
                        " GROUP BY week");
        
        return $sales;
    }
    
    public function sales_monthly($filters) {
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
                        WHERE invoices.status >= 0 ".$where.
                        " GROUP BY month");
        
        return $sales;
    }
    
    public function sales_invoice($filters) {
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
                    WHERE invoices.status >= 0 ".$where.
                    " GROUP BY invoices.id");
        
        return $sales;
    }
    public function orderList()
    {
        $id=Request()->id;
        $shop=User::where('id',$id)->first();
        $orders=Invoice::where('customer_id',$id)->get();
        return view('admin.reports.orderlist',compact('orders','shop'));
    }
    public function orderView()

    {
        $id=Request()->id;
        $order=Order::where('id',$id)->first();

        //$customer=User::where('id',$order->user_id)->first() or abort(404);

        $orderitems=OrderItem::join('products','products.id','=','order_items.product_id')->where('order_items.order_id',$id)->get();

        $invoice=Invoice::with(['order'=>function($query){$query->with(['billing','delivery','item'=>function($q){$q->with('product');}]);},'user'])->where('id',$id)->first();

        $stocks=Stock::get();

        $submenu="Invoice";

          $title="Order";

        

        return view('admin.reports.orderview',compact('stocks','order','submenu','title','invoice'));

    }
    
    
    
    
}
?>

