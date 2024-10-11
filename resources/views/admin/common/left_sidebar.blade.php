<aside class="main-sidebar">
	<div class="left_logo_box">
		<a href="/">
			<img src="/public/backend/dist/img/logo.png" alt="" >
		</a>
		
	</div>
    <section class="sidebar">
		<ul class="sidebar-menu">
			<li class="{{ (Route::current()->uri() == 'admin/dashboard') ? 'active' : ''  }}"><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'customers'))
				<li class="{{ (Route::current()->uri() == 'admin/customers') || (Route::current()->uri() == 'admin/add-customer') || (Route::current()->uri() == 'admin/edit-customer/{id}') || (Route::current()->uri() == 'admin/customer/properties/{id}')  || (Route::current()->uri() == 'admin/customer/bookings/{id}') || (Route::current()->uri() == 'admin/customer/payouts/{id}')  || (Route::current()->uri() == 'admin/customer/payment-methods/{id}') || (Route::current()->uri() == 'admin/customer/wallet/{id}')  ? 'active' : '' }}"><a href="{{ url('admin/customers') }}"><i class="fa fa-users"></i><span>Customers</span></a></li>
			@endif
			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'properties'))
				<li class="{{ (Route::current()->uri() == 'admin/properties') || (Route::current()->uri() == 'admin/add-properties') || (Route::current()->uri() == 'admin/listing/{id}/{step}') ? 'active' : ''  }}"><a href="{{ url('admin/properties') }}"><i class="fa fa-home"></i><span>Properties</span></a></li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_bookings'))
				<li class="{{ (Route::current()->uri() == 'admin/bookings') || (Route::current()->uri() == 'admin/bookings/detail/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/bookings') }}"><i class="fa fa-shopping-cart"></i><span>Bookings</span></a></li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'view_payouts'))
				<li class="{{ (Route::current()->uri() == 'admin/payouts') || (Route::current()->uri() == 'admin/payouts/details/{id}') || (Route::current()->uri() == 'admin/payouts/edit/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/payouts') }}"><i class="fa fa-paypal"></i><span>Payouts</span></a></li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_amenities'))
				<li class="{{ (Route::current()->uri() == 'admin/amenities') || (Route::current()->uri() == 'admin/add-amenities') || (Route::current()->uri() == 'admin/edit-amenities/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/amenities') }}"><i class="fa fa-bullseye"></i><span>Amenities</span></a></li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_pages'))
				<li class="{{ (Route::current()->uri() == 'admin/pages') || (Route::current()->uri() == 'admin/add-page') || (Route::current()->uri() == 'admin/edit-page/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/pages') }}"><i class="fa fa-newspaper-o"></i><span>Static Pages</span></a></li>
			@endif

			<!-- @if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'addons'))
				<li class="{{ (Route::current()->uri() == 'admin/addons')  ? 'active' : ''  }}"><a href="{{ url('admin/addons') }}"><i class="fa fa-puzzle-piece"></i><span>Addons</span></a></li>
			@endif -->

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_reviews'))
				<li class="{{ (Route::current()->uri() == 'admin/reviews') || (Route::current()->uri() == 'admin/edit_review/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/reviews') }}"><i class="fa fa-eye"></i><span>Manage Reviews</span></a></li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_testimonial'))
				<li class="{{ (Route::current()->uri() == 'admin/testimonials') || (Route::current()->uri() == 'admin/edit-testimonials/{id}') || (Route::current()->uri() == 'admin/add-testimonials') ? 'active' : ''  }}"><a href="{{ url('admin/testimonials') }}"><i class="fa fa-quote-left"></i><span>Testimonials</span></a></li>
			@endif
			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'package_list'))
				<li class="{{ (Route::current()->uri() == 'admin/package-list') || (Route::current()->uri() == 'admin/package-list') || (Route::current()->uri() == 'admin/package-list') ? 'active' : ''  }}"><a href="{{ url('admin/package-list') }}"><i class="fa fa-list"></i><span>Package List</span></a></li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_admin'))
				<li class="{{ (Route::current()->uri() == 'admin/admin-users') || (Route::current()->uri() == 'admin/add-admin') || (Route::current()->uri() == 'admin/edit-admin/{id}') ? 'active' : ''  }}">
					<a href="{{ url('admin/admin-users') }}">
					<i class="fa fa-user-plus"></i> <span>Users</span>
					</a>
				</li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_messages'))
				<li class="{{ (Route::current()->uri() == 'admin/messages') || (Route::current()->uri() == 'admin/messaging/host/{id}') || (Route::current()->uri() == 'admin/send-message-email/{id}') ? 'active' : ''  }}">
					<a href="{{ url('admin/messages') }}">
						<i class="fa fa-comments" aria-hidden="true"></i> <span>Messages</span>
					</a>
				</li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'view_reports'))
				<li class="treeview {{ (Route::current()->uri() == 'admin/sales-report' || Route::current()->uri() == 'admin/sales-analysis' || Route::current()->uri() == 'admin/overview-stats') ? 'active' : ''  }}">
					<a href="#">
					<i class="fa fa-bar-chart-o"></i> <span>Reports</span><i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
					<li class="{{ (Route::current()->uri() == 'admin/overview-stats') ? 'active' : ''  }}"><a href="{{ url('admin/overview-stats') }}"><span>Overview & Stats</span></a></li>
					<li class="{{ (Route::current()->uri() == 'admin/sales-report') ? 'active' : ''  }}"><a href="{{ url('admin/sales-report') }}"><span>Sales Report</span></a></li>
					<li class="{{ (Route::current()->uri() == 'admin/sales-analysis') ? 'active' : ''  }}"><a href="{{ url('admin/sales-analysis') }}"><span>Sales Analysis</span></a></li>
					</ul>
				</li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'pms_appoint_managers'))
			<li class="{{ (Route::current()->uri() == 'admin/add-appoint-managers') || (Route::current()->uri() == 'admin/edit-appoint-managers/{id}') || (Route::current()->uri() == 'admin/add-appoint-managers') ? 'active' : ''  }}"><a href="{{ url('admin/appoint-managers') }}"><i class="fa fa-quote-left"></i><span>Appoint Managers</span></a></li>
			@endif
			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'pms_master'))
			<li class="treeview {{ (Route::current()->uri() == 'admin/brand-master' || Route::current()->uri() == 'admin/department-master' || Route::current()->uri() == 'admin/recurring-service-master' || Route::current()->uri() == 'admin/recurring-packages-master' || Route::current()->uri() == 'admin/vendor-master' || Route::current()->uri() == 'admin/service-master'  || Route::current()->uri() == 'admin/category-master' || Route::current()->uri() == 'admin/sub-category-master') ? 'active' : ''    }}">
		
				<a href="#">
				  <i class="fa fa-bar-chart-o"></i> <span>Pms Master</span><i class="fa fa-angle-left pull-right"></i>
				</a>

				<ul class="treeview-menu">
				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'brand_view'))

				<li class="{{ (Route::current()->uri() == 'admin/brand-master') ? 'active' : ''  }}"><a href="{{ url('admin/brand-master') }}"><span>Brnad Master</span></a></li>
				@endif
				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'category_view'))
				
				<li class="{{ (Route::current()->uri() == 'admin/category-master') ? 'active' : ''  }}"><a href="{{ url('admin/category-master') }}"><span>Category Master</span></a></li>
				@endif

				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'sub_category_view'))

				<li class="{{ (Route::current()->uri() == 'admin/sub-category-master') ? 'active' : ''  }}"><a href="{{ url('admin/sub-category-master') }}"><span>Sub category Master</span></a></li>
				@endif
				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'department_view'))
				
				<li class="{{ (Route::current()->uri() == 'admin/department-master') ? 'active' : ''  }}"><a href="{{ url('admin/department-master') }}"><span>Department Master</span></a></li>
			
				@endif
				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'service_view'))
				
				<li class="{{ (Route::current()->uri() == 'admin/service-master') ? 'active' : ''  }}"><a href="{{ url('admin/service-master') }}"><span>Service Master</span></a></li>
				
				@endif
				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'recurring_service_view'))
				
				<li class="{{ (Route::current()->uri() == 'admin/recurring-service-master') ? 'active' : ''  }}"><a href="{{ url('admin/recurring-service-master') }}"><span>Recurring Service Master
				</span></a></li>
				@endif
				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'recurring_package_view'))

				<li class="{{ (Route::current()->uri() == 'admin/recurring-packages-master') ? 'active' : ''  }}"><a href="{{ url('admin/recurring-packages-master') }}"><span>Recurring Package Master
				</span></a></li>
				@endif
				@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'vendor_view'))

				<li class="{{ (Route::current()->uri() == 'admin/vendor-master') ? 'active' : ''  }}"><a href="{{ url('admin/vendor-master') }}"><span>Vendor Master
				</span></a></li>
				@endif

				</ul> 
			</li>
			@endif
				
		
			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'service_request'))
			
			<li class="{{ (Route::current()->uri() == 'admin/service_request') || (Route::current()->uri() == 'admin/edit-service-request/{id}') || (Route::current()->uri() == 'admin/add-service-request') ? 'active' : ''  }}"><a href="{{ url('admin/service_request') }}"><i class="fa fa-quote-left"></i><span>Service Request</span></a></li>
			
			@endif
			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'pms_inventory'))
			  <li class="{{ (Route::current()->uri() == 'admin/pms_inventory') || (Route::current()->uri() == 'admin/edit-pms-inventory/{id}') || (Route::current()->uri() == 'admin/add-pms-inventory') ? 'active' : ''  }}"><a href="{{ url('admin/pms_inventory') }}"><i class="fa fa-quote-left"></i><span>Pms Inventory</span></a></li>
			@endif
			@if(Helpers::has_permission(Auth::guard('admin')->user()->id, 'pms_job'))
			<li class="{{ (Route::current()->uri() == 'admin/pms_job') || (Route::current()->uri() == 'admin/edit-pms-job/{id}') || (Route::current()->uri() == 'admin/add-pms-job') ? 'active' : ''  }}"><a href="{{ url('admin/pms_job') }}"><i class="fa fa-quote-left"></i><span>Pms Job</span></a></li>
			@endif

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'manage_email_template'))
				<li class="{{ (Route::current()->uri() == 'admin/email-template/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/email-template/1') }}"><i class="fa fa-envelope"></i><span>Email Templates</span></a></li>
			@endif

			<!-- Email Template Ends -->
		
			
			<li class="{{ (Route::current()->uri() == 'admin/cache-clear') ? 'active' : ''  }}"><a href="{{ url('admin/cache-clear') }}"><i class="fa fa-trash-o"></i><span>Cache Clear</span></a></li>

			@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'general_setting'))
				<li class="{{ (Request::segment(2) == 'settings') ? 'active' : ''  }}"><a href="{{ url('admin/settings') }}"><i class="fa fa-gears"></i><span>Settings</span></a></li>
			@endif
		</ul>
    </section>
	<div class="left_green_shadow"></div>
	<div class="left_blue_shadow"></div>
	<div class="left_red_shadow"></div>

	<div class="spinner-wrap">
        <div class="spinner-item"></div>
        <div class="spinner-item spinner-item--2"></div>
        <div class="spinner-item spinner-item--3"></div>
        <div class="spinner-item spinner-item--4"></div>
    </div>

</aside>
