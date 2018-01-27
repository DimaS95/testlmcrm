<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\SphereMask;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
       // $this->leads = $leads;
    }

    public function index(Request $request)
    {


        $leads = DB::table('leads')
            ->join('customers', 'leads.customer_id', '=', 'customers.id')
            ->join('open_leads','leads.id', '=', 'lead_id')
            ->where('open_leads.agent_id', '=', $request->user()->id)
            ->select('leads.*', 'customers.phone')
            ->get();
        return view('test.index', ['leads' => $leads]);
    }


}
