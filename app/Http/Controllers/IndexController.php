<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Storage;
use App\Translate;

class IndexController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 30000000);
        $this->middleware('auth');
    }

    public function index($id,$word) {
        $tr = new GoogleTranslate('en');
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $tr->setSource('en'); // Translate from English
        $tr->setSource(); // Detect language automatically
        $tr->setTarget('tr'); // Translate to Georgian

        $dd = $tr->getResponse($word);

        $translation = "";
        if( isset($dd[0][0][0]) ) {
            $translation = $dd[0][0][0];
        }
        
        $pronounce = "";
        if( isset($dd[0][1][3]) ) {
            $pronounce = $dd[0][1][3];
        }

        $part_of_speech = "";
        if( isset($dd[1][0][0]) ) {
            $part_of_speech = $dd[1][0][0];
        }
        
        $alt_synonyms = "";
        if( isset($dd[1][0][1]) ) {
            for( $i = 0; $i < count($dd[1][0][1]); $i++ ) {
                $alt_synonyms .= $dd[1][0][1][$i];
                $alt_synonyms .= "|";
            }
            $alt_synonyms = rtrim($alt_synonyms, "|");

            //remove translation
            $alt_synonyms_array = explode("|",$alt_synonyms);
            $alt_synonyms = "";
            for( $i = 0; $i < count($alt_synonyms_array); $i++ ) {
                if($alt_synonyms_array[$i] != $translation) {
                    $alt_synonyms .= $alt_synonyms_array[$i];
                    $alt_synonyms .= "|";
                }
            }
            $alt_synonyms = rtrim($alt_synonyms, "|");
        }

        $synonyms = "";
        if( isset($dd[1][0][2]) ) {
            for( $i = 0; $i < count($dd[1][0][2]); $i++ ) {
                if( isset($dd[1][0][2][$i][1]) ) {
                    for( $j = 0; $j < count($dd[1][0][2][$i][1]); $j++ ) {
                    
                        $synonyms .= $dd[1][0][2][$i][1][$j];
                        $synonyms .= "|";
                    }
                }
            }
            $synonyms = rtrim($synonyms, "|");

            //remove origin word
            $synonyms_array = explode("|",$synonyms);
            $synonyms = "";
            for( $i = 0; $i < count($synonyms_array); $i++ ) {
                if($synonyms_array[$i] != $word) {
                    $synonyms .= $synonyms_array[$i];
                    $synonyms .= "|";
                }
            }
            $synonyms = rtrim($synonyms, "|");
        }

        $result = array(
            $id,
            $word,
            $pronounce,
            $part_of_speech,
            $translation,
            $synonyms,
            $alt_synonyms
        );

        $trs = new Translate;
        $trs->word_id = $result[0];
        $trs->word = $result[1];
        $trs->pronounce = $result[2];
        $trs->part_of_speech = $result[3];
        $trs->translation = $result[4];
        $trs->synonyms = $result[5];
        $trs->alt_synonyms = $result[6];
        $trs->save();
        
        return $result;
    }

    public function get(Request $request) {

        $path = $request->file('csv')->store('public');

        $words = array();

        if (($handle = fopen ( storage_path('app/').$path, 'r' )) !== FALSE) {
            $no = 0;
            while ( ($data = fgetcsv ( $handle, 1000, ',' )) !== FALSE ) {
                if($no != 0) {
                    $words[$no][0] = $data [0];
                    $words[$no][1] = $data [1];
                }
                $no++;
            }
            fclose ( $handle );
        }

        $list =
        [
        "ID","input word","pronounce","part-of-speech","translation","synonyms","alt-synonyms"
        ];

        $file = fopen("output\English_Hungarian.csv","w");
        


        fputcsv($file,$list);

        for( $i = 1; $i <= count($words); $i++ ) {
            $result = self::index($words[$i][0],$words[$i][1]);
            fputcsv($file,$result);
        }

        return view('data')->with('path',$path)->with('count',count($words));
        
    }

    public function test() {
        $tr = new GoogleTranslate('en');
        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $tr->setSource('en'); // Translate from English
        $tr->setSource(); // Detect language automatically
        $tr->setTarget('es'); // Translate to Georgian

        $word = "excited";

        $dd = $tr->getResponse($word);

        dump($dd);

        $translation = $dd[0][0][0];

        $pronounce = $dd[0][1][3];

        $part_of_speech = $dd[1][0][0];

        $alt_synonyms = "";
        for( $i = 0; $i < count($dd[1][0][1]); $i++ ) {
            $alt_synonyms .= $dd[1][0][1][$i];
            $alt_synonyms .= "|";
        }
        $alt_synonyms = rtrim($alt_synonyms, "|");

        //remove translation
        $alt_synonyms_array = explode("|",$alt_synonyms);
        $alt_synonyms = "";
        for( $i = 0; $i < count($alt_synonyms_array); $i++ ) {
            if($alt_synonyms_array[$i] != $translation) {
                $alt_synonyms .= $alt_synonyms_array[$i];
                $alt_synonyms .= "|";
            }
        }
        $alt_synonyms = rtrim($alt_synonyms, "|");


        
        $synonyms = "";
        for( $i = 0; $i < count($dd[1][0][2]); $i++ ) {
            for( $j = 0; $j < count($dd[1][0][2][$i][1]); $j++ ) {
                
                $synonyms .= $dd[1][0][2][$i][1][$j];
                $synonyms .= "|";
            }
        }
        $synonyms = rtrim($synonyms, "|");


        //remove origin word
        $synonyms_array = explode("|",$synonyms);
        $synonyms = "";
        for( $i = 0; $i < count($synonyms_array); $i++ ) {
            if($synonyms_array[$i] != $word) {
                $synonyms .= $synonyms_array[$i];
                $synonyms .= "|";
            }
        }
        $synonyms = rtrim($synonyms, "|");



        $result = array(
            324,
            $word,
            $pronounce,
            $part_of_speech,
            $translation,
            $synonyms,
            $alt_synonyms
        );
        dump($result);
    }
}
