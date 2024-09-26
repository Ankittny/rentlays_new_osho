<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .invoice-container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-header img {
            max-width: 150px;
        }
        .invoice-header h1 {
            font-size: 24px;
            margin: 0;
        }
        .invoice-details {
            margin-top: 20px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details th, .invoice-details td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .invoice-details th {
            background-color: #f5f5f5;
        }
        .invoice-total {
            margin-top: 20px;
            text-align: right;
        }
        .invoice-total p {
            font-size: 18px;
            margin: 0;
        }
        .invoice-notes {
            margin-top: 20px;
        }
        .invoice-notes p {
            margin: 0;
        }
    </style>
</head>
<body>
    @php
        $user = \App\Models\User::find($invoice->customer_id);
        $jobitem = \App\Models\PmsJobsItems::where('pms_job_id',$invoice->job_id)->get();
        $userdetails = \App\Models\UserDetails::where('user_id',$invoice->customer_id)->first();
    @endphp
    <div class="invoice-container">
        <div class="invoice-header">
            <img src="{{ asset('public/front/images/logos/1717060043_logo.png') }}" alt="Company Logo">
            <h1>Rentalys Invoice</h1>
        </div>
        <div class="invoice-details">
            <table>
                <tr>
                    <td>Invoice Number:</td>
                    <td>{{$invoice->invoice_number}}</td>
                </tr>
                <tr>
                    <td>Invoice Date:</td>
                    <td>{{$invoice->invoice_date}}</td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td>{{$user->first_name}} {{$user->last_name}}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td> {{$user->email}} </td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td> {{$user->phone}} </td>
                </tr>
                <tr>
                    <td>Customer Address:</td>
                    <td>{{$userdetails['value'] ?? ""}}</td>
                </tr>
            </table>
        </div>
        <div class="invoice-details">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Offer Price</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($jobitem as $data)
                    @php
                        $service = \App\Models\PmsServiceMaster::where('id', $data->service_id)->first();
                        $inventory = \App\Models\PmsInventoryProducts::where('id', $data->pms_inventory_product_id)->first();
                        
                        // Determine the price and sellprice
                        $price = $inventory?->price ?? 0;
                        $sellprice = $inventory?->sellprice ?? 0;
                        
                        // Calculate the percentage difference
                        $percentage = ($price > 0 && $sellprice != 0) ? abs((($sellprice - $price) / $price) * 100) : 0;
                    @endphp
                    <tr>
                        <td>{{ $service?->name ?? "" }} {{ $inventory?->description ?? "" }}</td>
                        @if($price != 0 && $sellprice != 0)
                            <td>{{ $price }}</td>
                            <td>{{ $sellprice }}</td>
                        @else
                            <td>{{ $service?->amount ?? "0" }}</td>
                            <td>0</td>
                        @endif
                        <td>{{ number_format($percentage,0) }}%</td>
                    </tr>
                @endforeach
                
                   
                </tbody>
            </table>
        </div>
        <div class="invoice-total">
            {{-- <p>Total Amount: $250.00</p> --}}
            <p>Paid Amount: {{$invoice->paid_amount}}</p>
            <p>Balance Amount: {{$invoice->paid_amount}}</p>
        </div>
        <div class="invoice-notes">
            <p>Notes: Thank you for your business.</p>
        </div>
    </div>
</body>
</html>
