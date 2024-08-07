@extends('layouts.participant', ['class' => 'g-sidenav-show bg-gray-100'])


<style>
    .navbar-vertical.bg-white .navbar-nav > .nav-item .nav-link.active {
    background-color: #ffeeea !important;
    box-shadow: none;
}

.subtest-title {
    font-size: 14px;
    font-weight: 800;
}
.profile-card {
      max-width: 400px;
      /* margin: 20px auto; */
      /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
      border-radius: 10px;
      overflow: hidden;
      background-color: #fff;
      display: flex;
      align-items: center;
      padding: 20px;
    }
    .profile-card img {
        width: 40;
    height: 40;
    border-radius: 50%;
    object-fit: cover;
    }
    .profile-card .card-body {
      flex: 1;
    }

    .navbar-vertical {
        overflow: hidden !important;
    }

    .navbar-collapse {
        overflow: auto
    }
</style>

@section('content')
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
        <div class="sidenav-header">
            <div class="profile-card" style="gap: 8px;">
                <img src="https://via.placeholder.com/80" alt="Profile Photo">
                <div class="w-100">
                  <h5 class="card-title mb-0">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</h5>
                  <p class="card-text">{{auth()->user()->email}}</p>
                </div>
              </div>
        </div>
        <div class="p-3">
            <form class="mb-0" role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <div class="d-flex justify-content-end">
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Log out</span>
                    </a>
                </div>
            </form>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " style="height: 65%;" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                @foreach($participant as $i => $p)
                    <li class="nav-item">
                        <a class="nav-link subtest-item " subtest-id="{{$p->subtest->id}}" subtest-index="{{$i + 1}}" href="javascript:void(0)" onclick="loadSoal({{$p->subtest->id}}, {{$p->id}}, {{$p->subtest->questions->count()}}, this)">
                            {{-- <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                            </div> --}}
                            <div class="border  w-100 p-2" style="border-radius: 8px;">
                                <div class="d-flex flex-column">
                                    <div class="subtest-title">{{$p->subtest->subtest_name}}
                                    </div>
                                    <div style="font-size: 12px;color: #acacac;">
                                       <i class="fa fa-calendar"></i> {{$p->jadwal->start_date}}
                                    </div>
                                    <div style="font-size: 12px;color: #acacac;">
                                        <i class="fa fa-clock"></i> {{$p->jadwal->start_time}} - {{$p->jadwal->end_time}}
                                    </div>
                                    @if ($p->jadwal->status_test == 1)
                                        <div style="font-size: 12px;color: green;">
                                            <i class="fa fa-check"></i> {{$p->jadwal->updated_time}}
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
    </aside>

    <main class="main-content border-radius-lg">
        <div class="container mt-5" id="items-container">

        </div>
    </main>




@endsection

@push('js')

<script>


let currentSoal = 1;
let countSoal = 1;

let markedSoal = [];
let answeredSoal = [];

function loadSoal(subtest_id, participant_id, jumlah_soal, subtest) {
    $.ajax({
        url: `/exam/question/${subtest_id}/${participant_id}`,
        type: 'GET',
        beforeSend:  function(data) {
            $('#items-container').html('Loading...');
            $('.subtest-item').removeClass('active')

            $(subtest).addClass('active')
        },
        success: function(data) {
            currentSoal = 1;
            markedSoal = [];
            answeredSoal = [];
            countSoal = jumlah_soal

            $('#items-container').html(data);


            bindEvents()
        },
        error: function() {
            alert('Gagal memuat item.');
        }
    });
}


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

    if (currentSoal === countSoal) {
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
    for (let i = 1; i <= countSoal; i++) {
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

        if (currentSoal === countSoal) {
            $('#nextBtn').hide();
            $('#submitBtn').show();
        } else {
            $('#nextBtn').show();
            $('#submitBtn').hide();
        }


    }
}

function submitAnswer() {
    if (answeredSoal.length == countSoal) {
        $('#ujianForm').submit()
    } else {
        alert('Mohon pastikan mengisi semua jawaban.')
    }
}

function bindEvents() {
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

        if (currentSoal === countSoal) {
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
        result.answer = []

        formData.forEach(function(item) {
            if (item.name.includes('soal')) {
                result.answer.push(JSON.parse(item.value));
            } else {
                result[item.name] = item.value;
            }

        });

        result.markedSoal = markedSoal;

        console.log(result); // Display the result in console

        // Optionally, you can use AJAX to submit the form data to the server

        $.ajax({
            url: '/exam/submit',
            type: 'POST',
            data: result,
            beforeSend: function() {
                $('#newSubmit').attr('disabled', true)
                $('#response-message').html('')
            },
            success: function(response) {
                // Tampilkan pesan sukses
                // console.log(response)
                if (response.success) {
                    $('#response-message').html(`
                        <div class="alert alert-success text-white" role="alert">
                            ${response.message}
                        </div>
                    `)

                    window.location.reload()
                } else {
                    $('#response-message').html(`
                        <div class="alert alert-danger text-white" role="alert">
                            ${response.message}
                        </div>
                    `)

                    $('#newSubmit').attr('disabled', false)
                }

            },
            error: function(xhr) {
                $('#response-message').html(`
                <div class="alert alert-danger text-white" role="alert">
                    Internal server error
                </div>
                `);
                $('#newSubmit').attr('disabled', false)
            }
        });

    });
}

    $(document).ready(function() {

    });


</script>


@endpush
