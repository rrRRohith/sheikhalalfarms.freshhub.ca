<form action="" method="get" id="filter_form">
    @csrf
    <div class="row">
        
        <div class="col-sm-6 col-lg-4">
            <label class="control-label">Duration: </label>
            <label class="input-radio"><input type="radio" name="duration" id="duration-1" class="duration" value="1" checked> All Time </label>
            <label class="input-radio"><input type="radio" name="duration" id="duration-2" class="duration" value="2" @if(request()->duration==2) checked @endif> Week </label>
            <label class="input-radio"><input type="radio" name="duration" id="duration-3" class="duration" value="3" @if(request()->duration==3) checked @endif> Day </label>
            <label class="input-radio"><input type="radio" name="duration" id="duration-4" class="duration" value="4" @if(request()->duration==4) checked @endif> Custom </label>
            <div id="all" style="@if(Request()->duration ==1 || !(isset(Request()->duration))) display:block; @else display:none;@endif">
                <input type="text" value="All time" class="form-control" style="background:url(/img/calendar.png) no-repeat right 5px center #eee !important;" disabled>
            </div>
            <div id="day" style="@if(Request()->day !='') display:block; @else display:none;@endif" >
                <input type="text" name="day" id="day1" autocomplete="off" placeholder="Select Date" value="{{Request()->day}}" class="form-control" style="background:url(/img/calendar.png) no-repeat right 5px center #FFF !important;">
            </div>
            <div id="week" style="@if(Request()->week !='') display:block; @else display:none;@endif" >
                <input type="text" name="week" id="week1" autocomplete="off" placeholder="Select Week"  value="{{Request()->week}}" class="form-control"  style="background:url(/img/calendar.png) no-repeat right 5px center #FFF !important;">
            </div>
            <div id="custom" style="@if(Request()->custom !='') display:block; @else display:none;@endif">
                <input type="text" name="custom" id="customd" autocomplete="off" placeholder="Select Date Period"  value="{{Request()->custom}}" class="form-control" style="background:url(/img/calendar.png) no-repeat right 5px center #FFF !important;">
            </div>
            
        </div>
        
        
        @if($submenu=='ReportByProduct')
        <div class="col-sm-6 col-lg-2">
         <label class="control-label">Category</label>
            <select name="category" id="category" class="form-control">
                <option value="">All</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}" @if(Request()->category==$category->id) selected @endif>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6 col-lg-2">
         <label class="control-label">Search By Name</label>
         <input type="text" name="search" class="form-control"  value="{{Request()->search ?? ''}}">
            
        </div>
        @endif
        <div class="col-sm-6 col-lg-2">
            <label class="control-label">Status</label>
            {{Request()->status}}
            <select name="status"  class="form-control">
                @if($submenu=='ReportByCustomer' || $submenu=='ReportByProduct')
                <option value="">All</option>
                <option value="1" @if(Request()->has('status') && Request()->status==1) selected @endif>Active</option>
                <option value="0" @if(Request()->has('status') && Request()->status==0) selected @endif>Inactive</option>
                @else
                <option value="">All</option>
                <option value="4" @if(Request()->status==4) selected @endif>Ready</option>
                <option value="5" @if(Request()->status==5) selected @endif>Dispatching</option>
                <option value="6" @if(Request()->status==6) selected @endif>Delivered</option>
                @endif
            </select>
        </div>
        @if($submenu=='ReportBySale')
        <div class="col-sm-6 col-lg-2">
            <label class="control-label">Report Type</label>
            <select name="reporttype"  class="form-control" id="reporttype">
                
                <option value="1" selected>Daily</option>
                <option value="2" @if(Request()->reporttype=='2') selected @endif>Weekly</option>
                <option value="3" @if(Request()->reporttype=='3') selected @endif>Monthly</option>
                <option value="4" @if(Request()->reporttype=='4') selected @endif>Invoice</option>
            </select>
        </div>
        @endif
        <div class="col-sm-12 col-lg-2">
           
            <button  class="white_button" type="submit">Get Report</button>
        </div>
    </div>
</form>