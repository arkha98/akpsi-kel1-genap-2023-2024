<?php

namespace App\Helpers;

use App\Traits\EnvTrait;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Throwable;

class CustomHelper
{
    use EnvTrait;    

    const _UNIQUE_KEY = 'jLZ6SuPgFf4DE4a7HYxr';
    const _OPTIONAL_KEY = 'mz4DiFhzHEcvg9PBD4gF';

    const _LOGIN_FOR_PAGE_ADMIN = 'LOGIN_FOR_PAGE_ADMIN';

    const _SUCCESS = 1;
    const _ERROR = 0;

    const _SUCCESS_MESSAGE = 'Success successfully...';
    const _SUCCESS_MESSAGE_STORE_DATA = 'Data store successfully...';
    const _SUCCESS_MESSAGE_UPDATE_DATA = 'Data update successfully...';
    const _SUCCESS_MESSAGE_DELETE_DATA = 'Data delete successfully...';
    const _SUCCESS_MESSAGE_SHOW_DATA = 'Data show successfully...';
    const _SUCCESS_MESSAGE_PAGINATION_DATA = 'Data pagination successfully...';

    const _ERROR_MESSAGE = 'error detected...';
    const _ERROR_MESSAGE_STORE_DATA = 'Error in store data';
    const _ERROR_MESSAGE_UPDATE_DATA = 'Error in update data';
    const _ERROR_MESSAGE_DELETE_DATA = 'Error in delete data';
    const _ERROR_MESSAGE_SHOW_DATA = 'Error in show data';
    const _ERROR_MESSAGE_PAGINATION_DATA = 'Error in pagination data';

    const _ERROR_MESSAGE_THROW_CONTROLLER = 'Error in exception';

    const _SUCCESS_AUTH = 'Authentication successfully...';
    const _SUCCESS_CHECK_AUTH = 'Check auth successfully...';
    const _ERROR_CHECK_AUTH = 'Check auth failed';
    const _ERROR_AUTH = 'Authentication failed';
    const _ERROR_NOT_AUTHORIZED = 'You are not authorized';
    const _SUCCESS_LOGOUT = 'Logout successfully....';
    const _ERROR_LOGOUT = 'Logout failed';

    const _CODE_SUCCESS_BASIC = 200;
    const _CODE_ERROR_AUTH = 401;
    const _CODE_ERROR_FORBIDDEN = 403;
    const _CODE_ERROR_VALIDATE = 400;
    const _CODE_ERROR_THROW = 500;
    const _CODE_ERROR_INTERNAL = 500;

    const _TIMEOUT_TOKEN = 90;

    const _KODE_KONFIG_SCHEDULER_AKTIF = "SCHEDULER_AKTIF";
    const _KODE_KONFIG_SCHEDULER_WAKTU = "SCHEDULER_WAKTU";

    public static function createSlug($param)
    {
        return Str::slug($param);
    }

    public static function returnStringLocalDate($stringDate)
    {
        $date = Carbon::parse($stringDate);
        // $end_date = date("Y-m-d H:i:s", strtotime($stringDate));

        // $strIntDate = strtotime($date);
        // $strIntNow = strtotime(now());

        // $check = $strIntNow - $strIntDate;
        // $check = round($check / (60 * 60 * 24));

        $interval = now()->diff($date);
        $check = $interval->format('%a');

        if($check == 0){
            $sd = $date->diffForHumans();
        }
        else{
            // $sd = $date->formatLocalized("%A, %d %B %Y %H:%M") .  ' WIB';
            $sd = $date->formatLocalized("%d %b %Y %H:%M") .  ' WIB';
        }

        return $sd;
    }

    public static function returnDate($stringDate)
    {
        $date = Carbon::parse($stringDate);
        $end_date = date("Y-m-d H:i:s", strtotime($stringDate));

        // $strIntDate = strtotime($date);
        // $strIntNow = strtotime(now());

        // $check = $strIntNow - $strIntDate;
        // $check = round($check / (60 * 60 * 24));

        return $end_date;
    }

    public static function returnStringDateGoogleFormat($stringDate)
    {
        $datetime = new DateTime($stringDate);
        $result = $datetime->format('Y-m-d\TH:i:sP');
        return $result;
    }

    public static function generateRandomString($length = 5, $charToRand = 'str', $toLower = true) : string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numChars ='0123456789';
        $strChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';    
        $processChars = '';
        
        if($charToRand == 'str') $processChars = $strChars;
        if($charToRand == 'num') $processChars = $numChars;
        if($charToRand == 'all') $processChars = $characters;

        $charactersLength = strlen($processChars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $processChars[random_int(0, $charactersLength - 1)];
        }

        if($toLower){
            $randomString = strtolower($randomString);
        }

