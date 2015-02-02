<?php

class GuestbookController extends BaseController
{

    public function getAll()
    {
        return json_encode(array(
            'success' => true,
            'tablerows' => View::make('guestbooktable')->with('guests', Guest::where('joined_party', 0)->get())->render()
        ));
    }

    public function createNew()
    {
        $name = Input::get('name');
        $age = Input::get('age');
        $gender = Input::get('gender');
        $email = Input::get('email');
        if (!$name || !$age || !$gender || !$email)
        {
            return json_encode(array(
                'success' => false,
                'message' => 'Please fill in the form completely.'
            ));
        }
        Guest::create([
            'name' => $name,
            'age' => $age,
            'gender' => $gender,
            'email' => $email
        ]);
        return json_encode(array(
            'success' => true
        ));
    }

    public function delete()
    {
        $ids = Input::get('ids', []);
        if (!is_array($ids))
            $ids = [$ids];
        Guest::whereIn('id', $ids)->delete();
        return json_encode(array(
            'success' => true
        ));
    }
}
