<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Attendance;
use App\Models\Emp;
use App\Models\App_settings;
use App\Models\Leave_date;
use App\Imports\AttendanceImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Crypt;
use Exporter;
use Excel;
use Cyberduck\LaravelExcel\Contract\SerialiserInterface;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataexport(){
        // $query=collect(DB::select('select * from attendances', [1]));
        // $query = DB::select('select * from attendances', [1]);
        // $query = DB::select('select * `id` from attendances')->get();
        $query = collect(DB::table('attendances')->select('id', 'date')->get());
       
         $variable=[1,2];
         foreach ($variable as $key => $value) {
             # code...
        $excel = Exporter::make('Excel');
        $yourFileName="abc.xlsx";
        // $excel->loadQuery($query);
        // $excel->stream($yourFileName);
        // return 'public/media/'.$yourFileName;

        $excel->save('public/media/','123.xlsx');
        // Exporter::make('Excel')->load(collect($query))->stream($yourFileName);
          
         }






        // $excel->loadQuery($query);
        // $excel->stream($yourFileName);
        // return $excel->save('public/media/'+$yourFileName);
        // return $collection = Exporter::make('Excel')->load($query)->setSerialiser(new ApplicantSerializer)->stream($yourFileName);

    }

    public function send_report_alert_mail_to_emp(){
    //   return public_path();
    $filename='abc';
    $count1=1;
    $count2=2;
    // return storage_path('app/public/media/abc.xlsx');
        $emp_email='sudhirsinghkumar11@gmail.com';
        $data=['name'=>'sudhir', "email"=>'sudhirsinghkumar11@gmail.com'];
        $user['to_emp_email'] = 'sudhirsinghkumar11@gmail.com';
        // $files = [
        //     public_path('public/media/abc.xlsx'),
        //     public_path('public/media/abc1.xlsx'),
        // ];
        $files = [
            storage_path('app/public/media/'.$filename.$count1.'.xlsx'),
            storage_path('app/public/media/'.$filename.$count2.'.xlsx'),
        ];
        Mail::send('email.send_report_alert_mail_to_emp', $data, function($messages) use ($user,$files){
           $messages->to($user['to_emp_email']);
           $messages->subject('Report details');
           foreach ($files as $file){
            $messages->attach($file);
        }
       }); 
       return 'Report send successfully';
    }
    public function index(Request $request)
    {
        //
        if($request->session()->has('ADMIN_LOGIN')){
        return redirect('admin/dashboard');
        }else{
        return view('admin.login');
        }
        return view('admin.login');
    }
    public function auth(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $email = $request->post('email');
        $password = $request->post('password');
       
        $result=Admin::where(['email'=>$email])->get();
        if(isset($result[0])){
            // $db_password=Crypt::decrypt($result[0]->password);
            // if($db_password == $request->post('password')){
            //     $request->session()->put('ADMIN_LOGIN',true);
            //     $request->session()->put('ADMIN_ID',$result[0]->id);
            //     return redirect ('admin/dashboard');
            // } else {
            //     $request->session()->flash('error','Invalid login details');
            //     return redirect ('admin');
            // }
            
              //new code in 2022
              $db_password=Hash::check($password,$result[0]->password);
 
              if($db_password){
                  $request->session()->put('ADMIN_LOGIN',true);
                  $request->session()->put('ADMIN_ID',$result[0]->id);
  
                  //new code in 2022
                  $app_settings_data=app_settings::where(['admin_id'=>session('ADMIN_ID')])->get();
                  if(isset($app_settings_data[0]->id)){
                  $request->session()->put('LOGO',$app_settings_data[0]->logo);
                  $request->session()->put('COMPANY_NAME',$app_settings_data[0]->company_name);
                  $request->session()->put('ADDRESS',$app_settings_data[0]->address.', '.$app_settings_data[0]->city.', '.$app_settings_data[0]->state.', '.$app_settings_data[0]->pincode);
                  }
                }  
                  // new code in 2022
            

        }
            if(isset($result[0]->id)){
                $request->session()->put('ADMIN_LOGIN',true);
                $request->session()->put('ADMIN_ID',$result[0]->id);
                return redirect ('admin/dashboard');
    
            } else {
                $request->session()->flash('error','Invalid login details');
                return redirect ('admin');
             }
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
 
    public function emp_list()
    {
        //
       $employees = DB::select(DB::raw("SELECT `emps`.id, `emps`.name,`emps`.date_of_joining,`emps`.email,`emps`.official_email,`emps`.salary,is_verify, status,`emp_personal_infos`.contact,`emp_professional_infos`.company_name,`emp_professional_infos`.from_date as last_company_from_date,`emp_professional_infos`.to_date as last_company_to_date,`emp_professional_infos`.experience_letter,`emp_professional_infos`.sallary_slip,`emp_academic_infos`.highest_qualification,`emp_academic_infos`.university_college,`emp_academic_infos`.from_date,`emp_academic_infos`.to_date,`emp_academic_infos`.qualification_certificate,`emp_academic_infos`.diploma_certificate,`emp_academic_infos`.professional_certificate,`emp_personal_infos`.c_address,`emp_personal_infos`.c_city,`emp_personal_infos`.c_state,`emp_personal_infos`.c_pincode,`emp_personal_infos`.p_address,`emp_personal_infos`.p_city,`emp_personal_infos`.p_state,`emp_personal_infos`.p_pincode,`emp_personal_infos`.guardian_contact,`emp_personal_infos`.adhar_number,`emp_personal_infos`.adhar_front_copy,`emp_personal_infos`.adhar_back_copy,`emp_personal_infos`.profile_image FROM emps LEFT JOIN emp_personal_infos ON emps.id=emp_personal_infos.emp_id LEFT JOIN emp_academic_infos ON emps.id=emp_academic_infos.emp_id LEFT JOIN emp_professional_infos ON emps.id=emp_professional_infos.emp_id"));
        // return $employees;
        // $employees=Emp::all();
        // return $employees;
        return view('admin.emp')->with('employees',$employees);
    }
 
    public function emp_data_by_id(Request $request,$id){
       $emp_data_by_id = DB::select(DB::raw("SELECT `emps`.id, `emps`.name, `emps`.date_of_joining,`emps`.email,`emps`.official_email,`emps`.salary,is_verify, status,`emp_personal_infos`.contact,`emp_professional_infos`.company_name,`emp_professional_infos`.from_date as last_company_from_date,`emp_professional_infos`.to_date as last_company_to_date,`emp_professional_infos`.experience_letter,`emp_professional_infos`.sallary_slip,`emp_academic_infos`.highest_qualification,`emp_academic_infos`.university_college,`emp_academic_infos`.from_date,`emp_academic_infos`.to_date,`emp_academic_infos`.qualification_certificate,`emp_academic_infos`.diploma_certificate,`emp_academic_infos`.professional_certificate,`emp_personal_infos`.c_address,`emp_personal_infos`.c_city,`emp_personal_infos`.c_state,`emp_personal_infos`.c_pincode,`emp_personal_infos`.p_address,`emp_personal_infos`.p_city,`emp_personal_infos`.p_state,`emp_personal_infos`.p_pincode,`emp_personal_infos`.guardian_contact,`emp_personal_infos`.adhar_number,`emp_personal_infos`.adhar_front_copy,`emp_personal_infos`.adhar_back_copy,`emp_personal_infos`.profile_image,`emp_personal_infos`.pan_card_copy FROM emps LEFT JOIN emp_personal_infos ON emps.id=emp_personal_infos.emp_id LEFT JOIN emp_academic_infos ON emps.id=emp_academic_infos.emp_id LEFT JOIN emp_professional_infos ON emps.id=emp_professional_infos.emp_id WHERE emps.id='$id'"));
    // return $employe_data_by_id;
       return view('admin.emp_data_by_id')->with('emp_data_by_id', $emp_data_by_id);
    }

    function update_emp_data_process(Request $request){
    // return $request;
    // emps text update
    $update_emps_status = DB::table('emps')
    ->where('id',$request->update_user_id)
    ->update(['name'=>$request->name,'email'=>$request->p_email,
    'official_email'=>$request->official_email,'date_of_joining'=>$request->date_of_joining]);
    // academic info text update
    $update_academic_info_status = DB::table('emp_academic_infos')
    ->where('emp_id',$request->update_user_id)
    ->update(['highest_qualification'=>$request->highest_qualification,'university_college'=>$request->university_college,
    'from_date'=>$request->from_date,'to_date'=>$request->to_date]);
    //professional info text update
        $update_professional_info_status = DB::table('emp_professional_infos')
        ->where('emp_id',$request->update_user_id)
        ->update(['company_name'=>$request->company_name,'from_date'=>$request->from_date,
        'to_date'=>$request->to_date]);
    //personal info text update
        if($request->is_it_permanent_address){
        if(strlen((string)$request->p_pincode) == 6) {
        $update_personal_info_status = DB::table('emp_personal_infos')
        ->where('emp_id',$request->update_user_id)
        ->update(['p_address'=>$request->p_address,'p_city'=>$request->p_city, 'p_state'=>$request->p_state,'p_pincode'=>$request->p_pincode,'contact'=>$request->personal_contact,'guardian_contact'=>$request->guardian_contact,'c_address'=>$request->p_address,'c_city'=>$request->p_city, 'c_state'=>$request->p_state,'c_pincode'=>$request->p_pincode,'adhar_number'=>$request->adhar_number]);
        }else{
            return response()->json(["status"=>"error", "msg"=>"Invalid pincode"]);
        }
        }else{
            if(strlen((string)$request->c_pincode) == 6) {
            $update_personal_info_status = DB::table('emp_personal_infos')
            ->where('emp_id',$request->update_user_id)
            ->update(['p_address'=>$request->p_address,'p_city'=>$request->p_city, 'p_state'=>$request->p_state,'p_pincode'=>$request->p_pincode,'contact'=>$request->personal_contact,'guardian_contact'=>$request->guardian_contact,'c_address'=>$request->c_address,'c_city'=>$request->c_city, 'c_state'=>$request->c_state,'c_pincode'=>$request->c_pincode,'adhar_number'=>$request->adhar_number]);
            }else{
                return response()->json(["status"=>"error", "msg"=>"Invalid pincode"]);
            }
        }
    // academic info text update














       if($update_personal_info_status === 1){
        return response()->json(["status"=>"success", "msg"=>"User info updated successfully"]);
        }elseif($update_academic_info_status === 1){
        return response()->json(["status"=>"success", "msg"=>"User info updated successfully"]);
        }elseif($update_professional_info_status === 1){
        return response()->json(["status"=>"success", "msg"=>"User info updated successfully"]);
        }elseif($update_emps_status === 1){
            return response()->json(["status"=>"success", "msg"=>"Emps info updated successfully"]);
        }else{
        return response()->json(["status"=>"no_changed_data", "msg"=>"No change found"]);
        }
    }




























    public function status(Request $request,$status,$id)
    {
        //
        echo $status;
       if($status == 1){
        $msg = 'Employee activated successfuly';
       }else{
        $msg = 'Employee deactivated successfuly';
       }
        
        $model=Emp::find($id);
        $model->status=$status;
        $model->save();
        
        $request->session()->flash('message',$msg);
        return redirect('admin/emp');
        
    }
    // leave management start
    public function leave_management()
    {
         $leave_datas  =  Leave_date::get();
     
        return view('admin.leave')->with('leave_datas',$leave_datas);
        if(isset($personal_info[0]->id)){
            $request->session()->put('MY_PERSONAL_INFO',true);
        return view('emp.personal_info')->with('personal_info',$personal_info);
        }
        return view('emp.manage_personal_info_process');
     }

     public function create_leave(Request $request){
        $is_leave_date_exist=Leave_date::where(['date'=>$request->post('date')])->get();
       if(isset($is_leave_date_exist[0])){
           return response()->json(["status"=>"error", "msg"=>"This leave date allready exist"]);
       }else{
           $leave_create = new Leave_date();
           $leave_create->date = $request->post('date');
           $leave_create->leave_desc = $request->post('leave_desc');
       
           $leave_create_status = $leave_create->save();
          if($leave_create_status){
          $leave_datas  =  Leave_date::get();
           return response()->json(["status"=>"success", "data"=> $leave_datas, "msg"=>"Leave created successfully"]);
          }else {
           return response()->json(["status"=>"error", "msg"=>"Something went wrong"]);
          }
   
       }
   }
   public function get_leave_by_id(Request $request){
    $leave_datas  =  Leave_date::where(['id'=>$request->id])->get();
    if($leave_datas[0]->id){
        return response()->json(["status"=>"success", "data"=> $leave_datas, "msg"=>"Leave created successfully"]);
    }else{
    return response()->json(["status"=>"error", "data"=> $leave_datas, "msg"=>"something went wrong"]);
    }
   }
// leave management end

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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function upload_attendance(Request $request)
    {
        //
        return view('admin.upload_attendance');

    }
    public function upload_attendance_process(Request $request){

        $request->validate([
            'emp_id'=>'required',
            'date'=>'required',
            'in_time'=>'required',
            'out_time'=>'required'
        ]);
        if($request->__update_id>0){
        $updated_result = DB::table('attendances')
        ->where('id',$request->__update_id)
        ->where('emp_id',$request->emp_id)
        ->where('date',$request->date[0])
        ->update(['in_time'=>$request->in_time[0],'out_time'=>$request->out_time[0]]);
        // return $updated_result;
        if($updated_result){
            return response()->json(["status"=>"updated", "emp_id"=>$request->emp_id, "code"=>$updated_result, "msg"=>"updated successfully"]);
        }else{
            return response()->json(["status"=>"no_changed_data", "code"=>$updated_result, "msg"=>"No change found"]);
        }

        }else{
        for ($i=0; $i < count($request->date); $i++) { 
            $data=[
            'emp_id'=>$request->emp_id,
            'date'=> $request->date[$i],
            'in_time'=>$request->in_time[$i],
            'out_time'=>$request->out_time[$i]
            ];
          $result=DB::table('attendances')->insert($data);
        }
      }        
        return response()->json(["status"=>"success", "emp_id"=>$request->emp_id, "msg"=>"Attendance submited successfully"]);
    }
    public function attendance_reporting(Request $request)
    {
        //
    return view('admin.attendance_reporting');
    }

    public function attendance_reporting_process1(Request $request)
    {
        $get_data=$request;
        $data = explode("|",$get_data);
        if($data[1] !='' && $data[2] !='' && $data[3] !=''){
        // $filterd_data = $filterd_data = Attendance::whereBetween('date',[$data[2],$data[3]])->get();
        $filterd_data = $filterd_data = Attendance::where('date', '>=', $data[2])
                                                    ->where('date', '<=', $data[3])
                                                    ->where('emp_id', $data[1])
                                                    ->get();
        return response()->json(["status"=>"success", "data"=>$filterd_data]);

       }
       else
       { 
        return response()->json(["status"=>"error", "data"=>'Please select required details']);

        }

       }
       public function attendance_filter_before_upload_process(Request $request)
       {
           $get_data=$request;
           $data = explode("|",$get_data);
           if($data[1] !='' && $data[2] !=''){
           // $filterd_data = $filterd_data = Attendance::whereBetween('date',[$data[2],$data[3]])->get();
           $filterd_data = $filterd_data = Attendance::where('date', '=', $data[2])
                                                       ->where('emp_id', $data[1])
                                                       ->get();
            if(isset($filterd_data[0]->id)){
                return response()->json(["status"=>"success", "data"=>$filterd_data]);
            } else{ 
            return response()->json(["status"=>"error", "data"=>'']);
            }
   
          }
        }
   
        public function attendance_reporting_process(Request $request)
        {
       
         $filterd_data =   DB::select(DB::raw("SELECT TIMEDIFF(`attendances`.`out_time`,`attendances`.`in_time`) AS 'working_hour',`attendances`.`date`,`attendances`.`in_time`,`attendances`.`out_time`,`attendances`.`status` FROM `attendances` where `attendances`.`emp_id` = '$request->emp_id' AND `attendances`.`date` >= '$request->from' AND `attendances`.`date` <= '$request->to' ORDER BY date ASC"));
         // return $filterd_data;
            // $filterd_data = $filterd_data = Attendance::whereBetween('date',[$data[2],$data[3]])->get();
         //    $filterd_dataa = $filterd_data = Attendance::where('date', '>=', $request->from)
         //                                                ->where('date', '<=', $request->to)
         //                                                ->where('emp_id', $request->emp_id)
         //                                                ->get();
             $emp_info = DB::select(DB::raw("SELECT `emps`.id, `emps`.name,`emps`.salary,`emps`.email,`emp_personal_infos`.contact,`emp_personal_infos`.c_address,`emp_personal_infos`.c_city,`emp_personal_infos`.c_state,`emp_personal_infos`.c_pincode FROM emps LEFT JOIN emp_personal_infos ON emps.id=emp_personal_infos.emp_id WHERE emps.id='$request->emp_id'"));
             if(isset($emp_info[0]->id)){
             session()->forget('EMP_DATA_FOR_REPORT');
             $request->session()->put('EMP_DATA_FOR_REPORT',$emp_info[0]->id.', '.$emp_info[0]->name.','.$emp_info[0]->c_address.', '.$emp_info[0]->c_city.', '.$emp_info[0]->c_state.', '.$emp_info[0]->c_pincode);
             }
            return response()->json(["status"=>"success", "data"=>$filterd_data,"emp_info"=>$emp_info, "from_date"=>$request->from, "to_date"=>$request->to]);
           }

    public function updatepassword()
    {
        $r = Admin::find(1);
        $r->password=Hash::make('admin');
        $r->save();
    }
//new from stagserver
    public function reset_password_process(Request $request)
    {
        $reset_password = Admin::find(1);
        $reset_password->password=Hash::make($request->password);
        $reset_password_status = $reset_password->save();
        if($reset_password_status){
            return response()->json(["status"=>"success", "msg"=>"Password updated successfully"]);
           }else {
            return response()->json(["status"=>"error", "msg"=>"Something went wrong"]);
           }
    }
//new from stagserver

    public function search_employee(Request $request)
    {
 $search= $request->search;
//  return $search.'serach result';
if ($search == '') {
     $employees_by_search = Emp::orderby('name','asc')
    ->select('id','name')
    ->limit(5)
    ->get();

}else{
    $employees_by_search = Emp::orderby('name','asc')
    ->select('id','name')
    ->where('name','like','%'.$search.'%')
    ->limit(5)
    ->get();
    }
    // return response()->json(["status"=>"success", "data"=>$employees_by_search]);
    $response= array();
    foreach ($employees_by_search as $employee) {
    $response[] = array(
    'id'=>$employee->id,
    'text'=>$employee->name
    );
}
  return response()->json($response);
}

public function create_user(Request $request){
     $is_user_email_exist=Emp::where(['email'=>$request->post('email')])->get();
    if(isset($is_user_email_exist[0])){
        return response()->json(["status"=>"error", "msg"=>"User email allready exist"]);
    }else{
     $is_official_email_exist=Emp::where(['official_email'=>$request->post('official_email')])->get();
    if(isset($is_official_email_exist[0])){
        return response()->json(["status"=>"error", "msg"=>"Official email allready exist"]);
    }else{
        $emp_create = new Emp();
        $emp_create->name = $request->post('name');
        $emp_create->email = $request->post('email');
        $emp_create->official_email = $request->post('official_email');
        $emp_create->salary = $request->post('salary');
        $emp_create->password = Crypt::encrypt($request->post('password'));
        $rand_id=rand(111111111,999999999);
        $emp_create->rand_id = $rand_id;
        $emp_create_status = $emp_create->save();
        $this->send_login_details_to_emp($request, $emp_create->id);
       if($emp_create_status){
        return response()->json(["status"=>"success", "msg"=>"User created successfully"]);
       }else {
        return response()->json(["status"=>"error", "msg"=>"Something went wrong"]);
       }

    }
}
  
}
public function send_login_details_to_emp($request, $id){
     $emp_detail=Emp::where(['id'=>$id])->get();
     $rand_id= $emp_detail[0]->rand_id;
     $password=Crypt::decrypt($emp_detail[0]->password);
     $personal_email=$emp_detail[0]->email;
     $official_email=$emp_detail[0]->official_email;
     $data=['name'=>'sudhir','rand_id'=>$rand_id,"email"=>$personal_email, "official_email"=>$official_email, "password"=>$password];
     $user['to_personal_email'] = $personal_email;
     $user1['to_official_email'] = $official_email;
     Mail::send('email.send_login_mail_to_emp', $data, function($messages) use ($user){
        $messages->to($user['to_personal_email']);
        $messages->subject('Login details');
    });  
    Mail::send('email.verify_mail', $data, function($messages) use ($user1){
        $messages->to($user1['to_official_email']);
        $messages->subject('Verify Email');
    });
    $msg = "Login details send  successfully";
    $request->session()->flash('message',$msg);

    return redirect('admin/emp');
}


public function import_attendance_form(){

return view('admin.import_attendance_form');
}

//app setting start

function app_settings(Request $request){
    $app_settings=app_settings::where(['admin_id'=>session('ADMIN_ID')])->get();
 
    if(isset($app_settings[0]->id)){
        return view('admin.app_settings')->with('app_settings',$app_settings);
    }
    return view('admin.manage_app_settings_process');

 }















 function manage_app_settings_process(Request $request){
     $app_setting_exist=app_settings::where(['admin_id'=>session('ADMIN_ID')])->get();
    if(count($app_setting_exist)){
       $app_settings_update_status = DB::table('app_settings')
         ->where('id',$app_setting_exist[0]->id)
         ->update(['company_name'=>$request->company_name,'address'=>$request->address,'city'=>$request->city,'state'=>$request->state,'pincode'=>$request->pincode]);
    
    if($app_settings_update_status){
        session()->forget('COMPANY_NAME');
        session()->forget('ADDRESS');
        $app_settings_info=app_settings::where(['admin_id'=>session('ADMIN_ID')])->get();
        if(isset($app_settings_info[0]->id)){

        $request->session()->put('COMPANY_NAME',$app_settings_info[0]->company_name);
        $request->session()->put('LOGO',$app_settings_info[0]->logo);
        $request->session()->put('ADDRESS',$app_settings_info[0]->address.', '.$app_settings_info[0]->city.', '.$app_settings_info[0]->state.', '.$app_settings_info[0]->pincode);
        }
        return response()->json(["status"=>"success", "msg"=>"App setting updated successfully"]);
       }else {
        return response()->json(["status"=>"warning", "msg"=>"No change found"]);
       }
    }
else{
        $app_settings = new app_settings();
        $app_settings->admin_id=session('ADMIN_ID');
        $app_settings->company_name=$request->company_name;
        $app_settings->address=$request->address;
        $app_settings->city=$request->city;
        $app_settings->state=$request->state;
        $app_settings->pincode=$request->pincode;
        $app_settings_new_record_status = $app_settings->save();
    }
    if($app_settings_new_record_status){
        return response()->json(["status"=>"success", "msg"=>"App setting added successfully"]);
       }else {
        return response()->json(["status"=>"error", "msg"=>"Something went wrong.."]);
       }
}
 


function independent_image_upload_to_app_settings(Request $request){
     if($request->user_id == session('ADMIN_ID')){
       $app_settings_record_exist=app_settings::where(['admin_id'=>$request->user_id])->get();
       if(count($app_settings_record_exist)){   
               $image_file =$request->file($request->field_name);
               $image_filename = $request->user_id.'-'.$request->field_name.'_'.time(); 
               $image_file->storeAS('/public/media',$image_filename);      
               $image_upload_status = DB::table('app_settings')
               ->where('admin_id',$request->user_id)
               ->update([$request->field_name=>$image_filename]);
      
       }else{
           $app_settings = new app_settings();
           $app_settings->admin_id=$request->user_id;
           $new_image_file = $request->file($request->field_name);
           $image_filename = $request->user_id.'-'.$request->field_name.'_'.time(); 
           $app_settings->logo=$image_filename;
           $new_image_file->storeAS('/public/media',$image_filename);
           $image_upload_status = $app_settings->save();
         
       } 
       if($image_upload_status){
        session()->forget('LOGO');
        $app_logo=app_settings::where(['admin_id'=>session('ADMIN_ID')])->get();
        if(isset($app_logo[0]->id)){
        $request->session()->put('LOGO',$app_logo[0]->logo);
        }
         
           return response()->json(["status"=>"success", "msg"=>"Logo uploaded successfully"]);
       } else {
           return response()->json(["status"=>"warning", "msg"=>"something wrong"]);
       }
   }
   else{
   return response()->json(["status"=>"error", "msg"=>"You are not allowed"]);
   }
}




























//end app setting

public function import_attendance_form_process(Request $request){
    Excel::import(new AttendanceImport, $request->file);
    $msg = "Record Imported successfully";
    $request->session()->flash('message',$msg);

    return redirect('admin/import-attendance');
    }
}
