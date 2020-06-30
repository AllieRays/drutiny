<?php

namespace Drutiny\Http\Audit;

use Drutiny\Sandbox\Sandbox;
use Drutiny\Annotation\Param;

/**
 *
 * @Param(
 *  name = "header",
 *  description = "The HTTP header to check the value of.",
 *  type = "string"
 * )
 * @Param(
 *  name = "header_value",
 *  description = "The value to check against.",
 *  type = "string"
 * )
 */
class HttpHeaderMatch extends Http
{
    public function configure() {
        $this->addParameter(
          'header',
          static::PARAMETER_REQUIRED,
          'The HTTP header to check the value of.'
        );
        $this->addParameter(
          'header_value',
          static::PARAMETER_REQUIRED,
          'The value to check against.'
        );
        $this->HttpTrait_configure();
    }

    public function audit(Sandbox $sandbox)
    {
        $value = $sandbox->getParameter('header_value');
        $res = $this->getHttpResponse($sandbox);
        $header = $sandbox->getParameter('header');

        if (!$res->hasHeader($header)) {
            return false;
        }
        $headers = $res->getHeader($header);
        return $value == $headers[0];
    }
}