        return $randomString;     
    }

    #region ------- PAGINATION

    public static function defaultParamPagination($filters, $request)
    {
        $getType = $request->input('getType', "pagination"); // all, pagination
        $sort = $request->input('sort', "desc");
        $sortBy = $request->input('sortBy', "created_at");
        $currentPage = $request->input('currentPage', 1);
        $dataPerPage = $request->input('dataPerPage', 100);

        $custom = [
            "params" => $filters,
            "getType" => $getType,
            "sort" => $sort,
            "sortBy" => $sortBy,
            "currentPage" => $currentPage,
            "dataPerPage" => $dataPerPage
        ];
        return $custom;
    }

    public static function doPagination($query, string $sort, string $sortBy, int $currentPage, int $dataPerPage)
    {
        if ($query->count() > 0) {
            $query = $query->orderBy($sortBy, $sort)
                ->skip(($currentPage -  1) * $dataPerPage)
                ->take($dataPerPage);
        }
        return $query;
    }

    public static function resultPagination($params, $getType, $data, int $count, string $sort, string $sortBy, int $currentPage, int $dataPerPage)
    {
        $result = [
            'data' => $data,
            'count' => $count,
            'sort' => $sort,
            'sortBy' => $sortBy,
            'currentPage' => $currentPage,
            'dataPerPage' => $dataPerPage,
            'params' => $params,
            'getType' => $getType,
        ];

        return $result;
    }

    #endregion --------- PAGINATION

    #--------------------------------------------------------------------------------

    #--------------------------------------------------------------------------------

    #region PASSWORD

    public static function getUniqueKey(): string
    {
        return self::_UNIQUE_KEY;
    }

    public static function saltPassword(string $password, string $optKey = self::_OPTIONAL_KEY): string
    {
        $password = $optKey . self::_UNIQUE_KEY . $password;
        return $password;
    }

    public static function hashPassword(string $password, string $optKey = self::_OPTIONAL_KEY): string
    {
        // return Hash::make(self::saltPassword($password, $optKey));
        return password_hash(self::saltPassword($password, $optKey), PASSWORD_DEFAULT);
    }

    #endregion password

    #--------------------------------------------------------------------------------

    #region return result

    public static function returnResultBasic($result)
    {
        $result = [
            'status_message' => 1,
            'result' => $result,
            'errors' => []
        ];
        return $result;
    }

    public static function returnResultSuccess()
    {
        $result = [
            'status_message' => 1,
            'result' => [],
            'errors' => []
        ];
        return $result;
    }

    public static function returnResultError($errors)
    {
        $result = [
            'status_message' => 0,
            'errors' => $errors,
            'result' => []
        ];
        return $result;
    }

    public static function returnResultErrorThrowException($th)
    {
        error_log("exception: " . $th->getMessage());
        Log::error($th->getMessage());
        Log::error($th->getTraceAsString());
        $errors = [
            // 'error' => 'error exception'
            // 'error exception'
            'exception' => ['error exception']
        ];
        $result = [
            'status_message' => 0,
            'errors' => $errors,
            'result' => []
        ];
        return $result;
    }

    #endregion return result

    #--------------------------------------------------------------------------------

    #region RESPONSE TO BLADE VIEW /  REDIRECT TO VIEW
    public static function returnViewWithData($viewName, $result)
    {
        // return view($viewName, $result);
        if(empty($result)) return view($viewName);
        return view($viewName)
                ->with($result['result'])
                ->with($result['errors'])
                ->with($result['status_message']);
    }

    public static function returnViewWithError($viewName, $result)
    {
        return view($viewName)->with($result['errors'])->with($result['status_message']);
    }

    public static function returnViewWithErrorException($viewName, $th)
    {
        $result =  CustomHelper::returnResultErrorThrowException($th);
        return view($viewName)->with($result['errors'])->with($result['status_message']);
    }

    public static function RedirectBackWithErrorException($th)
    {
        $result =  CustomHelper::returnResultErrorThrowException($th);
        return redirect()->back()->withErrors($result['errors'])->with($result['status_message']);
    }

    #endregion RESPONSE BLADE VIEW

    #--------------------------------------------------------------------------------

    #region RESPONSE JSON

    public static function basicResponse($result, $message = self::_SUCCESS_MESSAGE, $statusCode = 200)
    {
        $result = [
            'status_code' => 200,
            'result' => $result['result'] ?? [],
            'message' => $message,
            'errors' => [],
            'status' => self::_SUCCESS
        ];
        return response()->json($result, $statusCode);
    }

    public static function basicErrorResponse($errors, $message = self::_ERROR_MESSAGE, $statusCode = 500)
    {
        if(count($errors) > 0){
            $statusCode =200;
        }
        $result = [
            'status_code' => $statusCode,
            'message' => $message,
            'errors' => $errors,
            'status' => self::_ERROR
        ];

        return response()->json($result, $statusCode);
    }

    public static function throwErrorResponse(Throwable $th, $errors = [], $message = self::_ERROR_MESSAGE_THROW_CONTROLLER, $statusCode = 500)
    {
        error_log("exception: " . $th->getMessage());
        Log::error($th->getMessage());
        Log::error($th->getTraceAsString());
        $result = [
            'status_code' => $statusCode,
            'message' => $message,
            // 'error' => $th->getMessage(),
            'error' => 'Error exception',
            'errors' => $errors,
            'status' => self::_ERROR
        ];

        return response()->json($result, $statusCode);
    }

    public static function errorNotAuthResponse()
    {
        //abort(CustomHelper::_CODE_ERROR_AUTH, 'Access denied');
        return self::basicErrorResponse([], self::_ERROR_NOT_AUTHORIZED, self::_CODE_ERROR_AUTH);
    }

    #endregion RESPONSE JSON

}
