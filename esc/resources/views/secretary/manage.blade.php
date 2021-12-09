<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CICS e - Services</title>
    <link rel="stylesheet" href="{{ URL::asset('css/student/index.css'); }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <!--filter-->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

    
</head>
<body>
    @if($user_type == '3')
        @include('secretary.nav')
    @else
        @include('clerk.nav')
    @endif

    <div class="container indexMargin home">
  <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><span id="titlePage">Manage User</span></h1>
          </div>
          <div class='col-lg-12' style='text-align:right'>    
              <button data-toggle="modal" data-target="#myDetails" id="add"type="button" class="btn btn-light">Add New User</button><br>
          </div>
          {{-- <div class='col-lg-6' style='text-align:left'>  
            <div id='filters'>
              <span>Filter by &nbsp;</span>
              <select name='fetchval' id='fetchval'>
                <option value='' disabled='' selected=''></option>
                <option value=''>Information System</option>
                <option>Information Technology</option>
                <option>Computer Science</option>
                <option>Office Staff</option>

              </select>
            </div>
        </div> --}}
      </div>
      
      {{-- <div class="row downloadReportDiv" style="margin-bottom: 1%; text-align: right"> --}}
      
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
          <label for="pwd">Prefixes and Title: </label>
          <input type="text" class="form-control" id="prefix" placeholder="Example: Asst. Prof. Dean" name="prefix" required>
        </div>
          <div class="form-group">
            <label for="pwd">First Name: </label>
            <input type="text" class="form-control" id="fname" placeholder="Example: Juan Miguel Jr." name="fname" required>
          </div>
          <div class="form-group">
            <label for="npwd">Last Name: </label>
            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" required>
          </div>
          <div class="form-group">
            <label for="npwd">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required>
          </div>
          <div class="form-group">
            <label for="npwd">Position: <i>(Enter 1 for professor, 2 for Dean, 3 for Secretary, 4 for Registrar, 5 for Office Clerk)</i></label>
            <input class="form-control" id="type" placeholder="Enter Position" name="type"  type="number" min="1" max="5" required>
          </div>
          <div class="form-group">
            <label for="npwd">Department: <i>(Enter 0 for IT, 1 for IS, 2 for CS, 4 for Office Staff)</i></label>
            <input class="form-control" id="department" placeholder="Enter department" name="type"  type="number" min="1" max="4" required>
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
                    <table class="table table-striped table-bordered table-hover sortable" width="100%">
                        
                        <thead>
                        <tr>
                            <th style="text-align:center">ID</th>
                            <th style="text-align:center">Full Name</th> 
                            <th style="text-align:center">Email</th>
                            <th style="text-align:center">Position</th>
                            <th style="text-align:center">Department</th>                            
                            <th style="text-align:center">Status</th>
                            {{-- <th style="text-align:center">Action</th> --}}
                            

                        </tr>
                        </thead>
                        @foreach($user as $user)
                        
                        <tbody>
                        <tr>
                            <td style="text-align:center">{{$user->id}}</td>
                            <td style="text-align:left; "><p style='margin-left:10px'>{{$user->prefix}} {{$user->fname}} {{$user->lname}}</td></p>
                            <td style="text-align:left"><p style='margin-left:10px'>{{$user->email}}</td></p>
                            <td style="text-align:left">
                            @if ($user->id == 8 || $user->id == 9 || $user->id == 10)
                            <p style='margin-left:10px'> Department Chair</p>
                            @elseif ($user->type==1)     
                            <p style='margin-left:10px'>Professor<p>
                            @elseif ($user->type==2) 
                            <p style='margin-left:10px'>Dean<p>
                            @elseif($user->type==3)
                            <p style='margin-left:10px'>Secretary<p>
                            @elseif($user->type==4) 
                            <p style='margin-left:10px'>Registrar</p>
                            @elseif($user->type==5) 
                            <p style='margin-left:10px'>Office Clerk</p>
                            @else 
                            <p style='margin-left:10px'>Undentified<p>
                            @endif
                            
                            </td>
                            <td style="text-align:left">
                              @if ($user->department == 0)
                              <p style='margin-left:10px'> Information Technology</p>
                              @elseif ($user->department== 1)     
                              <p style='margin-left:10px'>Information System<p>
                              @elseif ($user->department == 2) 
                              <p style='margin-left:10px'>Computer Science<p>
                              @elseif($user->department==3)
                              <p style='margin-left:10px'>Office Staff<p>
                              @else 
                              <p style='margin-left:10px'>Undentified<p>
                              @endif
                            </td>
                            <td style="text-align:center">
                            <input id='status' data-id="{{$user->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $user->status ? 'checked' : '' }}>

                            {{-- <//input type='submit' name='action' id='inactive' value='Inactive'></input></td> --}}

                        </tr>
                      </tbody>
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