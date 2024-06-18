<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function showRegistrarPage()
{
    // Fetch subjects from the database
    $subjects = Subject::all();

    // Fetch students from the database
    $students = Student::all();

    // Pass both subjects and students to the view
    return view('registrar_page', compact('subjects', 'students'));
}

}
