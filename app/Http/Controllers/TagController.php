<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Repository;
use \Validator;
use App\Tag;
class TagController extends Controller
{
    protected $tags;
    /**
    * Construct new controller.
    *
    * @return void
    */
    public function __construct(Tag $tags)
    {

        $this->tags = new Repository($tags);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=$request->q;
        $this->query=$this->tags->getModel()->newQuery();
        if($request->q){
            $this->query->where('name', 'LIKE', '%'.$query.'%')->orWhere('id', 'LIKE', '%'.$query.'%');
        }
        if($request->sort && $request->order){
            $this->query->orderBy($request->sort,$request->order)->limit(10);
            $sortColumn=[$request->sort,$request->order];
        }else{
            $sortColumn=['created_at','desc'];
            $this->query->orderBy($sortColumn[0],$sortColumn[1])->limit(10);
        }
        $items=$this->query->get();
        $fullLink=$request->fullUrl();
        return view('pages.tags', compact('items', 'query','sortColumn','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return '<div class="modal" id="modal-open-add-tag" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <form id="add_tag_form" action="/tags_add" method="post"> <div class="modal-header"> <h5 class="modal-title">Add new tag</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> </div><div class="modal-body"> <div class="form-group"> <label for="tag_name_input">Tag_name</label> <input type="text" name="name" class="form-control" id="tag_name_input" placeholder="Enter Tag" required=""> </div></div><div class="modal-footer"> <button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> </div><input type="hidden" name="_token" value="'.csrf_token().'"> </form> </div></div></div>';
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return back()->with('fail','Tag Adding failed');
        }else{
            $this->tags->create([
                'name' => $request->name,
                'published' =>'1'
            ]);
        
            return back()->with('success','Tag Added successful');
        }
    }
    /**
    * Gets a new validator instance with the defined rules.
    *
    * @param Illuminate\Http\Request $request
    *
    * @return Illuminate\Support\Facades\Validator
    */
    protected function getValidator(Request $request)
    {
        $rules = [
            'name' => 'required|max:255|unique:tags,name'
        ];

        return Validator::make($request->all(), $rules);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $selectedTag = $this->tags->show($id);
        return $selectedTag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
            $query=$request->name;
            $items=$this->tags->getModel()->where('name', 'LIKE', '%'.$query.'%')->select('id', 'name as text')->get();
            return $items;
    }
    public function deleteForm($id){
        return '<div class="modal" id="modal-open-delete-tag" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <form id="delete-form" action="/tags_delete/'.$id.'" method="post"> <div class="modal-header"> <h5 class="modal-title">Delete tag</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> </div><div class="modal-footer"> <button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> </div><input type="hidden" name="_token" value="'.csrf_token().'"> </form> </div></div></div>';
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $selectedTag = $this->tags->show($id);
        return '<div class="modal" id="modal-open-edit-tag" tabindex="-1" role="dialog" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <form id="edit-form" action="tags_edit/'.$selectedTag->id.'" method="post"> <div class="modal-header"> <h5 class="modal-title">Edit tag - "'.$selectedTag->name.'"</h5> <button type="button" id="close_edit_tag_modal" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> </div><div class="modal-body"> <div class="form-group"> <label for="tag_name_input">Tag_name</label> <input type="text" name="name" class="form-control" id="tag_name_input" placeholder="Enter Tag" required="" value="'.$selectedTag->name.'"> </div></div><div class="modal-footer"> <button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> </div><input type="hidden" name="_token" value="'.csrf_token().'"> </form> </div></div></div>';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return back()->with('fail','Tag Edited failed');
        }else{
            if($request->has('name')){
                $this->tags->update(['name' => $request->name],$id);
                return back()->with('success','Tag Edited successful');
            }else{
                return back()->with('fail','Tag Edited failed');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->tags->delete($id)){
            return back()->with('success','Tag Deleted successful');
        }else{
            return back()->with('fail','Tag Deleted failed');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lazyLoading(Request $request)
    {
        $query=$request->q;
        $this->query=$this->tags->getModel()->newQuery();
        if($request->q){
            $this->query->where('name', 'LIKE', '%'.$query.'%')->orWhere('id', 'LIKE', '%'.$query.'%');
        }
        if($request->sort && $request->order){ 
            $this->query->orderBy($request->sort,$request->order);
        }else{
            $sortColumn=['created_at','desc'];
            $this->query->orderBy($sortColumn[0],$sortColumn[1]);
        }
        if($request->offset){
            $this->query->offset($request->offset)->limit(10);
        }
        $items=$this->query->get();
        return $items;
    }
}
