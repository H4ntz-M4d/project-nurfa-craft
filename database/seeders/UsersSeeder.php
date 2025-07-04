<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 2,
                'username' => 'dongorankunthara',
                'email' => 'estiawanjailani@perum.org',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'dongorankunthara-1'
            ],
            [
                'id' => 3,
                'username' => 'adinata26',
                'email' => 'galang35@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'adinata26-2'
            ],
            [
                'id' => 4,
                'username' => 'restu95',
                'email' => 'gunawantina@ud.int',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'restu95-3'
            ],
            [
                'id' => 5,
                'username' => 'wahyuwibowo',
                'email' => 'yessisimbolon@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'wahyuwibowo-4'
            ],
            [
                'id' => 6,
                'username' => 'kartamandala',
                'email' => 'laila69@ud.net',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'kartamandala-5'
            ],
            [
                'id' => 7,
                'username' => 'zulaikadartono',
                'email' => 'darmana46@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'zulaikadartono-6'
            ],
            [
                'id' => 8,
                'username' => 'gaman88',
                'email' => 'aisyah01@ud.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'gaman88-7'
            ],
            [
                'id' => 9,
                'username' => 'iprabowo',
                'email' => 'raditya57@pt.co.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'iprabowo-8'
            ],
            [
                'id' => 10,
                'username' => 'kalimwinarsih',
                'email' => 'ghaliyatimustofa@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'kalimwinarsih-9'
            ],
            [
                'id' => 11,
                'username' => 'halimreksa',
                'email' => 'prayogaharjo@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'halimreksa-10'
            ],
            [
                'id' => 12,
                'username' => 'iswahyudijasmani',
                'email' => 'elaksita@pd.go.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'iswahyudijasmani-11'
            ],
            [
                'id' => 13,
                'username' => 'sihotangbalijan',
                'email' => 'hmardhiyah@pt.gov',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'sihotangbalijan-12'
            ],
            [
                'id' => 14,
                'username' => 'karman35',
                'email' => 'prima24@ud.web.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'karman35-13'
            ],
            [
                'id' => 15,
                'username' => 'padma80',
                'email' => 'mansurkarsana@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'padma80-14'
            ],
            [
                'id' => 16,
                'username' => 'baktiono16',
                'email' => 'adriansyahmulyanto@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'baktiono16-15'
            ],
            [
                'id' => 17,
                'username' => 'lalita82',
                'email' => 'bakdasamosir@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'lalita82-16'
            ],
            [
                'id' => 18,
                'username' => 'nugrohomulya',
                'email' => 'kasusramanullang@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'nugrohomulya-17'
            ],
            [
                'id' => 19,
                'username' => 'kalim14',
                'email' => 'iwastuti@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'kalim14-18'
            ],
            [
                'id' => 20,
                'username' => 'winarnokeisha',
                'email' => 'bakidin60@ud.co.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'winarnokeisha-19'
            ],
            [
                'id' => 21,
                'username' => 'vwastuti',
                'email' => 'rosman80@ud.sch.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'vwastuti-20'
            ],
            [
                'id' => 22,
                'username' => 'prakasavanya',
                'email' => 'hastamaulana@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'prakasavanya-21'
            ],
            [
                'id' => 23,
                'username' => 'kurniawansoleh',
                'email' => 'zulaikhamaryati@pt.my.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'kurniawansoleh-22'
            ],
            [
                'id' => 24,
                'username' => 'vmanullang',
                'email' => 'wrajata@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'vmanullang-23'
            ],
            [
                'id' => 25,
                'username' => 'gadapradipta',
                'email' => 'ikhsanharyanto@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'gadapradipta-24'
            ],
            [
                'id' => 26,
                'username' => 'thamrinlembah',
                'email' => 'vnasyiah@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'thamrinlembah-25'
            ],
            [
                'id' => 27,
                'username' => 'putrinasyidah',
                'email' => 'krahayu@pt.mil.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'putrinasyidah-26'
            ],
            [
                'id' => 28,
                'username' => 'saiful41',
                'email' => 'namagabala@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'saiful41-27'
            ],
            [
                'id' => 29,
                'username' => 'pratiwiibrani',
                'email' => 'okto29@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'pratiwiibrani-28'
            ],
            [
                'id' => 30,
                'username' => 'damusihombing',
                'email' => 'situmorangfarah@ud.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'damusihombing-29'
            ],
            [
                'id' => 31,
                'username' => 'bhastuti',
                'email' => 'joko14@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'bhastuti-30'
            ],
            [
                'id' => 32,
                'username' => 'kurnia94',
                'email' => 'cawisonopermadi@pd.net.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'kurnia94-31'
            ],
            [
                'id' => 33,
                'username' => 'soleh85',
                'email' => 'tsaputra@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'soleh85-32'
            ],
            [
                'id' => 34,
                'username' => 'daliono34',
                'email' => 'gatot40@ud.ponpes.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'daliono34-33'
            ],
            [
                'id' => 35,
                'username' => 'yahya11',
                'email' => 'khidayanto@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'yahya11-34'
            ],
            [
                'id' => 36,
                'username' => 'chartati',
                'email' => 'ksamosir@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'chartati-35'
            ],
            [
                'id' => 37,
                'username' => 'shartati',
                'email' => 'atmaja34@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'shartati-36'
            ],
            [
                'id' => 38,
                'username' => 'edi10',
                'email' => 'mila94@pt.ac.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'edi10-37'
            ],
            [
                'id' => 39,
                'username' => 'wulandarikawaya',
                'email' => 'wagemaryati@ud.net.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'wulandarikawaya-38'
            ],
            [
                'id' => 40,
                'username' => 'hasanahcecep',
                'email' => 'marsudi16@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'hasanahcecep-39'
            ],
            [
                'id' => 41,
                'username' => 'hasna24',
                'email' => 'bmaheswara@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'hasna24-40'
            ],
            [
                'id' => 42,
                'username' => 'gsiregar',
                'email' => 'elaksmiwati@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'gsiregar-41'
            ],
            [
                'id' => 43,
                'username' => 'adhiarja44',
                'email' => 'tugimannasyiah@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'adhiarja44-42'
            ],
            [
                'id' => 44,
                'username' => 'ugunawan',
                'email' => 'qwinarno@hotmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'ugunawan-43'
            ],
            [
                'id' => 45,
                'username' => 'rezayolanda',
                'email' => 'halimahkarta@perum.co.id',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'rezayolanda-44'
            ],
            [
                'id' => 46,
                'username' => 'usadadaliono',
                'email' => 'zulfasalahudin@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'usadadaliono-45'
            ],
            [
                'id' => 47,
                'username' => 'candrakantasuryatmi',
                'email' => 'almirapadmasari@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'candrakantasuryatmi-46'
            ],
            [
                'id' => 48,
                'username' => 'sari64',
                'email' => 'hasta67@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'sari64-47'
            ],
            [
                'id' => 49,
                'username' => 'xsuwarno',
                'email' => 'ismail39@cv.org',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'xsuwarno-48'
            ],
            [
                'id' => 50,
                'username' => 'ghaliyatiutama',
                'email' => 'kamidinlaksmiwati@yahoo.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'ghaliyatiutama-49'
            ],
            [
                'id' => 51,
                'username' => 'hasanahokto',
                'email' => 'xuyainah@gmail.com',
                'password' => 'hashed_password',
                'role' => 'customers',
                'slug' => 'hasanahokto-50'
            ]
        ]);
    }
}
