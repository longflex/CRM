<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laralum;
use Mail;
use File;
use App\Notifications\WelcomeMessage;
use App\Notifications\AccountActivation;
use App\Session;
                                                                                                    

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'activation_key', 'register_ip', 'country_code','company','isReseller','department'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_key',
    ];

    /**
    * Mutator to capitalize the name
    *
    * @param mixed $value
    */
    public function setNameAttribute($value){
        $this->attributes['name'] = ucwords($value);
    }

    /**
    * Returns all the roles from the user
    *
    */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
    * Returns true if the user has access to laralum
    *
    */
    public function isAdmin()
    {
        return $this->hasPermission('laralum.access');
    }

    /**
    * Returns true if the user has the permission slug
    *
    * @param string $slug
    */
    public function hasPermission($slug)
    {
        
        foreach($this->roles as $role) {
            // dd($role->permissions);
            foreach($role->permissions as $perm) {
                
                if($perm->slug == $slug) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
    * Returns true if the user has the role
    *
    * @param string $name
    */
    public function hasRole($name)
    {
        foreach($this->roles as $role) {
            if($role->name == $name) {
                return true;
            }
        }
        return false;
    }

    /**
    * Returns all the blogs owned by the user
    *
    */
    public function blogs()
    {
        return $this->hasMany('App\Blog');
    }

    /**
    * Returns true if the user has blog access
    *
    * @param number $id
    */
    public function has_blog($id)
    {
        foreach($this->roles as $role){
            foreach(Laralum::blog('id', $id)->roles as $b_role){
                if($role->id == $b_role->id){
                    return true;
                }
            }
        }
        return false;
    }

    /**
    * Returns true if the user owns the blog
    *
    * @param number $id
    */
    public function owns_blog($id)
    {
        if($this->id == Laralum::blog('id', $id)->user_id){
            return true;
        } else {
            return false;
        }
    }
	
	 public function owns_group($id)
    {
		
        if($this->id == Laralum::group('id', $id)[0]->client_id){
            return true;
        } else {
            return false;
        }
    }

	 public function owns_contact($id)
     {
        if($this->id == Laralum::contact('id', $id)[0]->user_id){
            return true;
        } else {
            return false;
        }
    }
	
	public function owns_senderid($id)
    {
        if($this->id == Laralum::sender('id', $id)[0]->user_id){
            return true;
        } else {
            return false;
        }
    }
	
	public function owns_banks($id)
    {
        if($this->id == Laralum::banks('id', $id)[0]->user_id){
            return true;
        } else {
            return false;
        }
    }
	
	public function owns_gatewayid($id)
    {
        if($this->id == Laralum::getway('id', $id)[0]->user_id){
            return true;
        } else {
            return false;
        }
    }
    /**
    * Returns all the posts from the user
    *
    */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
    * Returns true if the users owns the post
    *
    * @param number $id
    */
    public function owns_post($id)
    {
        if($this->id == Laralum::post('id', $id)->author->id){
            return true;
        } else {
            return false;
        }
    }

    /**
    * Returns the user avatar from Gavatar
    *
    * @param number $size
    */
    public function avatar($size = null)
    {
        $file = Laralum::avatarsLocation() . '/' . md5($this->email);
        $file_url = asset($file);
        if(File::exists($file)){
            return $file_url;
        } else {
            return Laralum::defaultAvatar();
        }
    }

    /**
    * Returns all the documents from the user
    *
    */
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    /**
    * Returns all the social accounts from the user
    *
    */
    public function socials()
    {
        return $this->hasMany('App\Social');
    }

    /**
    * Returns true if the user has the social account
    *
    * @param string $provider
    */
    public function hasSocial($provider)
    {
        foreach($this->socials as $social){
            if($social->provider == $provider){
                return true;
            }
        }
        return false;
    }

    /**
    * Sends the welcome email notification to the user
    *
    */
    public function sendWelcomeEmail()
    {
        return $this->notify(new WelcomeMessage($this));
    }

    /**
    * Sends the activation email notification to the user
    *
    */
    public function sendActivationEmail()
    {
        return $this->notify(new AccountActivation($this));
    }

    protected $with = ['sessions'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public static function allEmployees($exceptId = NULL)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        if (!is_null($exceptId)) {
            $users = User::withoutGlobalScope('active')
                //->join('role_user', 'role_user.user_id', '=', 'users.id')
                //->join('roles', 'roles.id', '=', 'role_user.role_id')
                //->join('employee_details', 'employee_details.user_id', '=', 'users.id')
                //->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
                ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.mobile')
                //->where('roles.name', '<>', 'client')
                ->where('users.id', '<>', $exceptId)
                ->where('users.reseller_id', $client_id)
                ->where('users.isReseller', '!=', 1);
            $users->orderBy('users.name', 'asc');
            $users->groupBy('users.id');
            return $users->get();
        }

        return cache()->remember(
            'all-employees',
            60 * 60 * 24,
            function () use ($exceptId,$client_id) {
                $users = User::withoutGlobalScope('active')
                    //->join('role_user', 'role_user.user_id', '=', 'users.id')
                    //->join('roles', 'roles.id', '=', 'role_user.role_id')
                    //->join('employee_details', 'employee_details.user_id', '=', 'users.id')
                    //->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
                    ->select('users.id', 'users.name', 'users.email', 'users.created_at','users.mobile')
                    //->where('roles.name', '<>', 'client');
                    ->where('users.reseller_id', $client_id)
                    ->where('users.isReseller', '!=', 1);
                if (!is_null($exceptId)) {
                    $users->where('users.id', '<>', $exceptId);
                }

                $users->orderBy('users.name', 'asc');
                $users->groupBy('users.id');
                return $users->get();
            }
        );
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function leaveTypes()
    {
        return $this->hasMany(EmployeeLeaveQuota::class);
    }
}
