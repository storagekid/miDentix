<?php

namespace App\Traits;

use App\File as FileClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

trait Fileable {

  protected static $columns = array();

  public static function boot()
  {
    parent::boot();
      $class = static::class;
      self::$columns = Schema::getColumnListing(with(new $class)->getTable());
      // $class = static::class;
      self::deleting(function ($model) {
          // dump('Deleting Parent Class from Fileable');
          $archives = $model->files;
          // dump($archives);
          // dump(count($archives));
          if (count($archives)) {
            foreach ($archives as $file) {
              $file->delete();
            }
          };
      });
  }

  public function __call($method, $arguments) {
    // dd(self::$columns);
    foreach (self::$columns as $column) {
      if (strpos($column, 'file_id')) {
        if (strpos($column, $method) !== false) {
          return $this->belongsTo(FileClass::class, $column);
        }
      }
    }
    return parent::__call($method, $arguments);
  }

  public function files()
  {
      return $this->morphMany(FileClass::class, 'fileable');
  }

  public static function storeFile (
    $file,
    $path,
    $name=null,
    $thumbnail=null,
    $user_id=null,
    $group_id=null,
    $public=false,
    $move=false,
    $permissions=740
    ) {
    // if ($public) $path = 'public/' . $path;
    // dump($file);
    // dump($path);
    // dump($name);
    // dump($move);
    // dd('Checking');
    $timestamp = time();
    if (!$name) {
      if (gettype($file) === 'string') {
        $name = substr($file, strrpos($file,'/')+1);
      } else {
        $name = $file->getClientOriginalName();
      }
    } else {
      if (gettype($file) !== 'string') {
        $extension = $file->getClientOriginalExtension();
        $name = $name . '.' . $extension;
      } else {
        $extension = substr($file, strrpos($file,'.')+1);
        // $name = $name . '.' . $extension;
      }
    }
    
    if (!$user_id) $user_id = Auth::user()->id;
    if (!$group_id) $group_id = Auth::user()->groups[0]->id;
    $storeDir = $public && strpos($path, 'public/') === false ? 'public/' . $path : $path;

    if (!Storage::exists($storeDir)) {
        Storage::makeDirectory($storeDir);
    }
    if (gettype($file) !== 'string') {
      $name = str_replace_last('.', '-' . $timestamp . '.', $name);
    }
    if (gettype($file) === 'string') {
      // $extension = substr($file, strrpos($file,'.')+1);
      // if ($public && strpos($path, 'public') === false) $file = 'public/' . $file;
      // dump($public);
      // dump($file);
      // dump($storeDir);
      // dump($name);
      // dump($extension);
      // dd('Checking');
      $fullPath = $storeDir . '/' . $name;
      if (!Storage::exists($fullPath)) {
        // dump($fullPath);
        // dd('Dont Exists');
        $move ? Storage::move($file, $storeDir . '/' . $name) : Storage::copy($file, $storeDir . '/' . $name);
      } else {
        $model = FileClass::where('url', $path . '/' . $name)->first();
        if ($model) {
          return $model;
        }
      }
      // $fullPath = $storeDir . '/' . $name;
    } else {
      $fullPath = $file->storeAs($storeDir, $name);
    }
    $url = $path . '/' . $name;
    $type = mime_content_type(storage_path('app/' . $fullPath));
    $extension = pathinfo(storage_path('app/' . $fullPath), PATHINFO_EXTENSION);

    // if ($thumbnail) {
    //   $thumbnail = self::storeThumbnail($path, $name, $fullPath, $public);
    // }

    $model = FileClass::create([
      'name' => $name,
      'path' => $path,
      'url' => $url,
      'type' => $type,
      'thumbnail' => $thumbnail,
      'extension' => $extension,
      'permissions' => $permissions,
      'is_public' => $public,
      'user_id' => $user_id,
      'group_id' => $group_id
    ]);
    if ($thumbnail) {
      $model->storeThumbnail($thumbnail);
    }
    // dd($model->getRealPaths());
    // dd($model->toArray());
    return $model;
  }
 }