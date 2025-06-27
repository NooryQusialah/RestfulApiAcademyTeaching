<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{

    public function index()
    {
        $TagsData= TagResource::collection(Tag::all());
        return $TagsData->response()->setStatusCode(200,'All Tags Data');
    }


    public function store(Request $request)
    {
        try {
            $this->authorize('create', Tag::class);
                $Validator=Validator::make($request->all(),[
                    'tagName'=>'required|unique:tags,name'
                ]);
                if($Validator->fails()){
                    return response(['errors'=>$Validator->errors()->all()],422);
                }

                $ValidatedData=$Validator->validate();

                $TagData=Tag::create([
                    'name'=>$ValidatedData['tagName'],
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
                return response()->json([
                    'message'=>'Tag Created Successfully',
                    'data'=>$TagData,
                ],200);
        } catch (NotFoundHttpException $exception)
        {
            return response(['errors'=>'error happen '],422);

        }
    }

    public function show($id)
    {
        $TagDetails=new TagResource(Tag::findOrFail($id));
        return  $TagDetails->response()->setStatusCode(200,"Tag Details"); ;
    }

    public function update(Request $request, $id)
    {
        $TagCheck=Tag::findOrFail($id);
        $this->authorize('update', $TagCheck);
        $Validator=Validator::make($request->all(),[
            'tagName'=>'required|unique:tags,name,'.$TagCheck->id
        ]);
        if($Validator->fails()){
            return response(['errors'=>$Validator->errors()->all()],422);
        }

        $ValidatedData=$Validator->validate();
        $TagCheck->update([
            'name'=>$ValidatedData['tagName'],
            'updated_at'=>now(),
        ]);
        return response()->json([
            'message'=>'Tag Updated Successfully',
            'data'=>$TagCheck,
        ]);

    }

    public function destroy($id)
    {
        $TagCheck=Tag::findOrFail($id);
        $this->authorize('delete', $TagCheck);
        $TagCheck->delete();
        return response()->json([
            'message'=>'Tag Deleted Successfully',
            'data'=>$TagCheck,
        ],200);
    }

    public function TagLessons($id)
    {
        $TagLessonsData=Tag::with('lessons')
                            ->select('id','name')
                            ->where('id',$id)
                            ->findOrFail($id);
        return response()->json([
            'message'=>'Tag Lessons Data',
            'data'=>$TagLessonsData,
        ],200);
    }
}
