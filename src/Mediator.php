<?php
declare(strict_types=1);

namespace Spatial\Mediator;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Mediator implements MiddlewareInterface
{
//    /** @var ReopeningEntityManager */
//    private $em;
//
//    public function __construct(ReopeningEntityManager $em)
//    {
//        $this->em = $em;
//    }


    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface|null $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {
//        $this->em->open();
//        try {
//            if ($request == null) {
//                throw new ArgumentNullException(get_class($request));
//            }
//
//            $handler = $handler ?? $this->_getHandlerName($request);
//
//            return $handler->handle($request);
//        } finally {
//            $this->em->getConnection()->close();
//            $this->em->clear();
//        }
        $handler = $handler ?? $this->_getHandlerName($request);
        return $handler->handle($request);
    }


    /**
     * Generate Hanlder name from request name
     *
     * @param ServerRequestInterface $request
     * @return RequestHandlerInterface
     */
    private function _getHandlerName(ServerRequestInterface $request): RequestHandlerInterface
    {
        $requestNamespace = explode('\\', get_class($request));
        if (count($requestNamespace) > 1) {
            $modelName = $requestNamespace[count($requestNamespace) - 1];
        } else {
            $modelName = $requestNamespace;
        }
        $handlerName = $modelName . 'Handler';
        $handler = \str_replace($modelName, $handlerName, get_class($request));
        return new $handler();
    }
}
