<?php
/**
 * Created by ngocnh.
 * Date: 8/5/15
 * Time: 9:25 PM
 */

namespace Modules\Core\Http\Controllers;

use Carbon\Carbon;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Modules\Core\Http\Requests\UserApplicationRequest;
use Modules\Core\Http\Requests\UserStoreRequest;
use Modules\Core\Http\Requests\UserUpdateRequest;
use Modules\Core\Repositories\RoleRepository;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Transformers\UserDatatablesTransformer;
use Modules\Core\Transformers\UserTransformer;
use Datatables;
use Modules\Service\Repositories\ClientRepository;

class UserController extends BackendController
{

    public function __construct(Manager $manager, UserRepository $user, RoleRepository $role, ClientRepository $client)
    {
        parent::__construct($manager);
        $this->user   = $user;
        $this->role   = $role;
        $this->client = $client;
    }


    public function getIndex()
    {
        if ($response = event('user.index.before.render')) {
            return $this->theme->of($response[0])->render();
        }

        return $this->theme->of('core::account_list')->render();
    }


    public function getCreate()
    {

        $data = $this->renderView();

        return $this->theme->of('core::view', $data)->render();
    }


    public function getProfile()
    {
        $user   = $this->manager->createData(new Item(auth()->user(), new UserTransformer))->toArray();
        $client = auth()->user()->client();

        $data = [
            'title' => trans('core::config.title'),
            'route' => [
                'store'  => 'configuration.setting.store',
                'update' => 'configuration.setting.update'
            ],
            'tabs'  => [
                'profile'  => [
                    'li'  => '[li class="active"][a href="#profile" data-toggle="tab"]' . trans('core::user.profile') . '[/a][/li]',
                    'tab' => [
                        'id'     => 'profile',
                        'active' => true,
                        'form'   => [
                            "[h4]" . trans('core::user.profile.header') . "[/h4]",
                            "[form_open action='" . route('user.update',
                                $user['id']) . "' method='POST' class='form-horizontal' ]",
                            "[input type='hidden' name='redirect' value='" . route('user.profile') . "'][/input]",
                            "[label class='control-label' for='image']" . trans('core::user.image') . "[/label]",
                            "[ckimage class='col-sm-6' id='image' name='image' value='" . (isset($user['avatar']) ? $user['avatar'] : '') . "'][/ckimage]",
                            "[label class='control-label' for='first_name']" . trans('core::user.first_name') . "[/label][input type='text' class='form-control' id='first_name' name='meta.first_name' value='" . (isset($user['meta']['first_name']) ? $user['meta']['first_name'] : '') . "'][/input]",
                            "[label class='control-label' for='last_name']" . trans('core::user.last_name') . "[/label][input type='text' class='form-control' id='last_name' name='meta.last_name' value='" . (isset($user['meta']['last_name']) ? $user['meta']['last_name'] : '') . "'][/input]",
                            "[label class='control-label' for='nickname']" . trans('core::user.nickname') . "[/label][input type='text' class='form-control' id='nickname' name='meta.nickname' value='" . (isset($user['meta']['nickname']) ? $user['meta']['nickname'] : '') . "'][/input]",
                            "[label class='control-label' for='birthday']" . trans('core::user.birthday') . "[/label][input type='text' class='form-control b-datepicker' data-view='2' data-min='" . Carbon::now()->subYears(100)->format('d/m/Y') . "' data-max='" . Carbon::now()->subYears(10)->format('d/m/Y') . "' id='birthday' name='meta.birthday' value='" . (isset($user['meta']['birthday']) ? $user['meta']['birthday'] : '') . "'][/input]",
                            "[label class='control-label' for='address']" . trans('core::user.address') . "[/label][input type='text' class='form-control' id='address' name='meta.address' value='" . (isset($user['meta']['address']) ? $user['meta']['address'] : '') . "'][/input]",
                            "[label class='control-label' for='phone']" . trans('core::user.phone') . "[/label][input type='tel' class='form-control' id='phone' name='meta.phone' value='" . (isset($user['meta']['phone']) ? $user['meta']['phone'] : '') . "'][/input]",
                            "[label class='control-label' for='url']" . trans('core::user.url') . "[/label][input type='text' class='form-control' id='url' name='meta.url' value='" . (isset($user['meta']['url']) ? $user['meta']['url'] : '') . "'][/input]",
                            "[label class='control-label' for='company']" . trans('core::user.company') . "[/label][input type='text' class='form-control' id='url' name='meta.company' value='" . (isset($user['meta']['company']) ? $user['meta']['company'] : '') . "'][/input]",
                            "[label class='control-label' for='about']" . trans('core::user.about') . "[/label][textarea class='form-control' rows='5' id='about' name='meta.about']" . (isset($user['meta']['about']) ? $user['meta']['about'] : '') . "[/textarea]",
                            "[button type='submit' class='btn btn-success']" . trans('core::general.save') . "[/button]",
                            "[form_close]"
                        ]
                    ]
                ],
                'setting'  => [
                    'li'  => '[li][a href="#setting" data-toggle="tab"]' . trans('core::user.profile.settings') . '[/a][/li]',
                    'tab' => [
                        'id'   => 'setting',
                        'form' => [
                            "[h4]" . trans('core::user.profile.settings.header') . "[/h4]",
                            "[form_open action='" . route('user.application') . "' method='POST' class='form-horizontal' ]",
                            "[input type='hidden' name='redirect' value='" . route('user.profile') . "'][/input]",
                            "[label class='control-label' for='client_id']" . trans('core::user.profile.settings.client_id') . "[/label][input type='text' class='form-control' readonly value='" . (isset($client['id']) ? $client['id'] : '') . "'][/input]",
                            "[label class='control-label' for='client_secret']" . trans('core::user.profile.settings.client_secret') . "[/label][input type='text' class='form-control' readonly value='" . (isset($client['secret']) ? $client['secret'] : '') . "'][/input]",
                            "[label class='control-label' for='name']" . trans('core::user.profile.settings.name') . "[/label][input type='text' class='form-control' id='name' name='name' value='" . (isset($client['name']) ? $client['name'] : '') . "'][/input]",
                            "[label class='control-label' for='url']" . trans('core::user.profile.settings.url') . "[/label][input type='text' class='form-control' id='url' name='url' value='" . (isset($client['url']) ? $client['url'] : '') . "'][/input]",
                            "[button type='submit' class='btn btn-success']" . trans('core::general.save') . "[/button]",
                            "[form_close]"
                        ]
                    ]
                ],
                'security' => [
                    'li'  => '[li][a href="#security" data-toggle="tab"]' . trans('core::user.profile.security') . '[/a][/li]',
                    'tab' => [
                        'id'   => 'security',
                        'form' => [
                            "[h4]" . trans('core::user.profile.security.header') . "[/h4]",
                            "[form_open action='" . route('user.update',
                                $user['id']) . "' method='POST' class='form-horizontal' ]",
                            "[input type='hidden' name='redirect' value='" . route('user.profile') . "'][/input]",
                            "[label class='control-label' for='old_password']" . trans('core::user.old_password') . "[/label][input type='password' class='form-control' id='old_password' name='old_password'][/input]",
                            "[label class='control-label' for='new_password']" . trans('core::user.new_password') . "[/label][input type='password' class='form-control' id='new_password' name='new_password'][/input]",
                            "[label class='control-label' for='password_confirm']" . trans('core::user.password_confirm') . "[/label][input type='password' class='form-control' id='password_confirm' name='password_confirm'][/input]",
                            "[label class='control-label' for='email']" . trans('core::user.email') . "[/label][input type='email' class='form-control' id='email' name='email' value='{$user['email']}'][/input]",
                            "[button type='submit' class='btn btn-success']" . trans('core::general.save') . "[/button]",
                            "[form_close]"
                        ]
                    ]
                ]
            ]
        ];

        if ($response = event('user.profile.after.render', [$data])) {
            $data = $response[0];
        }

        return $this->theme->of('core::profile', $data)->render();
    }


