<?php

namespace App\View\Components;

use App\Models\Teacher_section;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SubjectsWidget extends Component
{
    public $subjects;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $student = Auth::user()->student;

        $this->subjects = Teacher_section::with(['teacher.user', 'subject'])
            ->where('section_id', $student->section_id)
            ->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.subjects-widget');
    }
}
