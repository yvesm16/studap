<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IICS E - Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,600;0,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href ="../css/stylemain.css" >
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
 </head>

 <body id="end-consultation">
     <div id="end-consul-modal">
         <center>
         <p id="title-end-consul">Rate our service</p> 
         {{-- @if(session()->has('message'))
                <div class="alert-danger" style="color:#000000;">
                    {{ session()->get('message') }}
                </div>
          @endif --}}

         
<form id="stud-satisfaction-form" action='studstatis' method='post'>
  @csrf
    <fieldset class="stars">
      
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
      <input type="radio" name="stars" id="star-reset"/><br><br><br><br>
      <button id="regbutton" type="submit" class="login-btn" name='submit'>Submit</button>

    </fieldset>

  </form>
   
     </div>
    </center>

 </body>
 </html>