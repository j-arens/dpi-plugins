<?php namespace DpiTabs\core;

class Container {

    /**
     * @var array
     */
    protected $repository = [];

    /**
     * Check if a binding already exists in the repository
     * 
     * @param string $key
     * @return boolean
     */
    protected function bindingExists($key) {
        return array_key_exists($key, $this->repository);
    }

    /**
     * Check a binding for dependencies and store them
     * 
     * @param string $className
     * @return array
     */
    protected function getDependencies($className) {
        $refl = new \ReflectionClass($className);
        $constr = $refl->getConstructor();

        if (!$constr) {
            return [];
        }

        $params = $constr->getParameters();

        if (empty($params)) {
            return [];
        }

        return array_map(function($dependency) {
            return $dependency->name;
        }, $params);
    }

    /**
     * Add a new binding to the repository
     * 
     * @param string $key
     * @param string $className
     * @return void
     */
    public function bind($key, $className) {
        if ($this->bindingExists($key)) {
            throw new \Exception('');
        }

        $this->repository[$key] = [
            'className' => $className,
            'dependencies' => $this->getDependencies($className),
        ];
    }

    /**
     * NewUp's a class along with any dependencies
     * 
     * @param string $key
     * @return object
     */
    public function resolve($key) {
        if (!$this->bindingExists($key)) {
            throw new \Exception('Binding does not exist');
        }

        $binding = $this->repository[$key];

        if (empty($binding['dependencies'])) {
            return new $binding['className'];
        }

        $dependencies = array_map(function($key) {
            return $this->resolve($key);
        }, $binding['dependencies']);

        return new $binding['className'](...$dependencies);
    }
    
}