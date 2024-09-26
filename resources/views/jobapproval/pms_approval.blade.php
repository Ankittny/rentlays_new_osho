<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Service</title>
<style>
  /* Basic CSS for layout */
  .payment-info {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
  }
  .owner-info {
    margin-top: 20px;
  }
  .payment-button {
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }
</style>
</head>
   
<body>
  <div class="payment-info">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h2>Rentlay Payment Service</h2>
        <p>Owner Name: {{$result->first_name . ' ' . $result->last_name}}</p>
        <p>Email: {{$result->email}}</p>
        <p>Phone: {{$result->phone}}</p>
    @if($get_job_id->status == 'approved')
    <form action="{{url('paynow')}}" method="post">
        @csrf
        <input type="hidden" name="type" id="job_id" value="pms">
        <input type="hidden" name="job_id" id="job_id" value="{{$get_job_id->job_id}}">
        <input type="hidden" name="user_id" id="user_id" value="{{$get_job_id->user_id}}">
        <input type="hidden" name="payable_amount" id="payable_amount" value="{{$get_job_id->payable_amount}}">
        <input type="hidden" name="payment_method_id" id="payment_method_id" value="4">
        
      {{-- <input type="text" name="remark" id="remark" placeholder="Remark"> --}}
      <button class="payment-button">{{$get_job_id->payable_amount}} Payment Now</button>
  </form>
    @elseif($get_job_id->status == 'rejected')
        <p>Payment Status: {{$get_job_id->status}}</p>
    @else
    <form action="{{url('update-job-approval')}}" method="post">
          @csrf
          <input type="hidden" name="type" value="pms">
          <input type="hidden" name="job_id" id="job_id" value="{{$get_job_id->job_id}}">
            <select class="form-control" name="status">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        <input type="hidden" name="remark" id="remark" placeholder="Remark">
        <button class="payment-button">{{$get_job_id->payable_amount}}Approved Payment</button>
    </form>
   @endif
  </div>
</body>
</html>
