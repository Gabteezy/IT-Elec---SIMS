<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required',
            'tuition' => 'nullable'
        ]);
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        try {
            User::create($incomingFields);
            return redirect('/')->with('success', 'Registration successfull!');
        } catch (Exception $e) {
            return redirect('/registration_form')->with('error', 'Registration failed');            
        }
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt([
            'email' => $incomingFields['email'], 
            'password' => $incomingFields['password']
            
        ])) {
            $request->session()->regenerate();
            $user = auth()->user();
            if ($user->type === 'Registrar') {
                return redirect('/registrar_page');
            } elseif ($user->type === 'Cashier') {
                return redirect('/cashier_page');
            } elseif ($user->type === 'Student') {
                return redirect('/user_page');
            } else {
                return redirect('/');
            }
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function updateStudent(Request $request, User $user)
    {
        $incomingFields = $request->validate([
            'editFirstName' => 'required',
            'editMiddleName' => 'nullable',
            'editLastName' => 'required'
        ]);

        $user->firstname = $incomingFields['editFirstName'];
        $user->middlename = $incomingFields['editMiddleName'];
        $user->lastname = $incomingFields['editLastName'];
        $user->save();

        return response()->json(['success' => true, 'message' => 'Personal information updated successfully.']);
    }

    public function updateTuition(Request $request, $id)
{
    $request->validate([
        'tuition' => 'required|numeric',
        'paymentMethod' => 'required|in:cash,credit_card'
    ]);

    $user = User::find($id);

    if ($user) {
        $user->tuition = $request->input('tuition');
        $user->payment_method = $request->input('paymentMethod'); // Store the payment method
        $user->save();

        return response()->json(['success' => true, 'message' => 'Tuition and payment method updated successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }
}


    public function deleteStudent(User $user)
    {
        Subject::where('student_id', $user->id)->delete();
        $user->delete();
        return response()->json(['success' => true, 'message' => 'Student and related subjects deleted successfully']);
    }

}
