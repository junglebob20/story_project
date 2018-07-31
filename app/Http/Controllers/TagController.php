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
                'items' => $this->tags->all(),
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
        //
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
    public function test(){
            return $this->tags->getModel()->where('name', 'LIKE', '%tag%')->select('id', 'name as text')->get();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
}
