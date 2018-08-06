<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Repositories\ImageRepository;
use App\Repositories\Repository;
use Intervention\Image\ImageManagerStatic as ImageManager;
use \Validator;
use App\Image;
use App\Tag;
use Illuminate\Support\Facades\Storage;
class ImageController extends Controller
{
    protected $images;
    protected $tags;
    /**
    * Construct new controller.
    *
    * @return void
    */
    public function __construct(Image $images, Tag $tags)
    {
        $this->tags = new Repository($tags);
        $this->images = new Repository($images);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=$request->q;
        $this->query=$this->images->getModel()->newQuery();
        if($request->q){
            $this->query->where('name', 'LIKE', '%'.$query.'%')->orWhere('id', 'LIKE', '%'.$query.'%')->orWhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%'.$query.'%');
            });
        }
        if($request->sort && $request->order){
            if($request->sort=='tags'){
                $this->query->whereHas('tags')->orderBy('name',$request->order)->limit(10);
                $sortColumn=[$request->sort,$request->order];
            }else{
                $this->query->orderBy($request->sort,$request->order)->limit(10);
                $sortColumn=[$request->sort,$request->order];
            }
        }else{
            $sortColumn=['created_at','desc'];
            $this->query->orderBy($sortColumn[0],$sortColumn[1])->limit(10);
        }
        $items=$this->query->get();
        $active_page='images';
        return view('pages.images', compact('items', 'query','sortColumn','active_page','request'));
            /*return view('pages.images', [
                'items' => $this->images->all(),
                'tags' => $this->tags->all(),
                'sortColumn' => ['created_at','asc']
            ]);*/
    }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(){
        return $this->images->getModel()->whereHas('tags')->orderBy('name','asc')->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.images_modal',[
            'modal' => 'add_image'
        ]);
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
            return back()->with('fail','Image Upload failed, please check your image');
        }else{
            if( $request->hasFile('image') ) {
                $image = $request->file('image');
                $input['imageName'] = time();
                $input['imageExt'] = $image->getClientOriginalExtension();
                $destinationPath = public_path('storage/images');
                $img = ImageManager::make($image->getRealPath());
                if(!$this->check_imageSize($image)){
                    $img->resize(512, 512);
                }
                $img->save($destinationPath.'/'.$input['imageName'].'.'.$input['imageExt']);
    
                $newImage=$this->images->create([
                    'name' => $input['imageName'],
                    'path'=> 'storage/images/',
                    'ext'=> $input['imageExt']
                ]);

                $tags=$request->input('tags');
             
                $tagsToSync=array();
                foreach($tags as $k => $tag){
                    $checkedTag=$this->tags->all()->where('id',$tag)->first();
                    if($checkedTag){
                        array_push($tagsToSync,$checkedTag->id);
                    }else{
                        $newTag=$this->tags->create(['name' => $tag]);
                        array_push($tagsToSync,$newTag->id);
                    }
                }
                $newImage->tags()->sync($tagsToSync);

                return back()->with('success','Image Upload successful');
            }else{
                return back()->with('fail','Image Upload failed, please check your image');
            }
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tags' => 'required'
        ];

        return Validator::make($request->all(), $rules);
    }
        /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidatorUpdate(Request $request)
    {
        $rules = [
            'tags' => 'required'
        ];

        return Validator::make($request->all(), $rules);
    }
    /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidatorImage(Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ];

        return Validator::make($request->all(), $rules);
    }
    protected function check_imageSize($photo) {
        $maxHeight = 512;
        $maxWidth = 512;
        list($width, $height) = getimagesize($photo);
        if($width >= $maxWidth || $height >= $maxHeight){
            return false;
        }else{
            return true;
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $selectedImage = $this->images->with(['tags' => function($query) {
            $query->select('*','name as text');
        }])->where('id',$id)->get()->first();
        return $selectedImage;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->images->with(['tags' => function($query) {
            $query->select('*','name as text');
        }])->where('id',$id)->get()->first();
        return view('pages.images_modal',[
            'modal' => 'edit_image',
            'item' => $item
        ]);
    }
    /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $item = $this->images->show($id);
        return view('pages.images_modal',[
            'modal' => 'delete_image',
            'item' => $item
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = $this->getValidatorUpdate($request);
        
        if ($validator->fails()) {
            return back()->with('fail','Image Upload failed, please check your image');
        }else{
            if($request->image) {
                if($this->getValidatorImage($request)->fails()){
                    return back()->with('fail','Image Upload failed, please check your image');
                }
                $this->deleteImageFromStorage($request->id);
                $image = $request->file('image');
                $input['imageName'] = time();
                $input['imageExt'] = $image->getClientOriginalExtension();
                $destinationPath = public_path('storage/images');
                $img = ImageManager::make($image->getRealPath());
                if(!$this->check_imageSize($image)){
                    $img->resize(512, 512);
                }
                $img->save($destinationPath.'/'.$input['imageName'].'.'.$input['imageExt']);

                $this->images->update([
                    'name' => $input['imageName'],
                    'path'=> 'storage/images/',
                    'ext'=> $input['imageExt']
                ],$request->id);

            }
            $tags=$request->input('tags');
            $tagsToSync=array();
            foreach($tags as $k => $tag){
                $checkedTag=$this->tags->all()->where('id',$tag)->first();
                if($checkedTag){
                    array_push($tagsToSync,$checkedTag->id);
                }else{
                    $newTag=$this->tags->create(['name' => $tag]);
                    array_push($tagsToSync,$newTag->id);
                }
            }
            $this->images->show($request->id)->tags()->sync($tagsToSync);
                            return back()->with('success','Image Upload successful');
        }
    }
    protected function deleteImageFromStorage($id){
        $currentImage=$this->images->show($id);
        Storage::disk('public')->delete('images/'.$currentImage->name.'.'.$currentImage->ext);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $this->images->show($request->id)->tags()->detach();
        if($this->images->delete($request->id)){
            return back()->with('success','Image Deleted successful');
        }else{
            return back()->with('fail','Image Deleted failed');
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
        $this->query=$this->images->getModel()->newQuery();
        if($request->q){
            $this->query->where('username', 'LIKE', '%'.$query.'%')->orWhere('id', 'LIKE', '%'.$query.'%')->orWhere('role', 'LIKE', '%'.$query.'%');
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
        return view('pages.images_modal',[
            'modal' => 'item_source',
            'items' => $items
        ]);
    }
}
