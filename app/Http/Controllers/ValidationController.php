<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Merchant;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationController extends Controller
{
    use ApiResponseTrait;

    public function refreshToken(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'merchant_code' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }
        $merchant = Merchant::where('merchant_code', $request->merchant_code)->first();
        if ($merchant) {
            // Tạo token cho merchant
            $token = $merchant->createToken('API Token')->accessToken;
            $data = [
                'token' => $token
            ];
            return $this->successResponse($data);
        } else {
            return $this->errorResponse('Merchant not found', 404);
        }
    }
    public function validateMerchant(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'url' => 'required',
            'method' => 'required',
            'data' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }

        $employee = Employee::create($data);

        return response([ 'employee' => new
        EmployeeResource($employee),
            'message' => 'Success'], 200);
    }

}
