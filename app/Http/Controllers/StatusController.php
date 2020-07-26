<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    /**
     * save user status.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUserSatus(Request $request)
    {
        $userId = Auth::user()->id;
        if($request->has('status')){
          $user = User::find($userId);
          $user->status = $request->status;  
          $user->save(); 
        }
        if($request->has($request->expire_time)){
        $deleteTime = Carbon::parse($request->expire_time);
        $userStatus = new UserStatus;
        $userStatus->user_id =$userId;
        $userStatus->expire_time = $deleteTime;
        $userStatus->save();    
        }
        return redirect()->back();  

    }

    public function allPosts(Request $request)
    {
        
        $columns = array( 
                            0 =>'id', 
                            1 =>'name',
                            2=> 'username',
                            3=> 'email',
                            4=> 'status',
                        );
  
        $totalData = User::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            if(Auth::check())
            {
            $posts = User::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
       
            }else{            
            $posts = User::offset($start)
                          ->where('status',"Public")    
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        }
        else {
            $search = $request->input('search.value'); 

            $posts =  User::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('status', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = User::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('status', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['name'] = $post->name;
                $nestedData['username'] = $post->username;
                $nestedData['email'] = $post->email;
                $nestedData['status'] = $post->status;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
    
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
    
}
 