    public function postStore(UserStoreRequest $request, $external = false)
    {
        $attributes = [
            'attributes' => [
                'email'          => $request->email,
                'password'       => $request->password,
                'activation_key' => $request->status ? null : str_random(24),
                'type'           => $request->type,
                'status'         => $request->status ? 1 : 0,
            ],
            'roles'      => $request->roles,
            'image'      => $request->image ?: false
        ];

        if ($request->meta) {
            foreach ($request->meta as $key => $value) {
                $attributes['meta'][$key] = $value;
            }
        }

        if ($request->username) {
            $attributes['username'] = $request->username;
        }

        if ($response = event('user.before.store', [$attributes])) {
            $attributes = $response[0];
        }

        if ($user = $this->user->create($attributes)) {
            event('user.after.store', [$user]);
            flash(trans('core::user.create_success', ['name' => $user->username ?: $user->email]));

            return $external ? $user : redirect()->route('user.index');
        } else {
            flash()->error(trans('core::general.error'));

            return $external ? false : redirect()->back()->withInput();
        }
    }


    public function getEdit($id)
    {
        $user         = $this->user->find($id);
        $user         = new Item($user, new UserTransformer, 'user');
        $user         = $this->manager->createData($user)->toArray();
        $data         = $this->renderView($user);
        $data['item'] = $user;

        if ($response = event('user.edit.before.render', [$data])) {
            $data = $response[0];
        }

        return $this->theme->of('core::view', $data)->render();
    }


