
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
    <title>Student Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    @include('header');
    <div class="container border-3 border rounded-3 my-5">
        <div class="row container position-absolute top-0">
            <div class="col-sm-2 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Personal Information</h5>
                        <p class="card-text fw-semibold">Name:<br> {{ auth()->user()->firstname }} {{ auth()->user()->middlename }} {{ auth()->user()->lastname }}</p>
                        <p class="card-text fw-semibold">Email:<br> {{ auth()->user()->email }}</p>
                        <p class="card-text fw-semibold">Tuition:<br> {{ auth()->user()->tuition }} </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Enrollment Details</h5>
                        @if ($subjects->isNotEmpty())
                            <table class="mt-2 table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Subject Code</th>
                                        <th scope="col">Subject Name</th>
                                        <th scope="col">Schedule</th>
                                        <th scope="col">Instructor</th>
                                        <th scope="col">Grades</th>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No enrollment details available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
