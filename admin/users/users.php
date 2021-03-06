<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            <h3 class="card-title">Users List</h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            <button type="button" name="add" id="btnAdd" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-xs"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="clear:both"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table id="userData" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Password</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="usersData">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="userModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="userForm">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter First Name</label>
                            <input type="text" name="userFName" id="userFName" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Enter Last Name</label>
                            <input type="text" name="userLName" id="userLName" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Enter User Email</label>
                            <input type="email" name="userEmail" id="userEmail" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Enter User Type</label>
                            <input type="text" name="userType" id="userType" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Enter User Password</label>
                            <input type="text" name="userPassword" id="userPassword" class="form-control" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <input type="hidden" name="userEmail" id="userEmail" /> -->
                        <input type="hidden" name="btnAction" id="btnAction" />
                        <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            getUsers();

            $('#btnAdd').click(function() {
                $('#userForm')[0].reset();
                $('.modal-title').html("<i class='fa fa-plus'></i> Add User");
                $('#action').val("Add");
                $('#btnAction').val("Add");
            });
            $(document).on('click', '.edit', function() {
                var userEmail = $(this).attr("id");
                $.ajax({
                    url: "users/usersUtility.php",
                    method: "POST",
                    data: {
                        userActions: 'getUser',
                        userEmail: userEmail
                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        $('#userModal').modal('show');
                        $('#userFName').val(data.userFName);
                        $('#userLName').val(data.userLName);
                        $('#userEmail').val(data.userEmail);
                        $('#userType').val(data.userType);
                        $('#userPassword').val(data.userPassword);

                        $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit User");
                        // $('#userId').val(data.userEmail);
                        $('#action').val('Update');
                        $('#btnAction').val('Update');
                        $('#userPassword').attr('required', false);
                        $('#userFName').attr('required', false);
                        $('#userLName').attr('required', false);
                        $('#userEmail').attr('required', false);
                        $('#userType').attr('required', false);

                    }
                });

            });

            $(document).on('click', '#action', function() {
                var action = $(this).val();
                if (action == "Add") {
                    var userFName = $('#userFName').val();
                    var userLName = $('#userLName').val();
                    var userEmail = $('#userEmail').val();
                    var userType = $('#userType').val();
                    var userPassword = $('#userPassword').val();
                    $.ajax({
                        url: "users/usersUtility.php",
                        method: "POST",
                        data: {
                            userActions: 'new',
                            userEmail: userEmail,
                            userFName: userFName,
                            userLName: userLName,
                            userType: userType,
                            userPassword: userPassword
                        },
                        success: function(data) {
                            console.log(data);
                            getUsers();
                        },
                        error: function(jqXHR, exception) {
                            console.log(jqXHR);
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            alert(msg);
                        },
                    })
                } else {
                    var userFName = $('#userFName').val();
                    var userLName = $('#userLName').val();
                    var userEmail = $('#userEmail').val();
                    var userType = $('#userType').val();
                    var userPassword = $('#userPassword').val();
                    console.log(userEmail, userFName, userLName);

                    $.ajax({
                        url: "users/usersUtility.php",
                        method: "POST",
                        data: {
                            userActions: 'update',
                            userEmail: userEmail,
                            userFName: userFName,
                            userLName: userLName,
                            userType: userType,
                            userPassword: userPassword
                        },
                        success: function(data) {
                            console.log(data);

                            // getUsers();
                        },
                        error: function(jqXHR, exception) {
                            console.log(jqXHR);

                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            alert(msg);
                        },
                    })
                }

            });

            $(document).on('click', '.delete', function() {
                var userEmail = $(this).attr("id");
                console.log(userEmail)
                $.ajax({
                    url: "users/usersUtility.php",
                    method: "POST",
                    data: {
                        userActions: 'delete',
                        userEmail: userEmail
                    },
                    success: function(data) {
                        // location.reload();
                        // location.reload()
                        getUsers();
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR);

                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        alert(msg);
                    },
                });

            });

            function getUsers() {
                $.ajax({
                    url: "users/usersUtility.php",
                    method: "POST",
                    data: {
                        userActions: 'getUsers'
                    },
                    success: function(data) {
                        $('#usersData').html(data);
                    }
                });
            }
        });
    </script>

</body>

</html>