<?php


namespace Hexacore\Core\Annotation\Parser;

use Hexacore\Core\Annotation\Type\AnnotationType;

/**
 * Class AnnotationParser
 * @package Hexacore\Core\Annotation\Parser
 */
class AnnotationParser implements AnnotationParserInterface
{
    /**
     * @param string $annotationValueString
     * @return mixed|null
     */
    private function parseAnnotationValue(string $annotationValueString)
    {
        $data = trim($annotationValueString);
        $dataArray = preg_split("/\,/", $data);

        $annotationArray = null;

        foreach ($dataArray as $data) {
            $data = trim($data);
            if ("" === $data) {
                $annotationArray[] = null;
            } else if (preg_match('/".*"/', $data)) {
                $annotationArray[] = substr($data, 1, -1);
            } else {
                $annotationArray[] = intval($data);
            }
        }

        return 1 === sizeof($annotationArray) ? $annotationArray[0] : $annotationArray;
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

            $annotationValue = $this->parseAnnotationValue($value);
            $annotationArray[$key] = new AnnotationType($key, $annotationValue);
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
            return preg_match('/^@[A-Za-z][a-zA-z0-9]*\([A-Za-z0-9",. ]*\)$/', trim($value));
        });

        foreach ($annotationArrayString as $commentLine) {
            if (1 < substr_count($commentLine, "(")) {
                throw new \Exception("Several annotations on the same line");
            } else if (preg_match('/"[a-zA-Z0-9.]+,[A-Za-z0-9.]+"/', $commentLine)) {
                throw new \Exception("String value can't contain ,");
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