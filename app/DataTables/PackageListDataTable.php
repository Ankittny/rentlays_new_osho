<?php
namespace App\DataTables;

use App\Models\PmsSubscriptionIds;
use App\User;
use Auth, DB, Session;
use Yajra\DataTables\Services\DataTable;

class PackageListDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->of($this->query())
            ->editColumn('package_name', function ($item) {
                return ucwords(strtolower($item->package_name));
            })
            ->editColumn('services', function ($item) {
                return $item->services;
            })
            ->make(true);
    }

    public function query()
    {
        $query = PmsSubscriptionIds::join('properties', function ($join) {
            $join->on('pms_subscription_ids.property_id', '=', 'properties.id');
        })
        ->join('pms_recurring_packages', function ($join) {
            $join->on('pms_subscription_ids.package_id', '=', 'pms_recurring_packages.id');
        })
        ->join('users', function ($join) {
            $join->on('properties.host_id', '=', 'users.id');
        })
        ->select([
            'pms_subscription_ids.id as id',
            'pms_subscription_ids.subscription_type as subscription_type',
            'pms_subscription_ids.start_date_time as start_date_time',
            'pms_subscription_ids.created_at',
            'properties.name as property_name',
            'users.first_name as property_name_user',  // Include user's first name
            'pms_recurring_packages.package_name as package_name',
            'pms_recurring_packages.price as price',
            'pms_recurring_packages.pms_recurring_service_ids as pms_recurring_service_ids',
            'pms_recurring_packages.offer_price as offer_price'
        ])
        ->where('pms_subscription_ids.status', '=', '1')->where('user_id', '=', auth()->user()->id);
        // Apply date filtering if necessary
        $from = request()->get('from');  // Assuming 'from' is passed as a query parameter
        $to = request()->get('to');      // Assuming 'to' is passed as a query parameter

        if (!empty($from)) {
            $query->whereDate('pms_subscription_ids.created_at', '>=', $from);
        }
        if (!empty($to)) {
            $query->whereDate('pms_subscription_ids.created_at', '<=', $to);
        }

        // Execute query and process results
        $results = $query->get()->map(function ($package) {
            // Split service IDs
            $serviceIds = explode(',', str_replace(' ', '', $package->pms_recurring_service_ids));
            // Fetch service details
            $services = DB::table('pms_recurring_services')
                ->whereIn('id', $serviceIds)
                ->select('service_id', 'duration_time')
                ->get();
            
            // Fetch service names
            $serviceIdsForName = $services->pluck('service_id');
            $serviceNames = DB::table('pms_service_masters')
                ->whereIn('id', $serviceIdsForName)
                ->pluck('name', 'id');
            
            // Format services into a single line with HTML line breaks
            $formattedServices = $services->map(function ($service) use ($serviceNames) {
                return $serviceNames[$service->service_id] . '-  ' . $service->duration_time;
            });

            // Add formatted services to the package
            $package->services = $formattedServices;

            return $package;
        });

        return $this->applyScopes($results);
    }

    public function html()
    {
        // Check if the authenticated user is an admin
        if (Auth::guard('admin')->user()->username == 'admin') {
            $this->builder()->addColumn([
                'data' => 'property_name_user',
                'name' => 'users.first_name',
                'title' => 'Property Owner'
            ]);
        }
        // Define columns
        $this->builder()
            ->addColumn(['data' => 'package_name', 'name' => 'pms_recurring_packages.package_name', 'title' => 'Package Name'])
            ->addColumn(['data' => 'property_name', 'name' => 'properties.name', 'title' => 'Property Name'])
            ->addColumn(['data' => 'subscription_type', 'name' => 'pms_subscription_ids.subscription_type', 'title' => 'Subscription Type'])
            ->addColumn(['data' => 'services', 'name' => 'services', 'title' => 'Services Name'])
            ->addColumn(['data' => 'price', 'name' => 'pms_recurring_packages.price', 'title' => 'Price'])
            ->addColumn(['data' => 'offer_price', 'name' => 'pms_subscription_ids.offer_price', 'title' => 'Offer Price']);
        
        

        return $this->builder()
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'transactiondatatables_' . time();
    }
}
