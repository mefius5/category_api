<?php

namespace Tests\Unit;

use App\Category;
use App\Providers\CategoryStored;
use App\User;
use FactoryMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories_by_locale()
    {
        $categoriesFR = factory(Category::class, 15)->create([
            'locale' => 'FR'
        ]);
        $categoriesDE = factory(Category::class, 10)->create([
            'locale' => 'DE'
        ]);
        $categoriesPL = factory(Category::class, 5)->create([
            'locale' => 'PL'
        ]);
        $response = $this->get("api/categories?locale=PL");

        $response->assertOk()
                 ->assertJsonCount(5)
                 ->assertJsonStructure([
                     [
                        'name',
                        'locale'
                     ]
                 ]);

    }

    public function test_cannot_insert_same_category_and_locale()
    {
        $category = factory(Category::class)->create();

        $formData = [
            'name' => $category->name,
            'locale' => $category->locale
        ];

        $response = $this->post("api/categories", $formData);

        $response->assertStatus(422)
                 ->assertJson([
                    'message' => 'This category already exists in database'
                 ]);
    }

    public function test_stored_in_database()
    {
        $formData = [
            'name' => 'Laravel',
            'locale' => 'PL'
        ];

        $user = factory(User::class)->create();

        $response = $this->post("api/categories", $formData);

        $response->dump();

        $response->assertCreated()
                 ->assertJson([
                    'message' => 'Category successfully stored'
                 ]);
        Event::fake();

        $this->assertDatabaseHas('categories', [
            'name' => $formData['name'],
            'locale' => $formData['locale']
        ]);

    }
}
