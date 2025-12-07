<?php

namespace App\Http\Controllers;

use App\Models\CommunityThread;
use App\Models\CommunityMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityThreadController extends Controller
{
    /**
     * Show all community threads (Community page)
     */
    public function index()
    {
        $threads = CommunityThread::with(['company', 'user', 'latestMessage'])
            ->orderBy('last_activity_at', 'desc')
            ->paginate(15);

        return view('community.threads', compact('threads'));
    }

    /**
     * Show a single thread with all its messages
     */
    public function show(CommunityThread $communityThread)
    {
        $thread = $communityThread->load(['company', 'user', 'messages.user']);

        return view('community.show', compact('thread'));
    }

    /**
     * Store a new message in a thread
     */
    public function storeMessage(Request $request, CommunityThread $communityThread)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = CommunityMessage::create([
            'community_thread_id' => $communityThread->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_from_company' => false, // Only users can post directly
        ]);

        // Update thread's last activity timestamp
        $communityThread->update([
            'last_activity_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json($message->load('user'), 201);
        }

        return redirect()->route('community.show', $communityThread)
            ->with('success', 'Message posted successfully!');
    }

    /**
     * Create a new thread
     */
    public function create()
    {
        return view('community.create');
    }

    /**
     * Store a new community thread
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $thread = CommunityThread::create([
            'company_id' => $request->company_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'last_activity_at' => now(),
        ]);

        CommunityMessage::create([
            'community_thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_from_company' => false,
        ]);

        return redirect()->route('community.show', $thread)
            ->with('success', 'Thread created successfully!');
    }
}
