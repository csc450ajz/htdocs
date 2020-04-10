<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            <h3 class="card-title">Categories List</h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            <button type="button" name="add" id="btnAdd" data-toggle="modal" data-target="#categoryModal" class="btn btn-success btn-xs"><i class="fas fa-plus"></i></button>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="categoriesData">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="categoryModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="categoryForm">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter Category Name</label>
                            <input type="text" name="name" id="name" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Enter Category Status</label>
                            <input type="text" name="status" id="status" class="form-control" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="categoryId" id="Id" />
                        <input type="hidden" name="btnAction" id="btnActions" />
                        <input type="submit" name="action" id="actions" class="btn btn-info" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            getCategories();

            $('#btnAdd').click(function() {
                $('#categoryForm')[0].reset();
                $('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
                $('#actions').val("Add");
                $('#btnActions').val("Add");
            });
            $(document).on('click', '.editCat', function() {
                var categoryId = $(this).attr("id");
                $.ajax({
                    url: "categories/categoriesUtility.php",
                    method: "POST",
                    data: {
                        categoryActions: 'getCategory',
                        categoryId: categoryId
                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        $('#categoryModal').modal('show');
                        $('#name').val(data.categoryName);
                        $('#status').val(data.categoryStatus);
                        $('#Id').val(data.categoryId);
                        $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Category");
                        $('#actions').val('Update');
                        $('#btnActions').val('Update');
                        $('#name').attr('required', false);
                        $('#status').attr('required', false);
                    }
                });

            });

            $(document).on('click', '#actions', function() {
                var action = $(this).val();
                if (action == "Add") {

                    var categoryName = $('#name').val();
                    var categoryStatus = $('#status').val();
                    $.ajax({
                        url: "categories/categoriesUtility.php",
                        method: "POST",
                        data: {
                            categoryActions: 'new',
                            categoryName: categoryName,
                            categoryStatus: categoryStatus
                        },
                        success: function(data) {
                            console.log(data);
                            getCategories();
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
                    var categoryId = $('#Id').val();
                    var categoryName = $('#name').val();
                    var categoryStatus = $('#status').val();
                    console.log(categoryId, categoryName, categoryStatus);

                    $.ajax({
                        url: "categories/categoriesUtility.php",
                        method: "POST",
                        data: {
                            categoryActions: 'update',
                            categoryId: categoryId,
                            categoryName: categoryName,
                            categoryStatus: categoryStatus
                        },
                        success: function(data) {
                            console.log(data);

                            // getCategories();
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

            $(document).on('click', '.deleteCat', function() {
                var categoryId = $(this).attr("id");
                $.ajax({
                    url: "categories/categoriesUtility.php",
                    method: "POST",
                    data: {
                        categoryActions: 'delete',
                        categoryId: categoryId
                    },
                    success: function(data) {

                        getCategories();
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

            function getCategories() {
                $.ajax({
                    url: "categories/categoriesUtility.php",
                    method: "POST",
                    data: {
                        categoryActions: 'getCategories'
                    },
                    success: function(data) {
                        $('#categoriesData').html(data);
                    }
                });
            }
        });
    </script>

</body>

</html>