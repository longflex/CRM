<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Lead extends Model
{
    protected $table = 'leads';
    protected $fillable = ['user_id' , 'client_id', 'account_type', 'department', 'member_type','lead_source','lead_status','preferred_language','agent_id','profile_photo','member_id','name','date_of_birth','date_of_joining','date_of_anniversary','rfid','gender','blood_group','married_status','email','mobile','alt_numbers','id_proof','created_by','qualification','branch','profession','sms_required','call_required','sms_language','address_type','address','country','state','district','pincode'];

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function hasRole($name)
    {
        foreach($this->roles as $role){
            if($role->name == $name){
                return true;
            }
        }
        return false;
    }

}
