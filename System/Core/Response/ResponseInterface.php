<?php

namespace Hexacore\Core\Response;

use Hexacore\Core\Request\RequestInterface;

interface ResponseInterface
{
    /**
     * Set header values
     *
     * @param string $key ie: content-type
     * @param string $value ie: application/json
     * @return self
     */
    public function setHeader(string $key, string $value): self;

    /**
     * Set cookies values
     *
     * @param string $name
     * @param null $value
     * @return ResponseInterface
     */
    public function setCookie(string $name, $value): self;

    /**
     * Set http code
     *
     * @param integer $code
     * @return self
     */
    public function setCode(int $code): self;

    /**
     * Set Http content
     *
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self;

    /**
     * Send the response
     *
     * @param RequestInterface $request
     * @return self
     */
    public function send(RequestInterface $request): self;
}
