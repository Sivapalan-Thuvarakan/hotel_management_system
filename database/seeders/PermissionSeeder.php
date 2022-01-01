<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('users')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('departments')->delete();

        $input =  [
            // Department==================================================================================
            [ 'name' => 'can-view-department', 'guard_name' => 'web', 'group_name' => "Department"],
            [ 'name' => 'can-edit-department', 'guard_name' => 'web', 'group_name' => "Department"],
            [ 'name' => 'can-add-department', 'guard_name' => 'web', 'group_name' => "Department"],
            [ 'name' => 'can-delete-department', 'guard_name' => 'web', 'group_name' => "Department"],

            // Main-Department==================================================================================
            [ 'name' => 'can-view-main-department', 'guard_name' => 'web', 'group_name' => "Main-Department"],

            // ROLE==================================================================================
            [ 'name' => 'can-view-role', 'guard_name' => 'web', 'group_name' => "Role"],
            [ 'name' => 'can-edit-role', 'guard_name' => 'web', 'group_name' => "Role"],
            [ 'name' => 'can-add-role', 'guard_name' => 'web', 'group_name' => "Role"],
            [ 'name' => 'can-delete-role', 'guard_name' => 'web', 'group_name' => "Role"],

            // User==================================================================================
            [ 'name' => 'can-view-user', 'guard_name' => 'web', 'group_name' => "User"],
            [ 'name' => 'can-edit-user', 'guard_name' => 'web', 'group_name' => "User"],
            [ 'name' => 'can-add-user', 'guard_name' => 'web', 'group_name' => "User"],
            [ 'name' => 'can-delete-user', 'guard_name' => 'web', 'group_name' => "User"],

            // Room Type==================================================================================
            [ 'name' => 'can-view-room_type', 'guard_name' => 'web', 'group_name' => "RoomType"],
            [ 'name' => 'can-edit-room_type', 'guard_name' => 'web', 'group_name' => "RoomType"],
            [ 'name' => 'can-add-room_type', 'guard_name' => 'web', 'group_name' => "RoomType"],
            [ 'name' => 'can-delete-room_type', 'guard_name' => 'web', 'group_name' => "RoomType"],

            // Room==================================================================================
            [ 'name' => 'can-view-room', 'guard_name' => 'web', 'group_name' => "Room"],
            [ 'name' => 'can-edit-room', 'guard_name' => 'web', 'group_name' => "Room"],
            [ 'name' => 'can-add-room', 'guard_name' => 'web', 'group_name' => "Room"],
            [ 'name' => 'can-delete-room', 'guard_name' => 'web', 'group_name' => "Room"],

            // Customer==================================================================================
            [ 'name' => 'can-view-customer', 'guard_name' => 'web', 'group_name' => "customer"],
            [ 'name' => 'can-edit-customer', 'guard_name' => 'web', 'group_name' => "customer"],
            [ 'name' => 'can-add-customer', 'guard_name' => 'web', 'group_name' => "customer"],
            [ 'name' => 'can-delete-customer', 'guard_name' => 'web', 'group_name' => "customer"],

            // Supplier==================================================================================
            [ 'name' => 'can-view-supplier', 'guard_name' => 'web', 'group_name' => "supplier"],
            [ 'name' => 'can-edit-supplier', 'guard_name' => 'web', 'group_name' => "supplier"],
            [ 'name' => 'can-add-supplier', 'guard_name' => 'web', 'group_name' => "supplier"],
            [ 'name' => 'can-delete-supplier', 'guard_name' => 'web', 'group_name' => "supplier"],

            // Stock==================================================================================
            [ 'name' => 'can-view-stock', 'guard_name' => 'web', 'group_name' => "stock"],
            [ 'name' => 'can-edit-stock', 'guard_name' => 'web', 'group_name' => "stock"],
            [ 'name' => 'can-add-stock', 'guard_name' => 'web', 'group_name' => "stock"],
            [ 'name' => 'can-delete-stock', 'guard_name' => 'web', 'group_name' => "stock"],

             // product==================================================================================
             [ 'name' => 'can-view-product', 'guard_name' => 'web', 'group_name' => "product"],
             [ 'name' => 'can-edit-product', 'guard_name' => 'web', 'group_name' => "product"],
             [ 'name' => 'can-add-product', 'guard_name' => 'web', 'group_name' => "product"],
             [ 'name' => 'can-delete-product', 'guard_name' => 'web', 'group_name' => "product"],
         
             // sales==================================================================================
             [ 'name' => 'can-view-sales', 'guard_name' => 'web', 'group_name' => "sales"],
             [ 'name' => 'can-edit-sales', 'guard_name' => 'web', 'group_name' => "sales"],
             [ 'name' => 'can-add-sales', 'guard_name' => 'web', 'group_name' => "sales"],
             [ 'name' => 'can-delete-sales', 'guard_name' => 'web', 'group_name' => "sales"],

            // Reservations==================================================================================
            [ 'name' => 'can-view-reservations', 'guard_name' => 'web', 'group_name' => "reservations"],
            [ 'name' => 'can-edit-reservations', 'guard_name' => 'web', 'group_name' => "reservations"],
            [ 'name' => 'can-add-reservations', 'guard_name' => 'web', 'group_name' => "reservations"],
            [ 'name' => 'can-delete-reservations', 'guard_name' => 'web', 'group_name' => "reservations"],

            // Reports====================================================================================
            [ 'name' => 'can-view-reports', 'guard_name' => 'web', 'group_name' => "reports"],
            [ 'name' => 'can-view-reservation_report', 'guard_name' => 'web', 'group_name' => "reports"],

        ];

        DB::table('permissions')->insert($input);
        DB::table('roles')->insert([
                    ['name'=>'super_admin' , 'guard_name' => 'web'],
                    ['name'=>'admin' , 'guard_name' => 'web'],
        ]);

        $permissions = DB::table('permissions')->get();
        $role_id = DB::table('roles')->where('name' , 'super_admin')->first()->id;

        foreach ($permissions as $key => $permission) {
            DB::table('role_has_permissions')->insert([
                ['role_id'=>$role_id, 'permission_id'=>$permission->id]
            ]);
        }
        DB::table('departments')->insert([
            'name' => "JAFFNA",
            'code' => "D-100001",
            'type' => 'main',
            'contact_no' => "0767219211"
        ]);

        $user = DB::table('users')->insert([
            'name' => "Super Admin",
            'email' => "superAdmin@admin.com",
            'email_verified_at' => now(),
            'password' => bcrypt('superadmin@2021'),
            'department_id' => 1
        ]);

        DB::table('model_has_roles')->insert([
            ['model_id'=>1, 'model_type' => 'App\Models\User', 'role_id'=>$role_id]
        ]);

        $role_permissions = DB::table('role_has_permissions')
                    ->where('role_id' , $role_id)->get();

        foreach ($role_permissions as $key => $permission) {
            DB::table('model_has_permissions')->insert([
                ['model_id'=>$role_id, 'model_type' => 'App\Models\User', 'permission_id'=>$permission->permission_id]
            ]);
        }

        //Thuvarakan
        $customers = DB::table('customers')->insert([
            'first_name' => "Thuvarakan",
            'last_name' => "Sivapalan",
            'phone_no' => "0771964801",
            'email' => "superAdmin@admin.com",
            'national_id' => "991234567V",
            'code' => "C-100001",
        ]);

        $suppliers = DB::table('suppliers')->insert([
            'name' => "redbull",
            'phone_no' => "0771964801",
            'email' => "thuvamit2017@gmail.com",
            'address'=>"Manipay",
            'code' => "S-100001",
        ]);

        $stock = DB::table('stocks')->insert([
            'product_name' => "jack daniel",
            'type' => "liquor",
            'brand' => "JD",
            'purchase_price' => 10000,
            'quantity' => "100",
            'description' => "Alcohol percentage 20%",
            'is_product' => 1,
            'supplier_id'=>1,
            'department_id'=>1,
            'user_id'=>1,
            'code' => "ST-100001",
        ]);

        $products = DB::table('products')->insert([
            'product_name' => "jack daniel",
            'selling_price' => "20000",
            'discount' => "20",
            'stock_id'=>1,
            'department_id'=>1,
            'user_id'=>1,
            'code' => "P-100001",
        ]);

        $room_types = DB::table('room_types')->insert([
            'name' => "luxury",
            'image' => null,
            'rental_price' => 20000.00,
            'reservation_fee_percentage' => 5,
            'description' => "Luxury Room Type"
        ]);

        $rooms = DB::table('rooms')->insert([
            'code' => "R-100001",
            'status' => "open",
            'description' => "Luxury Room",
            'room_type_id' => 1,
        ]);
    }
}
