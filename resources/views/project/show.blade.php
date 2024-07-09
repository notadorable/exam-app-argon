@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Project: {{ $project->project_name }}</h6>
                    </div>
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Description: {{ $project->project_description }}</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <h6 class="text-capitalize">Subtests:</h6>
                            <ul class="list-group">
                                @foreach ($project->mapping as $mapping)
                                    <li class="list-group-item">{{ $mapping->subtest->subtest_name }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-3">
                            <h6 class="text-capitalize">Upload Participants from Excel:</h6>
                            {{ Form::open(['route' => 'participant.upload', 'id' => 'uploadForm']) }}
                                <input type="hidden" class="form-control" name="project_id" placeholder="Project ID" value="{{ $project->id }}">
                                <div class="form-group">
                                    <input type="file" class="form-control" name="file" id="exampleFormControlInput1" placeholder="Participant list">
                                </div>
                                <div class="text-right" style="text-align:right;">
                                    <button type="submit" class="btn btn-primary float-right" id="upload-btn">Upload Data</a>
                                </div>
                            {{ Form::close() }}
                            <div id="result"></div>
                        </div>

                        <h6 class="text-capitalize">Participants:</h6>
                        <table id="participantsTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 5%;text-align: center;">No</th>
                                    {{-- <th style="width: 20%;text-align: center;">NIK</th> --}}
                                    <th style="width: 30%;text-align: center;">Name</th>
                                    <th style="width: 30%;text-align: center;">Email</th>
                                    <th style="width: 30%;text-align: center;">Datetime</th>
                                    <th style="width: 30%;text-align: center;">Subtest</th>
                                    <th style="width: 30%;text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($participants as $participant)
                                    <tr>
                                        <td style="text-align: center;">{{ $i++ }}</td>
                                        {{-- <td style="text-align: center;">{{ $participant->nik }}</td> --}}
                                        <td style="text-align: center;">{{ $participant->name }}</td>
                                        <td style="text-align: center;">
                                            <div>{{ $participant->user->email }}</div>
                                            <div>{{ $participant->user->username }}</div>
                                        </td>
                                        <td style="text-align: center;">{{ $participant->jadwal->start_time }} - {{ $participant->jadwal->end_time }}</td>
                                        <td style="text-align: center;">{{ $participant->subtest->subtest_name }}</td>
                                        <td style="text-align: center;">{{ $participant->jadwal->status_test == 1 ? 'Selesai' : 'Belum Mulai' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#participantsTable').DataTable();
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('participant.upload') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function(response) {
                        $('#upload-btn').attr('disabled', true)
                    },
                    success: function(response) {
                        if(response.success) {
                            var result = '<h1>Parsed Excel Data</h1>';
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Participants uploaded successfully!',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                // Reload the page after SweetAlert is closed
                                location.reload();
                            });
                        }

                        $('#upload-btn').attr('disabled', false)
                    },
                    error: function(xhr) {
                        var errorMessage = '<div>Error: ' + xhr.status + ' ' + xhr.statusText + '</div>';
                        $('#messages').html(errorMessage);

                        $('#upload-btn').attr('disabled', false)
                    }
                });
            });
        });
    </script>
@endpush
