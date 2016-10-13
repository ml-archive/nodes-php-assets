<?php

declare (strict_types = 1);


namespace Nodes\Assets\Http\Requests;

use Nodes\Http\Requests\FormRequest;

/**
 * Class CdnRequest
 *
 * @package Nodes\Assets\Http\Requests
 */
class CdnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mode'   => ['in:resize,crop'],
            'width'  => ['required_with:height', 'integer', 'min:1'],
            'height' => ['required_with:width', 'integer', 'min:1'],
            'w'      => ['required_with:h', 'integer', 'min:1'],
            'h'      => ['required_with:w', 'integer', 'min:1'],
            'folder' => ['string'],
            'file'   => ['string'],
        ];
    }

    /**
     * Adds route params to be validated
     *
     * @author Pedro Coutinho <peco@nodesagency.com>
     * @access public
     * @return array
     */
    public function all()
    {
        $data = parent::all();

        $data['folder'] = $this->route('folder');
        $data['file']   = $this->route('file');

        return $data;
    }

    /**
     * This is a special case where we want to force a JSON response
     * where we can say the request was invalid.
     *
     * @author Pedro Coutinho <peco@nodesagency.com>
     * @access public
     *
     * @param array $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return response()->json(['errors' => $errors], 412);
    }


}