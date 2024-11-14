<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
      body {
        background-color: #f5f5f5;
      }
      .container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Service Request</h2>
      <hr>
      <p><strong>Issue:</strong> {{ $serviceRequest['issue'] }}</p>
      @if(!empty($serviceRequest['image']))
      <p><img src="{{ asset('images/service-request/' . $serviceRequest['image']) }}" width="100" class="img-fluid" /></p>
      @endif
      <p><strong>Description:</strong> {{ $serviceRequest['description'] }}</p>
      <p><strong>Priority:</strong> {{ $serviceRequest['priority'] }}</p>
      @php
          $property=App\Models\Properties::where('id', $serviceRequest['property_id'])->first();
          $property_owner=App\Models\User::where('id', $property->host_id)->first();
      @endphp
      <p><strong>Property Name:</strong> {{  $property->name }}</p>
      <p><strong>Property Owner Name:</strong> {{  $property_owner->first_name . ' ' . $property_owner->last_name }}</p>
      <p><strong>Property Owner Email:</strong> {{  $property_owner->email }}</p>
      <p><strong>Property Owner Phone:</strong> {{  $property_owner->formatted_phone }}</p>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
