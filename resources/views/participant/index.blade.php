@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Manage Participant'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Participant</h6>
                    </div>
                    <div class="card-body p-3">
                        {{ Form::open(['route' => 'participant.upload', 'id' => 'uploadForm']) }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="project_id" placeholder="Project ID">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="file" id="exampleFormControlInput1" placeholder="Participant list">
                        </div>
                        <div class="text-right" style="text-align:right;">
                            <button type="submit" class="btn btn-primary float-right">Upload Data</a>
                        </div>
                        {{ Form::close() }}
                        <div id="result"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('layouts.footers.auth.footer') --}}
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
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
                    success: function(response) {
                        if(response.success) {
                            var result = '<h1>Parsed Excel Data</h1>';
                            response.data.forEach(function(sheet) {
                                result += '<h2>Sheet:</h2><table border="1">';
                                sheet.forEach(function(row) {
                                    result += '<tr>';
                                    row.forEach(function(cell) {
                                        result += '<td>' + cell + '</td>';
                                    });
                                    result += '</tr>';
                                });
                                result += '</table>';
                            });
                            $('#result').html(result);
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = '<div>Error: ' + xhr.status + ' ' + xhr.statusText + '</div>';
                        $('#messages').html(errorMessage);
                    }
                });
            });
        });
    </script>
@endpush
