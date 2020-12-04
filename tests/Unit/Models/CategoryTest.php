<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;


class CategoryTest extends TestCase
{
    protected $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->category);
    }

    public function test_valid_table_properties()
    {
        $this->assertEquals('categories', $this->category->getTable());
    }

    public function test_valid_primary_key_properties()
    {
        $this->assertEquals('id', $this->category->getKeyName());
    }

    public function test_valid_fillable_properties()
    {
        $this->assertEquals([
            'parent_id',
            'name',
        ], $this->category->getFillable());
    }

    public function test_children_function()
    {
        $children = $this->category->children();
        $this->assertInstanceOf(HasMany::class, $children);
        $this->assertEquals('parent_id', $children->getForeignKeyName());
        $this->assertEquals('id', $children->getLocalKeyName());
    }

    public function test_products_function()
    {
        $products = $this->category->products();
        $this->assertInstanceOf(HasMany::class, $products);
        $this->assertEquals('category_id', $products->getForeignKeyName());
        $this->assertEquals('id', $products->getLocalKeyName());
    }

    public function test_relationship_parent()
    {
        $relation = $this->category->parent();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }
}
