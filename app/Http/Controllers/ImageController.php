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
    public function test(){
        $tags = $this->images->show(1)->tags()->get();
        return $tags;
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
                
                /*foreach($tags as $k => $tag){
                    if($this->tags->show($tag)){

                    }
                }*/
                $newImage->tags()->sync($tags);

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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
