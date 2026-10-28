<?php

namespace App\Http\Controllers;

use App\Actions\ListUsers;
use Illuminate\Contracts\View\View;

class UserOverviewController extends Controller
{
    public function __invoke(ListUsers $listUsers): View
    {
        return view('users.index', [
            'users' => $listUsers->handle(),
        ]);
    }
}
