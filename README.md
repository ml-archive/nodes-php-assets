#Assets

##Install by adding

#Set up service provider
```php
Nodes\Assets\ServiceProvider::class
```

#Copy the config file

```php
from assets/config to htdocs/config/assetsv2
```

#Pick providers
There is both a upload and url provider
This can be found in general config

```php
config/assetsv2/general
```


#php4 functions

```php
function assets_add($file, $folder = null, UploadSettings $settings = null)
```

```php
function assets_add_uploaded_file(UploadedFile $file, $folder = null, UploadSettings $settings = null)
```

```php
function assets_add_url($url, $folder = null, UploadSettings $settings = null)
```

```php
function assets_add_data_uri($dataUri, $folder = null, UploadSettings $settings = null)
```

```php
function assets_get($path, UrlSettings $settings = null)
```

#Facade

```php
\Assets::
```

```php
public function add($file, $folder = null, UploadSettings $settings = null)
```

```php
public function addFromUploadedFile(UploadedFile $file, $folder = null, UploadSettings $settings = null)
```

```php
public function addFromUrl($url, $folder = null, UploadSettings $settings = null)
```

```php
public function addFromDataUri($dataUri, $folder = null, UploadSettings $settings = null)
```

```php
public function get($path)
```

