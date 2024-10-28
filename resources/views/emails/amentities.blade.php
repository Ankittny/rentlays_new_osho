<!doctype html>
<html lang="en">
  <head>
    <title>Amenities Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5 w-75 mx-auto" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6;">
        <p class="lead">Invoice for Customer:</p>
        <div class="mb-4">
            <strong>Name:</strong> {{$user->first_name}} {{$user->last_name}}<br>
            <strong>Email:</strong> {{$user->email}}<br>
            <strong>Telephone:</strong> {{$user->phone}}<br>
            <strong>Country:</strong> {{$user->country}}
        </div>
    
        <h3 class="border-bottom pb-2 mb-4">Invoice Summary</h3>
    
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Key</th>
                    <th scope="col">Amenities Status</th>
                    <th scope="col">Working Status</th>
                    <th scope="col">Repair Status</th>
                    <th scope="col">Estimated Cost</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalCost = 0;
                    $amenitiesStatus = json_decode($data["amenities_status"], true);
                    $working = json_decode($data["working"], true);
                    $repairStatus = json_decode($data["repair_status"], true);
                    $estimatedCost = json_decode($data["estimated_cost"], true);
                @endphp

                @foreach ($amenitiesStatus as $key => $status)
                    @if ($status === "yes" && isset($working[$key]) && $working[$key] === "not_working" && isset($repairStatus[$key]) && $repairStatus[$key] === "in_repairing" && isset($estimatedCost[$key]) && !empty($estimatedCost[$key]))
                        @php
                            $cost = floatval($estimatedCost[$key]);
                            $totalCost += $cost;
                        @endphp
                        <tr>
                            <td>{{ App\Models\Amenities::find($key)->title }}</td>
                            <td>{{ ucfirst($status) }}</td>
                            <td>{{ $working[$key] === 'not_working' ? 'Not Working' : ucfirst($working[$key]) }}</td>
                            <td>{{ $repairStatus[$key] === 'in_repairing' ? 'In Repairing' : ucfirst($repairStatus[$key]) }}</td>
                            <td>₹{{ number_format($cost, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <h3 class="text-right mt-4">Total Cost: ₹{{ number_format($totalCost, 2) }}</h3>
        @isset($paymentLink)
        <div class="text-center mt-4">
            <a class="btn btn-primary" href="{{$paymentLink ?? null}}" class="btn btn-success">Payment link </a>
        </div>
        @endisset
    </div>
  </body>
</html>

