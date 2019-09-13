<?php
namespace BajakLautMalaka\PmiAdmin\Seeds;

use Illuminate\Database\Seeder;
use BajakLautMalaka\PmiAdmin\Privilege;
use BajakLautMalaka\PmiAdmin\PrivilegeCategory;
use BajakLautMalaka\PmiAdmin\Role;
use BajakLautMalaka\PmiAdmin\RolePrivilege;

class PrivilegeTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        

        $category = [
            [
                "name" => "User Management",
                "privileges" => [
                    [
                        "name" => "Tambah Admin"
                    ],
                    [
                        "name" => "Edit Admin"
                    ],
                    [
                        "name" => "Non/aktif Admin"
                    ],
                    [
                        "name" => "Lihat Donator"
                    ],
                    [
                        "name" => "Lihat Relawan"
                    ],
                    [
                        "name" => "Moderasi Relawan"
                    ],
                ]
            ],
            [
                "name" => "Donasi Management",
                "privileges" => [
                    [
                        "name" => "Tambah Donasi"
                    ],
                    [
                        "name" => "Edit Donasi"
                    ],
                    [
                        "name" => "Buka/Tutup Donasi"
                    ],
                    [
                        "name" => "Visibilitas Donasi"
                    ],
                    [
                        "name" => "Perpanjang Donasi"
                    ],
                    [
                        "name" => "Lihat Bulan Dana"
                    ],
                                        [
                        "name" => "Lihat Donasi Dana"
                    ],
                                        [
                        "name" => "Lihat Donasi Barang"
                    ],
                ]
            ],
            [
                "name" => "Transaksi Management",
                "privileges" => [
                    [
                        "name" => "Transaksi Bulan Dana"
                    ],
                    [
                        "name" => "Transaksi Donasi Dana"
                    ],
                    [
                        "name" => "Transaksi Donasi Barang"
                    ],
                    [
                        "name" => "Lihat Transaksi"
                    ],
                    [
                        "name" => "Edit Transaksi"
                    ]
                ]
            ],
            [
                "name" => "Manual Transaksi",
                "privileges" => [
                     [
                        "name" => "Manual Bulan Dana"
                    ],
                    [
                        "name" => "Manual Donasi Dana"
                    ],
                    [
                        "name" => "Manual Donasi Barang"
                    ]
                ]
            ],
            [
                "name" => "RSVP",
                "privileges" => [
                    [
                        "name" => "Tambah RSVP"
                    ],
                    [
                        "name" => "Lihat RSVP"
                    ],
                    [
                        "name" => "Edit RSVP"
                    ],
                    [
                        "name" => "Buka/Tutup RSVP"
                    ],
                    [
                        "name" => "Moderasi RSVP"
                    ],
                    [
                        "name" => "Arsipkan RSVP"
                    ],
                    [
                        "name" => "Lihat Arsip RSVP"
                    ]
                ]
            ],
            [
                "name" => "Settings Anggota",
                "privileges" => [
                    [
                        "name" => "Tambah Anggota"
                    ],
                    [
                        "name" => "Lihat Anggota"
                    ],
                    [
                        "name" => "Edit Anggota"
                    ],
                    [
                        "name" => "Hapus Anggota"
                    ]
                ]
            ],
            [
                "name" => "Settings Wilayah",
                "privileges" => [
                    [
                        "name" => "Tambah Wilayah"
                    ],
                    [
                        "name" => "Lihat Wilayah"
                    ],
                    [
                        "name" => "Edit Wilayah"
                    ],
                    [
                        "name" => "Hapus Wilayah"
                    ]
                ]
            ],
            [
                "name" => "Settings Unit",
                "privileges" => [
                    [
                        "name" => "Tambah Unit"
                    ],
                    [
                        "name" => "Lihat Unit"
                    ],
                    [
                        "name" => "Edit Unit"
                    ],
                    [
                        "name" => "Hapus Unit"
                    ]
                ]
            ]
        ];
        foreach ($category as $key => $value) {
            $privilegeCategory = PrivilegeCategory::firstOrCreate([ 'name' => $value['name']]);
            
            foreach ($value['privileges'] as $privilege ) {
                
                $privilege['privilege_category_id'] = $privilegeCategory->id;

                $getPrivilege = Privilege::firstOrCreate(
                    ['name' => $privilege['name'] ],
                    $privilege
                );

            }
        }

        $roles = [
            [
                'role' => ['name' => 'Administrator'],
                'category' => [
                    'User Management',
                    'Donasi Management',
                    'Transaksi Management',
                    'Manual Transaksi',
                    'RSVP',
                    'Settings Anggota',
                    'Settings Wilayah',
                    'Settings Unit'
                ]
            ],
            [
                'role' => ['name' => 'Bendahara'],
                'category' => [
                   'Transaksi Management'
                ]
            ],
            [
                'role' => ['name' => 'Operator'],
                'category' => [
                    'RSVP'
                ]
            ]
        ];

        foreach ($roles as $key => $value) {
            $role               = Role::firstOrCreate($value['role']);
            $privilegeCategory  = PrivilegeCategory::whereIn('name',$value['category'])->pluck('id');
            $privileges         = Privilege::whereIn('privilege_category_id',$privilegeCategory)->pluck('id');
            $privileges         = $privileges->toArray();
            foreach ($privileges as $key => $value) {
                RolePrivilege::firstOrCreate([
                    'role_id' => $role->id,
                    'privilege_id' => $value
                ]);
            }
        }
    }
}