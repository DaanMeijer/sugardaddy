<?php

namespace App\Http\Controllers;

use App\LogLine;
use App\LogUpload;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use Carbon\Carbon;
use Psy\Input\CodeArgument;

class GraphController extends Controller
{

    public function form(Request $request){
        return view('form');
    }

    public function upload(Request $request)
    {

        /** @var UploadedFile $file */
        $file = $request->file;

        $name = $file->getClientOriginalName();

        $existing = $request->user()->uploads()->whereName($name)->first();

        if($existing){
            return redirect(action('GraphController@upload'))->with('error', 'Dit bestand is al geupload');
        }

        $fileContents = file_get_contents($file->getRealPath());

        $convert = function ($input) {
            return mb_convert_encoding($input, 'UTF-8', 'UTF-16LE');
        };

        $upload = LogUpload::create([
            'user_id' => $request->user()->id,
            'upload' => $convert($fileContents),
            'name' => $name,
        ]);

        return redirect(action('GraphController@graph'));

    }

    public function graph(Request $request){
        $date = $request->get('daterange', date('Y-m-d'));
        $date = CarbonImmutable::parse($date);

        $lines = LogLine::whereIn('log_upload_id', $request->user()->uploads()->pluck('id'))->whereDate('timestamp', $date)->orderBy('timestamp', 'ASC')->get();

        return view("graph", ['date' => $date, 'lines' => $lines]);
    }

}
