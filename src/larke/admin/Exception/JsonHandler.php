<?php

declare (strict_types = 1);

namespace Larke\Admin\Exception;

use Throwable;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

/**
 * 异常返回json
 *
 * @create 2021-1-13
 * @author deatil
 */
class JsonHandler extends ExceptionHandler
{
    public function render($request, $exception)
    {
        $message = $exception->getMessage();
        if (empty($message)) {
            return parent::render($request, $exception);
        }
        
        parent::render($request, $exception);
        
        $data = [
            'success' => false,
            'code' => \ResponseCode::EXCEPTION,
            'message' => $message,
        ];
        
        if (config('app.debug')) {
            $data['exception'] = $this->renderException($exception);
        }
        
        return response()->json($data);
    }

    /**
     * 异常信息
     *
     * @param Throwable $e
     *
     * @return array
     */
    protected function renderException(Throwable $e)
    {
        $data = [
            'name' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $e->getMessage(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
            'tables' => [
                'GET Data' => request()->query(),
                'POST Data' => $_POST,
                'Files' => get_included_files(),
                'Cookies' => $_COOKIE,
                'Session' => \Session::all(),
                'Server/Request Data' => request()->server(),
                'Environment Variables' => $_ENV,
            ],
        ];

        return $data;
    }

}
