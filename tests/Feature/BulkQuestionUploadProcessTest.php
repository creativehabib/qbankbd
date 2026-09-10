<?php

use App\Livewire\Questions\BulkUpload;
use App\Models\ExamCategory;
use App\Models\Tag;
use Livewire\Livewire;

it('processes raw mcq text into preview questions before submit', function () {
    Livewire::test(BulkUpload::class)
        ->set('rawText', "১. শব্দটির অর্থ কী? (ক) কলসি (খ) চরকি (গ) কুলফি (ঘ) বাড়ি")
        ->call('processQuestions')
        ->assertHasNoErrors()
        ->assertSet('processedQuestions.0.title', 'শব্দটির অর্থ কী?')
        ->assertSet('processedQuestions.0.options.0.option_text', 'কলসি')
        ->assertSet('processedQuestions.0.options.3.option_text', 'বাড়ি')
        ->assertSee('১. শব্দটির অর্থ কী?')
        ->assertSee('(ক) কলসি')
        ->assertSee('(ঘ) বাড়ি');
});

it('renders Flux pillboxes for bulk upload metadata', function () {
    $tag = Tag::query()->create(['name' => 'Algebra']);
    $examCategory = ExamCategory::query()->create(['name' => 'SSC', 'slug' => 'ssc']);

    Livewire::test(BulkUpload::class)
        ->assertSee('Algebra')
        ->assertSee('SSC')
        ->set('tagIds', [(string) $tag->id])
        ->set('exam_category_ids', [(string) $examCategory->id])
        ->assertSet('tagIds', [(string) $tag->id])
        ->assertSet('exam_category_ids', [(string) $examCategory->id]);
});
