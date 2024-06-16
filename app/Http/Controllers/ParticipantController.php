<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Subtest;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        return view('participant.index', []);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);


        DB::transaction(function () use ($request) {
            $project_id = $request->input('project_id');
            $file = $request->file('file');
            $parsed = Excel::toArray([], $file);
            $header = array_shift($parsed[0]);
            $data = $parsed[0];
            $map_data = [];

            foreach ($data as $key => $row) {
                $participant = [];

                foreach ($header as $key_H => $column) {
                    $participant[$column] = $row[$key_H];
                }

                $map_data[] = $participant;
            }

            $subtest_list = Subtest::where('is_active', 1)->get()->toArray();

            foreach ($map_data as $key => $row) {

                $user = User::where('email', $row['email'])->first();
                if (empty($user)) {
                    $user = new User();
                    $user->username = generateRandomString();
                    $user->password = bcrypt($user->username);
                }
                $user->firstname = $row['firstname'];
                $user->lastname = $row['lastname'];
                $user->email = $row['email'];
                $user->save();

                Participant::where('nik', $user->username)->delete();
                Jadwal::where('nik', $user->username)->delete();

                $start_time = $row['start_time'];

                foreach ($subtest_list as $key => $value) {
                    $participant = new Participant();
                    $participant->project_id = $project_id;
                    $participant->subtest_id = $value['id'];
                    $participant->nik = $user->username;
                    $participant->name = $user->firstname . ' ' . $user->lastname;
                    $participant->is_active = 1;
                    $participant->created_by = 'admin';
                    $participant->created_time = date('Y-m-d H:i:s');
                    if ($participant->save()) {

                        $jadwal = new Jadwal();
                        $jadwal->project_id = $project_id;
                        $jadwal->participant_id = $participant->id;
                        $jadwal->nik = $user->username;
                        $jadwal->name = $user->firstname . ' ' . $user->lastname;
                        $jadwal->start_date = $row['start_date'];
                        $jadwal->end_date = $row['end_date'];
                        $jadwal->start_time = $start_time;
                        $jadwal->end_time = date('H:i:s', strtotime('+'.$value['duration'].' minutes', strtotime($start_time)));
                        $jadwal->status_test = 0;
                        $jadwal->is_active = 1;
                        $jadwal->created_by = 'admin';
                        $jadwal->created_time = date('Y-m-d H:i:s');
                        $jadwal->save();

                        $start_time = $jadwal->end_time;
                    }
                }
            }

        });

        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }
}

function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
