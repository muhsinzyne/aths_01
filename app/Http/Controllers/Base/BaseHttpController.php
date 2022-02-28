<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseHttpController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->buildPageData();
    }

    public function buildPageData()
    {
        $this->data['logo']             = asset('dist/images/logo.svg');
        $this->data['organization']     = 'ATHS';
        $this->data['app']              = 'Communicator';
        $this->data['app_name']         = config('app.name');
        $this->data['page_title']       = '';
        $this->data['page_description'] = '';
        $this->data['brudcrums']        = [];
        $this->data['uri']              = request()->getUri();
        $this->data['layout']           = 'side-menu';
        $this->data['activeUser']       = Auth::user();
    }
}
