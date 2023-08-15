<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Services\APIRequestService;
use App\Traits\AppConfigTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    private $apiRequestService;

    public function __construct(APIRequestService $apiRequestService)
    {
        $this->apiRequestService = $apiRequestService;
    }

    public function index(): View
    {
        $response = $this->apiRequestService->fetchListingsWithCurl('LISTINGS_URL');
        $properties = [];

        if ($response['success'] ?? false && isset($response['data']['properties'])) {
            $properties = $response['data']['properties'];
        }

        $currentPage = request()->input('page', 1); // Get the current page or default to 1
        $perPage = 16;

        // Create our paginator and add it to the data array
        $paginatedProperties = new LengthAwarePaginator(
            array_slice($properties, ($currentPage - 1) * $perPage, $perPage),
            count($properties), // Total items
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('listings.index', ['properties' => $paginatedProperties]);
    }
}
