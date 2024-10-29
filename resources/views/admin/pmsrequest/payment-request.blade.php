<!doctype html>
<html lang="en">
  <head>
    <title>Payment Request</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="/public/backend/dist/img/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      .card-header {
        background-color: #3498db;
        color: white;
        padding: 20px;
        text-align: center;
      }
      .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        padding: 16px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h2>Payment Request</h2>
            </div>
            <div class="card-body">
              @php
                $totalCost = 0;
                $amenitiesStatus = json_decode($data["amenities_status"], true);
                $working = json_decode($data["working"], true);
                $repairStatus = json_decode($data["repair_status"], true);
                $estimatedCost = json_decode($data["estimated_cost"], true);
            @endphp
              <table class="table">
                <thead>
                  <tr>
                    <th>Amenity Name</th>
                    <th>Estimated Cost</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($amenitiesStatus as $key => $status)
                    @if ($status === "yes" && isset($working[$key]) && $working[$key] === "not_working" && isset($repairStatus[$key]) && $repairStatus[$key] === "in_repairing" && isset($estimatedCost[$key]) && !empty($estimatedCost[$key]))
                      @php
                          $cost = floatval($estimatedCost[$key]);
                          $totalCost += $cost;
                      @endphp
                      <tr>
                        <td>{{ App\Models\Amenities::find($key)->title }}</td>
                        <td>₹{{ number_format($cost, 2) }}</td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
              <p>Total Cost: ₹{{ number_format($totalCost, 2) }}</p>
              <form action="{{ route('amount-pay') }}" method="POST">
                @csrf
                <input type="hidden" name="unique_id" value="{{ 'pay_' . $data->property_id . '_' . Str::uuid() }}">
                <input type="hidden" name="property_id" value="{{$data->property_id}}">
                <input type="hidden" name="amount" value="{{ $totalCost }}">
                <div class="text-center">
                  <button type="submit" name="status" value="pay" class="btn btn-success mr-2">Pay</button>
                  <button type="submit" name="status" value="cancel" class="btn btn-danger">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6Jty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

