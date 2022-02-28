<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseHttpController;
use Illuminate\Support\Facades\File;

class PagesController extends BaseHttpController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get view file location from menu config
        $view                     = theme()->getOption('page', 'view');
        $this->data['page_title'] = 'DashBoard';
        $this->data['brudcrums']  = [
            ['title' => trans('app.home'), 'url' => ''],
            ['title' => trans('app.home'), 'url' => ''],
        ];

        // Check if the page view file exist
        if (view()->exists('pages.' . $view)) {
            return view('pages.' . $view, ['data' => $this->data]);
        }

        // Get the default inner page
        return redirect('/');
    }

    /**
     * Temporary function to replace icon duotone
     */
    public function replaceIcons()
    {
        $fileContent = file_get_contents(public_path('icon_replacement.txt'));
        $lines       = explode("\n", $fileContent);

        $patterns     = [];
        $replacements = [];
        foreach ($lines as $line) {
            $el = explode(' - ', $line);
            if (empty($line)) {
                continue;
            }
            $patterns[]     = trim($el[0]);
            $replacements[] = trim($el[1]);
        }

        $files    = File::allFiles(resource_path());
        $filtered = array_filter($files, function ($str) {
            return strpos($str, '.php') !== false;
        });

        foreach ($filtered as $file) {
            $bladeFileContent = file_get_contents($file->getPathname());

            $bladeFileContent = str_replace($patterns, $replacements, $bladeFileContent);

            file_put_contents($file->getPathname(), $bladeFileContent);
        }
    }
}
