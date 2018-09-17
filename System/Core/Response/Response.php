<?php

namespace Hexacore\Core\Response;

use Hexacore\Core\Request\RequestInterface;

class Response implements ResponseInterface
{
    protected $headers;

    protected $code;

    protected $content;

    //https://http.cat
    const CONTINUE = 100;
    const SWITCHING_PROTOCOLS = 101;
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NO_CONTENT = 204;
    const PARTIAL_CONTENT = 206;
    const MULTI_STATUS = 207;
    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const SEE_OTHER = 303;
    const NOT_MODIFIED = 304;
    const USE_PROXY = 305;
    const TEMPORARY_REDIRECT = 307;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const REQUEST_TIMEOUT = 408;
    const CONFLICT = 409;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const REQUEST_ENTITY_TOO_LARGE = 413;
    const REQUEST_URI_TOO_LONG = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const ENHANCE_YOU_CLAM = 420;
    const MISDIRECTED_REQUEST = 421;
    const UNPROCESSABLE_ENTITY = 422;
    const LOCKED = 423;
    const FAILED_DEPENDENCY = 424;
    const UNORDERED_COLLECTION = 425;
    const UPGRADE_REQUIRED = 426;
    const TOO_MANY_REQUESTS = 429;
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    const NO_RESPONSE = 444;
    const BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = 450;
    const UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const INTERNAL_SERVER_ERROR = 500;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const VARIANT_ALSO_NEGOTIATES = 506;
    const INSUFFICIENT_STORAGE = 507;
    const LOOP_DETECTED = 508;
    const BANDWIDTH_LIMIT_EXCEEDED = 509;
    const NOT_EXTENDED = 510;
    const NETWORK_AUTHENTICATION_REQUIRED = 511;
    const NETWORK_CONNECT_TIMEOUT_ERROR = 599;

    public static $status = [
        100 => "Continue",
        101 => "Switching Protocols",
        200 => "OK",
        201 => "Created",
        202 => "Accepted",
        203 => "Non-Authoritative Information",
        204 => "No Content",
        206 => "Partial Content",
        207 => "Multi-Status",
        300 => "Multiple Choices",
        301 => "Moved Permanently",
        302 => "Found",
        303 => "See Other",
        304 => "Not Modified",
        305 => "Use Proxy",
        307 => "Temporary Redirect",
        400 => "Bad Request",
        401 => "Unauthorized",
        402 => "Payment Required",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        406 => "Not Acceptable",
        408 => "Request Timeout",
        409 => "Conflict",
        410 => "Gone",
        411 => "Length Required",
        412 => "Precondition Failed",
        413 => "Payload Too Large",
        414 => "URI Too Long",
        415 => "Unsupported Media Type",
        416 => "Range Not Satisfiable",
        417 => "Expectation Failed",
        418 => "I'm a teapot",
        420 => "Enchant your Claim",
        421 => "Misdirected Request",
        422 => "Unprocessable Entity",
        423 => "Locked",
        424 => "Failed Dependency",
        425 => "Too Early",
        426 => "Upgrade Required",
        429 => "Too Many Requests",
        431 => "Request Header Fields Too Large",
        444 => "No Response",
        450 => "BLocked by Windows Parental COntrols",
        451 => "Unavailable For Legal Reasons",
        500 => "Internal Server Error",
        502 => "Bad Gateway",
        503 => "Service Unavailable",
        504 => "Gateway Timeout",
        506 => "Variant Also Negotiates",
        507 => "Insufficient Storage",
        508 => "Loop Detected",
        509 => "Bandwidth Limit Excedded",
        510 => "Not Extended",
        511 => "Network Authentication Required",
        599 => "Network connect timeout error"
    ];

    public function __construct(string $content, array $headers = [], $code = 200)
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->code = $code;
    }

    public function setHeader(string $key, string $value): ResponseInterface
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function setCode(int $code): ResponseInterface
    {
        $this->code = $code;

        return $this;
    }

    public function setContent(string $content): ResponseInterface
    {
        $this->content = $content;

        return $this;
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        header($request->getServer("SERVER_PROTOCOL") . " " . $this->code . " " . self::$status[$this->code]);

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo $this->content;

        return $this;
    }
}
