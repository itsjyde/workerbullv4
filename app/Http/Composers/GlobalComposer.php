<?php

namespace App\Http\Composers;

use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('logged_in_user', auth()->user());
    }
}
