<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Middleware\OneBasicMiddleware;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


   public function __construct()
    {
//        $this->middleware(OneBasicMiddleware::class);
       $this -> middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit=($request->limit > 50) ? 10 : $request->limit;
        $users = new UserCollection(User::paginate($limit));
        return $users->response()->setStatusCode(200,'All Users');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $validator=Validator::make($request->all(),[
           'userName'=>'required',
           'userEmail'=>'required|email|unique:users,email',
           'userPassword'=>'required|min:8',
            'role'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $validatedData=$validator->validated();
        $validatedData['userPassword']=Hash::make($validatedData['userPassword']);
        $UserData=User::create([
            'name'=>$validatedData['userName'],
            'email'=>$validatedData['userEmail'],
            'password'=>$validatedData['userPassword'],
            'role_id'=>$validatedData['role'],
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        $dataSent=new UserResource($UserData);
        return $dataSent->response()->setStatusCode(200,'User Created');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
            $user = new UserResource(User::findOrFail($id));
            return $user->response()->setStatusCode(200,'User');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $CheckUser=User::findOrFail($id);
        $this->authorize('update', $CheckUser);
        $validator=Validator::make($request->all(),[
            'userName'=>'required',
            'userEmail'=>'required|email|unique:users,email,'.$CheckUser->id,
            'userPassword'=>'required|min:8',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $validatedData=$validator->validated();
        $validatedData['userPassword']=Hash::make($validatedData['userPassword']);
        $CheckUser->update([
            'name'=>$validatedData['userName'],
            'email'=>$validatedData['userEmail'],
            'password'=>$validatedData['userPassword'],
            'updated_at'=>now(),
        ]);
        $DataSent=new UserResource($CheckUser);
        return $DataSent->response()->setStatusCode(200,'User Updated');



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $UserCheck=User::findOrFail($id);
        $this->authorize('delete', $UserCheck);
        $UserCheck->delete();
        return response()->json([
            'message'=>'User Deleted',
        ],200);
    }

    public function userLessons($id)
    {
            $LessonsOfTheUser=User::with('lessons:id,title,body,user_id')
                ->select('id','name','email')
                ->where('id',$id)
                ->findOrFail($id);
            return response()->json([
                'LessonsOfTheUser'=>$LessonsOfTheUser,
            ],200);
    }
}
