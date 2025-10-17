<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutContent;

class AboutController extends Controller
{
    // Public: get about content (latest)
    public function show()
    {
        $content = AboutContent::latest()->first();
        return response()->json($content);
    }

    // Admin: update or create
    public function update(Request $request)
    {
        $data = $request->validate(['content' => 'required|string']);
        $about = AboutContent::latest()->first();
        if ($about) {
            $about->update($data);
        } else {
            $about = AboutContent::create($data);
        }
        return response()->json(['message'=>'About content saved', 'content' => $about]);
    }
}
