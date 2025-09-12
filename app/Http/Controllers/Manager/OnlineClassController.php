<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Online_class;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\Student\NewLiveClassAdded;
use App\Notifications\Teacher\NewLiveClassAdded as TeacherNewLiveClassAdded;
use App\Services\ZoomService;
use Carbon\Carbon;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OnlineClassController extends Controller
{
    protected $zoom;

    public function __construct(ZoomService $zoom)
    {
        $this->zoom = $zoom;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = Grade::all();

        return view('pages.Manager.StudyContent.onlineZoom.create', compact('grades'));
    }

    public function createIndirect()
    {
        $grades = Grade::all();

        return view('pages.Manager.StudyContent.onlineZoom.createIndirect', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Grade_id' => 'required|integer|exists:grades,id',
            'Classroom_id' => 'required|integer|exists:classrooms,id',
            'section_id' => 'required|integer|exists:sections,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date|after:now',
            'duration' => 'required|integer|min:1',
            'password'     => 'nullable|string|max:64',
            'teacher_id' => 'required|integer|exists:teachers,id',
        ]);

        try {
            $startAtLocal = \Carbon\Carbon::parse($request->start_time, 'Asia/Gaza');
            $startAtUtc   = $startAtLocal->clone()->setTimezone('UTC');

            $payload = [
                'topic'     => $request->topic,
                'start_iso' => $startAtUtc->toIso8601String(),  // لزووم
                'timezone'  => 'Asia/Gaza',
                'duration'  => (int) $request->duration,
                'password'  => $request->password, // أو null
            ];

            $meeting = $this->zoom->createMeeting($payload);

            $onlineClass = Online_class::create([
                'integration' => true,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'created_by' => Auth::user()->email,
                'teacher_id' => $request->teacher_id,
                'subject_id' => $request->subject_id,
                'meeting_id' => $meeting['id'],
                'topic' => $meeting['topic'],
                'start_at' => $startAtUtc,
                'duration' => $meeting['duration'],
                'password' => $meeting['password'],
                'start_url' => $meeting['start_url'],
                'join_url' => $meeting['join_url'],
                // 'created_by_teacher_id' => Auth::user()->teacher->id,
            ]);

            $usersQ = User::query()
                ->whereHas('student', function ($q) use ($onlineClass) {
                    $q->where('section_id', $onlineClass->section_id);
                });

            $usersQ->chunkById(200, function ($users) use ($onlineClass) {
                Notification::send($users, new NewLiveClassAdded($onlineClass));
            });

            // Notify the teacher
            $teacherUser = User::whereHas('teacher', function ($q) use ($onlineClass) {
                $q->where('id', $onlineClass->teacher_id);
            })->first();

            Notification::send($teacherUser, new TeacherNewLiveClassAdded($onlineClass));

            Flasher::addSuccess(trans('messages.success'));
            return redirect()->route('StudyContent.index');
        } catch (\Exception $e) {
            try {
                if (!empty($meeting['id'] ?? null)) {
                    $this->zoom->deleteMeeting($meeting['id']);
                }
            } catch (\Throwable $ignored) {
            }

            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function storeIndirect(Request $request)
    {
        $request->validate([
            'Grade_id' => 'required|integer|exists:grades,id',
            'Classroom_id' => 'required|integer|exists:classrooms,id',
            'section_id' => 'required|integer|exists:sections,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'meeting_id' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date|after:now',
            'duration' => 'required|integer|min:1',
            'password' => 'required|string|max:100',
            'start_url' => 'required|url|max:2048',
            'join_url' => 'required|url|max:2048',
            'teacher_id' => 'required|integer|exists:teachers,id',
        ]);

        try {
            $onlineClass = Online_class::create([
                'integration' => false,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'created_by' => Auth::user()->email,
                'teacher_id' => $request->teacher_id,
                'subject_id' => $request->subject_id,
                'meeting_id' => $request->meeting_id,
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $request->duration,
                'password' => $request->password,
                'start_url' => $request->start_url,
                'join_url' => $request->join_url,
                // 'created_by_teacher_id' => Auth::user()->teacher->id,
            ]);

            $usersQ = User::query()
                ->whereHas('student', function ($q) use ($onlineClass) {
                    $q->where('section_id', $onlineClass->section_id);
                });

            $usersQ->chunkById(200, function ($users) use ($onlineClass) {
                Notification::send($users, new NewLiveClassAdded($onlineClass));
            });

            // Notify the teacher
            $teacherUser = User::whereHas('teacher', function ($q) use ($onlineClass) {
                $q->where('id', $onlineClass->teacher_id);
            })->first();

            Notification::send($teacherUser, new TeacherNewLiveClassAdded($onlineClass));

            Flasher::addSuccess(trans('messages.success'));
            return redirect()->route('StudyContent.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Online_class  $online_class
     * @return \Illuminate\Http\Response
     */
    public function show(Online_class $online_class)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Online_class  $online_class
     * @return \Illuminate\Http\Response
     */
    public function edit(Online_class $online_class)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Online_class  $online_class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Online_class $online_class)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Online_class  $online_class
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $info = Online_class::findOrFail($id);

            if ($info->integration) {
                $deleted = $this->zoom->deleteMeeting($info->meeting_id);
                if (!$deleted) {
                    return redirect()->back()->with(['error' => 'Failed to delete Zoom meeting']);
                }
            }

            $info->delete();

            Flasher::addError(trans('messages.Delete'));
            return redirect()->route('StudyContent.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
