<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // This looks for resources/views/chat/index.blade.php
        // If your file has a different name inside the 'chat' folder, change it here.
        return view('chat.index');
    }
}
