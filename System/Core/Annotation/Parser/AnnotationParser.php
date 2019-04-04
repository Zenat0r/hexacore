<?php


namespace Hexacore\Core\Annotation\Parser;

/**
 * Class AnnotationParser
 * @package Hexacore\Core\Annotation\Parser
 */
class AnnotationParser implements AnnotationParserInterface
{
    /**
     * @param string $annotationValueString
     * @return mixed|null
     * @throws \Exception
     */
    private function parseAnnotationValue(string $annotationValueString)
    {
        $data = trim($annotationValueString);

        $stack = 0;

        $value = "";

        $annotationArray = null;

        for ($i = 0; $i < strlen($data); $i++) {
            $char = $data[$i];

            if ("," === $char && 0 === $i) {
                throw new \Exception("Parsing error : can't start with a ,");
            }

            if ("[" === $char) {
                $stack++;

                if (1 === $stack) {
                    continue;
                }
            } else if ("]" === $char) {
                $stack--;

                if (0 === $stack) {
                    $annotationArray[] = $this->parseAnnotationValue($value);

                    $value = "";
                    continue;
                }
            }

            if (0 === $stack) {
                if ("," === $char || $i === strlen($data) - 1) {
                    if ($i === strlen($data) - 1) {
                        $value .= $char;

                        if ("," === $char) {
                            throw new \Exception("Parsing error : can't end with a ,");
                        }
                    }

                    if (0 !== strlen($value)) {
                        if (preg_match('/".*"/', $value)) {
                            $value = trim($value);
                            $annotationArray[] = substr($value, 1, -1);
                        } else {
                            $annotationArray[] = intval($value);
                        }
                    }

                    $value = "";
                    continue;
                }
            } else if ($i === strlen($data) - 1) {
                throw new \Exception("Parsing error : missing bracket");
            }


            $value .= $char;
        }

        return 1 === sizeof($annotationArray) ? reset($annotationArray) : $annotationArray;
    }

    /**
     * @param array $annotations
     * @return array
     */
    private function parseAnnotations(array $annotations): array
    {
        $annotationArray = [];
        foreach ($annotations as $annotation) {
            $keyValueArray = preg_split("/\(/", trim($annotation));

            $key = $keyValueArray[0];
            $value = $keyValueArray[1];

            $key = substr($key, 1);
            $value = substr($value, 0, -1);

            $annotationArray[$key] = $this->parseAnnotationValue($value);
        }

        return $annotationArray;
    }

    /**
     * @param string $comment
     * @return array
     * @throws \Exception
     */
    private function filter(string $comment): array
    {
        $commentArrayLines = preg_split("/\*/", $comment);

        $annotationArrayString = array_filter($commentArrayLines, function ($value) {
            return preg_match('/^@[A-Za-z][a-zA-z0-9]*\([A-Za-z0-9"\[\],= \-_&éèêàâ@#$£€ù%\\\+\!:;\?\.{}\^\/]*\)$/', trim($value));
        });

        foreach ($annotationArrayString as $commentLine) {
            if (1 < substr_count($commentLine, "(")) {
                throw new \Exception("Several annotations on the same line");
            }
        }

        return $annotationArrayString;
    }

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function parse(string $comment): array
    {
        $annotationArrayString = $this->filter($comment);

        return $this->parseAnnotations($annotationArrayString);
    }
}