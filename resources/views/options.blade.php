@extends('voyager::master')


@section('content')

    <div id="theme_options">

        <div class="container-fluid">

            <h1 class="page-title">
                <i class="voyager-params"></i> {{ $theme->name }} Theme Options
                <small>Options and settings for the {{ $theme->name }} theme.</small>
            </h1>

            <div class="panel">
                <div class="panel-body">

                    @if(file_exists(config('themes.themes_folder', resource_path('views/themes')) . '/' . $theme->folder . '/options.blade.php'))
                        <?php if (!defined('ACTIVE_THEME_FOLDER')) {
                            define("ACTIVE_THEME_FOLDER", $theme->folder);
                        } ?>
                        <form action="{{ route('voyager.theme.options', $theme->folder) }}" method="POST"
                              enctype="multipart/form-data">

                            @include('themes_folder::' . $theme->folder . '.options')
                            {{ csrf_field() }}
                            <button class="btn btn-success">Save Theme Settings</button>
                        </form>
                    @else
                        <p>No options file for {{ $theme->name }} theme.</p>
                    @endif

                </div>
            </div>

        </div>

    </div>

@endsection

@section('javascript')
    <script>
        $(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
@endsection
