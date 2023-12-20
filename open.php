<?php
include './header.php';
require_once './src/ticket.php';
require_once './src/user.php';

$ticket = new Ticket();
$allTicket = $ticket::findByStatus('open');
$user = new User();

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    try {
        $ticket->delete($id);
        echo '<script>alert("Ticket deleted successfully");window.location = "./dashboard.php"</script>';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
        </ol>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Agent</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allTicket as $ticket) : ?>
                                <tr>
                                    <td><a href="./ticket-details.php?id=<?php echo $ticket->id ?>"><?php echo $ticket->title ?></a></td>
                                    <?php
                                    $usr = '';
                                    $userInstance = $user::find($ticket->team_member);
                                    if ($userInstance !== false) {
                                        $usr = $userInstance->name;
                                    } else {
                                        $usr = '<h6>no User assigned</h6>';
                                    }
                                    ?>
                                    <td><?php echo $usr; ?></td>

                                    <td><button class="btn btn-danger"><?php echo $ticket->status ?></button></td>
                                    <?php $date = new DateTime($ticket->created_at) ?>
                                    <td><?php echo $date->format('d-m-Y H:i:s') ?> </td>
                                    <td width="100px">
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <a href="./ticket-details.php?id=<?php echo $ticket->id ?>" class="btn btn-outline-primary">View</a>
                                                <a onclick="return confirm('Are you sure to delete')" href="?del=<?php echo $ticket->id; ?>" class="btn btn-outline-danger">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Footer -->
<footer class="sticky-footer">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="./index.php">Logout</a>
            </div>
        </div>
    </div>
</div>

</body>

</html>


