<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Auth;
use Session;
use App\Cart;
use View;
use URL;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(Request $request) {
        
        $this->middleware('guest', ['except' => 'logout']);
        $previous_url =  explode("/", parse_url(URL::previous(), PHP_URL_PATH));
        if (!empty($previous_url[3]) && $previous_url[3] == 'cart') {
            Session::set('backUrl', URL::previous());
        }else{
            Session::set('backUrl', URL::to('/'));
        }
    }

//    public function redirectTo() {
//        return Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo;
//    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $view = View::make('auth.sign_in');
        if ($request->wantsJson()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }
        return $view;
    }

    protected function authenticated($request, $user) {

        if ($request->wantsJson()) {
            
            if (Auth::check() && Auth::user()->status == 0 && !empty(Auth::user()->verify_token)) {
                Auth::logout();
                return response()->json(['error' => "Your account is not activated yet! Please check activation email in your inbox and activate your account."], 401);
            }else if(Auth::check() && Auth::user()->status == 0){
                Auth::logout();
                return response()->json(['error' => "Your account is deactivated by admin! Please contact with administrator."], 401);
            }
            
            if (Session::has('cartItem')) { // this is used to save guest user cart data
                $cart_data = Session::pull('cartItem');

                foreach ($cart_data as $key => $value) {
                    $value['user_id'] = $user->id;
                    $cart = Cart::Where('user_id', $user->id)->where('product_id', $value['product_id'])->first(array('id', 'quantity'));
                    if (!$cart) {
                        Cart::create($value);
                    }
                }
            }
            return response()->json(['intended' => Session::get('backUrl')]);
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request) {
        if ($request->wantsJson()) {
            return response()->json([
                        'error' => Lang::get('auth.failed')
                            ], 401);
        }

        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors([
                            $this->username() => Lang::get('auth.failed'),
        ]);
    }

    protected function sendLockoutResponse(Request $request) {
        $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
        );
        if ($request->wantsJson()) {
            return response()->json([
                        'error' => $message
                            ], 401);
        }

        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors([$this->username() => $message]);
    }

}