    public function postUpdate(UserUpdateRequest $request)
    {
        $attributes = [
            'attributes' => []
        ];

        if ($request->roles) {
            $attributes['roles'] = $request->roles;
        }

        if ($request->type) {
            $attributes['attributes']['type'] = $request->type;
        }

        if ($request->status) {
            $attributes['attributes']['status'] = $request->status;
        }

        if ($request->email && $request->email != auth()->user()->email) {
            $attributes['attributes']['email'] = $request->email;
        }

        if ($request->meta) {
            foreach ($request->meta as $key => $value) {
                $attributes['meta'][$key] = $value;
            }
        }

        if ($request->image) {
            $attributes['image'] = $request->image;
        }

        if ($request->username) {
            $attributes['attributes']['username'] = $request->username;
        }

        if ($request->new_password) {
            if (auth()->validate(['username' => auth()->user()->username, 'password' => $request->old_password])) {
                $attributes['attributes']['password'] = $request->new_password;
            } else {
                flash()->error(trans('core::user.old_password_not_match'));

                return redirect()->back();
            }
        }

        if ($response = event('user.before.update', [$attributes])) {
            $attributes = $response[0];
        }

        if ($user = $this->user->update($request->one, $attributes)) {
            event('user.after.update', [$user]);

            if ($request->ajax()) {
                return response($this->manager->createData(new Item($user, new UserTransformer))->toArray());
            }

            flash(trans('core::user.update_success', ['name' => $user->username ?: $user->email]));

            if ($user->id === auth()->user()->id) {
                $image = $user->files('featured')->first();

                session()->put('user', [
                    'id'        => $user->id,
                    'email'     => $user->email,
                    'name'      => $user->meta_key('nickname') ? $user->meta_key('nickname')->meta_value : ($user->meta_key('first_name') ? $user->meta_key('first_name') . ' ' : '') . ($user->meta_key('last_name') ? $user->meta_key('last_name')->meta_value : ''),
                    'avatar'    => $image ? ($image->url ?: url($image->path)) : '',
                    'logged_in' => true
                ]);

                if ($request->redirect) {
                    return redirect($request->redirect)->withCookie(cookie()->forever('user', [
                        'CandyUsername' => $user->email,
                        'CandyName'     => $user->meta_key('nickname') ? $user->meta_key('nickname')->meta_value : ($user->meta_key('first_name') ? $user->meta_key('first_name') . ' ' : '') . ($user->meta_key('last_name') ? $user->meta_key('last_name')->meta_value : ''),
                        'CandyAvatar'   => $image ? ($image->url ?: url($image->path)) : ''
                    ]));
                }

                return redirect()->route('user.index')->withCookie(cookie()->forever('user', [
                    'CandyUsername' => $user->email,
                    'CandyName'     => $user->meta_key('nickname') ? $user->meta_key('nickname')->meta_value : ($user->meta_key('first_name') ? $user->meta_key('first_name') . ' ' : '') . ($user->meta_key('last_name') ? $user->meta_key('last_name')->meta_value : ''),
                    'CandyAvatar'   => $image ? ($image->url ?: url($image->path)) : ''
                ]));
            } else {
                return $request->redirect ? redirect($request->redirect) : redirect()->route('user.index');
            }
        } else {
            if ($request->ajax()) {
                return response(false)->isClientError();
            } else {
                flash()->error(trans('core::general.error'));
            }

            return redirect()->back()->withInput();
        }
    }


    public function postApplication(UserApplicationRequest $request)
    {
        $attributes = [
            'client' => [
                'name'    => $request->name,
                'user_id' => auth()->user()->id
            ]
        ];

        if ($request->url) {
            $attributes['endpoint']['redirect_uri'] = $request->url;
        }

        $roles = auth()->user()->roles()->get();

        foreach ($roles as $role) {
            foreach ($role->permissions() as $permission) {
                $attributes['scopes'][] = "{$permission->module}.{$permission->name}";
            }
        }

        if ($response = event('user.application.before.store', [$attributes])) {
            $attributes = $response;
        }

        if ($client = $this->client->create($attributes)) {
            event('user.application.after.store');

            return redirect()->route('user.profile');
        } else {
            return redirect()->back()->withInput();
        }
    }


