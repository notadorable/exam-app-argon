@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Subtest: {{ $subtest->subtest_name }}</h6>
                    </div>
					<div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Duration: {{ $subtest->duration }} minutes</h6>
                    </div>
                    <div class="card-body p-3">
                        @if ($questions->count() > 0)
                            <ul class="list-group">
                                @php $questionNumber = 1; @endphp
                                @foreach ($questions as $question)
                                    <li class="list-group-item">
                                        <h6 class="mb-2">Soal {{ $questionNumber }}. {{ $question->question_name }}</h6>
                                        @if ($choices->where('question_id', $question->id)->count() > 0)
                                            <ul class="list-group list-group-flush">
                                                @foreach ($choices->where('question_id', $question->id) as $choice)
                                                    <li class="list-group-item">
                                                        {{ $choice->choice_type . '. ' . $choice->choice_name }}
                                                        @if ($choice->choice_answer == 'Y')
                                                            <span class="badge bg-success ms-2">Correct</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">No choices found for this question.</p>
                                        @endif
                                    </li>
                                    @php $questionNumber++; @endphp
                                @endforeach
                            </ul>
                        @else
                            <p>No questions found for this subtest.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
