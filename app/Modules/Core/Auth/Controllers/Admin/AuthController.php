<?php

namespace App\Modules\Core\Auth\Controllers\Admin;

use App\Modules\BackendController;
use Dingo\Api\Routing\Helpers;
use App\Modules\Api\Models\User;

/**
 * Description of AuthController
 *
 * @author Hoangdv
 */
class AuthController extends BackendController {
    use Helpers;

    public function __construct()
    {
        parent::__construct();

        //$this->layout = $this->theme . '.layouts.adminlte_login';
        $this->layout = null;
    }

    public function login()
    {
        $data = ['error' => null, 'email' => '', 'password' => ''];

        if(\Request::isMethod('post')){
            $params = \Input::all();

            $post = [
                'email' => $params['email'],
                'password' => $params['password'],
            ];
            
            try {
                $res = $this->api->post('api/auth/login', $post);
                
                $arr = [
                    'username' => $res['data']->username,
                    'email' => $res['data']->email,
                    'token' => $res['data']->token
                ];
                foreach ($arr as $key => $value) {
                    \Request::session()->put($key, $value);
                }
                return redirect('/admin');
            } catch (\Dingo\Api\Exception\InternalHttpException $e) {
                $response = $e->getResponse();
                $data['error'] = $response->original;
                $data['email'] = $post['email'];
                $data['password'] = $post['password'];
            }
        }

        return view('Auth::'. $this->theme . '.layouts.login', $data);
    }

    public function logout()
    {
        $rs = $this->api->post('api/auth/logout?get_object=1&access_token=' . \Request::session()->get('accessToken'));
        \Request::session()->flush();
        return redirect('/admin/login');
    }
}