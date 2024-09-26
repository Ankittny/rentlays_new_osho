

@extends('template')

@section('main')


    <style>
        .heightww{
            height: 300px;
        }

        .notfound {
  width: 1323px;
 
}
.thankbtm{
  margin-bottom: 20px;

}
    </style>

<div class="margin-top-85  thankbtm" >
    <div class="heightww ">
        <div class="error_width ">
          <div class="notfound position-center">
              <div class="notfound-404">
                <h1 style="font-size: 100px"><span>Thank you</span></h1>
              </div>

              <a href="{{url('properties')}}" class=" btn vbtn-outline-success text-14 font-weight-700 p-0 " style="padding: 10px !important;">Go Back to Property List</a>
            </div>
           
        </div>
      </div>
</div>
@endsection

@section('validation_script')

@endsection





