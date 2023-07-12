<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash as FacadesHash;
use App\Services\APIRequestService;
use App\Traits\AppConfigTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LeadController extends Controller
{
    private $apiRequestService;

    public function __construct(APIRequestService $apiRequestService)
    {
        $this->apiRequestService = $apiRequestService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $leadUrl = AppConfigTrait::get('LEADS_URL', false);

        $lead_api_response = $this->apiRequestService->api($leadUrl);

        // Get the response body as an array
        $lead_data = $lead_api_response->json();

        // Convert lead_data to a collection
        $lead_data_collection = new Collection($lead_data);

        // Sort the collection based on the request
        $sort = request()->input('sort');
        $direction = request()->input('direction');

        if ($sort && in_array($sort, ['first_name', 'email'])) {
            $lead_data_collection = $lead_data_collection->sortBy($sort, SORT_REGULAR, $direction === 'desc');
        }

        // Define how many items we want to be visible in each page
        $perPage = 5;

        // Get current page form url e.x. &page=1
        $page = LengthAwarePaginator::resolveCurrentPage();

        // Slice the collection to get the items to display in current page
        $currentPageItems = $lead_data_collection->slice($page * $perPage - $perPage, $perPage)->all();

        // Create our paginator and passing it to the view
        $paginatedLeadData = new LengthAwarePaginator($currentPageItems, count($lead_data_collection), $perPage);

        // set url path for generated links
        $paginatedLeadData->setPath(request()->url());

        return view('leads.index', compact('paginatedLeadData'))->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = FacadesHash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $favoritesUrl = AppConfigTrait::get('FAVORITES_URL', false);

        $favorites_api_response = $this->apiRequestService->api($favoritesUrl . $id);

        // Get the response body as an array
        $favorites_data = $favorites_api_response->json();

        // Convert favorites_data to a collection
        $favorites_data_collection = new Collection($favorites_data);
        
        $propertiesUrl = AppConfigTrait::get('LISTINGS_URL', false);

        $properties_api_response = $this->apiRequestService->api($propertiesUrl);

        // Get the response body as an array
        $properties_data = $properties_api_response->json();

        // Extract property IDs from lead_data_collection
        $lead_property_ids = $favorites_data_collection->pluck('property_id')->toArray();

        // Match property IDs with the IDs from the listings API
        $matched_properties = collect($properties_data)->whereIn('id', $lead_property_ids);

        // dd($matched_properties);

        $usersUrl = AppConfigTrait::get('LEADS_URL', false);

        $users_api_response = $this->apiRequestService->api($usersUrl);

        // Get the response body as an array
        $users_data = $users_api_response->json();

        // Extract user IDs from lead_data_collection
        $lead_user_ids = $favorites_data_collection->pluck('user_id')->toArray();

        // Match user IDs with the IDs from the users API
        $matched_users = collect($users_data)->whereIn('id', $lead_user_ids);
        
        return view('leads.show', compact('matched_users', 'matched_properties'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = FacadesHash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);
        FacadesDB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();

        $user->assignRole($request->input('roles'));

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
