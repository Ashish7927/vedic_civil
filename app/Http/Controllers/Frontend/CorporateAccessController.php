<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorporateAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function corporate_access(Request $request)
    {
        try {
            return view(theme('pages.corporate_access'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
