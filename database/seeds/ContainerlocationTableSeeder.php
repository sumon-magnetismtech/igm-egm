<?php

use Illuminate\Database\Seeder;

class ContainerlocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $containerLoctions = [
        ['code'=>'102DICD',"name"=>	"Dhaka ICD"],
        ['code'=>'301BMCD',"name"=>	"BM Container Depo Ltd."],
        ['code'=>'301CCTC',"name"=>	"Chittagong Container Transportation"],
        ['code'=>'301EALL',"name"=>	"Eastern Logistics Ltd."],
        ['code'=>'301EBIL',"name"=>	"Esack Brothers Industries Limited"],
        ['code'=>'301GLCL',"name"=>	"Golden Containers Limited"],
        ['code'=>'301HSAT',"name"=>	"Haji Saber Ahmed Timber Co. Ltd."],
        ['code'=>'301INCL',"name"=>	"Incontrade Limited"],
        ['code'=>'301IQLE',"name"=>	"Iqbal Enterprise"],
        ['code'=>'301KDSL',"name"=>	"KDS Logistics Ltd."],
        ['code'=>'301KNTL',"name"=>	"K&T Logistics Ltd."],
        ['code'=>'301NMCL',"name"=>	"Nemsan Container Limited"],
        ['code'=>'301OCCL',"name"=>	"Ocean Containers Ltd."],
        ['code'=>'301PLCL',"name"=>	"PortLink Logistics Centre Ltd."],
        ['code'=>'301QNSC',"name"=>	"QNS Container Services Ltd."],
        ['code'=>'301SAPE',"name"=>	"Summit Alliance Port Ltd. (East)"],
        ['code'=>'301SAPL',"name"=>	"Summit Alliance Port Ltd. (West)"],
        ['code'=>'301SHML',"name"=>	"Shafi Motors Ltd."],
        ['code'=>'301SHPM',"name"=> "Shipper's Premises"],
        ['code'=>'301VOLS',"name"=> "Vertex Off-Doc Logistic Services Limited"],
        ['code'=>'752NPNG',"name"=>	"Custom House, Pangaon"],
        ];

        foreach ($containerLoctions as $containerLoction) {
            \App\Containerlocation::create($containerLoction);
        }
    }
}
