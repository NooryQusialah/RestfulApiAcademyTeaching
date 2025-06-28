<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $limit=($request->limit > 50) ? 10 : $request->limit;
        $Lessons = LessonResource::collection(Lesson::paginate($limit));
        return $Lessons->response()->setStatusCode(200,'All Lessons');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Lesson::class);
        $validator=Validator::make($request->all(),[
           'LessonTitle'=>'required',
           'LessonBody'=>'required',
           'UserID'=>'required|exists:users,id',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $validatedData=$validator->validated();
        $LessonData= Lesson::create([
           'title'=>$validatedData['LessonTitle'],
           'body'=>$validatedData['LessonBody'],
           'user_id'=>$validatedData['UserID'],
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        $DataSent=new LessonResource($LessonData);
        return $DataSent->response()->setStatusCode(200,'Lesson Created');
    }


    public function show($id)
    {
        $LessonDetails=new LessonResource(Lesson::findOrFail($id));
        return $LessonDetails->response()->setStatusCode(200,'Lesson Details');
    }

    public function update(Request $request,$id)
    {
        $LessonCheck=Lesson::findOrFail($id);
        $this->authorize('update', $LessonCheck);
        $validator=Validator::make($request->all(),[
            'LessonTitle'=>'required',
            'LessonBody'=>'required',
            'UserID'=>'required|exists:users,id',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $validatedData=$validator->validated();
        $LessonCheck->update([
            'title'=>$validatedData['LessonTitle'],
            'body'=>$validatedData['LessonBody'],
            'user_id'=>$validatedData['UserID'],
            'updated_at'=>now(),
        ]);
        $DataSent=new LessonResource($LessonCheck);
        return $DataSent->response()->setStatusCode(200,'Lesson Updated');
    }

    public function destroy($id)
    {
        $LessonCheck=Lesson::findOrFail($id);
        $this->authorize('delete', $LessonCheck);
        $LessonCheck->delete();
        return response()->json([
            'message'=>'Lesson Deleted'
        ],200);
    }

    Public function LessonTags($id)
    {
        $LessonTagsData=Lesson::with('tags:id,name')
                               ->select('id','title','body')
                               ->where('id',$id)
                               ->findOrFail($id);

        return response()->json([
           'LessonTagsData'=>$LessonTagsData
        ],200);
    }
}
