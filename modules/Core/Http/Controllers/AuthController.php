<?php
/**
 * Created by ngocnh.
 * Date: 8/3/15
 * Time: 8:41 PM
 */

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Modules\Core\Http\Requests\LoginRequest;
use Modules\Core\Transformers\UserTransformer;

class AuthController extends CoreController
{

    public function __construct()
    {
        parent::__construct();
        $this->theme = theme('default', 'login');
    }


    public function login(Request $request)
    {
        $this->theme->prependTitle(trans('core::login.title'));
        $user = $request->cookie('user');

        if (isset( $user['CandyUsername'] ) && $user['CandyUsername'] && ! $request->change) {
            return $this->theme->scope('lock_screen', [ 'user' => $user ])->render();
        } else {
            return $this->theme->scope('login')->render();
        }
    }


    public function do_login(LoginRequest $request)
    {
        $username = $request->username ?: $request->email;
        $password = $request->password;

        if (auth()->attempt([
                'email'    => $username,
                'password' => $password,
                'status'   => 1
            ]) || auth()->attempt([ 'username' => $username, 'password' => $password, 'status' => 1 ])
        ) {
            $user               = auth()->user();
            $user->last_visited = new \DateTime();
            $user->save();
            $image = $user->files('featured')->first();

            session()->put('user', [
                'id'        => $user->id,
                'email'     => $user->email,
                'name'      => $user->meta_key('nickname') ? $user->meta_key('nickname')->meta_value : ( $user->meta_key('first_name') ? $user->meta_key('first_name') . ' ' : '' ) . ( $user->meta_key('last_name') ? $user->meta_key('last_name')->meta_value : '' ),
                'avatar'    => $image ? ( $image->url ?: url($image->path) ) : '',
                'logged_in' => true
            ]);

            event('user.login', [ $user ]);

            if ($request->ajax()) {
                $manager = new Manager();
                $user    = new Item(auth()->user(), new UserTransformer);

                return response()->json($manager->createData($user)->toArray(), 200);
            }

            return redirect('/')->withCookie(cookie()->forever('user', [
                'CandyUsername' => $user->email,
                'CandyName'     => $user->meta_key('nickname') ? $user->meta_key('nickname')->meta_value : ( $user->meta_key('first_name') ? $user->meta_key('first_name') . ' ' : '' ) . ( $user->meta_key('last_name') ? $user->meta_key('last_name')->meta_value : '' ),
                'CandyAvatar'   => $image ? ( $image->url ?: url($image->path) ) : ''
            ]));

        } else {
            if ($request->ajax()) {
                return response()->json([ 'error' => trans('core::login.login_failed') ], 422);
            }

            flash()->error(trans('core::login.login_failed'));

            return redirect()->back()->withInput();
        }
    }


    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }
}