<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\SessionRepository;

/**
 * Class UserSessionController.
 */
class UserSessionController extends Controller
{
    /**
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     */
    public function clearSession(ManageUserRequest $request, SessionRepository $sessionRepository, User $user)
    {
        $sessionRepository->clearSession($user);

        return redirect()->back()->withFlashSuccess(__('alerts.backend.users.session_cleared'));
    }
}
