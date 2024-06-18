<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;

class SubjectController extends Controller
{
    public function addSubject(Request $request, User $user)
    {
        $incomingFields = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'schedule' => 'required',
            'instructor' => 'required',
            'grades' => 'nullable'
        ]);

        $incomingFields['student_id'] = $user->id;

        try {
            Subject::create($incomingFields);
            return response()->json(['success' => true, 'message' => 'Subject added successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while adding the subject.']);
        }
    }

    public function updateSubject(Request $request, Subject $subject)
    {
        $incomingFields = $request->validate([
            'editSubjectCode' => 'required',
            'editSubjectName' => 'required',
            'editSchedule' => 'required',
            'editInstructor' => 'required',
            'editGrades' => 'nullable'
        ]);

        $subject->update([
            'code' => $incomingFields['editSubjectCode'],
            'name' => $incomingFields['editSubjectName'],
            'schedule' => $incomingFields['editSchedule'],
            'instructor' => $incomingFields['editInstructor'],
            'grades' => $incomingFields['editGrades']
        ]);

        return response()->json(['success' => true, 'message' => 'Subject updated successfully.']);
    }

    public function deleteSubject(Subject $subject)
    {
        $subject->delete();

        return response()->json(['success' => true, 'message' => 'Subject deleted successfully.']);
    }

}
