<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Bag;
use Illuminate\Support\Facades\Auth;

class BagComposer
{
    public function compose(View $view)
    {
        if (Auth::check() && Auth::user()->role === 'clinic') {
            $bagCount = Bag::where('clinic_id', Auth::id())->count();
            $view->with('bagCount', $bagCount);
        } else {
            $view->with('bagCount', 0);
        }
    }
}
