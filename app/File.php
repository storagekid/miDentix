<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    public static function boot()
    {
      parent::boot();
        self::deleting(function (File $file) {
            $dirs = $file->getRealDirectories();
            $fileSystem = new Filesystem;
            $files = $file->getDeletingPaths();
            if (count($files)) {
                foreach ($files as $archive) {
                    Storage::delete($archive);
                }
            }
            if (count($dirs['directories'])) {
                foreach ($dirs['directories'] as $dir) {
                    if ($fileSystem->exists($dir)) {
                        $files = $fileSystem->files($dir);
                        $folders = $fileSystem->directories($dir);
                        if (empty($files) && empty($folders)) {
                            $fileSystem->deleteDirectory($dir);
                            $levels = (int) $dirs['levels'];
                            while ($levels > 0) {
                                $levels--;
                                $dir = substr($dir, 0, strrpos($dir, '/'));
                                if ($fileSystem->exists($dir)) {
                                    $files = $fileSystem->files($dir);
                                    $folders = $fileSystem->directories($dir);
                                    if (empty($files) && empty($folders)) $fileSystem->deleteDirectory($dir);
                                    else break;
                                } else break;
                            }
                        }
                    }
                }
            }
        });
    }

    protected $fillable = ['name', 'path', 'url', 'type', 'thumbnail', 'extension', 'permissions', 'is_public', 'user_id', 'group_id', 'fileable_id', 'fileable_type'];
    protected $guarded = [];
    protected $casts = ['is_public' => 'boolean'];
    protected static $permissions = [
        'view' => [
          'Marketing' => ['*'],
        ]
    ];
    // public function setIsPublicAttribute($value)
    // {
    //     $this->attributes['is_public'] = (boolean) $value;
    // }

    public function fileable()
    {
        return $this->morphTo();
    }

    public static function checkFile($file) {
        if (!Storage::exists($file)) {
            return false;
        }
        return true;
    }

    public function getBaseName() {
        return str_replace_last('.' . $this->extension, '', $this->name);
    }
    public function getRealPaths() {
        $url = '';
        if ($this->is_public) {
            $url .= ('app/public/' . $this->url);
        } else {
            $url .= 'app/' . $this->url;
        }
        $thumbnail = '';
        if ($this->is_public) {
            $thumbnail .= ('app/public/' . $this->thumbnail);
        } else {
            $thumbnail .= 'app/public/' . $this->thumbnail;
        }
        $paths = [
          'url' => storage_path($url),
        ];
        if ($this->thumbnail) $paths['thumbnail'] = storage_path($thumbnail);
        return $paths;
    }
    public function getRealDirectories() {
        $url = '';
        $dirs = [
            'directories' => [],
            'levels' => substr_count($this->path, '/')
        ];
        if ($this->is_public) {
            $url .= ('app/public/' . $this->path);
        } else {
            $url .= 'app/' . $this->path;
        }
        $thumbnail = '';
        if ($this->is_public) {
            $thumbnail .= ('app/public/' . $this->path);
        } else {
            $thumbnail .= 'app/public/' . $this->path;
        }
        $dirs['directories']['url'] = storage_path($url);
        if ($this->thumbnail) $dirs['directories']['thumbnail'] = storage_path($thumbnail);
        return $dirs;
    }
    public function getDeletingPaths() {
        $url = $this->is_public ? 'public/' : '';

        $paths = ['url' => $url . $this->url];
        if ($this->thumbnail) $paths['thumbnail'] = 'public/' . $this->thumbnail;

        return $paths;
    }
    public function renameFile($newName, $moveTo=null, $copy=false) {
        if ($moveTo === $this->path && $newName === $this->name) return 'Nothing Change';
        $completeName = strpos($newName, $this->extension) ? $newName : $newName . '.' . $this->extension;
        $path = $this->url;
        if (!$moveTo) $newPath = $this->path . '/' . $completeName;
        else $newPath = $moveTo . '/' . $completeName;
        if ($this->is_public) {
          $path = 'public/' . $path;
          $newPath = 'public/' . $newPath;
        }
        // dd($newPath);
        $copy ? Storage::copy($path, $newPath) : Storage::move($path, $newPath);
        if ($this->thumbnail) {
            $thumbnail = $this->thumbnail;
            if ($this->is_public) {
                $thumbnail = 'public/' . $thumbnail;
            }
            if (!$copy) {
                $newThumbnail = str_replace($this->getBaseName(), $newName, $this->thumbnail);
                $newPath = $newThumbnail;
            } else {
                $newThumbnail = $moveTo . '/' . $newName . '_thumbnail.' . $this->extension;
                $newPath = $newThumbnail;
            }
            if ($this->is_public) $newPath = 'public/' . $newPath;
            $copy ? Storage::copy($thumbnail, $newPath) : Storage::move($thumbnail, $newPath);
            // Storage::move($thumbnail, $newPath);
            $this->thumbnail = $newThumbnail;
            // $this->update([
            //     'thumbnail' => $newThumbnail
            // ]);
        }
        if (!$copy) $url = $this->path . '/' . $completeName;
        else $url = $moveTo . '/' . $completeName;
        if (!$copy) $path = $this->path;
        if ($moveTo) {
            $path = $moveTo;
            $url = $path . '/' . $completeName;
        }
        // else $path = $moveTo;

        $this->name = $completeName;
        $this->url = $url;
        $this->path = $path;

        $this->save();
        // $this->update([
        //   'name' => $completeName,
        //   'url' => $url
        // ]);
    }
    public function storeThumbnail ($thumbnail=true) {
        // Create Thumbnail
        $imagick = new \Imagick();
        // Reads image from PDF
        $path = 'public/' . $this->path;
        $file = $this->url;
        if ($this->is_public) {
            // $path = 'public/' . $path;
            $file = 'public/' . $file;
        };
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        $fileName = storage_path('app/' . $file);
        if ($thumbnail !== 'multi') $fileName .= '[0]';
        $imagick->readImage($fileName);
        if ($thumbnail === 'multi') {
            $imagick->resetIterator();
            $imagick = $imagick->appendImages(false);
        }
        $thumbnailName = $this->getBaseName() . '_thumbnail.jpg';
        $thumbnailPath = $path . '/' . $thumbnailName;
        // Resize Image
        $imagick->resizeImage (400, 400 , \Imagick::FILTER_CATROM , 1, true);
        // Writes an image
        $imagick->writeImage(storage_path('app/' . $thumbnailPath));
        $this->thumbnail = $this->path . '/' . $thumbnailName;
        $this->save();

        return $thumbnailPath;
      }
}
