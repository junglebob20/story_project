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
    public function index()
    {
        if(Auth::check()){

            return view('pages.images', [
                'items' => $this->images->all(),
                'tags' => $this->tags->all(),
                'sortColumn' => ['created_at','asc']
            ]);
        }
        return redirect('login');
    }
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request){
        dd($request);
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
    public function thumbnail(Request $request)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return back()->with('fail','Image Upload failed, please check your image');
        }else{
            if( $request->hasFile('image') ) {
                $input['imageName'] = time();
                $input['imageExt'] = $image->getClientOriginalExtension();
                $destinationPath = public_path('storage/thumbnail_images');
                $img = ImageManager::make($image->getRealPath());
                if(!$this->check_imageSize($image)){
                    $img->resize(512, 512);
                }
            }
            return $img;
        }
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
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
        //
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
}
