<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use App\Mail\Frontend\Contact\SendContact;
use App\Models\Contact;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if (session()->has('display_type')) {
            if (session('display_type') == 'rtl') {
                $path = 'frontend-rtl';
            } else {
                $path = 'frontend';
            }
        } elseif (config('app.display_type') == 'rtl') {
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->path.'.contact');
    }

    /**
     * @param  SendContactRequest  $request
     * @return mixed
     */
    public function send(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'g-recaptcha-response' => (config('access.captcha.registration') ? ['required', new CaptchaRule] : ''),
        ], [
            'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->number = $request->phone;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        Mail::send(new SendContact($request));
        Session::flash('alert', 'Response received successfully!');

        return redirect()->back();
    }
}
