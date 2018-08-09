<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Validator;
use App\Repositories\Repository;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * UserRepository.
     *
     * @var UserRepository
     */
    protected $users;
    /**
     * Construct new controller.
     *
     * @return void
     */
    public function __construct(User $users)
    {

        $this->users = new Repository($users);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=$request->q;
        $this->query=$this->users->getModel()->newQuery();
        if($request->q){
            $this->query->where('username', 'LIKE', '%'.$query.'%')->orWhere('id', 'LIKE', '%'.$query.'%')->orWhere('role', 'LIKE', '%'.$query.'%');
        }
        if($request->sort && $request->order){
            
            $this->query->orderBy($request->sort,$request->order)->limit(10);
            $sortColumn=[$request->sort,$request->order];
        }else{
            $sortColumn=['created_at','desc'];
            $this->query->orderBy($sortColumn[0],$sortColumn[1])->limit(10);
        }
        $items=$this->query->get();
        return view('pages.users_list', compact('items', 'query','sortColumn','request'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.users_list_modal',[
            'modal' => 'add_user'
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
            return back()->with('fail','User Adding failed');
        }else{
            $newUser=$this->users->create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'remember_token' => '0'
            ]);
            return back()->with('success','User Added successful');
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
            'username' => 'required|max:255|unique:users,username,'.$request->id,
            'password' => 'required|required_with:password_confirmation|same:password_confirmation|min:1',
            'password_confirmation' => 'required|min:1',
            'role' => 'required|min:1',
            '_token' => 'required'
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
        $selectedUser = $this->users->show($id);
        return $selectedUser;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->users->show($id);
        return view('pages.users_list_modal',[
            'modal' => 'edit_user',
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
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return back()->with('fail','User Adding failed');
        }else{
            if($request->password){
                $this->users->update([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'remember_token' => '0'
                ],$request->id);
            }else{
                $this->users->update([
                    'username' => $request->username,
                    'role' => $request->role,
                    'remember_token' => '0'
                ],$request->id);
            }

            return back()->with('success','User Added successful');
        }
    }
    /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $item = $this->users->show($id);
        return view('pages.users_list_modal',[
            'modal' => 'delete_user',
            'item' => $item
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($this->users->delete($request->id)){
            return back()->with('success','User Deleted successful');
        }else{
            return back()->with('fail','User Deleted failed');
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
        $this->query=$this->users->getModel()->newQuery();
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
        return view('pages.users_list_modal',[
            'modal' => 'item_source',
            'items' => $items
        ]);
    }
}
