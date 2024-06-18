<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cashier Page</title>
    <!-- Stylesheet links moved to the head -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    @include('header');
    <!-- TABLE CONTENT -->
    <p class="fs-1 ps-sm-5 font-monospace fw-bold">LIST OF STUDENTS</p>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mx-5 font-monospace">
            <li class="breadcrumb-item">Home</li>
        </ol>
    </nav>
    <div class="container-xl border-3 border rounded-3">
        <table id="studentsTable" class="mt-2 table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tuition</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="auto">
                @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->firstname }} {{ $student->lastname }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->tuition }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" onclick="editTuition({{ $student->id }}, {{ $student->tuition }})">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal for tuition edit -->
<div class="modal fade" id="tuitionModal" tabindex="-1" aria-labelledby="tuitionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tuitionModalLabel">Edit Tuition and Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tuitionForm" action="" method="POST">
                    @csrf
                    <input type="hidden" id="tuitionStudentId" name="studentId">
                    <label for="tuition">Tuition Amount:</label>
                    <input type="text" class="form-control" id="tuition" name="tuition" required>
                    <label for="paymentMethod" class="mt-3">Payment Method:</label>
                    <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                        <option value="">Select Payment Method</option>
                        <option value="cash">Cash</option>
                        <option value="credit_card">Credit Card</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="tuitionForm">Save changes</button>
            </div>
        </div>
    </div>
</div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('tuitionForm');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
    
                const formData = new FormData(form);
                const studentId = document.getElementById('tuitionStudentId').value;
    
                $.ajax({
                    type: 'POST',
                    url: '/updateTuition/' + studentId,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
    
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Tuition and payment method updated successfully',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#tuitionModal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'An error occurred while updating tuition',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message || 'An error occurred',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                        console.error(xhr.responseJSON.message || error);
                    }
                });
            });
        });
    
        function editTuition(studentId, tuition) {
            document.getElementById('tuitionStudentId').value = studentId;
            document.getElementById('tuition').value = tuition;
            $('#tuitionModal').modal('show');
        }
    </script>

</body>

</html>
