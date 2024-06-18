<!DOCTYPE html>
<html lang="en">
<head>
    <?php @include 'header.php'; ?>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
	<title>Registrar Page</title>
	<!-- custom css file link --> 
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    @include('header');
  <!-- TABLE CONTENT -->
  <p class=" fs-1 ps-sm-5  font-monospace fw-bold ">LIST OF STUDENTS</p>
  <nav style="--bs-breaadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb mx-5 font-monospace">
      <li class="breadcrumb-item">Home</li>
    </ol>
  </nav>
  <div class="container-xl border-3  border rounded-3  ">
  <table class="mt-2 table table-hover">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">First name</th>
        <th scope="col">Last name</th>
        <th scope="col">Email</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody class="auto" >
        @if ($students->isEmpty())
            <tr>
                <td colspan='5'>No data available</td>
            </tr>
        @else
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->firstname }}</td>
                    <td>{{ $student->lastname }}</td>
                    <td>{{ $student->email }}</td>
                    <td>
                        <a href="/viewDetails/{{ $student->id }}" type="button" class="btn btn-outline-primary rounded-pill">Details</a>
                        <button type="button" class="btn btn-outline-danger rounded-pill" onclick="confirmDelete(event, {{ $student->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
  </table>
</div>

<!-- Modal for delete confirmation -->
<div class="modal fade" id="deleteConfirmationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this student?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
    <script>
        function confirmDelete(button, studentId) {
                $('#deleteConfirmationModal').modal('show');

                $('#confirmDeleteBtn').off('click').on('click', function() {
                    deleteStudent(studentId);
                    $('#deleteConfirmationModal').modal('hide');
                });
            }

        function deleteStudent(id) {
            $.ajax({
                type: "POST",
                url: "/deleteStudent/" + id,
                data: { _token: '{{ csrf_token() }}', id: id },
                success: function(response) {
                    console.log(response);
                    location.reload();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>

</body>
</html>