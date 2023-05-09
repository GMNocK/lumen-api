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
            return response()->json( 
                $this->createResponse(200, 'Post found', Post::findOrFail($id)) 
            );
        } catch (\Exception $e) {
            return response()->json(
                $this->createResponse(500, $e->getMessage())
            );
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->update(['title' => $request->title, 'body' => $request->body]);
            return response()->json([
                'smartapp' => [
                    'status' => 'success', 
                    'message' => 'Post updated successfuly',
                    'data' => $post
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'smartapp' => [
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => null
                ]
            ]);
        }
    }
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            if ($post) {
                $post->delete();
                $response = [
                    'smartapp' => [
                        'status' => 'success',
                        'message' => 'Post deleted succesfuly',
                        'data' => $post,
                    ]
                ];
            } else {
                $response = [
                    'smartapp' => [
                        'status' => 'error',
                        'message' => 'Post not found in our databases',
                        'data' => null
                    ]
                ];
            }
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json([
                'smartapp' => [
                    'status' => 'error',
                    'message' => 'Post not found in our databases',
                    'data' => null
                ]
                ]);
        }
    }
}
