@extends('layouts.participant', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
   <!-- resources/views/ujian.blade.php -->
     <!-- Main Content -->
     <div class="container mt-5">
        <h1 class="mb-4">Soal Ujian Online</h1>
        <div class="row">
            <div class="col-md-3">
                <h5>Navigation</h5>
                <ul class="list-group mb-4" id="navigationList">
                    @for ($i = 1; $i <= 10; $i++)
                        <li class="list-group-item d-flex justify-content-between align-items-center nav-item" data-soal="{{ $i }}" id="navItem{{ $i }}">
                            Soal {{ $i }}
                            <span class="badge bg-secondary statusBadge" id="statusBadge{{ $i }}">Belum</span>
                        </li>
                    @endfor
                </ul>
                {{-- <div class="card mt-5" id="markedQuestionsCard" style="display: none;">
                    <div class="card-header">
                        Soal yang Ditandai
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="markedQuestionsList"></ul>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-9">
                <form id="ujianForm">
                    @csrf
                    @for ($i = 1; $i <= 10; $i++)
                        <div class="soal" id="soal{{ $i }}" style="display: {{ $i === 1 ? 'block' : 'none' }};">
                            <div class="mb-4">
                                <h5>Soal {{ $i }}</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="soal{{ $i }}" id="soal{{ $i }}a" value="a">
                                    <label class="form-check-label" for="soal{{ $i }}a">
                                        A. Pilihan A
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="soal{{ $i }}" id="soal{{ $i }}b" value="b">
                                    <label class="form-check-label" for="soal{{ $i }}b">
                                        B. Pilihan B
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="soal{{ $i }}" id="soal{{ $i }}c" value="c">
                                    <label class="form-check-label" for="soal{{ $i }}c">
                                        C. Pilihan C
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="soal{{ $i }}" id="soal{{ $i }}d" value="d">
                                    <label class="form-check-label" for="soal{{ $i }}d">
                                        D. Pilihan D
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="soal{{ $i }}" id="soal{{ $i }}e" value="e">
                                    <label class="form-check-label" for="soal{{ $i }}e">
                                        E. Pilihan E
                                    </label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-warning markBtn" data-soal="{{ $i }}">Mark for Review</button>
                        </div>
                    @endfor

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeSoal(-1)" disabled>Previous</button>
                        <button type="button" class="btn btn-secondary" id="nextBtn" onclick="changeSoal(1)">Next</button>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" style="display: none;" id="submitBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>



@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        let currentSoal = 1;
        let markedSoal = [];
        let answeredSoal = [];

        updateNavigation();

        function changeSoal(n) {
            // Hide current soal
            $('#soal' + currentSoal).hide();

            // Update currentSoal
            currentSoal += n;

            // Show new soal
            $('#soal' + currentSoal).show();

            // Enable/Disable buttons
            if (currentSoal === 1) {
                $('#prevBtn').attr('disabled', true);
            } else {
                $('#prevBtn').attr('disabled', false);
            }

            if (currentSoal === 10) {
                $('#nextBtn').hide();
                $('#submitBtn').show();
            } else {
                $('#nextBtn').show();
                $('#submitBtn').hide();
            }

            // Check if the current question is marked
            if (markedSoal.includes(currentSoal)) {
                $('.markBtn[data-soal="' + currentSoal + '"]').text('Unmark');
            } else {
                $('.markBtn[data-soal="' + currentSoal + '"]').text('Mark for Review');
            }

            updateNavigation();
        }

        function updateNavigation() {
            for (let i = 1; i <= 10; i++) {
                if (markedSoal.includes(i)) {
                    $('#navItem' + i).addClass('list-group-item-warning');
                } else {
                    $('#navItem' + i).removeClass('list-group-item-warning');
                }

                if (answeredSoal.includes(i)) {
                    $('#statusBadge' + i).removeClass('bg-secondary').addClass('bg-success').text('Sudah');
                } else {
                    $('#statusBadge' + i).removeClass('bg-success').addClass('bg-secondary').text('Belum');
                }

                if (i === currentSoal) {
                    $('#navItem' + i).addClass('active');
                } else {
                    $('#navItem' + i).removeClass('active');
                }
            }
        }

        $(document).ready(function() {
            $('.markBtn').on('click', function() {
                const soalNumber = $(this).data('soal');
                const index = markedSoal.indexOf(soalNumber);

                if (index > -1) {
                    // Unmark the question
                    markedSoal.splice(index, 1);
                    $(this).text('Mark for Review');
                    $('#markedQuestion' + soalNumber).remove();
                } else {
                    // Mark the question
                    markedSoal.push(soalNumber);
                    $(this).text('Unmark');
                    // $('#markedQuestionsList').append('<li class="list-group-item" id="markedQuestion' + soalNumber + '"><a href="#" class="markedQuestionLink" data-soal="' + soalNumber + '">Soal ' + soalNumber + '</a></li>');
                }

                // Show or hide the marked questions card
                // if (markedSoal.length > 0) {
                //     $('#markedQuestionsCard').show();
                // } else {
                //     $('#markedQuestionsCard').hide();
                // }

                updateNavigation();
                console.log('Marked Questions:', markedSoal);
            });

            $('#navigationList').on('click', '.nav-item', function() {
                const soalNumber = $(this).data('soal');
                // Hide current soal
                $('#soal' + currentSoal).hide();
                // Update currentSoal
                currentSoal = soalNumber;
                // Show new soal
                $('#soal' + currentSoal).show();

                // Enable/Disable buttons
                if (currentSoal === 1) {
                    $('#prevBtn').attr('disabled', true);
                } else {
                    $('#prevBtn').attr('disabled', false);
                }

                if (currentSoal === 10) {
                    $('#nextBtn').hide();
                    $('#submitBtn').show();
                } else {
                    $('#nextBtn').show();
                    $('#submitBtn').hide();
                }

                // Check if the current question is marked
                if (markedSoal.includes(currentSoal)) {
                    $('.markBtn[data-soal="' + currentSoal + '"]').text('Unmark');
                } else {
                    $('.markBtn[data-soal="' + currentSoal + '"]').text('Mark for Review');
                }

                updateNavigation();
            });

            $('#markedQuestionsList').on('click', '.markedQuestionLink', function(e) {
                e.preventDefault();
                const soalNumber = $(this).data('soal');
                // Hide current soal
                $('#soal' + currentSoal).hide();
                // Update currentSoal
                currentSoal = soalNumber;
                // Show new soal
                $('#soal' + currentSoal).show();

                // Enable/Disable buttons
                if (currentSoal === 1) {
                    $('#prevBtn').attr('disabled', true);
                } else {
                    $('#prevBtn').attr('disabled', false);
                }

                if (currentSoal === 10) {
                    $('#nextBtn').hide();
                    $('#submitBtn').show();
                } else {
                    $('#nextBtn').show();
                    $('#submitBtn').hide();
                }

                // Check if the current question is marked
                if (markedSoal.includes(currentSoal)) {
                    $('.markBtn[data-soal="' + currentSoal + '"]').text('Unmark');
                } else {
                    $('.markBtn[data-soal="' + currentSoal + '"]').text('Mark for Review');
                }

                updateNavigation();
            });

            $('input[type=radio]').on('change', function() {
                const soalNumber = $(this).attr('name').replace('soal', '');
                if (!answeredSoal.includes(parseInt(soalNumber))) {
                    answeredSoal.push(parseInt(soalNumber));
                }
                updateNavigation();
            });

            $('#ujianForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission

                let formData = $(this).serializeArray();
                let result = {};

                formData.forEach(function(item) {
                    result[item.name] = item.value;
                });

                result.markedSoal = markedSoal;

                console.log(result); // Display the result in console

                // Optionally, you can use AJAX to submit the form data to the server

            });
        });
    </script>
@endpush
