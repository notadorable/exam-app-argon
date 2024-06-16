@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Master Question'])
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Master Question</h6>
                        <a href="{{ route('question.create') }}" class="btn btn-primary float-right">Create</a>
                    </div>
                    <div class="card-body p-3">
                        <table id="questionsTable" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 5%;text-align: center;">No</th>
                                    <th style="width: 70%;text-align: center;">Subtest</th>
                                    <th style="text-align: center;">Jumlah Soal</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($subtests as $subtest)
                                    <tr>
                                        <td style="text-align: center;">{{ $i++ }}</td>
                                        <td>{{ $subtest->subtest_name }}</td>
                                        <td style="text-align: center;">{{ $subtest->question_count }}</td>
                    
                                        <td style="text-align: center;">
                                            <div class="d-flex gap-2" style="text-align: center;">
                                                <a href="{{ route('question.show', [$subtest->id]) }}" class="btn btn-info">Show</a>
                                                <a href="{{ route('question.edit', [$subtest->id]) }}" class="btn btn-primary">Edit</a>
                                                <form action="{{ route('question.destroy', [$subtest->id]) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
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
        {{-- @include('layouts.footers.auth.footer') --}}
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#questionsTable').DataTable();
        });
    </script>
@endpush
