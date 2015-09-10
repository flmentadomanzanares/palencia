<?php

use Palencia\Entities\Calendario;
use Faker\Generator;

class CalendarioTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new Calendario();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [


        ];

    }


    public function run()
    {

        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2014-12-29',
            'fecha_final' => '2015-01-04', 'semana_no' => '1'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-01-05',
            'fecha_final' => '2015-01-11', 'semana_no' => '2'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-01-12',
            'fecha_final' => '2015-01-18', 'semana_no' => '3'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-01-19',
            'fecha_final' => '2015-01-25', 'semana_no' => '4'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-01-26',
            'fecha_final' => '2015-02-01', 'semana_no' => '5'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-02-03',
            'fecha_final' => '2015-02-08', 'semana_no' => '6'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-02-09',
            'fecha_final' => '2015-02-15', 'semana_no' => '7'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-02-16',
            'fecha_final' => '2015-02-22', 'semana_no' => '8'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-02-23',
            'fecha_final' => '2015-03-01', 'semana_no' => '9'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-03-02',
            'fecha_final' => '2015-03-08', 'semana_no' => '10'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-03-09',
            'fecha_final' => '2015-03-15', 'semana_no' => '11'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-03-16',
            'fecha_final' => '2015-03-22', 'semana_no' => '12'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-03-23',
            'fecha_final' => '2015-03-29', 'semana_no' => '13'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-03-30',
            'fecha_final' => '2015-04-05', 'semana_no' => '14'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-04-06',
            'fecha_final' => '2015-04-12', 'semana_no' => '15'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-04-13',
            'fecha_final' => '2015-04-19', 'semana_no' => '16'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-04-20',
            'fecha_final' => '2015-04-26', 'semana_no' => '17'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-04-27',
            'fecha_final' => '2015-05-03', 'semana_no' => '18'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-05-04',
            'fecha_final' => '2015-05-10', 'semana_no' => '19'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-05-11',
            'fecha_final' => '2015-05-17', 'semana_no' => '20'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-05-18',
            'fecha_final' => '2015-05-24', 'semana_no' => '21'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-05-25',
            'fecha_final' => '2015-05-31', 'semana_no' => '22'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-06-01',
            'fecha_final' => '2015-06-07', 'semana_no' => '23'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-06-08',
            'fecha_final' => '2015-06-14', 'semana_no' => '24'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-06-15',
            'fecha_final' => '2015-06-21', 'semana_no' => '25'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-06-22',
            'fecha_final' => '2015-06-28', 'semana_no' => '26'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-06-29',
            'fecha_final' => '2015-07-05', 'semana_no' => '27'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-07-06',
            'fecha_final' => '2015-07-12', 'semana_no' => '28'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-07-13',
            'fecha_final' => '2015-07-19', 'semana_no' => '29'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-07-20',
            'fecha_final' => '2015-07-26', 'semana_no' => '30'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-07-27',
            'fecha_final' => '2015-08-02', 'semana_no' => '31'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-08-03',
            'fecha_final' => '2015-08-09', 'semana_no' => '32'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-08-10',
            'fecha_final' => '2015-08-16', 'semana_no' => '33'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-08-17',
            'fecha_final' => '2015-08-23', 'semana_no' => '34'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-08-24',
            'fecha_final' => '2015-08-30', 'semana_no' => '35'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-08-31',
            'fecha_final' => '2015-09-06', 'semana_no' => '36'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-09-07',
            'fecha_final' => '2015-09-13', 'semana_no' => '37'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-09-14',
            'fecha_final' => '2015-09-20', 'semana_no' => '38'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-09-21',
            'fecha_final' => '2015-09-27', 'semana_no' => '39'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-09-28',
            'fecha_final' => '2015-10-04', 'semana_no' => '40'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-10-05',
            'fecha_final' => '2015-10-11', 'semana_no' => '41'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-10-12',
            'fecha_final' => '2015-10-18', 'semana_no' => '42'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-10-19',
            'fecha_final' => '2015-10-25', 'semana_no' => '43'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-10-26',
            'fecha_final' => '2015-11-01', 'semana_no' => '44'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-11-02',
            'fecha_final' => '2015-11-08', 'semana_no' => '45'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-11-09',
            'fecha_final' => '2015-11-15', 'semana_no' => '46'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-11-16',
            'fecha_final' => '2015-11-22', 'semana_no' => '47'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-11-23',
            'fecha_final' => '2015-11-29', 'semana_no' => '48'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-11-30',
            'fecha_final' => '2015-12-06', 'semana_no' => '49'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-12-07',
            'fecha_final' => '2015-12-13', 'semana_no' => '50'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-12-14',
            'fecha_final' => '2015-12-20', 'semana_no' => '51'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-12-21',
            'fecha_final' => '2015-12-27', 'semana_no' => '52'));
        DB::table('calendario')->insert(Array('year' => '2015', 'fecha_inicio' => '2015-12-28',
            'fecha_final' => '2016-01-03', 'semana_no' => '53'));

    }


}