<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IICS E-Services</title>
    <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
</head>
<body>
    @include('director.nav')

    <div class="container indexMargin home">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><span id="titlePage">Manage User</span></h1>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-6 col-md-6">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                      <div class="row">
                          
                      </div>
                  </div>
                  <a href="{{ URL::to('director/crediting/1') }}" style="color: #8a6d3b">
                      <div class="panel-footer" style="background-color: white !important">
                          
                      </div>
                  </a>
              </div>
          </div>
          <div class="col-lg-6 col-md-6">
              <div class="panel panel-success">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-3">
                              <span class="glyphicon glyphicon-ok-circle" style="font-size: 25px"></span>
                          </div>
                          <div class="col-xs-9 text-right">
                              
                          </div>
                      </div>
                  </div>
                      <div class="panel-footer" style="background-color: white !important">
                      
                      </div>
                  </a>
              </div>
          </div>
      </div>
      {{-- <div class="row downloadReportDiv" style="margin-bottom: 1%; text-align: right"> --}}
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="panel-body" style="overflow-x: scroll">
                    <center>
                    <table width="80%" border="1">
                        
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th> 
                            <th>Email</th>
                            <th>Position</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        @foreach($user as $user)
                        
                        
                        <tr>
                            <td style="text-align:center">{{$user->id}}</td>
                            <td style="text-align:center">{{$user->lname}},{{$user->fname}}</td>
                            <td style="text-align:center">{{$user->email}}</td>
                            <td style="text-align:center">{{$role}}</td>
                            <td style="text-align:center"></td>
                        </tr>
                        
                        @endforeach
                    </table>
                    </center>
                    </div>
                  </div>
            </div>
        </div>
      </div>
  </div>
</div>

{{-- <div class="container indexMargin home">
    <table>
    <div id="page-wrapper">
        
                <div class="panel-footer" style="background-color: white !important">
    @foreach($user as $user)
    <tr>
        <th>ID</th>
        <th>Full Name</th> 
        <th>Email</th>
        <th>Status</th>
    </tr>
    <tr>    
        <td>{{$user->id}}</td>
        <td>{{$user->lname}},{{$user->fname}}</td>
        <td>{{$user->email}}</td>
        <td></td>
    </tr>
           }}
    </div>
    @endforeach
</table>
</div> 

<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="panel-body" style="overflow-x: scroll">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="courseCreditTable">
                        <thead>
                            <th>ID</th>
                            <th>Full Name</th> 
                            <th>Email</th>
                            <th>Status</th>
                        </thead>
                      </table>
                    </div>
                  </div>
            </div>
        </div>
--}}
    
</body>
</html>