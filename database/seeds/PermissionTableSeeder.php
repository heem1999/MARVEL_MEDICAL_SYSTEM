<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $permissions = [
         'Administration','Branches','Regions','Clinical Units','Clinical Group Comments',
         'Administrator','Users Roles','Manage Users',
         'Services Setup','Samples','Sample Types','Sample Location Request','Monitor Sample Location Requests',
         'Tests','Units of Measure','Manage Tests','Organisms','Antibiotic',
         'Services','Manage Services','Manage Extra Services','Assign Service To Processing Unit',
         'General Setup','Preparation','Questions','Cancel Reasons','Non Clinical Users',
         'Financial','Price Lists','Payers','Contract Classifications',
         'Treasuries','Manage Treasuries','Treasury Requests','Handling Treasury Request','Discount Comments','Currencies',
         'Registration','Patient Registration','Search Registration','Search Payment','Receipt List','Financial Claims','Monthly Claims',
         'Results','Search Results','Results delivery','Resend result by Web/Fax/Mail','Work Lists',
         'Sample Track','Receive Sample','Tools','Reprint sample details','Claims',

         'Add Region','Edit Region','Delete Region',
         'Add branch','Edit branch','Delete branch',
         'Add Sample Type','Edit Sample Type','Delete Sample Type',
         'Add User','Edit User','Delete User',
         'Add Role','Edit Role','Delete Role','Review','Save','Change Processing Unit','Manage Analyzers','Sample Splitting','Reports'
];
//updateOrCreate
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }
    }
}