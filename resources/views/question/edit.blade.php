@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Edit Subtest</h6>
                    </div>
                    <div class="card-body p-3">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }} <br>
                                @endforeach
                            </div>
                        @endif

                        {{ Form::model($subtest, array('route' => array('question.update', $subtest->id), 'method' => 'PUT')) }}

                        <div class="mb-3">
                            {{ Form::label('subtest_name', 'Subtest Name', ['class'=>'form-label']) }}
                            {{ Form::text('subtest_name', $subtest->subtest_name, array('class' => 'form-control')) }}
                            {{ Form::hidden('formula_id', 1) }}
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" id="addQuestionButton">Add Question</button>
                        </div>

                        <div id="questionFields" class="mb-5">
                            @php $questionIndex = 0; @endphp
                            @foreach ($questions as $question)
                                <div class="mb-3" id="questionField-{{ $question->id }}">
                                    <div class="row">
                                        <div class="col-md-9">
                                            {{ Form::label('question_name[' . $question->id . ']', 'Question Name', ['class'=>'form-label']) }}
                                            {{ Form::textarea('question_name[' . $question->id . ']', $question->question_name, array('class' => 'form-control', 'rows' => 3)) }}
                                        </div>
                                        <div class="col-md-3 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger me-2" onclick="removeQuestionField('questionField-{{ $question->id }}')">Remove</button>
                                        </div>
                                        <div class="col-md-12 mt-2"><button type="button" class="btn btn-secondary" onclick="addChoice('questionField-{{ $question->id }}')">Add Choice</button></div>
                                    </div>
                                    <div id="choiceFields-{{ $question->id }}">
                                        @php $choiceIndex = 0; @endphp
                                        @foreach ($choices->where('question_id', $question->id) as $choice)
                                            <div class="mb-2" id="choiceField-{{ $question->id }}-{{ $choiceIndex }}">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        {{ Form::label('choice_name[' . $question->id . '][' . $choiceIndex . ']', 'Choice', ['class'=>'form-label']) }}
                                                        {{ Form::text('choice_name[' . $question->id . '][' . $choiceIndex . ']', $choice->choice_name, array('class' => 'form-control')) }}
                                                        <div class="form-check">
                                                            {{ Form::hidden('choice_answer[' . $question->id . '][' . $choiceIndex . ']', 'false') }}
															{{ Form::radio('choice_answer[' . $question->id . '][' . $choiceIndex . ']', 'true', $choice->choice_answer == 'Y' ? true : false, ['class' => 'form-check-input', 'id' => 'customRadio' . $question->id . $choiceIndex]) }}
                                                            <label class="form-check-label" for="customRadio{{ $question->id }}{{ $choiceIndex }}">Correct Answer</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-center">
                                                        <button type="button" class="btn btn-danger ms-2" onclick="removeChoice('choiceField-{{ $question->id }}-{{ $choiceIndex }}')">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @php $choiceIndex++; @endphp
                                        @endforeach
                                    </div>
                                </div>
                                @php $questionIndex++; @endphp
                            @endforeach
                        </div>

                        {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
		$('#addQuestionButton').click(function() {
			var questionCount = $('#questionFields').children().length;
			var newQuestionField = `
				<div class="mb-3" id="questionField-${questionCount}">
					<div class="row">
						<div class="col-md-9">
							{{ Form::label('question_name[]', 'Question Name', ['class'=>'form-label']) }}
							{{ Form::textarea('question_name[]', null, array('class' => 'form-control', 'rows' => 3)) }}
						</div>
						<div class="col-md-3 d-flex align-items-center">
							<button type="button" class="btn btn-danger me-2" onclick="removeQuestionField('questionField-${questionCount}')">Remove</button>
						</div>
						<div class="col-md-12 mt-2"><button type="button" class="btn btn-secondary" onclick="addChoice('questionField-${questionCount}')">Add Choice</button></div>
					</div>
					<div id="choiceFields-${questionCount}">
					</div>
				</div>
			`;

			$('#questionFields').append(newQuestionField);
		});
    });

	function addChoice(questionFieldId) {
		var questionIndex = parseInt(questionFieldId.split('-')[1]);
		var choiceCount = $('#' + questionFieldId + ' #choiceFields-' + questionFieldId.split('-')[1]).children().length;
        if (choiceCount < 5) {
            var newChoiceField = `
                <div class="mb-2" id="choiceField-${questionFieldId}-${choiceCount}">
                    <div class="row">
                        <div class="col-md-9">
                            {{ Form::label('choice_name[${questionIndex}][${choiceCount}]', 'Choice', ['class'=>'form-label']) }}
                            {{ Form::text('choice_name[${questionIndex}][${choiceCount}]', null, array('class' => 'form-control')) }}
							<div class="form-check">
								{{ Form::hidden('choice_answer[${questionIndex}][${choiceCount}]', 'false') }}
								{{ Form::radio('choice_answer[${questionIndex}][${choiceCount}]', 'true', false, ['class' => 'form-check-input', 'id' => 'customRadio${questionIndex}_${choiceCount}']) }}
								<label class="form-check-label" for="customRadio${questionIndex}_${choiceCount}">Correct Answer</label>
							</div>

                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="button" class="btn btn-danger ms-2" onclick="removeChoice('choiceField-${questionFieldId}-${choiceCount}')">Remove</button>
                        </div>
                    </div>
                </div>
            `;
            $('#' + questionFieldId + ' #choiceFields-' + questionFieldId.split('-')[1]).append(newChoiceField);
        } else {
            alert('Maximum 5 choices allowed.');
        }
	}

	function removeQuestionField(fieldId) {
		$('#' + fieldId).remove();
	}

	function removeChoice(choiceId) {
		$('#' + choiceId).remove();
	}
</script>
@endpush