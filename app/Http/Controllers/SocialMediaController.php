<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SocialMediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage-social');
    }

    public function index(Request $request)
    {
        $query = SocialMediaPost::with('user')
            ->when($request->platform, function($q) use ($request) {
                $q->where('platform', $request->platform);
            })
            ->when($request->status, function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->type, function($q) use ($request) {
                $q->where('post_type', $request->type);
            });

        $posts = $query->latest()->paginate(10);
        $platforms = ['instagram', 'facebook', 'twitter', 'tiktok'];
        $statuses = ['draft', 'scheduled', 'published'];
        $types = ['post', 'story', 'reel'];

        return view('social.index', compact('posts', 'platforms', 'statuses', 'types'));
    }

    public function create()
    {
        return view('social.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'platform' => 'required|string',
            'post_type' => 'required|string',
            'status' => 'required|string',
            'publish_at' => 'nullable|date',
            'image' => 'required|image|max:5120',
            'caption' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('social', 'public');
        }

        $data['user_id'] = auth()->id();
        
        SocialMediaPost::create($data);

        return redirect()->route('social.index')->with('success', 'Post criado com sucesso!');
    }

    public function edit(SocialMediaPost $post)
    {
        return view('social.edit', compact('post'));
    }

    public function update(Request $request, SocialMediaPost $post)
    {
        $data = $request->validate([
            'platform' => 'required|string',
            'post_type' => 'required|string',
            'status' => 'required|string',
            'publish_at' => 'nullable|date',
            'image' => 'nullable|image|max:5120',
            'caption' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::delete($post->image);
            }
            $data['image'] = $request->file('image')->store('social', 'public');
        }

        $post->update($data);

        return redirect()->route('social.index')->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy(SocialMediaPost $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        
        $post->delete();
        return redirect()->route('social.index')->with('success', 'Post removido com sucesso!');
    }
}
