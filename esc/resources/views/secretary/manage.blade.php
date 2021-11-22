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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    
</head>
<body>

    @include('secretary.nav')
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
                    @if (session('warning'))
                        <div class="alert alert-warning">
                          {{ session('warning') }}
                        </div>
                    @elseif(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                      
                    @endif
                    <center>

                    <button data-toggle="modal" data-target="#myDetails" id="add"type="button" class="btn btn-light">Add New User</button><br>
                    <div class="modal fade" id="myDetails" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New User</h4>
      </div>
      
      <form action="{{ URL::to('secretary/addUser') }}" method="post">
        @csrf

      <div class="modal-body">
          <div class="form-group">
            <label for="pwd">First Name: <i>(No numerical values are allowed)</i></label>
            <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" pattern="[a-zA-Z]{1,}" required>
          </div>
          <div class="form-group">
            <label for="npwd">Last Name: <i>(No numerical values are allowed)</i></label>
            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" pattern="[a-zA-Z]{1,}" required>
          </div>
          <div class="form-group">
            <label for="npwd">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required>
          </div>
          <div class="form-group">
            <label for="npwd">Position: <i>(Enter 1 for professor, 2 for Director, 3 for Secretary, 4 for Registrar)</i></label>
            <input class="form-control" id="type" placeholder="Enter Email" name="type"  type="number" min="1" max="4" required>
          </div>
          <div class="form-group">
            <label for="npwd">Temporary Password:</label>
            <input type="password" class="form-control" id="tempPassword" placeholder="Enter Temporary password" name="tempPassword" required>
          </div>
          <div class="alert alert-success" style="display: none" id="successPassword">
              Password was successfully updated!
          </div>
          <div class="alert alert-danger" style="display: none" id="failedPassword">
              <span id="failedContent"></span>
          </div>
      </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      </div>
    </div>

  </div>
</div>
                    <table width="80%" border="1">
                        
                        <thead>
                        <tr>
                            <th style="text-align:center">ID</th>
                            <th style="text-align:center">Full Name</th> 
                            <th style="text-align:center">Email</th>
                            <th style="text-align:center">Position</th>
                            <th style="text-align:center">Status</th>
                            

                        </tr>
                        </thead>
                        @foreach($user as $user)
                        
                        
                        <tr>
                            <td style="text-align:center">{{$user->id}}</td>
                            <td style="text-align:center">{{$user->lname}},{{$user->fname}}</td>
                            <td style="text-align:center">{{$user->email}}</td>
                            <td style="text-align:center">
                            @if ($user->id == 8 || $user->id == 9 || $user->id == 10)
                                <p> Department Chair</p>
                            @elseif ($user->type==1)     
                                <p>Professor<p>
                            @elseif ($user->type==2) 
                                <p>Director<p>
                            @elseif($user->type==3)
                                <p>Secretary<p>
                            @elseif($user->type==4) 
                                <p>Registrar</p>
                            @else 
                                <p>Undentified<p>
                            @endif
                            
                            </td>
                            <td style="text-align:center">
                            <input id='status' data-id="{{$user->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $user->status ? 'checked' : '' }}>

                            {{-- <//input type='submit' name='action' id='inactive' value='Inactive'></input></td> --}}

                        </tr>
                        
                        @endforeach

                        <script>
                            $(function() {
                              $('.toggle-class').change(function() {
                                  var status = $(this).prop('checked') == true ? 1 : 0; 
                                  var user_id = $(this).data('id'); 
                                   console.log(status);
                                  $.ajax({
                                      type: "GET",
                                      dataType: "json",
                                      url: 'userChangeStatus',
                                      data: {'status': status, 'user_id': user_id},
                                      success: function(data){
                                        console.log(data.success)
                                      }
                                  });
                              })
                            })
                          </script>
                    </table>
                    <br><br><br><br>
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