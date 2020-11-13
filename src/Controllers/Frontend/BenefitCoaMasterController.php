<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BenefitCoaMasterConrtoller extends Controller
{
    public function index()
    {
        return redirect()->route('journal.create');
    }
}
