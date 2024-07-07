@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Subtest Details'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Participant Details for Subtest: {{ $subtestName }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-3">
                            <table id="questionsTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Participant Name</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->name }}</td>
                                            <td>{{ $participant->score }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#questionsTable').DataTable();
        });
    </script>
@endpush