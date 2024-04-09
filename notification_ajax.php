<!doctype html>
<html lang="zh-Hant-TW">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <title>Notification CRUD</title>

    <link rel="stylesheet" href="css/alertify.min.css" />
</head>
<body>

<!-- Add Notification -->
<div class="modal fade" id="notificationAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">新增提醒事項</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="savenotification">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>

                <div class="mb-3">
                    <label for="">標題</label>
                    <input type="text" name="title" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">備註事項</label>
                    <input type="text" name="remark" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                <button type="submit" class="btn btn-primary">儲存提醒</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Edit Notification Modal -->
<div class="modal fade" id="notificationEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">修改提醒事項</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateNotification">
            <div class="modal-body">

                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                <input type="hidden" name="notification_id" id="notification_id" >

                <div class="mb-3">
                    <label for="">標題</label>
                    <input type="text" name="title" id="edit_title" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">備註事項</label>
                    <input type="text" name="remark" id="edit_remark" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                <button type="submit" class="btn btn-primary">更新提醒</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- View Notification Modal -->
<div class="modal fade" id="notificationViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">提醒事項瀏覽</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">標題</label>
                    <p id="view_title" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">備註事項</label>
                    <p id="view_remark" class="form-control"></p>
                </div>
                <input type="hidden" name="view_notification_id" id="view_notification_id" >
            </div>
            <div class="modal-footer">
                <button id="markAsCompletedBtn" class="btn btn-success">設定為已完成</button>             
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                        <button type="button" class="btn btn-secondary" id="view-unfinish-btn">未完成提醒事項</button>
                        <button type="button" class="btn btn-warning" id="view-finish-btn">已完成提醒事項</button>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#notificationAddModal">
                            新增提醒事項
                        </button>
                </div>
                <div class="card-body">

                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>標題</th>
                                <th>備註事項</th>
                                <th>動作</th>
                                <th>狀態</th>
                            </tr>
                        </thead>
                        <tbody id="tasks-list">
                            <?php
                            require 'dbcon.php';

                            try {
                                $query = "SELECT * FROM notifications_ajax";
                                $stmt = $conn->query($query);
                        
                                if($stmt->rowCount() > 0)
                                {
                                    while($notification = $stmt->fetch(PDO::FETCH_ASSOC))
                                    {
                                        ?>
                                        <tr>                                            
                                            <td><?= $notification['title'] ?></td>
                                            <td><?= $notification['remark'] ?></td>
                                            <td>
                                                <button type="button" value="<?= $notification['id'] ?>" class="viewNotificationBtn btn btn-info btn-sm">View</button>
                                                <button type="button" value="<?= $notification['id'] ?>" class="editNotificationBtn btn btn-success btn-sm">Edit</button>
                                                <button type="button" value="<?= $notification['id'] ?>" class="deleteNotificationBtn btn btn-danger btn-sm">Delete</button>
                                            </td>
                                            <?php
                                                // Determine text color based on status
                                                $statusColor = ($notification['finish_status'] == 1) ? 'green' : 'red';
                                            ?>
                                            <td>
                                                <span style="color: <?php echo $statusColor; ?>">
                                                <?php echo ($notification['finish_status'] == 1) ? '已完成' : '未完成'; ?>
                                                </span>
                                            </td> 
                                        </tr>
                                        <?php
                                    }
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.min.js" ></script>

    <script src="js/alertify.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Function to fetch and display tasks based on status
            function displayTasks(status) {
                $.ajax({
                    url: 'fetch_tasks.php',
                    type: 'GET',
                    data: { status: status },
                    success: function(response) {
                        try {
                            var tasks = JSON.parse(response);
                            
                            if (Array.isArray(tasks)) {                 //檢查從後端返回的tasks是否是一個陣列
                                var tasksList = $('#tasks-list');

                                tasksList.empty(); // Clear existing tasks

                                // Iterate through tasks and append to table
                                tasks.forEach(function(task) {
                                    var statusColor = (task.finish_status == 1) ? 'green' : 'red';
                                    var statusText = (task.finish_status == 1) ? '已完成' : '未完成';

                                    var row = "<tr>" +
                                        "<td>" + task.title + "</td>" +
                                        "<td>" + task.remark + "</td>" +
                                        "<td>" +
                                        "<button type='button' value='" + task.id + "' class='viewNotificationBtn btn btn-info btn-sm'>View</button> " +
                                        "<button type='button' value='" + task.id + "' class='editNotificationBtn btn btn-success btn-sm'>Edit</button> " +
                                        "<button type='button' value='" + task.id + "' class='deleteNotificationBtn btn btn-danger btn-sm'>Delete</button>" +
                                        "</td>" +
                                        "<td><span style='color: " + statusColor + "'>" + statusText + "</span></td>" +
                                        "</tr>";

                                    tasksList.append(row);
                                });
                            } else {
                                console.error("Response is not an array:", tasks);
                            }
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.status, xhr.statusText);
                        console.error("Response Text:", xhr.responseText);
                    }
                });
            }

            // Initial load of all tasks
            displayTasks('3');

            // Button click handlers
            $('#view-unfinish-btn').on('click', function() {
                displayTasks('0'); // Show tasks with finish_status 0 (未完成)
            });

            $('#view-finish-btn').on('click', function() {
                displayTasks('1'); // Show tasks with finish_status 1 (已完成)
            });
        });
    </script>


    <script>
        $(document).on('submit', '#savenotification', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_notification", true);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);

                    }else if(res.status == 200){

                        $('#errorMessage').addClass('d-none');
                        $('#notificationAddModal').modal('hide');
                        $('#savenotification')[0].reset();

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable').load(location.href + " #myTable");

                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

        $(document).on('click', '.editNotificationBtn', function () {

            var notification_id = $(this).val();
            
            $.ajax({
                type: "GET",
                url: "code.php?notification_id=" + notification_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#notification_id').val(res.data.id);
                        $('#edit_title').val(res.data.title);
                        $('#edit_remark').val(res.data.remark);

                        $('#notificationEditModal').modal('show');
                    }

                }
            });

        });

        $(document).on('submit', '#updateNotification', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_notification", true);

            $.ajax({
                type: "POST",
                url: "code.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);

                    }else if(res.status == 200){

                        $('#errorMessageUpdate').addClass('d-none');

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        
                        $('#notificationEditModal').modal('hide');
                        $('#updateNotification')[0].reset();

                        $('#myTable').load(location.href + " #myTable");

                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

        $(document).on('click', '.viewNotificationBtn', function () {

            var notification_id = $(this).val();
            
            $.ajax({
                type: "GET",
                url: "code.php?notification_id=" + notification_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_notification_id').val(res.data.id);
                        $('#view_title').text(res.data.title);
                        $('#view_remark').text(res.data.remark);

                        $('#notificationViewModal').modal('show');
                    }
                }
            });
        });

        $(document).on('click', '.deleteNotificationBtn', function (e) {
            e.preventDefault();

            if(confirm('確定要刪除該資料嗎?'))
            {
                var notification_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "code.php",
                    data: {
                        'delete_notification': true,
                        'notification_id': notification_id
                    },
                    success: function (response) {

                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                            alert(res.message);
                        }else{
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable').load(location.href + " #myTable");
                        }
                    }
                });
            }
        });

        $(document).on('click', '#markAsCompletedBtn', function () {
           var notification_id = $('#view_notification_id').val(); // Assume you have a hidden input with notification_id
    
           $.ajax({
               type: "POST",
               url: "code.php", // Your PHP file to handle the marking as completed
               data: {
                   'notification_id': notification_id
               },
               success: function (response) {
                   
                   var res = jQuery.parseJSON(response);
                   if(res.status == 200) {
                      // Update the UI or show a success message
                      alertify.set('notifier','position', 'top-right');
                      alertify.success(res.message);

                      $('#notificationViewModal').modal('hide');
                      $('#myTable').load(location.href + " #myTable");
                     // Reload or update the table if needed
                   }else{
                    alert(res.message); // Handle error
                   }
                }
            });
        });


    </script>

</body>
</html>