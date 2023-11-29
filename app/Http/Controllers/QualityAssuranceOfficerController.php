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

class QualityAssuranceOfficerController extends Controller
{
    public function profile()
    {
        return view("quality-assurance-officer.profile");
    }

    public function students(Request $request)
    {
        $courses = Course::all(['id', 'name']);

        $student_courses = null;
        $course_id = $request->query('course');

        if (isset($course_id))
            $student_courses = StudentCourse::where('course_id', $course_id)->get();

        return view('quality-assurance-officer.students', compact('courses', 'student_courses'));
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

        return view('quality-assurance-officer.student-details', compact('student_course', 'student_exams'));
    }

    public function add_feedback(Request $request)
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

        return redirect()->back()->with('success', 'Feedback sent successfully.');
    }

    public function policies(Request $request)
    {
        $policies = Policy::where('added_by', $request->user()->id)->get();

        return view('quality-assurance-officer.manage-policies', compact('policies'));
    }

    public function add_policy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'for_role' => 'required|in:student,instructor',
            'content' => 'required|string'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        Policy::create([
            'for_role' => $request->for_role,
            'content' => $request->content,
            'added_by' => $request->user()->id
        ]);

        return redirect()->back();
    }

    public function remove_policy(int $id)
    {
        Policy::where('id', $id)->delete();

        return redirect()->back();
    }

    public function chat(Request $request)
    {
        $users = User::whereNot('role', 'quality_assurance_officer')->get(['id', 'name', 'role']);

        $with = $request->query('with');
        $messages = null;

        if (isset($with)) {
            $messages = Message::where(function ($query) use ($request, $with) {
                $query->where('from_user', $request->user()->id)->where('to_user', $with);
            })->orWhere(function ($query) use ($request, $with) {
                $query->where('from_user', $with)->where('to_user', $request->user()->id);
            })->get();
        }

        return view('quality-assurance-officer.chat', compact('users', 'messages'));
    }
}
