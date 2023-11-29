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

class InstructorController extends Controller
{
    public function profile()
    {
        return view("instructor.profile");
    }

    public function courses(Request $request)
    {
        $courses = Course::where('instructor_id', $request->user()->id)->get();
        return view('instructor.courses', compact('courses'));
    }

    public function add_course(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'instructor_id' => $request->user()->id
        ]);

        return redirect()->back();
    }

    public function remove_course(int $id)
    {
        Course::where('id', $id)->delete();

        return redirect()->back();
    }

    public function exams(Request $request)
    {
        $courses = Course::where('instructor_id', $request->user()->id)->get();
        $exams = array();
        foreach ($courses as $course) {
            $course_exams = Exam::where('course_id', $course->id)->get();
            foreach ($course_exams as $exam)
                array_push($exams, $exam);
        }

        return view('instructor.exams', compact('courses', 'exams'));
    }

    public function add_exam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'total_marks' => 'required|numeric',
            'course_id' => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $exam = Exam::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'total_marks' => $request->total_marks
        ]);

        $student_courses = StudentCourse::where('course_id', $request->course_id)->get();
        foreach ($student_courses as $student_course) {
            StudentExam::create([
                'student_id' => $student_course->student->id,
                'exam_id' => $exam->id
            ]);
        }

        return redirect()->back();
    }

    public function remove_exam(int $id)
    {
        Exam::where('id', $id)->delete();

        return redirect()->back();
    }

    public function students(Request $request)
    {
        $courses = Course::where('instructor_id', $request->user()->id)->get(['id', 'name']);

        $student_courses = null;
        $course_id = $request->query('course');

        if (isset($course_id))
            $student_courses = StudentCourse::where('course_id', $course_id)->get();

        return view('instructor.students', compact('courses', 'student_courses'));
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

        return view('instructor.student-details', compact('student_course', 'student_exams'));
    }

    public function update_student_exam(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'marks_secured' => 'required|numeric',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        StudentExam::where('id', $id)->update([
            'marks_secured' => $request->marks_secured
        ]);

        return redirect()->back();
    }

    public function feedback(Request $request)
    {
        $tickets = Feedback::where('to_id', $request->user()->id)->get();

        return view('instructor.feedback', compact('tickets'));
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

    public function policies()
    {
        $policies = Policy::where('for_role', 'instructor')->get(['id', 'content']);

        return view('instructor.policies', compact('policies'));
    }

    public function chat(Request $request)
    {
        $users = User::whereNot('role', 'instructor')->get(['id', 'name', 'role']);

        $with = $request->query('with');
        $messages = null;
        if (isset($with)) {
            $messages = Message::where(function ($query) use ($request, $with) {
                $query->where('from_user', $request->user()->id)->where('to_user', $with);
            })->orWhere(function ($query) use ($request, $with) {
                $query->where('from_user', $with)->where('to_user', $request->user()->id);
            })->get();
        }

        return view('instructor.chat', compact('users', 'messages'));
    }
}
