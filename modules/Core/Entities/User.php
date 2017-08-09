<?php namespace Modules\Core\Entities;

use Elasticquent\ElasticquentTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Service\Entities\Client;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use EntrustUserTrait, SoftDeletes, Authenticatable, CanResetPassword, ElasticquentTrait;

    protected $fillable = [
        "username",
        "email",
        "password",
        "activation_key",
        "last_visited",
        "remember_token",
        "type",
        "status",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected $guarded = [ "password" ];

    protected $hidden = [ 'password' ];

    protected $dates = [ 'created_at', 'updated_at' ];

    public $timestamps = true;

    public static $rules = [
        'create'          => [
            'username'         => 'alpha_num|between:4,24|unique:users,username',
            'email'            => 'required|email|max:128|unique:users,email',
            'password'         => 'required|min:6',
            'password_confirm' => 'required|min:6|same:password',
            'activation_key'   => 'required_if:status,0',
            'type'             => 'string|required',
            'status'           => 'integer|required',
            'roles'            => 'array|required'
        ],
        'update'          => [
            'username'         => 'alpha_num|between:4,24|unique:users,username,:id',
            'new_password'     => 'alpha_num|min:6',
            'password_confirm' => 'alpha_num|required_with:new_password|min:6|same:new_password',
            'meta'             => 'array',
            'type'             => 'string|required',
            'status'           => 'integer|required',
            'roles'            => 'array|required'
        ],
        'change_password' => [
            'password'         => 'required|min:6|same:password_confirm',
            'password_confirm' => 'required'
        ]
    ];


    public static function rules($action, $merge = [ ], $id = false)
    {
        $rules = self::$rules[$action];

        if ($id) {
            foreach ($rules as &$rule) {
                $rule = str_replace(':id', $id, $rule);
            }
        }

        return array_merge($rules, $merge);
    }


    public function client()
    {
        return $this->hasOne(Client::class)->first();
    }


    public function meta_key($meta_key, $group = false)
    {
        $query = $this->meta()->where('meta_key', '=', $meta_key);

        if ($group) {
            $query->where('group', '=', $group);
        }

        return $query->first();
    }


    public function meta()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function files($type = '*', $mine = '*', $status = 'open', $deleted = null)
    {
        $file = $this->belongsToMany(File::class, 'user_file', 'user_id', 'file_id', 'id')->where('files.status', '=', $status);

        if ($type !== '*') {
            $file->where('user_file.type', '=', $type);
        }

        if ($mine !== '*') {
            $file->where('files.type', '=', $mine);
        }

        return $file;
    }


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }


    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }


    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }


    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }


    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        // TODO: Implement getReminderEmail() method.
    }
}