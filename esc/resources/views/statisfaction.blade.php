<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IICS E - Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,600;0,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
 </head>
<body >
  <div class="container indexMargin">
    <div class='content'>
      @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
      @elseif (Session::has('warning'))
        <div class="alert alert-warning">{{ Session::get('warning') }}</div>

      @endif
         <center>      <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

         <h1 style='font-size:60px'>Rate our service</h1> 
         <br><br>
        <form action="{{ URL::to('statisfaction') }}" method="post">   
        @csrf

      <fieldset class="stars ">
        <div class='row'>
        <div class='col-sm-6 col-md-7 col-lg-7'>
        <input type="radio" name="stars" id="star1" ontouchstart="ontouchstart" value='5'/>
        <label class="fa fa-star" for="star1"></label>
        <input type="radio" name="stars" id="star2" ontouchstart="ontouchstart" value='4' />
        <label class="fa fa-star" for="star2"></label>
        <input type="radio" name="stars" id="star3" ontouchstart="ontouchstart" value='3'/>
        <label class="fa fa-star" for="star3"></label>
        <input type="radio" name="stars" id="star4" ontouchstart="ontouchstart" value='2' />
        <label class="fa fa-star" for="star4"></label>
        <input type="radio" name="stars" id="star5" ontouchstart="ontouchstart" value='1' />
        <label class="fa fa-star" for="star5"></label>
        <input type="radio" name="stars" id="star-reset"/>
        </div>
      </div>
        <br><br><br><br>
      <button id="regbutton" type="submit" class="login-btn" name='submit' value='Submit'>Submit</button>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </fieldset>
  </div>
  </div>
  </form>
   
     </div>
    </center>

 </body>

 </html>

 
 