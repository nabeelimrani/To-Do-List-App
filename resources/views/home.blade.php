@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('To-Do List') }}</div>
                <div class="alert alert-success" id="msg"></div>
                <div class="card-body">
                    <div class="form-group">
                        <button class="btn btn-outline-dark" id="newNoteBtn">Add New Note</button>
                        <button class="btn btn-outline-dark" id="showtable">Hide Table</button>
                    </div>
                    <form id="form">
                        @csrf
                        <div class="form-group" id="noteFormContainer" style="display: none;">
                            <div class="input-group mb-3">
                                <input type="hidden" id="idstore">
                                <textarea class="form-control" placeholder="Add a task" id="task_name" name="task_name" required rows="5"></textarea>

                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="savebutton">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container col-md-12 mt-4">
                <table id="taskTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Task</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $serialNo = 1;
                    @endphp
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $serialNo++ }}</td>
                            <td>{{ $task->Task }}</td>
                            <td>{{ $task->created_at->format('M d, Y H:i:s') }}</td>

                            <td>
                                <div class="action-buttons">
                                    <button type="button" data-taskid="{{$task->ID}}" class="btn btn-primary btn-sm edit-data">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                       
                                    
                                    <button type="button" data-taskid="{{$task->ID}}" class="btn btn-danger btn-sm restore-data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    
                                    
                                       
                                   
                                
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
      <b>&copy; 2023 To Do List. All rights reserved.</b>
    </div>
  </footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('datatables/datatable.custom.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 $(document).ready(function() {
    $('#taskTable').DataTable();
    $('#taskTable').show();
  
    // Toggle table visibility
    $("#showtable").click(function() {
      if ($("#showtable").text() === "Hide Table") {
        $('#taskTable').fadeOut();
        $('#taskTable').DataTable().destroy();
        $("#showtable").text("Show Table");
      } else {
        $('#taskTable').fadeIn(function() {
          $(this).DataTable();
        });
        $("#showtable").text("Hide Table");
      }
    });
  
    // Handle restore task confirmation
    $(document).on('click', '.restore-data', function(e) {
      var val = $(this).data('taskid');
      Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
      }).then((result) => {
        if (result.isConfirmed) {
          // User clicked "Yes", perform the restore action
          restoreTask(val);
        }
      });
    });
  
    // Handle edit task
    $(document).on('click', '.edit-data', function(e) {
      var taskId = $(this).data('taskid');
      editTask(taskId);
    });
  
    // Edit task function
    function editTask(taskId) {
      $.ajax({
        type: "GET",
        url: "/tasks/edit/" + taskId,
        success: function(response) {
          $("#noteFormContainer").slideToggle();
          $("#newNoteBtn").text("Close Form");
          $("#task_name").val(response.data.Task);
          $("#idstore").val(response.data.ID);
          $("#savebutton").text("Update");
        },
        error: function(error) {
          console.log(error);
          Swal.fire({
            icon: 'error',
            title: 'An error occurred',
            text: 'Failed to retrieve the task.'
          });
        }
      });
    }
  
    // Restore task function
    function restoreTask(taskId) {
      $.ajax({
        url: '/tasks/del/' + taskId,
        method: 'GET',
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Task deleted successfully!',
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            location.reload();
          });
        },
        error: function(error) {
          console.log(error);
          Swal.fire({
            icon: 'error',
            title: 'An error occurred',
            text: 'Failed to delete the task.'
          });
        }
      });
    }
  
    // Form submission
    $("#msg").hide();
    $("#noteFormContainer").hide();
  
    $("#newNoteBtn").click(function() {
      $("#noteFormContainer").slideToggle();
  
      if ($("#newNoteBtn").text() === "Add New Note") {
        $("#newNoteBtn").text("Close Form");
      } else {
        $("#newNoteBtn").text("Add New Note");
      }
    });
  
    $("#form").submit(function(e) {
  e.preventDefault();

  var formData = {
    _token: $('meta[name="csrf-token"]').attr("content"),
    task_name: $("#form textarea[name='task_name']").val(),
    id: $("#idstore").val()
  };

  var url = "/note/store";
  var buttonValue = $("#savebutton").text();

  if (buttonValue === "Update") {
    url = "/note/update/" + formData.id;
  }

  $.ajax({
    type: "POST",
    url: url,
    dataType: "json",
    data: formData,
    success: function(response) {
      if (response.status === "success") {
        $('#taskTable').DataTable();
        $('#taskTable').fadeIn();

        $("#form")[0].reset();
        $("#msg").show();
        $("#msg").html(response.success);
        $("#showtable").text("Close Table");

        setTimeout(function() {
          $("#msg").fadeOut(500, function() {
            $("#msg").html("").hide();
          });
        }, 2000);

        Swal.fire({
          icon: 'success',
          title: 'Task ' + buttonValue + ' Successfully!',
          showConfirmButton: false,
          timer: 1500
        }).then(function() {
          location.reload();
        });
      }
    },
    error: function(data) {
      console.log("Error:", data);
    }
  });
});

  });
</script>
  @endsection
