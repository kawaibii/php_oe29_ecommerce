<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->product);
    }

    public function test_valid_date_properties()
    {
        $this->assertEquals(['deleted_at', 'created_at', 'updated_at'], $this->product->getDates());
    }

    public function test_valid_fillable_properties()
    {
        $this->assertEquals(['name',
            'description',
            'rate',
            'original_price',
            'current_price',
            'category_id',
            'brand_id',
        ], $this->product->getFillable());
    }

    public function test_valid_hidden_properties()
    {
        $this->assertEquals([], $this->product->getHidden());
    }

    public function test_primary_key_name()
    {
        $this->assertEquals('id', $this->product->getKeyName());
    }

    public function test_valid_visible_properties()
    {
        $this->assertEquals([], $this->product->getVisible());
    }

    public function test_table_name()
    {
        $this->assertEquals('products', $this->product->getTable());
    }

    public function test_category_relationships()
    {
        $category = $this->product->category();
        $this->assertInstanceOf(BelongsTo::class, $category);
        $this->assertEquals('category_id', $category->getForeignKeyName());
        $this->assertEquals('id', $category->getOwnerKeyName());
    }

    public function test_brand_relationships()
    {
        $brand = $this->product->brand();
        $this->assertInstanceOf(BelongsTo::class, $brand);
        $this->assertEquals('brand_id', $brand->getForeignKeyName());
        $this->assertEquals('id', $brand->getOwnerKeyName());
    }

    public function test_images_relationships()
    {
        $images = $this->product->images();
        $this->assertInstanceOf(HasMany::class, $images);
        $this->assertEquals('product_id', $images->getForeignKeyName());
        $this->assertEquals('id', $images->getLocalKeyName());
    }

    public function test_comments_relationships()
    {
        $comments = $this->product->comments();
        $this->assertInstanceOf(HasMany::class, $comments);
        $this->assertEquals('product_id', $comments->getForeignKeyName());
        $this->assertEquals('id', $comments->getLocalKeyName());
    }

    public function test_product_detail_relationships()
    {
        $productDetails = $this->product->productDetails();
        $this->assertInstanceOf(HasMany::class, $productDetails);
        $this->assertEquals('product_id', $productDetails->getForeignKeyName());
        $this->assertEquals('id', $productDetails->getLocalKeyName());
    }

    public function test_supplier_relationships()
    {
        $supplier = $this->product->suppliers();
        $this->assertInstanceOf(BelongsToMany::class, $supplier);
        $this->assertEquals('product_id', $supplier->getForeignPivotKeyName());
        $this->assertEquals('supplier_id', $supplier->getRelatedPivotKeyName());
    }
}
