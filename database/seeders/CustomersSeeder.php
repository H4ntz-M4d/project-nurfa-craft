<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersSeeder extends Seeder
{
    public function run()
    {
        DB::table('customers')->insert([
            [
                'id_customers' => 1,
                'id_user' => 2,
                'nama' => 'Bakiman Pratama',
                'no_telp' => '+62-0890-838-6379',
                'jkel' => 'pria',
                'slug' => 'customer-1'
            ],
            [
                'id_customers' => 2,
                'id_user' => 3,
                'nama' => 'Harjasa Kuswoyo',
                'no_telp' => '+62 (594) 078-1618',
                'jkel' => 'pria',
                'slug' => 'customer-2'
            ],
            [
                'id_customers' => 3,
                'id_user' => 4,
                'nama' => 'Indah Hasanah',
                'no_telp' => '+62 (255) 341-9283',
                'jkel' => 'wanita',
                'slug' => 'customer-3'
            ],
            [
                'id_customers' => 4,
                'id_user' => 5,
                'nama' => 'Rizki Firmansyah',
                'no_telp' => '+62 (641) 395 3767',
                'jkel' => 'pria',
                'slug' => 'customer-4'
            ],
            [
                'id_customers' => 5,
                'id_user' => 6,
                'nama' => 'Dt. Satya Kusumo S.E.I',
                'no_telp' => '+62 (69) 166-9784',
                'jkel' => 'pria',
                'slug' => 'customer-5'
            ],
            [
                'id_customers' => 6,
                'id_user' => 7,
                'nama' => 'Ade Saptono',
                'no_telp' => '082 814 8932',
                'jkel' => 'pria',
                'slug' => 'customer-6'
            ],
            [
                'id_customers' => 7,
                'id_user' => 8,
                'nama' => 'Puti Chelsea Laksita',
                'no_telp' => '+62 (082) 278 2489',
                'jkel' => 'wanita',
                'slug' => 'customer-7'
            ],
            [
                'id_customers' => 8,
                'id_user' => 9,
                'nama' => 'Lanjar Puspasari',
                'no_telp' => '+62-0930-103-1051',
                'jkel' => 'pria',
                'slug' => 'customer-8'
            ],
            [
                'id_customers' => 9,
                'id_user' => 10,
                'nama' => 'Ir. Nabila Prasasta',
                'no_telp' => '(0631) 165-6670',
                'jkel' => 'wanita',
                'slug' => 'customer-9'
            ],
            [
                'id_customers' => 10,
                'id_user' => 11,
                'nama' => 'drg. Cahyono Anggraini',
                'no_telp' => '+62 (47) 317-8108',
                'jkel' => 'pria',
                'slug' => 'customer-10'
            ],
            [
                'id_customers' => 11,
                'id_user' => 12,
                'nama' => 'Harsaya Saptono',
                'no_telp' => '(0468) 723 4309',
                'jkel' => 'pria',
                'slug' => 'customer-11'
            ],
            [
                'id_customers' => 12,
                'id_user' => 13,
                'nama' => 'Legawa Hidayat',
                'no_telp' => '+62-0619-399-0916',
                'jkel' => 'pria',
                'slug' => 'customer-12'
            ],
            [
                'id_customers' => 13,
                'id_user' => 14,
                'nama' => 'Puti Belinda Nasyiah',
                'no_telp' => '+62-842-513-5427',
                'jkel' => 'wanita',
                'slug' => 'customer-13'
            ],
            [
                'id_customers' => 14,
                'id_user' => 15,
                'nama' => 'Paiman Puspasari',
                'no_telp' => '+62 (44) 935 3487',
                'jkel' => 'pria',
                'slug' => 'customer-14'
            ],
            [
                'id_customers' => 15,
                'id_user' => 16,
                'nama' => 'Eluh Marpaung M.M.',
                'no_telp' => '+62 (033) 456-7890',
                'jkel' => 'pria',
                'slug' => 'customer-15'
            ],
            [
                'id_customers' => 16,
                'id_user' => 17,
                'nama' => 'Dt. Uda Tamba S.Kom',
                'no_telp' => '+62-0158-692-3226',
                'jkel' => 'pria',
                'slug' => 'customer-16'
            ],
            [
                'id_customers' => 17,
                'id_user' => 18,
                'nama' => 'Harjaya Firgantoro',
                'no_telp' => '(0337) 543-3036',
                'jkel' => 'wanita',
                'slug' => 'customer-17'
            ],
            [
                'id_customers' => 18,
                'id_user' => 19,
                'nama' => 'Bambang Rajata',
                'no_telp' => '+62 (94) 019-6556',
                'jkel' => 'pria',
                'slug' => 'customer-18'
            ],
            [
                'id_customers' => 19,
                'id_user' => 20,
                'nama' => 'dr. Salimah Maheswara',
                'no_telp' => '+62 (0846) 564-8236',
                'jkel' => 'wanita',
                'slug' => 'customer-19'
            ],
            [
                'id_customers' => 20,
                'id_user' => 21,
                'nama' => 'Hj. Janet Hastuti',
                'no_telp' => '(0738) 721 4895',
                'jkel' => 'wanita',
                'slug' => 'customer-20'
            ],
            [
                'id_customers' => 21,
                'id_user' => 22,
                'nama' => 'Dipa Kusmawati',
                'no_telp' => '+62 (076) 936 7632',
                'jkel' => 'pria',
                'slug' => 'customer-21'
            ],
            [
                'id_customers' => 22,
                'id_user' => 23,
                'nama' => 'Rama Hariyah',
                'no_telp' => '088 957 9868',
                'jkel' => 'pria',
                'slug' => 'customer-22'
            ],
            [
                'id_customers' => 23,
                'id_user' => 24,
                'nama' => 'Hj. Ika Nurdiyanti M.Kom.',
                'no_telp' => '+62-0471-434-5581',
                'jkel' => 'wanita',
                'slug' => 'customer-23'
            ],
            [
                'id_customers' => 24,
                'id_user' => 25,
                'nama' => 'Julia Namaga',
                'no_telp' => '(0603) 669 0967',
                'jkel' => 'wanita',
                'slug' => 'customer-24'
            ],
            [
                'id_customers' => 25,
                'id_user' => 26,
                'nama' => 'KH. Luhung Prasetya',
                'no_telp' => '(0346) 706-5627',
                'jkel' => 'pria',
                'slug' => 'customer-25'
            ],
            [
                'id_customers' => 26,
                'id_user' => 27,
                'nama' => 'Sakti Hariyah',
                'no_telp' => '+62 (04) 653-7556',
                'jkel' => 'pria',
                'slug' => 'customer-26'
            ],
            [
                'id_customers' => 27,
                'id_user' => 28,
                'nama' => 'Martaka Hidayat',
                'no_telp' => '+62-003-309-2327',
                'jkel' => 'pria',
                'slug' => 'customer-27'
            ],
            [
                'id_customers' => 28,
                'id_user' => 29,
                'nama' => 'Tina Latupono S.E.',
                'no_telp' => '+62 (0190) 496-6319',
                'jkel' => 'wanita',
                'slug' => 'customer-28'
            ],
            [
                'id_customers' => 29,
                'id_user' => 30,
                'nama' => 'drg. Yuni Lestari S.IP',
                'no_telp' => '(057) 262-8498',
                'jkel' => 'wanita',
                'slug' => 'customer-29'
            ],
            [
                'id_customers' => 30,
                'id_user' => 31,
                'nama' => 'Pardi Hariyah',
                'no_telp' => '(050) 752 7354',
                'jkel' => 'pria',
                'slug' => 'customer-30'
            ],
            [
                'id_customers' => 31,
                'id_user' => 32,
                'nama' => 'Widya Budiyanto',
                'no_telp' => '+62 (043) 634 9578',
                'jkel' => 'wanita',
                'slug' => 'customer-31'
            ],
            [
                'id_customers' => 32,
                'id_user' => 33,
                'nama' => 'Banawa Nababan',
                'no_telp' => '+62 (182) 337 4989',
                'jkel' => 'pria',
                'slug' => 'customer-32'
            ],
            [
                'id_customers' => 33,
                'id_user' => 34,
                'nama' => 'Tami Mahendra',
                'no_telp' => '(0109) 477-7520',
                'jkel' => 'wanita',
                'slug' => 'customer-33'
            ],
            [
                'id_customers' => 34,
                'id_user' => 35,
                'nama' => 'Asmadi Maryadi S.E.I',
                'no_telp' => '+62 (0131) 869-9938',
                'jkel' => 'pria',
                'slug' => 'customer-34'
            ],
            [
                'id_customers' => 35,
                'id_user' => 36,
                'nama' => 'Lurhur Januar',
                'no_telp' => '+62-341-232-8120',
                'jkel' => 'wanita',
                'slug' => 'customer-35'
            ],
            [
                'id_customers' => 36,
                'id_user' => 37,
                'nama' => 'Tira Hasanah',
                'no_telp' => '+62 (034) 936 1832',
                'jkel' => 'pria',
                'slug' => 'customer-36'
            ],
            [
                'id_customers' => 37,
                'id_user' => 38,
                'nama' => 'Dr. Jumadi Farida',
                'no_telp' => '+62 (090) 659 4013',
                'jkel' => 'wanita',
                'slug' => 'customer-37'
            ],
            [
                'id_customers' => 38,
                'id_user' => 39,
                'nama' => 'Jarwadi Tampubolon',
                'no_telp' => '(055) 125-6746',
                'jkel' => 'pria',
                'slug' => 'customer-38'
            ],
            [
                'id_customers' => 39,
                'id_user' => 40,
                'nama' => 'Cut Sakura Namaga M.M.',
                'no_telp' => '(003) 859-7703',
                'jkel' => 'wanita',
                'slug' => 'customer-39'
            ],
            [
                'id_customers' => 40,
                'id_user' => 41,
                'nama' => 'R.A. Titin Manullang',
                'no_telp' => '+62 (0808) 613-1712',
                'jkel' => 'wanita',
                'slug' => 'customer-40'
            ],
            [
                'id_customers' => 41,
                'id_user' => 42,
                'nama' => 'Puspa Maulana',
                'no_telp' => '(039) 821 4658',
                'jkel' => 'wanita',
                'slug' => 'customer-41'
            ],
            [
                'id_customers' => 42,
                'id_user' => 43,
                'nama' => 'Juli Puspasari',
                'no_telp' => '0867533963',
                'jkel' => 'wanita',
                'slug' => 'customer-42'
            ],
            [
                'id_customers' => 43,
                'id_user' => 44,
                'nama' => 'Jumari Firgantoro',
                'no_telp' => '+62 (89) 517 1870',
                'jkel' => 'pria',
                'slug' => 'customer-43'
            ],
            [
                'id_customers' => 44,
                'id_user' => 45,
                'nama' => 'Hj. Zamira Nasyidah S.Sos',
                'no_telp' => '+62 (780) 913 4316',
                'jkel' => 'wanita',
                'slug' => 'customer-44'
            ],
            [
                'id_customers' => 45,
                'id_user' => 46,
                'nama' => 'Gamani Hakim',
                'no_telp' => '+62 (0556) 238-6922',
                'jkel' => 'pria',
                'slug' => 'customer-45'
            ],
            [
                'id_customers' => 46,
                'id_user' => 47,
                'nama' => 'Jail Uyainah',
                'no_telp' => '+62 (0740) 748 2175',
                'jkel' => 'pria',
                'slug' => 'customer-46'
            ],
            [
                'id_customers' => 47,
                'id_user' => 48,
                'nama' => 'Harjaya Pertiwi',
                'no_telp' => '+62 (944) 064-0909',
                'jkel' => 'wanita',
                'slug' => 'customer-47'
            ],
            [
                'id_customers' => 48,
                'id_user' => 49,
                'nama' => 'Winda Farida',
                'no_telp' => '+62-095-214-5623',
                'jkel' => 'wanita',
                'slug' => 'customer-48'
            ],
            [
                'id_customers' => 49,
                'id_user' => 50,
                'nama' => 'Jessica Latupono M.M.',
                'no_telp' => '+62 (023) 685 1604',
                'jkel' => 'wanita',
                'slug' => 'customer-49'
            ],
            [
                'id_customers' => 50,
                'id_user' => 51,
                'nama' => 'Daruna Halimah',
                'no_telp' => '0859317461',
                'jkel' => 'pria',
                'slug' => 'customer-50'
            ]
        ]);
    }
}