<?php

namespace SystemInc\LaravelAdmin\Tests\Unit;

use SystemInc\LaravelAdmin\Admin;
use SystemInc\LaravelAdmin\BlogCategory;
use SystemInc\LaravelAdmin\BlogPost;
use SystemInc\LaravelAdmin\BlogPostComment;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\GalleryImage;
use SystemInc\LaravelAdmin\Lead;
use SystemInc\LaravelAdmin\LeadMailed;
use SystemInc\LaravelAdmin\LeadSetting;
use SystemInc\LaravelAdmin\Location;
use SystemInc\LaravelAdmin\Map;
use SystemInc\LaravelAdmin\Order;
use SystemInc\LaravelAdmin\OrderItem;
use SystemInc\LaravelAdmin\OrderStatus;
use SystemInc\LaravelAdmin\Page;
use SystemInc\LaravelAdmin\PageElement;
use SystemInc\LaravelAdmin\PageElementType;
use SystemInc\LaravelAdmin\Product;
use SystemInc\LaravelAdmin\ProductCategory;
use SystemInc\LaravelAdmin\ProductComment;
use SystemInc\LaravelAdmin\Setting;
use SystemInc\LaravelAdmin\SimilarProduct;
use SystemInc\LaravelAdmin\Tests\LaravelAdminTestCase;

class ModelsTest extends LaravelAdminTestCase
{
    public function testFillablefieldsAdminModel()
    {
        $admin = new Admin();

        $this->assertArraySubset(['name', 'email', 'password'], $admin->getFillable());
    }

    public function testFillablefieldsBlogCategoryModel()
    {
        $blog_category = new BlogCategory();

        $this->assertArraySubset(['title', 'subtitle', 'thumb', 'excerpt', 'description', 'menu_order', 'slug', 'seo_title', 'seo_description', 'seo_keywords'], $blog_category->getFillable());
    }

    public function testFillablefieldsBlogPostModel()
    {
        $blog_post = new BlogPost();

        $this->assertArraySubset(['blog_category_id', 'slug', 'title', 'thumb', 'content', 'excerpt', 'visible', 'meta_title', 'meta_description', 'meta_keywords'], $blog_post->getFillable());
    }

    public function testFillablefieldsBlogPostCommentModel()
    {
        $blog_post_comment = new BlogPostComment();

        $this->assertArraySubset(['blog_post_id', 'name', 'email', 'content', 'approved'], $blog_post_comment->getFillable());
    }

    public function testFillablefieldsGalleryModel()
    {
        $gallery = new Gallery();

        $this->assertArraySubset(['title', 'key', 'product_id'], $gallery->getFillable());
    }

    public function testFillablefieldsGalleryImageModel()
    {
        $gallery_image = new GalleryImage();

        $this->assertArraySubset(['gallery_id', 'source', 'path_source', 'thumb_source', 'mobile_source', 'order_number'], $gallery_image->getFillable());
    }

    public function testFillablefieldsLeadModel()
    {
        $lead = new Lead();

        $this->assertArraySubset(['data'], $lead->getFillable());
    }

    public function testFillablefieldsLeadMailedModel()
    {
        $lead_mailed = new LeadMailed();

        $this->assertArraySubset(['email', 'subject', 'body'], $lead_mailed->getFillable());
    }

    public function testFillablefieldsLeadSettingModel()
    {
        $lead_setting = new LeadSetting();

        $this->assertArraySubset(['mailer_name', 'thank_you_subject', 'thank_you_body'], $lead_setting->getFillable());
    }

    public function testFillablefieldsLocationModel()
    {
        $location = new Location();

        $this->assertArraySubset(['title', 'url', 'key', 'map_id', 'description', 'address', 'latitude', 'longitude', 'image', 'thumb_image', 'marker_image', 'order_number'], $location->getFillable());
    }

    public function testFillablefieldsMapModel()
    {
        $map = new Map();

        $this->assertArraySubset(['title', 'key', 'description', 'zoom', 'latitude', 'longitude'], $map->getFillable());
    }

    public function testFillablefieldsOrderModel()
    {
        $order = new Order();

        $this->assertArraySubset(['invoice_number', 'order_status_id', 'shipment_price', 'total_price', 'valid_until', 'date_of_purchase', 'currency', 'note', 'billing_name', 'billing_email', 'billing_phone', 'billing_address', 'billing_city', 'billing_country', 'billing_postcode', 'billing_contact_person', 'shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_country', 'shipping_postcode', 'shipping_contact_person', 'parity', 'footnote', 'show_shipping_address', 'shipment_id'], $order->getFillable());
    }

    public function testFillablefieldsOrderItemModel()
    {
        $order_item = new OrderItem();

        $this->assertArraySubset(['order_id', 'product_id', 'quantity', 'discount', 'custom_price'], $order_item->getFillable());
    }

    public function testFillablefieldsOrderStatusModel()
    {
        $order_status = new OrderStatus();

        $this->assertArraySubset(['id', 'title'], $order_status->getFillable());
    }

    public function testFillablefieldsPageModel()
    {
        $page = new Page();

        $this->assertArraySubset(['title', 'elements_prefix', 'slug', 'description', 'keywords', 'parent_id', 'order_number'], $page->getFillable());
    }

    public function testFillablefieldsPageElementModel()
    {
        $page_element = new PageElement();

        $this->assertArraySubset(['key', 'title', 'content', 'page_id', 'page_element_type_id', 'order_number'], $page_element->getFillable());
    }

    public function testFillablefieldsPageElementTypeModel()
    {
        $page_element_type = new PageElementType();

        $this->assertArraySubset(['title'], $page_element_type->getFillable());
    }

    public function testFillablefieldsProductModel()
    {
        $product = new Product();

        $this->assertArraySubset(['product_category_id', 'brand_id', 'title', 'slug', 'excerpt', 'description', 'long_description', 'thumb', 'image', 'video', 'pdf', 'gallery_id', 'price', 'shipment_price', 'menu_order', 'visible', 'featured', 'stock', 'sku', 'seo_title', 'seo_description', 'seo_keywords', 'max_quantity', 'thumb_hover', 'image_hover', 'order_number', 'length', 'width', 'height', 'weight'], $product->getFillable());
    }

    public function testFillablefieldsProductCategoryModel()
    {
        $product_category = new ProductCategory();

        $this->assertArraySubset(['title', 'subtitle', 'thumb', 'thumb_hover', 'image', 'image_hover', 'video', 'excerpt', 'description', 'order_number', 'slug', 'seo_title', 'seo_description', 'seo_keywords'], $product_category->getFillable());
    }

    public function testFillablefieldsProductCommentModel()
    {
        $product_comment = new ProductComment();

        $this->assertArraySubset(['product_id', 'name', 'email', 'message', 'approved'], $product_comment->getFillable());
    }

    public function testFillablefieldsSettingModel()
    {
        $setting = new Setting();

        $this->assertArraySubset(['title', 'source'], $setting->getFillable());
    }

    public function testFillablefieldsSimilarProductModel()
    {
        $similar = new SimilarProduct();

        $this->assertArraySubset(['product_id', 'product_similar_id'], $similar->getFillable());
    }
}
