<?php

namespace SllizeVoyagerThemes\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    //
    protected $table = 'voyager_themes';
    protected $fillable = ['name', 'folder', 'version'];

    public function options()
    {
        return $this->hasMany('\SllizeVoyagerThemes\Models\ThemeOptions', 'voyager_theme_id');
    }
}
