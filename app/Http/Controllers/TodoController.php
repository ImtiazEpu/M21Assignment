<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodoController extends Controller {
    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function index( Request $request ) {
        $user  = User::where( 'email', $request->header( 'email' ) )->first();
        $todos = $user->todos;

        return response()->json( [ 'todos' => $todos ], 200 );
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function store( Request $request ) {
        $user = User::where( 'email', $request->header( 'email' ) )->first();

        $todo = $user->todos()->create( [
            'task'        => $request->task,
            'is_complete' => $request->is_complete
        ] );

        if ( $todo ) {
            return response()->json( [ 'todo' => $todo ], 200 );
        } else {
            return response()->json( [ 'message' => 'Todo creation failed' ], 500 );
        }
    }

    /**
     * @param  Request  $request
     * @param  Todo  $todo
     *
     * @return JsonResponse
     */
    public function update( Request $request, Todo $todo ) {
        $user = User::where( 'email', $request->header( 'email' ) )->first();
        if ( $user->id !== $todo->user_id ) {
            return response()->json( [ 'message' => 'Unauthorized' ], 403 );
        }

        $data = [ 'is_complete' => $request->is_complete ];
        if ( $request->has( 'task' ) ) {
            $data[ 'task' ] = $request->task;
        }

        $updated = $todo->update( $data );

        if ( $updated ) {
            return response()->json( [ 'todo' => $todo ], 200 );
        } else {
            return response()->json( [ 'message' => 'Todo update failed' ], 500 );
        }
    }

    /**
     * @param  Request  $request
     * @param  Todo  $todo
     *
     * @return JsonResponse
     */
    public function destroy( Request $request, Todo $todo ) {
        $user = User::where( 'email', $request->header( 'email' ) )->first();
        if ( $user->id !== $todo->user_id ) {
            return response()->json( [ 'message' => 'Unauthorized' ], 403 );
        }

        if ( $todo->delete() ) {
            return response()->json( [ 'message' => 'Todo deleted' ], 200 );
        } else {
            return response()->json( [ 'message' => 'Todo deletion failed' ], 500 );
        }
    }
}
