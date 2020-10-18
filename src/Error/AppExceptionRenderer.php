<?php
namespace App\Error;

use Cake\Core\Configure;
use App\Model\Table\Exceptions\InvalidEmailDomainException;
use Cake\Error\Debugger;
use Cake\Error\ExceptionRenderer;

/**
 * Class AppExceptionRenderer
 *
 * @package App\Error
 */
class AppExceptionRenderer extends ExceptionRenderer
{
    /**
     * @param \App\Model\Table\Exceptions\InvalidEmailDomainException $error The Error being handled
     *
     * @return \Cake\Http\Response
     */
    public function invalidEmailDomain(InvalidEmailDomainException $error)
    {
        $exception = $error;
        $code = $this->_code($exception);
        $template = 'invalid_email_domain';

        $message = $this->_message($exception, $code);
        $url = $this->controller->getRequest()->getRequestTarget();
        $response = $this->controller->getResponse();
        $response = $response->withStatus($code);

        $viewVars = [
            'message' => $message,
            'url' => h($url),
            'error' => $exception,
            'code' => $code,
        ];
        $serialize = ['message', 'url', 'code'];

        $isDebug = Configure::read('debug');
        if ($isDebug) {
            $trace = (array)Debugger::formatTrace($exception->getTrace(), [
                'format' => 'array',
                'args' => false,
            ]);
            $origin = [
                'file' => $exception->getFile() ?: 'null',
                'line' => $exception->getLine() ?: 'null',
            ];
            // Traces don't include the origin file/line.
            array_unshift($trace, $origin);
            $viewVars['trace'] = $trace;
            $viewVars += $origin;
            $serialize[] = 'file';
            $serialize[] = 'line';
        }
        $this->controller->set($viewVars);
        $this->controller->viewBuilder()->setOption('serialize', $serialize);

        $this->controller->setResponse($response);

        return $this->_outputMessage($template);
    }
}
