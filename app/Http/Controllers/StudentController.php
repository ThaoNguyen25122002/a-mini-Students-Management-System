<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request){
        $students = StudentResource::collection(Student::when($request->search,function($query) use($request){
            $query->where('name','like','%' . $request->search . '%')
            ->orWhere('email','like','%' . $request->search . '%');
        })->paginate(10)->withQueryString());
        // dd($students);
        return inertia('Students/Index',[
            'students' => $students,
            'searchTerm'=>$request->search
        ]);
    }
//     public function index(Request $request)
// {
//     // Lấy danh sách sinh viên với tìm kiếm và phân trang
//     // $students = Student::when($request->search, function($query) use($request) {
//     //     $query->where('name', 'like', '%' . $request->search . '%')
//     //           ->orWhere('email', 'like', '%' . $request->search . '%');
//     // })->paginate(10)->withQueryString();
//     $students = Student::when($request->search,function($query) use($request){
//         $query->where('name','like','%' . $request->search . '%')
//         ->orWhere('email','like','%' . $request->search . '%');
//     })->paginate(5)->withQueryString();
//     // Áp dụng resource vào collection đã phân trang
//     // $studentsCollection = StudentResource::collection($students);

//     return inertia('Students/Index', [
//         'students' => $students,
//         // 'searchTerm' => $request->search
//     ]);
// }

    public function create(){
        $classes = ClassesResource::collection(Classes::all());
        return inertia('Students/Create',['classes'=>$classes]);
    }


    public function store(StoreStudentRequest $request){
        Student::create($request->validated());
        return redirect()->route('students.index');
    }

    public function edit(Student $student){
        $classes = ClassesResource::collection(Classes::all());
        // dd($student);
        return inertia('Students/Edit',[
            'classes'=>$classes,
            'student'=> StudentResource::make($student),
        ]);
    }

    public function update(UpdateStudentRequest $request,Student $student){
        $student->update($request->validated());
        return redirect()->route('students.index');
    }


    public function destroy(Student $student){
        $student->delete();
        return redirect()->route('students.index');
    }

}
