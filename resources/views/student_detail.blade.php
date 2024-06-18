<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <title>Registrar Page</title>
    <link rel="stylesheet" type="text/css" href="header.php">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .dropdown-hidden {
            display: none;
        }
    </style>
</head>
<body>
    @include('header');
    <p class="fs-1 ps-sm-5 font-monospace fw-bold">Student Details</p>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mx-5 font-monospace">
            <li class="breadcrumb-item"><a href="{{ url('/registrar_page') }}">Home</a></li>
            <li class="breadcrumb-item">Details</li>
        </ol>
    </nav>

    <div class="container border-3 border rounded-3">
        <div class="row container-xxl my-1 position-absolute top-50">
            <div class="col-sm-2 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Personal Information</h5>
                        <p class="card-text fw-semibold">Name:<br> {{ $student->firstname }} {{ $student->middle }} {{ $student->lastname }}</p>
                        <p class="card-text fw-semibold">Email:<br> {{ $student->email }}</p>
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#editPersonalInfoModal">Edit</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Subject Schedule and Grade</h5>
                        <button type="button" class="btn btn-success position-absolute top-0 end-0 m-3" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
                        <table class="mt-2 table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Subject Code</th>
                                    <th scope="col">Subject Name</th>
                                    <th scope="col">Schedule</th>
                                    <th scope="col">Instructor</th>
                                    <th scope="col">Grades</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="subjectTableBody" class="auto">
                                @foreach ($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->schedule }}</td>
                                        <td>{{ $subject->instructor }}</td>
                                        <td>{{ $subject->grades }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" onclick="editSubject('{{ $subject->id }}', '{{ $subject->code }}', '{{ $subject->name }}', '{{ $subject->schedule }}', '{{ $subject->instructor }}', '{{ $subject->grades }}')">Edit</button>
                                            <button type="button" class="btn btn-danger" onclick="deleteSubject('{{ $subject->id }}')">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- EDIT PERSONAL INFORMATION MODAL -->
    <div class="modal fade" id="editPersonalInfoModal" tabindex="-1" aria-labelledby="editPersonalInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPersonalInfoModalLabel">Edit Personal Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPersonalInfoForm" action="/updateStudent/{{ $student->id }}" method="POST" onsubmit="event.preventDefault(); saveEditedPersonalInfo(this);">
                        @csrf
                        <div class="mb-3">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" name="editFirstName" value="{{ $student->firstname }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="editMiddleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="editMiddleName" name="editMiddleName" value="{{ $student->middlename }}">
                        </div>
                        <div class="mb-3">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" name="editLastName" value="{{ $student->lastname }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveEditedPersonalInfo()">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD SUBJECT MODAL -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Subject, Grade, and Schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="subjectForm" action="/addSubject/{{ $student->id }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="subjectCode" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="subjectCode" name="code" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="subjectName" class="form-label">Subject Name</label>
                            <select class="form-control" id="subjectName" name="name" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="schedule" class="form-label">Schedule</label>
                            <input type="text" class="form-control" id="schedule" name="schedule" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="instructor" class="form-label">Instructor</label>
                            <input type="text" class="form-control" id="instructor" name="instructor" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="grades" class="form-label">Grades (optional)</label>
                            <input type="text" class="form-control" id="grades" name="grades">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="addSubject()">Add Subject</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT SUBJECT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Subject Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSubjectForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="editSubjectCode" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="editSubjectCode" name="editSubjectCode" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="editSubjectName" class="form-label">Subject Name</label>
                            <select class="form-control" id="editSubjectName" name="editSubjectName" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="editSchedule" class="form-label">Schedule</label>
                            <input type="text" class="form-control" id="editSchedule" name="editSchedule" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="editInstructor" class="form-label">Instructor</label>
                            <input type="text" class="form-control" id="editInstructor" name="editInstructor" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="editGrades" class="form-label">Grades</label>
                            <input type="text" class="form-control" id="editGrades" name="editGrades">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveEditedSubject()">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    <script>
        // Arrays of subjects and instructors with their details
        const subjectDetails = {
            '': { code: '', schedule: '', instructor: '' },
            'IT Elec 04': { code: 'ITE04', schedule: 'Mon-Wed-Fri 10:00-11:00', instructor: 'Ebrahim Diangca' },
            'SIA 01': { code: 'SIA01', schedule: 'Tue-Thu 09:00-10:30', instructor: 'Aphrodite Gajo' },
            'SIA 02': { code: 'SIA02', schedule: 'Mon-Wed 13:00-14:30', instructor: 'John Mercaral' },
            'Capstone 01': { code: 'CAP01', schedule: 'Wed-Fri 11:00-12:30', instructor: 'Jayvee Migue' },
            'Capstone 02': { code: 'CAP02', schedule: 'Mon-Wed-Fri 15:00-16:30', instructor: 'Ralph Mandin' },
            'Science': { code: 'SCI01', schedule: 'Tue-Thu 14:00-15:30', instructor: 'Deyv Quillisadio' },
            'Math': { code: 'MTH01', schedule: 'Mon-Wed 09:00-10:30', instructor: 'Ebrahim Diangca' },
            'Filipino': { code: 'FIL01', schedule: 'Mon-Fri 08:00-09:00', instructor: 'Aphrodite Gajo' },
            'English': { code: 'ENG01', schedule: 'Tue-Thu 10:30-12:00', instructor: 'John Mercaral' }
        };

        // Function to populate subject dropdown and set event listener
        function populateSubjectDropdown() {
            const subjectSelect = document.getElementById('subjectName');
            const editSubjectSelect = document.getElementById('editSubjectName');

            for (const subject in subjectDetails) {
                const option = document.createElement('option');
                option.value = subject;
                option.text = subject;
                subjectSelect.add(option);
                editSubjectSelect.add(option.cloneNode(true));
            }

            subjectSelect.addEventListener('change', function() {
                fillSubjectDetails(subjectSelect.value);
            });

            editSubjectSelect.addEventListener('change', function() {
                fillEditSubjectDetails(editSubjectSelect.value);
            });
        }

        // Function to fill subject details in add modal
        function fillSubjectDetails(subject) {
            if (subjectDetails[subject]) {
                document.getElementById('subjectCode').value = subjectDetails[subject].code;
                document.getElementById('schedule').value = subjectDetails[subject].schedule;
                document.getElementById('instructor').value = subjectDetails[subject].instructor;
            }
        }

        // Function to fill subject details in edit modal
        function fillEditSubjectDetails(subject) {
            if (subjectDetails[subject]) {
                document.getElementById('editSubjectCode').value = subjectDetails[subject].code;
                document.getElementById('editSchedule').value = subjectDetails[subject].schedule;
                document.getElementById('editInstructor').value = subjectDetails[subject].instructor;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            populateSubjectDropdown();
        });

        function editPersonalInfo(firstName, middleName, lastName, email) {
            document.getElementById('editFirstName').value = firstName;
            document.getElementById('editMiddleName').value = middleName;
            document.getElementById('editLastName').value = lastName;
            $('#editPersonalInfoModal').modal('show');
        }

        function saveEditedPersonalInfo(form) {
            const url = form.action;
            const formData = $(form).serialize();
            console.log(formData);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Personal information edited successfully',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#editPersonalInfoModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'An error occurred while editing personal information',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    console.error(error);
                }
            });
        }

        function addSubject() {
            const form = document.getElementById('subjectForm');
            const url = form.action;
            const formData = $(form).serialize();
            console.log(url);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Subject added successfully',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'An error occurred while adding the subject.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    console.error(error);
                }
            });
        }

        function editSubject(id, code, name, schedule, instructor, grades) {
            document.getElementById('editSubjectCode').value = code;
            document.getElementById('editSubjectName').value = name;
            document.getElementById('editSchedule').value = schedule;
            document.getElementById('editInstructor').value = instructor;
            document.getElementById('editGrades').value = grades;

            const form = document.getElementById('editSubjectForm');
            form.action = '/updateSubject/' + id;
            console.log(form.action);
            $('#editModal').modal('show');
        }

        function saveEditedSubject() {
            const form = document.getElementById('editSubjectForm');
            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Subject edited successfully',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#editModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'An error occurred while editing',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    console.error(error);
                }
            });
        }

        function deleteSubject(id) {
            $.ajax({
                type: 'POST',
                url: '/deleteSubject/' + id,
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Subject deleted successfully',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'An error occurred while deleting',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred',
                    });
                    console.error(error);
                }
            });
        }
    </script>
</body>
</html>
