<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class SmsController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('id', 'desc')->paginate(10);
        return view('admin.sms.index', compact('messages'));
    }

    public function destroy(ContactMessage $sms)
    {
        $sms->delete();
        return redirect()->route('admin.sms.index')->with('success', 'Message deleted successfully!');
    }
}
