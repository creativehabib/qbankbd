<?php

namespace App\Livewire\Frontend;

use App\Models\Question;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query = '';

    public function search()
    {
        if (trim($this->query) !== '') {
            // $this->redirect('/search?q=' . urlencode($this->query));
        }
    }

    public function render()
    {
        $results = [];
        if (strlen($this->query) > 1) {
            $results = Question::where('title', 'like', '%' . $this->query . '%')
                ->limit(4)
                ->get();
        }

        return view('livewire.frontend.global-search', [
            'results' => $results
        ]);
    }
}
