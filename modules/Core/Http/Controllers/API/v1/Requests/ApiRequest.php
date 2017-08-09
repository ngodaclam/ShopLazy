<?php
/**
 * Created by PhpStorm.
 * User: NgocNH
 * Date: 9/1/15
 * Time: 10:31 AM
 */

namespace Modules\Core\Http\Controllers\API\v1\Requests;

use Dingo\Api\Exception\ResourceException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * ApiRequest
 *
 * This class allows us to use Illuminate\Foundation\Http\FormRequest for validation
 * inside the api controllers.
 *
 * Api Responses should not redirect!!!
 *
 * So in order to use FormRequest we must override some defaults methods.
 *
 */
abstract class ApiRequest extends FormRequest
{

    protected $auth;


    protected function failedAuthorization()
    {
        throw new AccessDeniedHttpException('Access denied!');
    }


    /**
     * Override the failedValidation method in order to avoid redirection
     *
     * and return a valid api validation error
     *
     * @param Validator $validator
     *
     * @throws ResourceException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ResourceException('Resource validation failed!', $validator->getMessageBag());
    }


    public function authorize()
    {
        return false;
    }


    public function rules()
    {
        return [ ];
    }
}