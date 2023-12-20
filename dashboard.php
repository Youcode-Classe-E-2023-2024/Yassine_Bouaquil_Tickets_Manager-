<?php
include './header.php';
require_once './src/ticket.php';
require_once './src/user.php';

$ticket = new Ticket();
$allTicket = $ticket::findAll();


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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-3">
        <h2 class="text-2xl font-bold mb-3">Dashboard</h2>
        <a href="./ticket.php" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> New Ticket</a>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-auto w-full border border-collapse border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Subject</th>
                                <th class="px-4 py-2">Agent</th>
                                <th class="px-4 py-2">Created At</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allTicket as $ticket) : ?>
                                <tr>
                                    <td class="px-4 py-2"><a href="./ticket-details.php?id=<?php echo $ticket->id ?>"><?php echo $ticket->title ?></a></td>
                                    <?php $agentId = $ticket->team_member; ?>
                                    <?php $agent = User::find($agentId); ?>
                                    <td class="px-4 py-2"><?php echo $agent ? $agent->name : 'No Agent Assigned'; ?></td>
                                    <?php $date = new DateTime($ticket->created_at) ?>
                                    <td class="px-4 py-2"><?php echo $date->format('d-m-Y H:i:s') ?> </td>
                                    <td class="px-4 py-2">
                                        <div class="btn-group" role="group">
                                            <a href="./ticket-details.php?id=<?php echo $ticket->id ?>" class="btn btn-outline-primary">View</a>
                                            <a onclick="return confirm('Are you sure to delete')" href="?del=<?php echo $ticket->id; ?>" class="btn btn-outline-danger">Delete</a>
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
</body>
</html>


<?php include './footer.php' ?>
