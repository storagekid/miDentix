<?php

namespace App\Traits;

use App\File as FileClass;
use App\Jobs\AppErrorHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

trait Fileable {

  protected static $columns = array();
  protected $fileObject, $fileType, $fileName, $filePath, $fileExtension, $fileIsPublic, $fileHasThumbnail, $filePermissions, $fileUserId, $fileGroupId, $fileExists;

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

  public static function getFileColumns() {
    $columns = [];
    foreach (self::$columns as $column) if (strpos($column, 'file_id')) $columns[] = $column;
    return $columns;
  }

  public function getFileFields() {
    $fileFields = [];
    $modelFields = property_exists($this, 'quasarFormFields') ? $this->quasarFormFields : [];
    foreach ($modelFields as $name => $field) {
      if (array_key_exists('type', $field)) if ($field['type']['name'] === 'file') $fileFields[$name] = $field;
    }
    return $fileFields;
  }

  public function saveFile ($file, $field, array $options = []) {
    // if ($public) $path = 'public/' . $path;
    // dump($file);
    // dump($path);
    // dump($name);
    // dump($move);
    // dd('Checking');
    $this->getInputFileType($file);
    if ($this->fileType === 'string') {
      $fileExists = \App\File::checkFile($file);
      if (!$fileExists) {
        AppErrorHandler::dispatch('File doesnt exists');
        return false;
      }
    }
    $this->fieldDataBuilder($field);
    $this->fileOptionsBuilder($options);
    
    // if (!$group_id) $group_id = Auth::user()->groups[0]->id;
    // $storeDir = $public && strpos($path, 'public/') === false ? 'public/' . $path : $path;

    // if (!Storage::exists($storeDir)) {
    //     Storage::makeDirectory($storeDir);
    // }
    // if (gettype($file) !== 'string') {
    //   $name = str_replace_last('.', '-' . $timestamp . '.', $name);
    // }
    // if (gettype($file) === 'string') {
    //   $fullPath = $storeDir . '/' . $name . '.' . $extension;;
    //   if (!Storage::exists($fullPath)) {
    //     $name = $name . '.' . $extension;
    //     $move ? Storage::move($file, $storeDir . '/' . $name) : Storage::copy($file, $storeDir . '/' . $name);
    //   } else {
    //     $model = FileClass::where('url', $path . '/' . $name)->first();
    //     if ($model) {
    //       return $model;
    //     }
    //   }
    // } else {
    //   $fullPath = $file->storeAs($storeDir, $name);
    // }
    // $url = $path . '/' . $name;
    // $type = mime_content_type(storage_path('app/' . $fullPath));
    // $extension = pathinfo(storage_path('app/' . $fullPath), PATHINFO_EXTENSION);

    // $model = FileClass::create([
    //   'name' => $name,
    //   'path' => $path,
    //   'url' => $url,
    //   'type' => $type,
    //   'thumbnail' => $thumbnail,
    //   'extension' => $extension,
    //   'permissions' => $permissions,
    //   'is_public' => $public,
    //   'user_id' => $user_id,
    //   'group_id' => $group_id
    // ]);
    // if ($thumbnail) {
    //   $model->storeThumbnail($thumbnail);
    // }
    // return $model;
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
        if (!$extension) {
          $extension = $file->extension();
          // dump($file->path());
          // dump($file->extension());
          // dump($file->clientExtension());
          // abort(301, 'File Has No Extension.');
        }
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
      $fullPath = $storeDir . '/' . $name . '.' . $extension;;
      if (!Storage::exists($fullPath)) {
        // dump($fullPath);
        // dd('Dont Exists');
        $name = $name . '.' . $extension;
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

  public function getInputFileType($file) {
    if (!$file) {
      AppErrorHandler::dispatch('Unprocessable File');
      return false;
    }
    $this->fileType = gettype($file);
    $this->fileObject = $file;
    return $this->fileType;
  }
  public function fieldDataBuilder($field) {
    
  }
  public function fileOptionsBuilder($options) {
    $this->fileName = $this->fileNameBuilder($this->fileObject, array_key_exists('name', $options) ? $options['name'] : null);
    $this->fileExtension = $this->fileExtensionBuilder($this->fileObject, array_key_exists('extension', $options) ? $options['extension'] : null);
    $this->fileHasThumbnail = array_key_exists('thumbnail', $options) ? $options['thumbnail'] : false;
    $this->fileUserId = $this->fileUserIdBuilder(array_key_exists('user_id', $options) ? $options['user_id'] : null);
    $this->fileGroupId = $this->fileGroupIdBuilder(array_key_exists('group_id', $options) ? $options['group_id'] : null);
    return [
        'name' => $this->fileName,
        'extension' => $this->fileExtension,
        'thumbnail' => $this->fileHasThumbnail,
        'user_id' => $this->fileUserId,
        'group_id' => $this->fileGroupId,
        'public' => $this->fileIsPublic,
        'move' => false,
        'permissions' => 740
      ];
  }
  public function fileNameBuilder($file, $name = null) {
    if (!$this->fileType) $this->getInputFileType($file);
    if (!$name) {
      if ($this->fileType === 'string') {
        $name = substr($file, strrpos($file,'/')+1);
      } else {
        $name = $file->getClientOriginalName();
      }
    }
    return $this->fileName;
  }
  public function fileExtensionBuilder($file, $extension) {
    if (!$this->fileName) $this->fileNameBuilder($file);
    if ($this->fileType !== 'string') {
      $this->fileExtension = $file->getClientOriginalExtension();
      if (!$this->fileExtension) {
        $this->fileExtension = $file->extension();
      }
    } else {
      $this->fileExtension = substr($file, strrpos($file,'.')+1);
    }
    return $this->fileExtension;
  }
  public function fileUserIdBuilder($userId) {
    if (!$userId) {
      $user = auth()->user() instanceof \App\User ? auth()->user() : auth()->guard('api')->user();
      if (!$user) AppErrorHandler::dispatch('There no user to assign to file');
    } else return $userId;
  }
  public function fileGroupIdBuilder($groupId) {
    if (!$groupId) {
      $user = auth()->user() instanceof \App\User ? auth()->user() : auth()->guard('api')->user();
      if (!$user) AppErrorHandler::dispatch('There no user to assign to file');
      return $user->groups[0]->id;
    } else return $groupId;
  }

  public function getFileNames($field) {
    abort(301, 'Campo de archivo erróneo');
  }
  public function getFilePaths($field) {
    abort(301, 'Campo de archivo erróneo');
  }
 }