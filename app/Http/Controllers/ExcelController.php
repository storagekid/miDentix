<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    public function export() {
    	// dd(request()->all());
    	\Excel::create(request()->model, function($excel) {
    		$class = "\App\\".request()->model;
    		// $class = "\App\\User";
    		$items = $class::findMany(request()->ids);
    		// $items = \App\Profile::all();
    		// $items = $items->toArray();
    		// dd($items);
    		$excel->sheet(request()->model, function($sheet) use($items) {
    			// Set font with ->setStyle()`
    			$sheet->setStyle(array(
    			    'font' => array(
    			        'name'      =>  'Helvetica',
    			    )
    			));
                $sheet->getStyle('A:AAA')->getAlignment()->setWrapText(true);
    			$sheet->loadView('layouts.excel.profiles')->with('items', $items);
    		});
    	})->store('xlsx',$this->path());
        return response()->download($this->path().'Profile.xlsx')->deleteFileAfterSend(true);
    }
    public function path() {
        return Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix('excel/exports/');
    }
}
