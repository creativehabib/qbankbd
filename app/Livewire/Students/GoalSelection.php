<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\AcademicClass;
use Illuminate\Support\Facades\Auth;

class GoalSelection extends Component
{
    public $step = 1;
    public $selectedParentId = null;
    public $selectedGoalId = null;

    public function selectParent($id)
    {
        $this->selectedParentId = $id;
        $this->step = 2;
    }

    public function backToParents()
    {
        $this->step = 1;
        $this->selectedParentId = null;
        $this->selectedGoalId = null;
    }

    public function selectGoal($id)
    {
        $this->selectedGoalId = $id;
    }

    public function saveGoal()
    {
        if (!$this->selectedGoalId) return;

        $user = Auth::user();
        $user->current_goal_id = $this->selectedGoalId;
        $user->save();

        session()->flash('success', 'আপনার লক্ষ্য সফলভাবে সেট করা হয়েছে!');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $parents = AcademicClass::whereNull('parent_id')->orderBy('order_sequence')->get();
        
        $children = collect();
        $parentName = '';
        if ($this->selectedParentId) {
            $parent = AcademicClass::find($this->selectedParentId);
            $parentName = $parent ? $parent->name : '';
            $children = AcademicClass::where('parent_id', $this->selectedParentId)->orderBy('order_sequence')->get();
        }

        return view('livewire.students.goal-selection', [
            'parents' => $parents,
            'children' => $children,
            'parentName' => $parentName
        ])->layout('layouts.app', ['title' => 'Select Your Goal']);
    }
}
