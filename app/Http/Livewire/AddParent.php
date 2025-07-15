<?php

namespace App\Http\Livewire;

use App\Models\ParentProfile;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddParent extends Component
{
     use WithFileUploads;

    public $successMessage = '';
    public $catchError, $updateMode = false, $photos, $show_table = true, $Parent_id;
    public $email, $Password,
        $Name_Father, $Name_Father_en,
        $Phone_Father, $Job_Father, $Job_Father_en,
        $Address_Father;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'email' => 'required|email',
            'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
    }

    public function render()
    {
        return view('livewire.add-parent', [
            'my_parents' => ParentProfile::all(),
        ]);
    }

    public function showformadd()
    {
        $this->show_table = false;
    }

    public function firstStepSubmit()
    {
        $this->validate([
            'email' => 'required|unique:my__parents,email,',
            'Password' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Address_Father' => 'required',
        ]);

        $this->submitForm();
    }

    public function submitForm()
    {

        try {
            $My_Parent = new ParentProfile();
            $My_Parent->email = $this->email;
            $My_Parent->password = Hash::make($this->Password);
            $My_Parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
            $My_Parent->Phone_Father = $this->Phone_Father;
            $My_Parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $My_Parent->Address_Father = $this->Address_Father;
            $My_Parent->save();

            $this->successMessage = trans('messages.success');
            $this->clearForm();
        } catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        }
    }

    public function edit($id)
    {
        $this->show_table = false;
        $this->updateMode = true;
        $My_Parent = ParentProfile::findOrFail($id);
        $this->Parent_id = $id;
        $this->email = $My_Parent->email;
        $this->Password = '';
        $this->Name_Father = $My_Parent->getTranslation('Name_Father', 'ar');
        $this->Name_Father_en = $My_Parent->getTranslation('Name_Father', 'en');
        $this->Job_Father = $My_Parent->getTranslation('Job_Father', 'ar');
        $this->Job_Father_en = $My_Parent->getTranslation('Job_Father', 'en');
        $this->Phone_Father = $My_Parent->Phone_Father;
        $this->Address_Father = $My_Parent->Address_Father;
    }

    public function submitForm_edit()
    {
        $this->validate([
            'email' => 'required|email|unique:my__parents,email,' . $this->Parent_id,
            'Name_Father' => 'required',
            'Phone_Father' => 'required',
            'Job_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father_en' => 'required',
            'Address_Father' => 'required',
        ]);
        try {

            $parent = ParentProfile::findOrFail($this->Parent_id);
            $parent->email = $this->email;
            // Only hash and update password if it's not empty
            if (!empty($this->Password)) {
                $parent->password = Hash::make($this->Password);
            }
            $parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
            $parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $parent->Phone_Father = $this->Phone_Father;
            $parent->Address_Father = $this->Address_Father;
            $parent->save();

            $this->successMessage = trans('messages.success');
            return redirect()->to('/add_parent');
        } catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        }
    }


    public function delete($id)
    {
        ParentProfile::findOrFail($id)->delete();
        return redirect()->to('/add_parent');
    }

    public function clearForm()
    {
        $this->email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Name_Father_en = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Phone_Father = '';
        $this->Address_Father = '';
    }
}
