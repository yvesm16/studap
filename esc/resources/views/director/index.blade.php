<!DOCTYPE html>
<html lang="en">
<head>
  <title>IICS E - Services</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
  <!-- <script src="{{ URL::asset('js/student/index.js'); }}"></script> -->
</head>
<body>

@include('director.nav')

<div class="container indexMargin home">
  <p>
        <!-- Modal -->

    @if(count($signature) == 0)
      <script type="text/javascript">
        $(window).on('load', function() {
            $('#signatureModal').modal('show');
        });
      </script>
    @endif
    @if(session('success'))
      <script type="text/javascript">
        $(window).on('load', function() {
            $('#successModal').modal('show');
        });
      </script>
    @endif
    @if(session('failed'))
      <script type="text/javascript">
        $(window).on('load', function() {
            $('#signatureModal').modal('hide');
            $('#failedModal').modal('show');
        });
      </script>
    @endif
  </p>
  <p>
    <img src="{{ URL::asset('img/iicslogo.png')}}" width="100px" style="margin-top: 1%">
    <h1>Welcome to IICS E-Services</h1>
    Student Consultation || Student Appeal on Course Grade || Course Crediting
  </p>
  <p>
    <h2>UST IICS Vision</h2>
    <div style="text-align: justify; margin-left: 5%; margin-right: 5%">
      As an academic arm of the Royal and Pontifical University of Santo Tomas, the Catholic University of the Philippines,
the Institute of Information and Computing Sciences (IICS) is committed in producing competent, compassionate,
and committed Thomasian graduates who are strongly founded with the existing theories and principles
surrounding their field of interest and is capable in the efficient application of computing solutions which adheres to
high ethical and moral standards.
    </div>
  </p>
  <p>
    <h2>UST IICS Mission</h2>
    <div style="text-align: justify; margin-left: 5%; margin-right: 5%">
      Institute of Information and Computing Sciences (IICS) envisions itself to be a Center of Excellence in Information
Technology Education. With the fast changing innovation in the IT industry, we foresee our students as globally competitive
graduates who specialize in the areas of Computer Science, Information Technology and Information Systems.
This can only be achieved however with faculty members and staff who are professional,
ethical and morally upright who respond to the needs and challenges of our constantly changing society.
    </div>
  </p>
  <p>
    <h3>Like and Follow Us at</h3>
    Facebook: <a href="https://www.facebook.com/USTIICS2014Official/">https://www.facebook.com/USTIICS2014Official/</a> <br>
    Twitter: @USTIICSOfficial
  </p>
</div>

</body>
</html>
