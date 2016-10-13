<?php

declare(strict_types=1);

/**
 * Class PublicFolderCdnControllerTest
 */
class PublicFolderCdnControllerTest extends Orchestra\Testbench\TestCase
{
    protected function setUp()
    {
        parent::setUp();

        require __DIR__.'/../../../routes/assets.php';
    }

    /**
     * Setup the necessary Service Providers
     *
     * @author Pedro Coutinho <peco@nodesagency.com>
     * @access protected
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            Nodes\Assets\ServiceProvider::class,
            \Nodes\ServiceProvider::class,
        ];
    }

    /**
     * @dataProvider cdn_validInput_dataProvider
     */
    public function testItShould_cdn_validInput()
    {
        $publicFolderCacheMock = $this->createMock(\Nodes\Assets\Support\PublicFolderCache::class);
        $this->app->instance(\Nodes\Assets\Support\PublicFolderCache::class, $publicFolderCacheMock);

        $folder = 'my-folder';
        $file   = 'myfile.jpg';

        $path = $folder.'/'.$file;

        $publicFolderCacheMock->expects($this->once())->method('cache')->with($path, null, null,
            'resize')->willReturn(response("OK", 200));

        $this->call('GET', 'cdn/'.$path);

        $this->assertResponseStatus(200);
    }

    /**
     * @dataProvider cdn_invalidInput_dataProvider
     */
    public function testItShould_cdn_invalidInput($input)
    {
        $folder = 'my-folder';
        $file   = 'myfile.jpg';

        $path = $folder.'/'.$file;

        $this->call('GET', 'cdn/'.$path, $input);

        $this->assertResponseStatus(412);
    }


    public function cdn_validInput_dataProvider()
    {
        return [
            'allData' => [
                [
                    'mode'   => 'resize',
                    'width'  => 250,
                    'height' => 250,
                ],
            ],
            'shorter' => [
                [
                    'mode' => 'resize',
                    'w'    => 250,
                    'h'    => 250,
                ],
            ],
        ];
    }

    public function cdn_invalidInput_dataProvider()
    {
        return [
            'invalidMode'        => [
                [
                    'mode'   => uniqid(),
                    'width'  => 250,
                    'height' => 250,
                ],
            ],
            'invalidWidth'       => [
                [
                    'mode'   => 'resize',
                    'width'  => 0,
                    'height' => 250,
                ],
            ],
            'heightWithoutWidth' => [
                [
                    'mode'   => 'resize',
                    'height' => 250,
                ],
            ],
            'invalidHeight'      => [
                [
                    'mode'   => 'resize',
                    'width'  => 250,
                    'height' => 0,
                ],
            ],
            'widthWithoutHeight' => [
                [
                    'mode'  => 'resize',
                    'width' => 250,
                ],
            ],
        ];
    }
}
