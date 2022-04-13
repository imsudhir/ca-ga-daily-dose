<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->session()->has('USER_LOGIN')){
            return redirect('user/dashboard');
            }else{
            return view('user.login');
            }
            return view('user.login');
    }
    public function user_signup(Request $request)
    {
        //
    //   $valid = Validator::make($request->all(),[
    //         "name"=>'required',
    //         "email"=>'required|email|unique:emps.email',
    //         "password"=>'required'
    //     ]);


        $is_email_exist=User::where(['email'=>$request->post('email')])->get();
        if(isset($is_email_exist[0])){
            return ["msg"=>"Email exist"];
        }else{
            $emp_signup = new User();
            $emp_signup->name = $request->post('name');
            $emp_signup->email = $request->post('email');
            $emp_signup->password = Hash::make($request->post('password'));
        
            $emp_signup->save();
              
            return ["msg"=>"Registerd successfully"];
        }
           
    }
    

    public function user_login_process(Request $request)
    {
    
        $result=User::where(['email'=>$request->post('l_email')])->get();
        if(isset($result[0])){
            $password=$request->post('l_password');
            if(Hash::check($password, $result[0]->password)){
                $request->session()->put('USER_LOGIN',true);
                $request->session()->put('USER_ID',$result[0]->id);
                $request->session()->put('USER_NAME',$result[0]->name);
                return ["msg"=>"Login successfull", "status"=>"success"];
            }else{
                return ["msg"=>"Invalid password"];
            }
        }else{
            return ["msg"=>"Please enter valid email"];
        }
        if(isset($result['0']->id)){
            $request->session()->put('USER_LOGIN',true);
            $request->session()->put('USER_ID',$result['0']->id);
            $request->session()->put('USER_NAME',$result['0']->name);
            print_r($result['0']->id);
            return redirect ('user/dashboard');

        } else {
            $request->session()->flash('error','Invalid login details');
            return redirect ('user');
         }
           
    }

    function personal_info(Request $request){
        
        $user_id=session('USER_ID');
        $personal_info = DB::select(DB::raw("SELECT `users`.id, `users`.name, `users`.email,`Contact_infos`.phone,`Contact_infos`.city,`Contact_infos`.profile_image FROM users INNER JOIN Contact_infos ON users.id = Contact_infos.user_id AND users.id = $user_id "));
        $data['states']=DB::table('states')->orderBy('state','asc')->get();
        if(isset($personal_info[0]->id)){
        return view('user.personal_info')->with('personal_info',$personal_info);
        }
         return view('user.manage_personal_info_process',$data);
    
     }

     function getcity(Request $request){
        
        $state_id= $request->state_id;
          $city=DB::table('city')->where('state',$state_id)->orderBy('city','asc')->get();
          $html='<option value="">select state</option>';
          
          foreach ($city as $list){
            $html.='<option value="'.$list->id.'">'.$list->city.'</option>';
          }
          echo $html;
 
        // if(isset($personal_info[0]->id)){
        // return view('user.personal_info')->with('personal_info',$personal_info);
        // }
        //  return view('user.manage_personal_info_process',$data);
    
     }

    function manage_personal_info($id){
        if(session('USER_ID') == $id){
        //    $update_personal_info=Contact_info::where(['user_id'=>session('USER_ID')])->get();
           $update_personal_info = DB::select(DB::raw("SELECT `users`.id, `users`.name, `users`.email,`Contact_infos`.phone,`Contact_infos`.city,`Contact_infos`.profile_image FROM users INNER JOIN Contact_infos ON users.id = Contact_infos.user_id AND users.id = $id "));

           if(isset($update_personal_info[0]->id)){
               return view('user.manage_personal_info')->with('update_personal_info',$update_personal_info);
               } else{
                   return redirect('user/personal-info');
               }
             }else{
               return redirect('user/personal-info');
             }
     
       }

       public function manage_personal_info_process(Request $request){
        //    return $request;
      
        if($request->post('id') == session('USER_ID')){
            $request->validate([
                'phone' => 'required|digits:10',
                'profile_image'=>'required|mimes:jpg,jpeg,png',
                'city'=>'required'
            ]);
           $contact_exist=Contact_info::where(['user_id'=>session('USER_ID')])->get();
        //    return $contact_exist->count();
        //    $personal_info=Emp_personal_info::where(['emp_id'=>session('USER_ID')])->get();
        if($contact_exist->count()!=0){
            $model=Contact_info::where(['user_id'=>session('USER_ID')])->get();
            $msg="Contact info Updated Successfuly";
        }else{
       $model=new Contact_info();
    //    $model->phone=$request->post('phone');
    //    $model->city=$request->post('city');
    //    $model->user_id=$request->post('id');
    //    $model->save();
        if($request->hasFile('profile_image')){
           $profile_img=$request->file('profile_image');
           $extn=$profile_img->extension();
           $file=time().'.'.$extn;
           $model->profile_image=$file;
           $profile_img->storeAS('/public/media',$file);
       }
       $model->phone=$request->post('phone');
       $model->city=$request->post('city');
       $model->user_id=$request->post('id');
       $model->save();
       $msg="Product Added Successfuly";
       }
    }

    if($request->post('update_user_id') == session('USER_ID')){
    //    return $request->post('update_user_id');
    $request->validate([
        'phone' => 'required|digits:10',
        'city'=>'required'
    ]);
        $updated_result = DB::table('Contact_infos')
        ->where('user_id',$request->post('update_user_id'))
        ->update(['phone'=>$request->post('phone'),'city'=>$request->post('city')]);
        if($updated_result){
            $msg="Updated Successfuly";
         }else{
            $msg="Error..";
        }
    }



    //     if($request->hasFile('profile_image')){
    //        $profile_img=$request->file('profile_image');
    //        $extn=$profile_img->extension();
    //        $file=time().'.'.$extn;
    //        $model->profile_image=$file;
    //        $profile_img->storeAS('/public/media',$file);
    //    }
    //    $model->phone=$request->post('phone');
    //    $model->city=$request->post('city');
    //    $model->user_id=$request->post('id');
    //    $model->save();
   
       $request->session()->flash('message',$msg);
       return redirect('user/personal-info');
   }



    public function dashboard()
    {
        return view('user.dashboard');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User_data  $user_data
     * @return \Illuminate\Http\Response
     */
    public function show(User_data $user_data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User_data  $user_data
     * @return \Illuminate\Http\Response
     */
    public function edit(User_data $user_data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User_data  $user_data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_data $user_data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User_data  $user_data
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_data $user_data)
    {
        //
    }
}
