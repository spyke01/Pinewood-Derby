<?php

namespace App\Http\Requests;


class HeatListImport extends \Maatwebsite\Excel\Files\ExcelFile
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	    // Import a user provided file
	    $file = Input::file('report');
	    $filename = $this->doSomethingLikeUpload($file);

	    // Return it's location
	    return $filename;
    }
}
