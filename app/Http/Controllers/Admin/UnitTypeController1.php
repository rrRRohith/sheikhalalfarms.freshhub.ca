<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Unit;
use App\Weight;

class UnitTypeController1 extends Controller
{

    public function index(Request $request)
    {
        $title="Unit Type";
        $submenu="Unit Type";
        
        return view('admin.unittype.index1',compact('title','submenu'));
    }
    public function defer(Request $request){
        /*
         * Get search key if requested.
         */
        $key = $request->get('key');
        if($key)
            $unittypes = Unit::sortable()->where('name', 'LIKE', '%'.$key.'%')->orWhere('shortcode','like','%'.$key.'%')->orderBy('id','asc')->paginate(10);
        else
            $unittypes = Unit::sortable()->orderBy('id','asc')->paginate(10);
        return [
            'data' => UnitResource::collection($unittypes),
            'links' => (string) $unittypes->links(),
        ];
    }
    public function create()
    {
        $title="Unit Type";
        $submenu="Unit Type";
        return view('admin.unittype.form',compact('submenu','title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'bail|required|unique:units,name',
            'code' => 'bail|required|max:3|unique:units,shortcode'
            ]);
        $unittype=new Unit();
        $unittype->name=$request->name;
        $unittype->shortcode=$request->code;
        $unittype->status=$request->has('status') ? 1 : 0;
        try
        {
            $unittype->save();
            return redirect('admin/unittype')->with('message',"Unit Type Added Successfully");
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        $title="Unit Type";
        $submenu="Unit Type";
        $unittype=Unit::find($id);
        return view('admin.unittype.form',compact('submenu','title','unittype'));
    }
    public function update(Request $request,$id)
    {
        
        $request->validate([
            'name'   => 'bail|required|unique:units,name,'. $id,
            'code' => 'bail|required|max:3|unique:units,shortcode,'. $id
            ]);
            
        $unittype=Unit::find($id);  
        $unittype->name=$request->name;
        $unittype->shortcode=$request->code;
        $unittype->status=$request->has('status') ? 1 : 0;
        
        try
        {
            $unittype->save();
            
            return redirect(admin_url('unittype'))->with('message',"Unit Type Updated Successfully");
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $unittype=Unit::find($id);
        try
        {
            $unittype->delete();
            return redirect('admin/unittype')->with('message',"Unit Type Deleted Successfully");
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
    }
    public function changeStatus($id)
    {
        $unittype=Unit::find($id);
        $unittype->status=($unittype->status==0) ? 1 : 0;
        try
        {
        $unittype->save();
        return redirect()->back()->with('message',"Unit Type Status Updated Successfully");
        }
        catch(Exception $e)
        {
            
        }
        
    }
    public function getWeight()
    {
        $title="Weight";
        $submenu="Weight";
        $weights=Weight::paginate(10);
        return view('admin.weight',compact('title','submenu','weights'));
    }
    public function changeBaseWeight($id)
    {
        $weight=Weight::find($id);
        $base=$weight->base;
        $weight->base=($base==1) ? 0 : 1;
        $weight->save();
        $weights=Weight::where('id','!=',$id)->update(['base'=>($base==1) ? 1 : 0]);
        
        return redirect()->back()->with('message',"Successfully set the default weight");
    }
}
