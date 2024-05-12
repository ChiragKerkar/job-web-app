<!-- dashboard.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

   <style>
        /* Custom CSS */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .logout-btn {
            position: fixed;
            top: 10px;
            right: 10px;
        }

    </style>
</head>
<body>

<div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mt-4 mb-3">Jobs Available</h2>
                <div id="saveAlert" class="alert d-none" role="alert"></div>
            </div>
            <div class="col-md-6 text-right">
                <!-- Logout button -->
                <a href="<?= url('login-view') ?>" class="btn btn-danger logout-btn">Logout</a>
            </div>
        </div>
    <input type="hidden" id="url" value="<?= url('/') ?>">
    <!-- Table to display dealer data -->
    <table class="table" id="dealerTable">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company Name</th>
                <th>Location</th>
                <th>Posted Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dealer as $dealerItem): ?>
                <tr>
                    <td><?= $dealerItem['job_title'] ?></td>
                    <td><?= $dealerItem['company_name'] ?></td>
                    <td><?= $dealerItem['location'] ?: 'N/A' ?></td>
                    <td><?= $dealerItem['posted_date'] ?: 'N/A' ?></td>
                    <td>
                        <a href="#" class="btn btn-primary editLink" data-id="<?= $dealerItem['id'] ?>">View</a>
                        <a href="#" class="btn btn-success applyLink" data-id="<?= $dealerItem['id'] ?>">Apply</a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Dealer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="saveAlert" class="alert d-none" role="alert"></div>
                <form id="editForm">
                <input type="hidden" id="user_id" name="user_id" value="">
                <input type="hidden" id="url" value="<?= url('/') ?>">
                    <div class="mb-3">
                        <label for="editCity" class="form-label">Job Title</label>
                        <input type="text" class="form-control" id="editCity" name="City" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editState" class="form-label">Description</label>
                        <textarea class="form-control" id="editState" name="State" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editZipCode" class="form-label">Requirements</label>
                        <input type="text" class="form-control" id="editZipCode" name="Zip_code" readonly>
                    </div>
                    <input type="hidden" id="dealerId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= url('js/form_submission/form_submit.js') ?>"></script>
</body>
</html>
