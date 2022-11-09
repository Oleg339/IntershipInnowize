<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function view()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function create()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function edit()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function update()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function delete()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function restore()
    {
        return auth()->user()->hasRole('Admin');
    }

    public function export()
    {
        return auth()->user()->hasRole('Admin');
    }
}
