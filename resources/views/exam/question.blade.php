<div class="d-flex align-items-center justify-content-between">
    <h1 class="mb-4">{{$subtest->subtest_name}}</h1>

    @if ($participant->jadwal->status_test == 0)
        <div class="d-flex align-items-center" style="gap: 16px;">

            <button type="button" class="btn btn-primary  mb-0" onclick="submitAnswer()" id="newSubmit">Submit</button>
        </div>
    @endif

</div>
<div>
    <div id="response-message"></div>

    {{-- <div>{{$participant->jadwal->status_test}}</div> --}}
</div>
@if ($participant->jadwal->status_test == 1)
    <div class="alert alert-success text-white" role="alert">
        Jawaban sudah di submit pada {{$participant->jadwal->updated_time}}
    </div>
@else
<div class="row">
    <div class="col-md-3">
        <h5>Navigation</h5>
        <ul class="list-group mb-4" id="navigationList">
            @for ($i = 1; $i <= $subtest->questions->count(); $i++)
                <li class="cursor-pointer list-group-item d-flex justify-content-between align-items-center nav-item" data-soal="{{ $i }}" id="navItem{{ $i }}">
                    Soal {{ $i }}
                    <span class="badge bg-secondary statusBadge" id="statusBadge{{ $i }}">Belum</span>
                </li>
            @endfor
        </ul>
    </div>
    <div class="col-md-9">
        <form id="ujianForm" class="mb-2">
            @csrf
            <input type="hidden" name="project_id" value="{{$participant->project_id}}">
            <input type="hidden" name="participant_id" value="{{$participant_id}}">
            <input type="hidden" name="subtest_id" value="{{$subtest_id}}">
            @for ($i = 1; $i <= $subtest->questions->count(); $i++)
                <div class="soal" id="soal{{ $i }}" style="display: {{ $i === 1 ? 'block' : 'none' }};">
                    <div class="mb-4">
                        <h5>{{$subtest->questions[$i-1]->question_name}}</h5>
                        <p>{{$subtest->questions[$i-1]->question_detail}}</p>

                        @foreach ($subtest->questions[$i-1]->choice as $i2 => $item)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="soal{{ $i }}" id="soal{{ $i }}_{{$item->choice_type}}" value="{{json_encode([
                                    "question_id" => $subtest->questions[$i-1]->id,
                                    "choice_id" => $item->id,
                                    "choice_type" => $item->choice_type
                                ])}}">
                                <label class="form-check-label" for="soal{{ $i }}_{{$item->choice_type}}">
                                    {{$item->choice_type}}. {{$item->choice_name}}
                                </label>
                            </div>
                        @endforeach

                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-warning markBtn mb-0" data-soal="{{ $i }}">Mark for Review</button>
                    </div>
                </div>
            @endfor


        </form>
        <div class="d-flex justify-content-between" style="gap: 8px;">
            <button type="button" class="btn btn-secondary mb-0" id="prevBtn" onclick="changeSoal(-1)" disabled>Previous</button>
            <button type="button" class="btn btn-secondary mb-0" id="nextBtn" onclick="changeSoal(1)">Next</button>
        </div>
    </div>
</div>
@endif


<script>


updateNavigation();


</script>