    public function getLock($id)
    {
        if ($user = $this->user->find($id)) {
            if ($user = $this->user->lock($user)) {
                if ($user->status == 1) {
                    flash(trans('core::user.unlock_success', ['name' => $user->username ?: $user->email]));
                } else {
                    flash(trans('core::user.lock_success', ['name' => $user->username ?: $user->email]));
                }

                return redirect()->route('user.index');
            }

            flash()->error(trans('core::general.error'));

            return redirect()->route('user.index');
        }

        flash()->error(trans('core::user.find_not_found', ['id' => $id]));

        return redirect()->route('user.index');
    }


    public function postTrash()
    {

    }


    public function postDestroy($id, $external = false)
    {
        if ($user = $this->user->find($id)) {
            if ($this->user->trash($user)) {
                flash(trans('core::user.trash_success', ['name' => $user->username ?: $user->email]));

                return $external ? $user : redirect()->route('user.index');
            }

            flash()->error(trans('core::general.error'));

            return $external ? false : redirect()->route('user.index');
        }

        flash()->error(trans('core::user.find_not_found', ['id' => $id]));

        return $external ? false : redirect()->route('user.index');
    }


    public function postDatatables()
    {
        return Datatables::of($this->user->select())->setTransformer(UserDatatablesTransformer::class)->make(true);
    }


    private function renderView($user = false)
    {
        $select_role = '[label class="control-label" for="roles"]' . trans('core::user.role') . '[/label][select multiple class="form-control" id="roles" name="roles."]';

        foreach ($this->role->all() as $role) {
            $select_role .= "[option value='$role->id' " . ((old('roles') == $role['id']) || (isset($user['roles']) && in_array($role['id'],
                        array_pluck($user['roles'], 'id'))) ? 'selected' : '') . "]$role->display_name[/option]";
        }

        $select_role .= '[/select]';

        $data = [
            'route' => [
                'store'  => 'user.store',
                'update' => 'user.update'
            ],
            'form'  => [
                'left'  => [
                    "[label class='col-sm-4 control-label']" . trans('core::user.first_name') . "[/label][div class='col-sm-8'][input class='form-control' type='text' id='first_name' name='meta.first_name' value='" . ($user && isset($user['meta']['first_name']) ? $user['meta']['first_name'] : (old('first_name') ?: '')) . "'][/input][/div]",
                    "[label class='col-sm-4 control-label']" . trans('core::user.last_name') . "[/label][div class='col-sm-8'][input class='form-control' type='text' id='last_name' name='meta.last_name' value='" . ($user && isset($user['meta']['last_name']) ? $user['meta']['last_name'] : (old('last_name') ?: '')) . "'][/input][/div]",
                ],
                'right' => [
                    "[input type='hidden' name='type' value='" . ($user && isset($user['type']) ? $user['type'] : (old('type') ?: 'default')) . "'][/input]",
                    "[label class='control-label' for='username']" . trans('core::user.username') . "[/label][input class='form-control' type='text' id='username' name='username' value='" . ($user && isset($user['username']) ? $user['username'] : (old('username') ?: '')) . "'][/input]",
                    "[label class='control-label' for='email']" . trans('core::user.email') . "[/label][input class='form-control' type='email' id='email' name='email' value='" . ($user && isset($user['email']) ? $user['email'] : (old('email') ?: '')) . "'][/input]",
                    "[label class='control-label' for='" . ($user ? 'new_password' : 'password') . "']" . trans('core::user.' . ($user ? 'new_password' : 'password')) . "[/label][input class='form-control' type='password' id='" . ($user ? 'new_password' : 'password') . "' name='" . ($user ? 'new_password' : 'password') . "' value='" . (old($user ? 'new_password' : 'password') ?: '') . "'][/input]",
                    "[label class='control-label' for='password_confirm']" . trans('core::user.password_confirm') . "[/label][input class='form-control' type='password' id='password_confirm' name='password_confirm' value='" . (old('password_confirm') ?: '') . "'][/input]",
                    $select_role,
                    "[label class='control-label' for='status']" . trans('core::user.status') . "[/label][switch2 id='status' name='status' checked='" . ($user && $user['status'] == 1 ? 'checked' : '') . "'][/switch2]"
                ]
            ]
        ];

        if ($response = event('user.create.before.render', [$data])) {
            $data = $response[0];
        }

        return $data;
    }
}