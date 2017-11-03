<?php

namespace SystemInc\LaravelAdmin\Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use SLA;
use SystemInc\LaravelAdmin\Blog;
use SystemInc\LaravelAdmin\BlogCategory;
use SystemInc\LaravelAdmin\BlogPost;
use SystemInc\LaravelAdmin\BlogPostComment;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\Order;
use SystemInc\LaravelAdmin\Page;
use SystemInc\LaravelAdmin\Product;
use SystemInc\LaravelAdmin\ProductCategory;
use SystemInc\LaravelAdmin\ProductComment;
use SystemInc\LaravelAdmin\Tests\LaravelAdminTestCase;

class PackageTest extends LaravelAdminTestCase
{
    public function tearDown()
    {
        parent::tearDown();
    }

    public function testDefaultConfig()
    {
        $this->assertArraySubset(['route_prefix' => 'administration', 'google_map_api' => ''], require __DIR__.'/../../src/config/laravel-admin.php');
    }

    public function testFacade()
    {
        $this->assertEquals(SLA_test::getFacadeName(), 'sla');
    }

    public function testSLAFacadeHaveBlogModel()
    {
        $this->assertInstanceOf(Blog::class, SLA::Blog());
    }

    public function testSLAFacadeHaveBlogPostModel()
    {
        $this->assertInstanceOf(BlogPost::class, SLA::Blog()->posts());
    }

    public function testSLAFacadeHaveBlogCategoriesModel()
    {
        $this->assertInstanceOf(BlogCategory::class, SLA::Blog()->categories());
    }

    public function testSLAFacadeHaveBlogPostCommentModel()
    {
        $this->assertInstanceOf(BlogPostComment::class, SLA::Blog()->comments());
    }

    public function testSLAFacadeHaveGalleryModel()
    {
        $this->assertInstanceOf(Gallery::class, SLA::gallery());
    }

    public function testSLAFacadeHaveStoragePath()
    {
        $this->assertEquals('/uploads/test.jpg', SLA::getFile('test.jpg'));
    }

    public function testSLAFacadeHaveLocationsCollection()
    {
        $this->assertInstanceOf(Collection::class, SLA::locations());
    }

    public function testSLAFacadeHaveMapsCollection()
    {
        $this->assertInstanceOf(Collection::class, SLA::maps());
    }

    public function testSLAFacadeHavePageModel()
    {
        $this->assertInstanceOf(Page::class, SLA::page());
    }

    public function testSLAFacadeHaveShopOrderModel()
    {
        $this->assertInstanceOf(Order::class, SLA::shop()->orders());
    }

    public function testSLAFacadeHaveShopProductModel()
    {
        $this->assertInstanceOf(Product::class, SLA::shop()->products());
    }

    public function testSLAFacadeHaveShopProductCommentModel()
    {
        $this->assertInstanceOf(ProductComment::class, SLA::shop()->comments());
    }

    public function testSLAFacadeHaveShopProductCategoryModel()
    {
        $this->assertInstanceOf(ProductCategory::class, SLA::shop()->categories());
    }

    public function testServiceProvider()
    {
        $this->assertTrue($this->app->bound('sla'));
        $this->assertTrue($this->app->bound('command.laravel-admin.instal'));
        $this->assertTrue($this->app->bound('command.laravel-admin.update'));
    }

    public function testServiceProviderExtendGuard()
    {
        $this->assertArraySubset(['provider' => 'system-admins'], $this->app->config['auth']['guards']['system-admin']);
        $this->assertArraySubset(['model' => 'SystemInc\LaravelAdmin\Admin'], $this->app->config['auth']['providers']['system-admins']);
    }
}

class SLA_test extends \SystemInc\LaravelAdmin\Facades\SLA
{
    public static function getFacadeName()
    {
        return parent::getFacadeAccessor();
    }
}
