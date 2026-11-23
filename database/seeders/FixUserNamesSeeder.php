<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixUserNamesSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            '2204475' => 'Myna Lyca Delfin',
            '2500558' => 'Sanjha Yvet Ebora',
            '2302359' => 'Rhuvielyn Dalawampo',
            '2302234' => 'Precious Angelica Comia',
            '2302520' => 'Merry Ann Bitang',
            '2204421' => 'John Ashley Alday',
            '2302570' => 'Bien John Dimaculangan',
            '2201238' => 'Vin Vernon Perez',
            '2101000' => 'Benigno Antonio III Aquino',
            '2302471' => 'Sheryn Angela Dote',
            '2102562' => 'Jester John Sales',
            '2302731' => 'Rose Aliyah Joy Enova',
            '1700945' => 'Gian Andrei Pita',
            '2302255' => 'Ian Jacob Bitoon',
            '2301252' => 'Lancelott Casa',
            '1700565' => 'John Kerby Delgado',
            '2302543' => 'Jethro Castillo',
            '2101839' => 'Mc Kenley Briones',
            '2301539' => 'John Edgar Emmanuel Perez',
            '1700261' => 'Daffyl Fran',
        ];

        $updated = 0;

        foreach ($map as $studentNumber => $realName) {
            $rows = DB::table('users')
                ->where('name', $studentNumber)
                ->orWhere('email', 'like', $studentNumber . '@%')
                ->update(['name' => $realName]);

            if ($rows > 0) {
                $updated += $rows;
                echo "  ✓ {$studentNumber} → {$realName}\n";
            } else {
                echo "  – {$studentNumber} not found (may already be updated)\n";
            }
        }

        echo "\nDone. Updated {$updated} record(s).\n";
    }
}
