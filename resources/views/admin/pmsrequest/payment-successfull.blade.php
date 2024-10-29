<!doctype html>
<html lang="en">
  <head>
    <title>Payment Successful</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <style>
      ._failed {
           border-bottom: solid 4px red !important;
        }
        ._failed i {
          color: red !important;
        }

        ._success {
            background-color: #FFFFFF;
            box-shadow: 0 15px 25px #00000019;
            padding: 45px;
            width: 100%;
            text-align: center;
            margin: 40px auto;
            border-radius: 10px;
            border-bottom: solid 4px #28a745;
        }

        ._success i {
            font-size: 55px;
            color: #28a745;
        }

        ._success h2 {
            margin-bottom: 12px;
            font-size: 40px;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 10px;
        }

        ._success p {
            margin-bottom: 0px;
            font-size: 18px;
            color: #495057;
            font-weight: 500;
        }

        .home-link {
            margin-top: 20px;
            font-size: 18px;
        }

    </style> 
  </head>
  <body>
    <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="message-box _success">
              <i class="fa fa-check-circle" aria-hidden="true"></i>
              <h2> Your payment was successful </h2>
              <p> Thank you for your payment. we will <br>
                be in contact with more details shortly </p>
              <a href="{{url('/')}}" class="btn btn-primary home-link">Back to Home</a>
            </div>
          </div>
        </div>
        <hr>
      </div>
  </body>
</html>

