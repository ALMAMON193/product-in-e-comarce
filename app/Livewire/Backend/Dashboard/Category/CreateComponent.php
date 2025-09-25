<?php

namespace App\Livewire\Backend\Dashboard\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateComponent extends Component
{
    public $categories = [
        ['name' => '', 'description' => '', 'is_featured' => false, 'sort_order' => 0],
    ];

    protected $rules = [
        'categories.*.name' => 'required|string|max:255|unique:categories,name',
        'categories.*.description' => 'nullable|string',
        'categories.*.is_featured' => 'boolean',
        'categories.*.sort_order' => 'integer|min:0',
    ];

    public function addCategory()
    {
        $this->categories[] = ['name' => '', 'description' => '', 'is_featured' => false, 'sort_order' => 0];
    }

    public function removeCategory($index)
    {
        if (count($this->categories) > 1) {
            unset($this->categories[$index]);
            $this->categories = array_values($this->categories);
        }
    }

    public function save()
    {
        $this->validate();

        if (empty($this->categories)) {
            $this->addError('categories', 'At least one category is required.');

            return;
        }

        foreach ($this->categories as $categoryData) {
            if (! empty($categoryData['name'])) {
                Category::create([
                    'name' => $categoryData['name'],
                    'slug' => Str::slug($categoryData['name']),
                    'description' => $categoryData['description'],
                    'is_featured' => $categoryData['is_featured'],
                    'sort_order' => $categoryData['sort_order'],
                ]);
            }
        }

        session()->flash('message', 'Categories created successfully!');
        $this->reset('categories');
        $this->categories = [['name' => '', 'description' => '', 'is_featured' => false, 'sort_order' => 0]];
    }

    public function render()
    {
        return view('livewire.backend.dashboard.category.create-component')
            ->layout('backend.app');
    }
}
