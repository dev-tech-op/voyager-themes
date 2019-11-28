<?php

if (!class_exists(RowTypeClass)) {
	class RowTypeClass {
				
		public $required;
		public $field;
		public $type;
		public $details;
		public $placeholder;
		
		public function __construct($args) { foreach ($args as $key => $value) { $this->{$key} = $value; } }
		
		// remove getTranslatedAttribute placeholder input text
		public function getTranslatedAttribute($attribute) { return $attribute; }
	};
}

if (!class_exists(DataTypeContentClass)) {
	class DataTypeContentClass {
		
		public $key;
		public $content;
		
		public function __construct($args) { foreach ($args as $key => $value) { $this->{$key} = $value; } }
		
		public function getKey() { return $this->key; }
	}
}

if (!function_exists(theme_field)) {

    function theme_field($type, $key, $title, $content = '', $details = '', $placeholder = '', $required = 0)
    {

        $theme = \SllizeVoyagerThemes\Models\Theme::where('folder', '=', ACTIVE_THEME_FOLDER)->first();

        $option_exists = $theme->options->where('key', '=', $key)->first();

        $id = 0;
		$content = "";
        if (isset($option_exists->value)) {
            $id = $option_exists->id;
			$content = $option_exists->value;
        }
		
		if (version_compare(substr(app('voyager')->getVersion(),1), '1.2.6', '<=')):
			$row = (object)['required' => $required, 'field' => $key, 'type' => $type, 'details' => $details, 'display_name' => $placeholder];
			$dataTypeContent = (object)["id" => $id, $key => $content];
			//$dataTypeContent = (object)[$key => $content];
        else:
			// remove getTranslatedAttribute()
			$row = new RowTypeClass(['required' => $required, 'field' => $key, 'type' => $type, 'details' => $details, 'display_name' => $placeholder]);
			$dataTypeContent = new DataTypeContentClass(['id' => $id, $key => $content]);
		endif;
        
        $label = '<label for="' . $key . '">' . $title . '<span class="how_to">You can reference this value with <code>theme(\'' . $key . '\')</code></span></label>';
        $details = '<input type="hidden" value="' . $details . '" name="' . $key . '_details__theme_field">';
        $type = '<input type="hidden" value="' . $type . '" name="' . $key . '_type__theme_field">';
        return $label . app('voyager')->formField($row, '', $dataTypeContent) . $details . $type . '<hr>';
    }

}

if (!function_exists(theme)) {

    function theme($key, $default = '')
    {
        $theme = \SllizeVoyagerThemes\Models\Theme::where('active', '=', 1)->first();

        if (Cookie::get('voyager_theme')) {
            $theme_cookied = \SllizeVoyagerThemes\Models\Theme::where('folder', '=', Cookie::get('voyager_theme'))->first();
            if (isset($theme_cookied->id)) {
                $theme = $theme_cookied;
            }
        }

        $value = $theme->options->where('key', '=', $key)->first();

        if (isset($value)) {
            return $value->value;
        }

        return $default;
    }

}

if (!function_exists(theme_folder)) {
    function theme_folder($folder_file = '')
    {

        if (defined('VOYAGER_THEME_FOLDER') && VOYAGER_THEME_FOLDER) {
            return 'themes/' . VOYAGER_THEME_FOLDER . $folder_file;
        }

        $theme = \SllizeVoyagerThemes\Models\Theme::where('active', '=', 1)->first();

        if (Cookie::get('voyager_theme')) {
            $theme_cookied = \SllizeVoyagerThemes\Models\Theme::where('folder', '=', Cookie::get('voyager_theme'))->first();
            if (isset($theme_cookied->id)) {
                $theme = $theme_cookied;
            }
        }

        define('VOYAGER_THEME_FOLDER', $theme->folder);
        return 'themes/' . $theme->folder . $folder_file;
    }
}

if (!function_exists(theme_folder_url)) {
    function theme_folder_url($folder_file = '')
    {

        if (defined('VOYAGER_THEME_FOLDER') && VOYAGER_THEME_FOLDER) {
            return url('themes/' . VOYAGER_THEME_FOLDER . $folder_file);
        }

        $theme = \SllizeVoyagerThemes\Models\Theme::where('active', '=', 1)->first();

        if (Cookie::get('voyager_theme')) {
            $theme_cookied = \SllizeVoyagerThemes\Models\Theme::where('folder', '=', Cookie::get('voyager_theme'))->first();
            if (isset($theme_cookied->id)) {
                $theme = $theme_cookied;
            }
        }

        define('VOYAGER_THEME_FOLDER', $theme->folder);
        return url('themes/' . $theme->folder . $folder_file);
    }
}
