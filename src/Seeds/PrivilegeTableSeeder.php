<?php
namespace BajakLautMalaka\PmiAdmin\Seeds;

use Illuminate\Database\Seeder;
use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\PrivilegeCategory;
use BajakLautMalaka\PmiAdmin\Role;
use BajakLautMalaka\PmiAdmin\RolePrivilege;
use Carbon\Carbon;

class PrivilegeTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $this->definePrivilegesForCategory('User Management', [
            'Tambah Admin',
            'Edit Admin',
            'Edit user',
            'Non/aktif Admin',
            'Lihat Admin',
            'Lihat Donator',
            'Lihat Relawan',
            'Moderasi Relawan'
        ]);

        $this->definePrivilegesForCategory('Donasi Management', [
            'Tambah Donasi',
            'Edit Donasi',
            'Buka/Tutup Donasi',
            'Visibilitas Donasi',
            'Perpanjang Donasi',
            'Lihat Bulan Dana',
            'Lihat Donasi Dana',
            'Lihat Donasi Barang'
        ]);

        $this->definePrivilegesForCategory('Transaksi Management', [
            'Transaksi Bulan Dana',
            'Transaksi Donasi Dana',
            'Transaksi Donasi Barang',
            'Lihat Transaksi',
            'Edit Transaksi'
        ]);

        $this->definePrivilegesForCategory('Manual Transaksi', [
            'Manual Bulan Dana',
            'Manual Donasi Dana',
            'Manual Donasi Barang'
        ]);

        $this->definePrivilegesForCategory('RSVP', [
            'Tambah RSVP',
            'Lihat RSVP',
            'Edit RSVP',
            'Moderasi RSVP',
            'Arsipkan RSVP',
            'Lihat Arsip RSVP'
        ]);

        $this->definePrivilegesForCategory('Settings Anggota', [
            'Tambah Anggota',
            'Lihat Anggota',
            'Edit Anggota',
            'Hapus Anggota'
        ]);

        $this->definePrivilegesForCategory('Settings Wilayah', [
            'Tambah Wilayah',
            'Lihat Wilayah',
            'Edit Wilayah',
            'Hapus Wilayah'
        ]);

        $this->definePrivilegesForCategory('Settings Unit', [
            'Tambah Unit',
            'Lihat Unit',
            'Edit Unit',
            'Hapus Unit'
        ]);

        $this->definePrivilegesForRole('Administrator', [
            'User Management',
            'Donasi Management',
            'Transaksi Management',
            'Manual Transaksi',
            'RSVP',
            'Settings Anggota',
            'Settings Wilayah',
            'Settings Unit'
        ]);

        $this->definePrivilegesForRole('Bendahara', [
            'Transaksi Management'
        ]);

        $this->definePrivilegesForRole('Operator', [
            'RSVP'
        ]);

    }

    private function definePrivilegesForCategory(string $categoryName, array $privileges): void
    {
        $timestamp = $this->getTimestamp();
        $category = $this->createCategory($categoryName);
        
        collect($privileges)->map(function ($privilegeName) use ($category, $timestamp) {
            $data = array_merge(['name'=>$privilegeName,'privilege_category_id'=>$category], $timestamp);
            Privilege::firstOrCreate(
                ['name'=>$privilegeName,'privilege_category_id'=>$category],
                $data
            );
        });
    }

    private function definePrivilegesForRole(string $roleName, array $privileges): void
    {
        $timestamp          = $this->getTimestamp();
        $role_id            = $this->createRole($roleName);
        $privilegeCategory  = PrivilegeCategory::whereIn('name',$privileges)->pluck('id');
        $privileges         = Privilege::whereIn('privilege_category_id',$privilegeCategory)->pluck('id');
        $privileges         = $privileges->toArray();
        foreach ($privileges as $key => $value) {
            RolePrivilege::firstOrCreate([
                'role_id' => $role_id,
                'privilege_id' => $value
            ]);
        }
    }
    
    private function getTimestamp(): array
    {
        return [ 'created_at'=> Carbon::now(), 'updated_at'=> Carbon::now() ];
    }
    
    private function createCategory(string $categoryName): int
    {
        $data = [array_merge(['name'=>$categoryName], $this->getTimestamp())];
        $privilegeCategory = PrivilegeCategory::firstOrCreate(
            ['name'=>$categoryName],
            $data
        );
        return (isset($privilegeCategory->id))? $privilegeCategory->id : NULL;
    }

    private function createRole(string $roleName): int
    {
        $data = array_merge(['name'=>$roleName], $this->getTimestamp());
        $role = Role::firstOrCreate(
            ['name'=>$roleName],
            $data
        );
        return (isset($role->id))? $role->id : NULL;
    }
}