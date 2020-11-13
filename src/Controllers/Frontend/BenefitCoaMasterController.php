<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BenefitCoaMasterController extends Controller
{
    public function index()
    {
        return redirect()->route('journal.create');
    }
}
