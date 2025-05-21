<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller{

    

    public function view()
    {
        
        $students = Student::all();
    return view('students.student', compact('students'));

    }

    public function add($id = null)
    {
    $student = new Student(); 
    return view('students.add', compact('student'));
    }   



    public function save(Request $request)
    {
        $student = new Student(); 
        $student->fill($request->all());
        $student->save(); 
    
        return redirect()->route('student')->with('success', 'Student added successfully!');

    }
    


    
}