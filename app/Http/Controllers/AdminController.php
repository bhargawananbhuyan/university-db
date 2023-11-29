<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Feedback;
use App\Models\Message;
use App\Models\StudentCourse;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function profile()
    {
        return view("admin.profile");
    }

    public function feedback(Request $request)
    {
        $tickets = Feedback::where('to_id', $request->user()->id)->get();

        return view('admin.feedback', compact('tickets'));
    }

    public function reply_to_feedback(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'reply' => 'required|string',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        Feedback::where('id', $id)->update([
            'reply' => $request->reply
        ]);

        return redirect()->back();
    }

    public function manage_users(Request $request)
    {
        $users = User::whereNot('role', 'administrator')->get();

        return view('admin.manage-users', compact('users'));
    }

    public function remove_user(int $id)
    {
        User::whereId($id)->delete();

        return redirect()->back();
    }

    public function add_user_form()
    {
        return view('admin.add-user');
    }

    public function add_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'role' => 'required|in:student,instructor,program_coordinator,quality_assurance_officer',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make('12345678'),
        ]);

        return redirect()->route('administrator.manage_users')
            ->with('success', 'User added successfully.');
    }

    public function user_permissions()
    {
        $users = User::whereNot('role', 'administrator')->get();

        return view('admin.user-permissions', compact('users'));
    }

    public function update_user(int $id)
    {
        User::whereId($id)->update([
            'blocked' => !User::whereId($id)->first()->blocked,
        ]);

        return redirect()->back();
    }

    public function students(Request $request)
    {
        $courses = Course::all(['id', 'name']);

        $student_courses = null;
        $course_id = $request->query('course');

        if (isset($course_id))
            $student_courses = StudentCourse::where('course_id', $course_id)->get();

        return view('admin.students', compact('courses', 'student_courses'));
    }

    public function student_details(int $course_id, int $student_id)
    {
        $student_course = StudentCourse::where('course_id', $course_id)
            ->where('student_id', $student_id)
            ->first();

        $exam_ids = Exam::where('course_id', $course_id)->pluck('id')->toArray();
        $student_exams = array();
        foreach ($exam_ids as $exam_id) {
            $exams = StudentExam::where('exam_id', $exam_id)->get();
            foreach ($exams as $student_exam)
                array_push($student_exams, $student_exam);
        }

        return view('admin.student-details', compact('student_course', 'student_exams'));
    }

    public function chat(Request $request)
    {
        $users = User::whereNot('role', 'administrator')->get(['id', 'name', 'role']);

        $with = $request->query('with');
        $messages = null;

        if (isset($with)) {
            $messages = Message::where(function ($query) use ($request, $with) {
                $query->where('from_user', $request->user()->id)->where('to_user', $with);
            })->orWhere(function ($query) use ($request, $with) {
                $query->where('from_user', $with)->where('to_user', $request->user()->id);
            })->get();
        }

        return view('admin.chat', compact('users', 'messages'));
    }

    public function queries(Request $request)
    {
        $queries = ContactQuery::all();

        return view('admin.queries', compact('queries'));
    }
}
