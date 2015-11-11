Install by adding

Nodes\Assets\ServiceProvider::class

and copy the config files to config/assetsv2

to config/app['providers']

use the php4 functions

function assets_add($file, $folder = null, UploadSettings $settings = null)
function assets_add_uploaded_file(UploadedFile $file, $folder = null, UploadSettings $settings = null)
function assets_add_url($url, $folder = null, UploadSettings $settings = null)
function assets_add_data_uri($dataUri, $folder = null, UploadSettings $settings = null)
function assets_get($path, UrlSettings $settings = null)

Or the the \Assets facade
public function add($file, $folder = null, UploadSettings $settings = null)
public function addFromUploadedFile(UploadedFile $file, $folder = null, UploadSettings $settings = null)
public function addFromUrl($url, $folder = null, UploadSettings $settings = null)
public function addFromDataUri($dataUri, $folder = null, UploadSettings $settings = null)
public function get($path)

Change providers in config\assetsv2\general
