<?php

use Illuminate\Database\Seeder;

class DescriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $descriptions = [
            [ 'description'=> "FABRICS READYMADE GARMENTS INDUSTRY"],
            [ 'description'=> "FABRICS READYMADE GARMENTS INDUSTRIES"],
            [ 'description'=> "FABRICS FOR 100 PCT EXPORT ORIENTED READYMADE GARMENTS INDUSTRY"],
            [ 'description'=> "FABRICS FOR 100 PCT EXPORT ORIENTED READYMADE GARMENTS INDUSTRIES"],
            [ 'description'=> "FABRICS FOR 100 PERCENT EXPORT ORIENTED READYMADE GARMENTS INDUSTRY"],
            [ 'description'=> "FABRICS FOR 100 PERCENT EXPORT ORIENTED READYMADE GARMENTS INDUSTRIES"],
            [ 'description'=> "ACCESSORIES READYMADE GARMENTS INDUSTRY"],
            [ 'description'=> "ACCESSORIES READYMADE GARMENTS INDUSTRIES"],
            [ 'description'=> "ACCESSORIES FOR 100 PCT EXPORT ORIENTED READYMADE GARMENTS INDUSTRY"],
            [ 'description'=> "ACCESSORIES FOR 100 PCT EXPORT ORIENTED READYMADE GARMENTS INDUSTRIES"],
            [ 'description'=> "ACCESSORIES FOR 100 PERCENT EXPORT ORIENTED READYMADE GARMENTS INDUSTRY"],
            [ 'description'=> "ACCESSORIES FOR 100 PERCENT EXPORT ORIENTED READYMADE GARMENTS INDUSTRIES"],
            [ 'description'=> "FABRICS AND ACCESSORIES FOR 100 PERCENT EXPORT ORIENTED READYMADE GARMENTS INDUSTRIES"],
            [ 'description'=> "YARN FOR 100 PCT EXPORT ORIENTED SWEATER INDUSTRY"],
            [ 'description'=> "YARN FOR 100 PCT EXPORT ORIENTED SWEATER INDUSTRIES"],
            [ 'description'=> "BRAND NEW CAPITAL MACHINERY FOR 100 PERCENT EXPORT ORIENTED SWEATER INDUSTRY"],
            [ 'description'=> "BICYCLE PARTS AND ACCESSORIES FOR 100 PCT EXPORT ORIENTED BICYCLE INDUSTRY"],
            [ 'description'=> "EXPANDABLE POLYSTYRENE: SB(1.2MM-1.8MM), S(0.9MM-1.3MM), S2(0.7MM-1.0MM)"],
            [ 'description'=> "EXPANDABLE POLYSTYRENE: SBL(1.6MM-2.3MM), SB(1.2MM-1.8MM), S(0.9MM-1.3MM), S2(0.7MM-1.0MM)"],
            [ 'description'=> "EXPANDABLE POLYSTYRENE: S(0.9MM-1.3MM), S2(0.7MM-1.0MM), S3(0.5MM-0.8MM)"],
        ];
        foreach($descriptions as $description){
            \App\Description::create($description);
        }

    }
}




















