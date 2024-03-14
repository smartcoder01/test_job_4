<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="UserRequest",
 *      description="User request schema",
 *      type="object",
 *      required={"email", "name", "age", "sex", "birthday"},
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          format="email",
 *          example="test@example.com"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="John Doe"
 *      ),
 *      @OA\Property(
 *          property="age",
 *          type="integer",
 *          example=30
 *      ),
 *      @OA\Property(
 *          property="sex",
 *          type="string",
 *          enum={"male", "female"},
 *          example="male"
 *      ),
 *      @OA\Property(
 *          property="birthday",
 *          type="string",
 *          format="date",
 *          example="1990-01-01"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string",
 *          example="+1234567890"
 *      )
 * )
 */
class UserRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'sex' => 'required|in:male,female',
            'birthday' => 'required|date',
            'phone' => 'nullable|string|max:20',
        ];
    }
}
