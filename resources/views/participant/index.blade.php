@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Manage Participant'])
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Participant</h6>
                        <a href="{{ route('question.create') }}" class="btn btn-primary float-right">Upload Data</a>
                    </div>
                    <div class="card-body p-3">

                    </div>
                </div>
            </div>
        </div>
        {{-- @include('layouts.footers.auth.footer') --}}
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // $('#questionsTable').DataTable();
        });
    </script>
@endpush
