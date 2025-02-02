<?php

namespace Mediconesystems\LivewireDatatables\Tests;

use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\ColumnSet;
use Mediconesystems\LivewireDatatables\Tests\Models\DummyModel;

class ColumnSetTest extends TestCase
{
    /** @test */
    public function it_can_generate_an_array_of_columns_from_a_model()
    {
        $model = factory(DummyModel::class)->create();

        $subject = ColumnSet::build($model);

        $this->assertCount(9, $subject->columns());

        $subject->columns()->each(function ($column) {
            $this->assertIsObject($column, Column::class);
        });
    }

    /**
     * @test
     * @dataProvider fieldDataProvider
     */
    public function it_can_correctly_populate_the_columns_from_the_model($name, $index, $column)
    {
        $model = factory(DummyModel::class)->create();

        $subject = ColumnSet::build($model)->columns();

        $this->assertEquals($name, $subject[$index]->label);
        $this->assertEquals($column, $subject[$index]->name);
        $this->assertNull($subject[$index]->callback);
        $this->assertNull($subject[$index]->filterable);
        $this->assertNull($subject[$index]->scope);
        $this->assertNull($subject[$index]->scopeFilter);
        $this->assertNull($subject[$index]->hidden);
    }

    public function fieldDataProvider()
    {
        return [
            ['Subject', 0, 'subject'],
            ['Category', 1, 'category'],
            ['Body', 2, 'body'],
            ['Flag', 3, 'flag'],
            ['Image', 4, 'image'],
            ['Expires_at', 5, 'expires_at'],
            ['Updated_at', 6, 'updated_at'],
            ['Created_at', 7, 'created_at'],
            ['Id', 8, 'id'],
        ];
    }

    /** @test */
    public function it_can_exclude_columns()
    {
        $model = factory(DummyModel::class)->create();

        $subject = ColumnSet::build($model)
            ->exclude(['id', 'body'])
            ->columns();

        $this->assertCount(7, $subject);

        $this->assertArrayNotHasKey(8, $subject);
        $this->assertArrayNotHasKey(2, $subject);
    }

    /** @test */
    public function it_can_include_columns()
    {
        $model = factory(DummyModel::class)->create();

        $subject = ColumnSet::build($model)
            ->include(['id', 'body'])
            ->columns();

        $this->assertCount(2, $subject);

        $this->assertEquals('id', $subject[0]->name);
        $this->assertEquals('body', $subject[1]->name);
    }

    /** @test */
    public function it_can_rename_columns()
    {
        $model = factory(DummyModel::class)->create();

        $subject = ColumnSet::build($model)
            ->include(['id|ident', 'body|main text'])
            ->columns();

        $this->assertCount(2, $subject);

        $this->assertEquals('id', $subject[0]->name);
        $this->assertEquals('ident', $subject[0]->label);
        $this->assertEquals('body', $subject[1]->name);
        $this->assertEquals('main text', $subject[1]->label);
    }
}
