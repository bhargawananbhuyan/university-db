<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Feedback;
use App\Models\Message;
use App\Models\Policy;
use App\Models\StudentCourse;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function profile()
    {
        return view("student.profile");
    }

    public function courses(Request $request)
    {
        $all_courses = Course::all();
        $student_courses = StudentCourse::where('student_id', $request->user()->id)->get();
        $enrolled_course_ids = $student_courses->pluck('course_id')->toArray();
        $courses = $all_courses->filter(function ($course) use ($enrolled_course_ids) {
            return !in_array($course->id, $enrolled_course_ids);
        });

        return view("student.courses", compact("courses", "student_courses"));
    }

    public function enroll_to_course(Request $request, int $id)
    {
        StudentCourse::create([
            'course_id' => $id,
            'student_id' => $request->user()->id
        ]);

        return redirect()->back();
    }

    public function unenroll_course(int $id)
    {
        StudentCourse::where('id', $id)->delete();

        return redirect()->back();
    }

    public function exams(Request $request)
    {
        $student_courses = StudentCourse::where('student_id', $request->user()->id)->get();

        $course_id = $request->query('course');

        $student_exams = array();
        if (isset($course_id)) {
            $exam_ids = Exam::where('course_id', $course_id)->pluck('id')->toArray();

            foreach ($exam_ids as $exam_id) {
                $exams = StudentExam::where('exam_id', $exam_id)->get();
                foreach ($exams as $exam)
                    array_push($student_exams, $exam);
            }
        }

        return view('student.exams', compact('student_courses', 'student_exams'));
    }

    public function grievances(Request $request)
    {
        $other_users = User::whereNot('role', 'student')->get(['id', 'name', 'role']);

        $tickets = Feedback::where('from_id', $request->user()->id)->get();

        return view('student.grievance-reporting', compact('other_users', 'tickets'));
    }

    public function add_grievance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string',
            'details' => 'required|string',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        Feedback::create([
            'subject' => $request->subject,
            'details' => $request->details,
            'from_id' => $request->user()->id,
            'to_id' => $request->query('to')
        ]);

        return redirect()->to($request->url());
    }

    public function feedback(Request $request)
    {
        $tickets = Feedback::where('to_id', $request->user()->id)->get();

        return view('student.feedback', compact('tickets'));
    }

    public function policies()
    {
        $policies = Policy::where('for_role', 'student')->get(['id', 'content']);

        return view('student.policies', compact('policies'));
    }

    public function chat(Request $request)
    {
        $users = User::whereNot('role', 'student')->get(['id', 'name', 'role']);

        $with = $request->query('with');
        $messages = null;

        if (isset($with)) {
            $messages = Message::where(function ($query) use ($request, $with) {
                $query->where('from_user', $request->user()->id)->where('to_user', $with);
            })->orWhere(function ($query) use ($request, $with) {
                $query->where('from_user', $with)->where('to_user', $request->user()->id);
            })->get();
        }

        return view('student.chat', compact('users', 'messages'));
    }
}
