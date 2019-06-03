<?php

declare(strict_types=1);


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
            'width'  => ['nullable', 'integer', 'min:1'],
            'height' => ['nullable', 'integer', 'min:1'],
            'w'      => ['nullable', 'integer', 'min:1'],
            'h'      => ['nullable', 'integer', 'min:1'],
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
    public function all($keys = NULL)
    {
        $data = parent::all();

        $data['folder'] = $this->route('folder');
        $data['file']   = $this->route('file');
        $data['width']  = $this->query('width');
        $data['height'] = $this->query('height');
        $data['w']      = $this->query('w');
        $data['h']      = $this->query('h');

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
