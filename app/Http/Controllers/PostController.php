<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;

class PostController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        try {
            return response()->json(  $this->createResponse(200, 'Post Found', Post::all()) );
        } catch (\Exception $e) {
            return response()->json( $this->createResponse(500, $e->getMessage()) );
        }
    }

    public function store(Request $request)
    {
        try {
            $post = Post::create([
                'title' => $request->title,
                'body' => $request->body,
            ]);
            if ($post) {
                return response()->json( $this->createResponse(200, 'Post created successfuly', $post) );
            } else {
                return response()->json( $this->createResponse(500, 'Something error, please contact admin.') );
            }
            
        } catch (\Exception $e) {
            return response()->json( $this->createResponse(500, $e->getMessage()) );
        }
    }
    public function show($id)
    {
        try {
            $post = Post::find($id);
            // $post = Post::findOrFail($id);
            if ($post) {
                return response()->json(
                    $this->createResponse(200, 'Post found', $post) 
                );
            } else {
                return response()->json(
                    $this->createResponse(404, 'Post not found') 
                );
            }
            
        } catch (\Exception $e) {
            return response()->json(
                $this->createResponse(500, $e->getCode())
            );
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->update(['title' => $request->title, 'body' => $request->body]);
            return response()->json(
                $this->createResponse(200, 'Post updated succesfuly', $post)
            );
        } catch (\Exception $e) {
            return response()->json(
                $this->createResponse(500, $e->getMessage())
            );
        }
    }
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            if ($post) {
                $post->delete();
                $response = $this->createResponse(200, 'Post deleted succesfuly', $post);
            } else {
                $response = $this->createResponse(400, 'Post not found');
            }
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(
                $this->createResponse(500, $e->getMessage())
            );
        }
    }
}
