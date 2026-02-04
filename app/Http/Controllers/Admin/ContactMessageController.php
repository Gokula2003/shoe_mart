<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        $unreadCount = ContactMessage::where('is_read', false)->count();
        
        return view('admin.contact-messages.index', compact('messages', 'unreadCount'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Mark as read when viewed
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        
        return view('admin.contact-messages.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
