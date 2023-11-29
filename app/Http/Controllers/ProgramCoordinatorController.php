<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Feedback;
use App\Models\Message;
use App\Models\StudentCourse;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramCoordinatorController extends Controller
{
    public function profile()
    {
        return view("program-coordinator.profile");
    }

    public function instructors()
    {
        $instructors = User::where('role', 'instructor')->get();

        return view("program-coordinator.manage-instructors", compact("instructors"));
    }

    public function instructor_details(int $id)
    {
        $courses = Course::where('instructor_id', $id)->get();
        $instructor = User::whereId($id)->first();

        return view('program-coordinator.instructor-details', compact('courses', 'instructor'));
    }

    public function add_instructor_course(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'instructor_id' => $id
        ]);

        return redirect()->back();
    }

    public function remove_instructor_course(int $course_id)
    {
        Course::where('id', $course_id)->delete();

        return redirect()->back();
    }

    public function feedback(Request $request)
    {
        $tickets = Feedback::where('to_id', $request->user()->id)->get();

        return view('program-coordinator.feedback', compact('tickets'));
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

    public function students(Request $request)
    {
        $courses = Course::all(['id', 'name']);

        $student_courses = null;
        $course_id = $request->query('course');

        if (isset($course_id))
            $student_courses = StudentCourse::where('course_id', $course_id)->get();

        return view('program-coordinator.students', compact('courses', 'student_courses'));
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

        return view('program-coordinator.student-details', compact('student_course', 'student_exams'));
    }

    public function chat(Request $request)
    {
        $users = User::whereNot('role', 'program_coordinator')->get(['id', 'name', 'role']);

        $with = $request->query('with');
        $messages = null;

        if (isset($with)) {
            $messages = Message::where(function ($query) use ($request, $with) {
                $query->where('from_user', $request->user()->id)->where('to_user', $with);
            })->orWhere(function ($query) use ($request, $with) {
                $query->where('from_user', $with)->where('to_user', $request->user()->id);
            })->get();
        }

        return view('program-coordinator.chat', compact('users', 'messages'));
    }
}
