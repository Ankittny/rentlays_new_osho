@extends('template')

@section('main')
    <div class="container-fluid container-fluid-90 min-height margin-top-85 mb-5">
        <div class="error_width " >
            <div class="row jutify-content-center position-center w-100 p-4 mt-4">
            <div class="text-center w-100">
                
                <div class="alert alert-primary mt-70  my" role="alert">
                    <br>
                    <img width="60" height="60" src="https://img.icons8.com/color/48/property.png" alt="property"/>
                    <p class="text-center ">  {{ __("The Property is currently waiting for verification  Once the admin verifies it, you’ll find this property here.") }}</p>
                   
                    <button class="btn vbtn-outline-success text-14 font-weight-700 p-0 mt-2 pl-4 pr-4 mb-4">
                        <p class="p-3 mb-0">  <img src="https://img.icons8.com/metro/26/000000/back.png" alt="back" class="gbicon"/> Go to Home</p>
                    </button>
                  </div>
                             
            </div>
        </div>
    </div>
    </div>
</div>
  </div>

@stop
