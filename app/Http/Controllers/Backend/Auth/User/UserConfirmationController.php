<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Backend\Auth\UserRepository;

/**
 * Class UserConfirmationController.
 */
class UserConfirmationController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return mixed
     */
    public function sendConfirmationEmail(ManageUserRequest $request, User $user)
    {
        // Shouldn't allow users to confirm their own accounts when the application is set to manual confirmation
        if (config('access.users.requires_approval')) {
            return redirect()->back()->withFlashDanger(__('alerts.backend.users.cant_resend_confirmation'));
        }

        if ($user->isConfirmed()) {
            return redirect()->back()->withFlashSuccess(__('exceptions.backend.access.users.already_confirmed'));
        }

        $user->notify(new UserNeedsConfirmation($user->confirmation_code));

        return redirect()->back()->withFlashSuccess(__('alerts.backend.users.confirmation_email'));
    }

    /**
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     */
    public function confirm(ManageUserRequest $request, User $user)
    {
        $this->userRepository->confirm($user);

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.confirmed'));
    }

    /**
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     */
    public function unconfirm(ManageUserRequest $request, User $user)
    {
        $this->userRepository->unconfirm($user);

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.unconfirmed'));
    }
}
