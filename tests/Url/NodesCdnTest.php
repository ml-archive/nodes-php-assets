<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nodes\Assets\ServiceProvider;
use Nodes\Assets\Url\Providers\NodesCdn;
use Nodes\Exceptions\Exception;

class NodesCdnTest extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function testData()
    {
        $url = $this->generateNodesCdn()->getUrlFromPath('folder/file.pdf');
        $this->assertTrue((bool) filter_var($url, FILTER_VALIDATE_URL));
        $this->assertTrue(strpos($url, 'data') !== false);
    }

    public function testJpg()
    {
        $url = $this->generateNodesCdn()->getUrlFromPath('folder/file.jpg');
        $this->assertTrue((bool) filter_var($url, FILTER_VALIDATE_URL));
        $this->assertTrue(strpos($url, 'image') !== false);
    }

    public function testWithUndefinedExtension()
    {
        $this->expectException(Exception::class);
        $this->generateNodesCdn()->getUrlFromPath('folder/file');
    }

    public function testInitProviderWithOutCloudFrontUrl()
    {
        $this->expectException(Exception::class);
        new NodesCdn([
            'cloudfrontUrlData' => 'test/',
            'imageExtensionMimeTypes' => [],
        ]);
    }

    public function testInitProviderWithMissingTrailingSlashOnCloudFrontUrl()
    {
        $this->expectException(Exception::class);
        new NodesCdn([
            'cloudfrontUrl'           => 'test',
            'imageExtensionMimeTypes' => [],
        ]);
    }

    public function testInitProviderWithOutImageExtensionMimeTypes()
    {
        $this->expectException(Exception::class);
        new NodesCdn([
            'cloudfrontUrl' => 'test/',
        ]);
    }

    public function testInitProviderWithNoneArrayImageExtensionMimeTypes()
    {
        $this->expectException(Exception::class);
        new NodesCdn([
            'cloudfrontUrl'           => 'test/',
            'cloudfrontUrlData'       => 'test/',
            'imageExtensionMimeTypes' => 'test',
        ]);
    }

    public function testInitProviderNew()
    {
        $nodesCdn = new NodesCdn([
            'cloudfrontUrl'           => 'test/',
            'cloudfrontUrlData'       => 'test/',
            'imageExtensionMimeTypes' => [],
        ]);

        $this->assertInstanceOf(NodesCdn::class, $nodesCdn);
    }

    public function testInitProviderWithoutCloudFrontUrlData()
    {
        $this->expectException(Exception::class);
        new NodesCdn([
            'cloudfrontUrl'           => 'test/',
            'imageExtensionMimeTypes' => [],
        ]);
    }

    private function generateNodesCdn()
    {
        return new NodesCdn([
            'cloudfrontUrl'           => 'test/',
            'cloudfrontUrlData'       => 'test/',
            'imageExtensionMimeTypes' => [
                'jpg'   => 'image/jpeg',
                'jpeg'  => 'image/jpeg',
                'pjpg'  => 'image/pjpeg',
                'pjpeg' => 'image/pjpeg',
                'png'   => 'image/png',
                'gif'   => 'image/gif',
                'svg'   => 'image/svg+xml',
                'svgz'  => 'image/svg+xml',
                'tiff'  => 'image/tiff',
            ],
        ]);
    }
}
