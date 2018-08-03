<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Repositories\TagRepository;
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
    public function index()
    {
        if(Auth::check()){
            return view('pages.tags', [
                'items' => $this->tags->getModel()->limit(10)->get(),
                'sortColumn' => ['created_at','asc']
            ]);
        }
        return redirect('login');
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
                'name' => $request->name
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
            'name' => 'required|max:255'
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

            return $this->tags->getModel()->where('name', 'LIKE', '%'.$request->name.'%')->select('id', 'name as text')->get();

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
        if($request->has('name')){
            $this->tags->update(['name' => $request->name],$id);
            return back()->with('success','Tag Edited successful');
        }else{
            return back()->with('fail','Tag Edding failed');
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
        return $this->tags->getModel()->offset($request->offset)->limit(10)->get();
    }
}
