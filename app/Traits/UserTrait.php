<?php
  
namespace App\Traits;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Role;

use Auth;

trait UserTrait {
  
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function validation($request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50|confirmed',
            'phone' => 'required',
            'role' => 'required'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'success' => false
            ], 400);
        }

        $role =Role::where('name',$request->role)->first();

        if ($role && $role->name == 'Admin' && Auth::user()->role->name != 'Admin') {
            return response()->json([
                'errors' => ['role' => ['Cannot add user against this role!']],
                'success' => false
            ], 400);
        }
        elseif(!$role)
        {
            return response()->json([
                'errors' => ['role' => ['Role Not found!']],
                'success' => false
            ], 400);
        }
        /*validation end*/
        
    }
    public function createOrUpdateUser(Request $request)
    {
        $response = $this->validation($request);
        // dd($response);
        if ($response && $response->getStatusCode() == 400) {
            return $response;
        }

        $role =Role::where('name',$request->role)->first();

        $request['role_id'] = $role->id;
        $request['name'] = $request->first_name.' '.$request->last_name;

        // dd($request->all());
        $user = $request->id ?  User::find($request->id) : new User;

        $user = $user->updateOrCreate(
            [
                'email' => $request->email,
            ],
            [
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'added_by' => $request->added_by,
            ]
        );

        $user->user_detail()->updateOrCreate(
            [
                'user_id'=>$user->id,
            ],
            [
                'phone'=>$request->phone,
                'gender'=>$request->gender,
                'date_of_birth'=>$request->date_of_birth,
                'address_line_1'=>$request->address_line_1,
                'address_line_2'=>$request->address_line_2,
                'country_id'=>$request->country_id,
                'state_id' => $request->state_id,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'tax_id'=>$request->tax_id
            ]
        );

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }
  
}