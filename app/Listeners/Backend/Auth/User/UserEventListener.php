<?php

namespace App\Listeners\Backend\Auth\User;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    public function onCreated($event)
    {
        \Log::info('User Created');
    }

    public function onUpdated($event)
    {
        \Log::info('User Updated');
    }

    public function onDeleted($event)
    {
        \Log::info('User Deleted');
    }

    public function onConfirmed($event)
    {
        \Log::info('User Confirmed');
    }

    public function onUnconfirmed($event)
    {
        \Log::info('User Unconfirmed');
    }

    public function onPasswordChanged($event)
    {
        \Log::info('User Password Changed');
    }

    public function onDeactivated($event)
    {
        \Log::info('User Deactivated');
    }

    public function onReactivated($event)
    {
        \Log::info('User Reactivated');
    }

    public function onSocialDeleted($event)
    {
        \Log::info('User Social Deleted');
    }

    public function onPermanentlyDeleted($event)
    {
        \Log::info('User Permanently Deleted');
    }

    public function onRestored($event)
    {
        \Log::info('User Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Auth\User\UserCreated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUpdated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserConfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onConfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserUnconfirmed::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onUnconfirmed'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPasswordChanged::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPasswordChanged'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserDeactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onDeactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserReactivated::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onReactivated'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserSocialDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onSocialDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserPermanentlyDeleted::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Auth\User\UserRestored::class,
            'App\Listeners\Backend\Auth\User\UserEventListener@onRestored'
        );
    }
}
