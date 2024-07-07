@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Monitoring</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-arrow-up text-success"></i>
                            <span class="font-weight-bold">4% more</span> in 2021
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <table id="questionsTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 5%;text-align: center;">No</th>
                                    <th style="width: 20%;text-align: center;">Project</th>
                                    <th style="width: 50%;text-align: center;">Description</th>
                                    <th style="text-align: center;">Jumlah Peserta</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($projects as $project)
                                    <tr>
                                        <td style="text-align: center;">{{ $i++ }}</td>
                                        <td>{{ $project->project_name }}</td>
                                        <td>{{ $project->project_description }}</td>
                                        <td style="text-align: center;">{{ $project->jumlah_peserta }}</td>
                                        <td style="text-align: center;">
                                            <div class="d-flex gap-2" style="text-align: center;">
                                                <a href="{{ route('home.subtest', [$project->id]) }}" class="btn btn-info">Detail</a>
                                            </div>
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
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#questionsTable').DataTable();
        });
    </script>
@endpush
