<?php

namespace App\Livewire\Admin\Institutions;

use App\Models\Institution;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class InstitutionIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $name = '';
    public $slug = '';
    public $description = '';
    public $official_website = '';
    public $established_year = '';
    public $logo = null;
    
    public $editingId = null;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'official_website' => 'nullable|url|max:255',
        'logo' => 'nullable|image|max:1024',
    ];

    public function create()
    {
        $this->reset(['name', 'slug', 'description', 'official_website', 'established_year', 'description', 'official_website', 'logo', 'editingId']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $institution = Institution::findOrFail($id);
        $this->editingId = $institution->id;
        $this->name = $institution->name;
        $this->slug = $institution->slug;
        $this->description = $institution->description;
        $this->official_website = $institution->official_website;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'official_website' => $this->official_website,
            'established_year' => $this->established_year,
        ];

        if ($this->logo) {
            $data['logo_path'] = $this->logo->store('institutions', 'public');
        }

        if ($this->editingId) {
            Institution::findOrFail($this->editingId)->update($data);
        } else {
            Institution::create($data);
        }

        $this->showModal = false;
        $this->reset(['name', 'slug', 'description', 'official_website', 'established_year', 'description', 'official_website', 'logo', 'editingId']);
    }

    public function delete($id)
    {
        Institution::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.institutions.institution-index', [
            'institutions' => Institution::latest()->paginate(10),
        ])->layout('layouts.app', ['title' => 'Institutions']);
    }
}
