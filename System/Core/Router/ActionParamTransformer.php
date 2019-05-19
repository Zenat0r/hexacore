<?php


namespace Hexacore\Core\Router;


use Hexacore\Core\DI\DIC;
use Hexacore\Core\Exception\Router\InvalidGetterException;
use Hexacore\Core\Exception\Router\RouterException;
use Hexacore\Core\Model\ManageableModelInterface;
use Hexacore\Core\Model\Repository\ModelRepository;
use Hexacore\Core\Request\Request;
use Hexacore\Core\Response\Response;

class ActionParamTransformer
{
    private $dic;

    /**
     * ActionParamTransformer constructor.
     * @param DIC $DIC
     */
    public function __construct(DIC $DIC)
    {
        $this->dic = $DIC;
    }

    /**
     * @param \ReflectionParameter $param
     * @param array $items
     * @return object
     */
    private function getClassParam(\ReflectionParameter $param, array &$items)
    {
        $className = $param->getClass()->getName();

        if (Request::class === $className) {
            $object = Request::get();
        } else {
            $class = $this->dic->get($className);

            if ($class instanceof ManageableModelInterface) {
                $repository = $this->dic->get(ModelRepository::class);

                $id = array_shift($items);

                $object = $repository->setModel($className)->findById($id);
            } else {
                $object = $class;
            }
        }

        return $object;
    }

    /**
     * @param \ReflectionParameter $param
     * @param array $items
     * @return float|int|mixed|null
     * @throws \ReflectionException
     */
    private function getUrlParam(\ReflectionParameter $param, array &$items)
    {
        $parameter = array_shift($items);

        if ($parameter === null && $param->isDefaultValueAvailable()) {
            $paramValue = $param->getDefaultValue();
        } elseif ($parameter === null) {
            throw new RouterException("Missing getters", Response::NOT_FOUND);
        } else {
            $paramType = $param->getType()->getName();

            if ($paramType === "int") {
                $paramValue = (int)$parameter;
            } elseif ($paramType === "double") {
                $paramValue = (double)$parameter;
            } elseif ($paramType === "float") {
                $paramValue = (float)$parameter;
            } else {
                $paramValue = $parameter;
            }
        }

        return $paramValue;
    }

    /**
     * @param array $reflectedParameters
     * @param array $items
     * @return array
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function getParams(array $reflectedParameters, array $items): array
    {
        $parameters = [];
        foreach ($reflectedParameters as $param) {
            if ($param->getClass()) {
                $parameters[] = $this->getClassParam($param, $items);
            } else {
                $parameters[] = $this->getUrlParam($param, $items);
            }
        }

        if (!empty($items)) {
            throw new InvalidGetterException("Too many getters", Response::NOT_FOUND);
        }

        return $parameters;
    }
}