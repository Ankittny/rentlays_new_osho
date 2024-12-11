<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        DB::table('permissions')->insert([
              ['id' => '1', 'name' => 'manage_admin', 'display_name' => 'Manage Admin', 'description' => 'Manage Admin Users'],
              ['id' => '2', 'name' => 'customers', 'display_name' => 'View Customers', 'description' => 'View Customer'],
              ['id' => '3', 'name' => 'add_customer', 'display_name' => 'Add Customer', 'description' => 'Add Customer'],
              ['id' => '4', 'name' => 'edit_customer', 'display_name' => 'Edit Customer', 'description' => 'Edit Customer'],
              ['id' => '5', 'name' => 'delete_customer', 'display_name' => 'Delete Customer', 'description' => 'Delete Customer'],
              ['id' => '6', 'name' => 'properties', 'display_name' => 'View Properties', 'description' => 'View Properties'],
              ['id' => '7', 'name' => 'add_properties', 'display_name' => 'Add Properties', 'description' => 'Add Properties'],
              ['id' => '8', 'name' => 'edit_properties', 'display_name' => 'Edit Properties', 'description' => 'Edit Properties'],
              ['id' => '9', 'name' => 'delete_property', 'display_name' => 'Delete Property', 'description' => 'Delete Property'],
              ['id' => '10', 'name' => 'manage_bookings', 'display_name' => 'Manage Bookings', 'description' => 'Manage Bookings'],
              ['id' => '12', 'name' => 'view_payouts', 'display_name' => 'View Payouts', 'description' => 'View Payouts'],
              ['id' => '13', 'name' => 'manage_amenities', 'display_name' => 'Manage Amenities', 'description' => 'Manage Amenities'],
              ['id' => '14', 'name' => 'manage_pages', 'display_name' => 'Manage Pages', 'description' => 'Manage Pages'],
              ['id' => '15', 'name' => 'manage_reviews', 'display_name' => 'Manage Reviews', 'description' => 'Manage Reviews'],
              ['id' => '16', 'name' => 'view_reports', 'display_name' => 'View Reports', 'description' => 'View Reports'],
              ['id' => '17', 'name' => 'general_setting', 'display_name' => 'Settings', 'description' => 'Settings'],
              ['id' => '18', 'name' => 'preference', 'display_name' => 'Preference', 'description' => 'Preference'],
              ['id' => '19', 'name' => 'manage_banners', 'display_name' => 'Manage Banners', 'description' => 'Manage Banners'],
              ['id' => '20', 'name' => 'starting_cities_settings', 'display_name' => 'Starting Cities Settings', 'description' => 'Starting Cities Settings'],
              ['id' => '21', 'name' => 'manage_property_type', 'display_name' => 'Manage Property Type', 'description' => 'Manage Property Type'],
              ['id' => '22', 'name' => 'space_type_setting', 'display_name' => 'Space Type Setting', 'description' => 'Space Type Setting'],
              ['id' => '23', 'name' => 'manage_bed_type', 'display_name' => 'Manage Bed Type', 'description' => 'Manage Bed Type'],
              ['id' => '24', 'name' => 'manage_currency', 'display_name' => 'Manage Currency', 'description' => 'Manage Currency'],
              ['id' => '25', 'name' => 'manage_country', 'display_name' => 'Manage Country', 'description' => 'Manage Country'],
              ['id' => '26', 'name' => 'manage_amenities_type', 'display_name' => 'Manage Amenities Type', 'description' => 'Manage Amenities Type'],
              ['id' => '27', 'name' => 'email_settings', 'display_name' => 'Email Settings', 'description' => 'Email Settings'],
              ['id' => '28', 'name' => 'manage_fees', 'display_name' => 'Manage Fees', 'description' => 'Manage Fees'],
              ['id' => '29', 'name' => 'manage_language', 'display_name' => 'Manage Language', 'description' => 'Manage Language'],
              ['id' => '30', 'name' => 'manage_metas', 'display_name' => 'Manage Metas', 'description' => 'Manage Metas'],
              ['id' => '31', 'name' => 'api_informations', 'display_name' => 'Api Credentials', 'description' => 'Api Credentials'],
              ['id' => '32', 'name' => 'payment_settings', 'display_name' => 'Payment Settings', 'description' => 'Payment Settings'],
              ['id' => '33', 'name' => 'social_links', 'display_name' => 'Social Links', 'description' => 'Social Links'],
              ['id' => '34', 'name' => 'manage_roles', 'display_name' => 'Manage Roles', 'description' => 'Manage Roles'],
              ['id' => '35', 'name' => 'database_backup', 'display_name' => 'Database Backup', 'description' => 'Database Backup'],
              ['id' => '36', 'name' => 'manage_sms', 'display_name' => 'Manage SMS', 'description' => 'Manage SMS'],
              ['id' => '37', 'name' => 'manage_messages', 'display_name' => 'Manage Messages', 'description' => 'Manage Messages'],
              ['id' => '38', 'name' => 'edit_messages', 'display_name' => 'Edit Messages', 'description' => 'Edit Messages'],
              ['id' => '39', 'name' => 'manage_testimonial', 'display_name' => 'Manage Testimonial', 'description' => 'Manage Testimonial'],
              ['id' => '40', 'name' => 'add_testimonial', 'display_name' => 'Add Testimonial', 'description' => 'Add Testimonial'],
              ['id' => '41', 'name' => 'edit_testimonial', 'display_name' => 'Edit Testimonial', 'description' => 'Edit Testimonial'],
              ['id' => '42', 'name' => 'delete_testimonial', 'display_name' => 'Delete Testimonial', 'description' => 'Delete Testimonial'],
              ['id' => '43', 'name' => 'social_logins', 'display_name' => 'Social Logins', 'description' => 'Manage Social Logins'],
              ['id' => '44', 'name' => 'addons', 'display_name' => 'Addons', 'description' => 'Manage Addons'],
              ['id' => '45','name' => 'google_recaptcha', 'display_name' => 'Google Recaptcha', 'description' => 'Manage Google Recaptcha'],
              ['id' => '46','name' => 'warehouse_type_setting', 'display_name' => 'Ware House Type', 'description' => 'Manage Ware House'],
              ['id' => '47','name' => 'floor_type_setting', 'display_name' => 'floor Type', 'description' => 'Manage floor type'],
              ['id' => '48','name' => 'accommodates_setting', 'display_name' => 'Accommodates', 'description' => 'Accommodates Setting'],
              ['id' => '49','name' => 'package_list', 'display_name' => 'Package List', 'description' => 'Package List'],
              ['id' => '50','name' => 'task_list', 'display_name' => 'Task List', 'description' => 'Task List'],
   
              ['id' => '51','name' => 'add_employee', 'display_name' => 'Add Employee', 'description' => 'Add Employee'],
              ['id' => '53','name' => 'pms_new_request', 'display_name' => 'Pms New Request', 'description' => 'Pms New Request'],
              ['id' => '54','name' => 'manage_designation', 'display_name' => 'Manage Designation', 'description' => 'Manage Designation'],
              ['id' => '55','name' => 'pms_appoint_managers', 'display_name' => 'Pms Appoint Manager', 'description' => 'Pms Appoint Manager'],
              ['id' => '56','name' => 'pms_master', 'display_name' => 'Pms Master', 'description' => 'Pms Master'],
              ['id' => '57','name' => 'brand_view', 'display_name' => 'Brand View', 'description' => 'Brand View'],
              ['id' => '58','name' => 'category_view', 'display_name' => 'Category View', 'description' => 'Category View'],
              ['id' => '59','name' => 'sub_category_view', 'display_name' => 'Sub Category View', 'description' => 'Sub Category View'],
              ['id' => '60','name' => 'department_view', 'display_name' => 'Department View', 'description' => 'Department View'],
              ['id' => '61','name' => 'service_view', 'display_name' => 'Service View', 'description' => 'Service View'],
              ['id' => '62','name' => 'recurring_service_view', 'display_name' => 'Recurring Service View', 'description' => 'Recurring Service View'],
              ['id' => '63','name' => 'recurring_package_view', 'display_name' => 'Recurring Package View', 'description' => 'Recurring Package View'],
              ['id' => '64','name' => 'vendor_view', 'display_name' => 'Vendor View', 'description' => 'Vendor View'],
              ['id' => '65','name' => 'service_request', 'display_name' => 'Service Request', 'description' => 'Service Request'],
              ['id' => '66','name' => 'pms_inventory', 'display_name' => 'Pms Inventory', 'description' => 'Pms Inventory'],
              ['id' => '67','name' => 'pms_job', 'display_name' => 'Pms Job', 'description' => 'Pms Job'],
              ['id' => '68','name' => 'manage_email_template', 'display_name' => 'Manage Email Template', 'description' => 'Manage Email Template'],
              ['id' => '69','name' => 'add_department_master', 'display_name' => 'Add Department Master', 'description' => 'Add Department Master'],
              ['id' => '70','name' => 'add_recurring_package_master', 'display_name' => 'Add Recurring Package Master', 'description' => 'Add Recurring Package Master'],
              ['id' => '71','name' => 'edit_recurring_package_master', 'display_name' => 'Edit Recurring Package Master', 'description' => 'Edit Recurring Package Master'],
              ['id' => '72','name' => 'delete_recurring_package_master', 'display_name' => 'Delete Recurring Package Master', 'description' => 'Delete Recurring Package Master'],
              ['id' => '73','name' => 'add_service_master', 'display_name' => 'Add Service Master', 'description' => 'Add Service Master'],
              ['id' => '74','name' => 'edit_service_master', 'display_name' => 'Edit Service Master', 'description' => 'Edit Service Master'],
              ['id' => '75','name' => 'delete_service_master', 'display_name' => 'Delete Service Master', 'description' => 'Delete Service Master'],
              ['id' => '76','name' => 'edit_department_master', 'display_name' => 'Edit Department Master', 'description' => 'Edit Department Master'],
              ['id' => '77','name' => 'add_recurring_service_master', 'display_name' => 'Add Recurring Service Master', 'description' => 'Add Recurring Service Master'],
              ['id' => '78','name' => 'edit_recurring_service_master', 'display_name' => 'Edit Recurring Service Master', 'description' => 'Edit Recurring Service Master'],
              ['id' => '79','name' => 'delete_recurring_service_master', 'display_name' => 'Delete Recurring Service Master', 'description' => 'Delete Recurring Service Master'],
              ['id' => '81','name' => 'add_task_list', 'display_name' => 'Add Task List', 'description' => 'Add Task List'],
              ['id' => '82','name' => 'edit_task_list', 'display_name' => 'Edit Task List', 'description' => 'Edit Task List'],
              ['id' => '83','name' => 'delete_task_list', 'display_name' => 'Delete Task List', 'description' => 'Delete Task List'],
        ]);
    }
}
