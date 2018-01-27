<?php
use Illuminate\Http\Request;

Route::group(['prefix' => 'admin'], function() {
    Route::get('sphere/data', 'Admin\SphereController@data');
    Route::get('agent/data', 'Admin\AgentController@data');
    Route::get('user/data', 'Admin\UserController@data');
});
//
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'web','localeSessionRedirect','localizationRedirect', 'localize']], function() {
    include('routes/front.routes.php');
    include('routes/agent.routes.php');
    include('routes/operator.routes.php');

    include('routes/admin.routes.php');
});

Route::get('test', 'TestController@index');

// данные для одного lead
Route::get('/lead/{id?}',function($id, Request $request){
    //получаем нужный sphere_id
    $prelead = DB::table('leads')
        ->where('leads.id', '=', $id)
        ->join('customers', 'leads.customer_id', '=', 'customers.id')
        ->join('open_leads','leads.id', '=', 'lead_id')
        ->join('sphere_attributes','leads.sphere_id', '=', 'sphere_attributes.sphere_id')
        ->select('leads.*', 'customers.phone', 'sphere_attributes.label')
        ->get();

    $sphere_id = $prelead[0]->sphere_id;

    //формируем таблицу и вставляем значения(запускаем только 1 раз)
    //AID
 /*   $aid = DB::table('sphere_attributes')->join('leads','sphere_attributes.sphere_id', '=', 'leads.sphere_id')->value('sphere_attributes.id');
    //OID
    $oid = DB::table('sphere_attribute_options')->join('sphere_attributes','sphere_attribute_options.id', '=','sphere_attributes.id' )->value('sphere_attribute_options.id');
    $spheremask = new SphereMask($sphere_id);
    $spheremask->addAttr($aid,$oid);
    DB::table('sphere_bitmask_'.$sphere_id)->insert(
        ['user_id' => $request->user()->id,'type' => 'lead','fb_'.$aid.'_'.$oid => 1]
    );
 */


    // формируем запрос конечного результата
    $lead = DB::table('leads')
        ->where('leads.id', '=', $id)
        ->join('customers', 'leads.customer_id', '=', 'customers.id')
        ->join('open_leads','leads.id', '=', 'lead_id')
        ->join('sphere_attributes','leads.sphere_id', '=', 'sphere_attributes.sphere_id')
        ->join('sphere_attribute_options','sphere_attributes.id', '=','sphere_attribute_options.sphere_attr_id')
        ->join('sphere_bitmask_'.$sphere_id,'leads.id', '=','sphere_bitmask_'.$sphere_id.'.user_id')
        ->where('sphere_bitmask_'.$sphere_id.'.type', '=', 'lead')
        ->where('open_leads.agent_id', '=',  $request->user()->id)
        ->where('sphere_attribute_options.ctype', '=','agent')
        ->select('leads.*', 'customers.phone', 'sphere_attributes.label', 'sphere_attribute_options.value')
        ->get();


    return !empty($lead) ? Response::json($lead) : null;
});



