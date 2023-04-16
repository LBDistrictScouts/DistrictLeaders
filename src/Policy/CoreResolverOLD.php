<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Policy;

use Authorization\Policy\Exception\MissingPolicyException;
use Authorization\Policy\ResolverInterface;
use Cake\Core\App;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\QueryInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\ORM\Query;

/**
 * Policy resolver that applies conventions based policy classes
 * for CakePHP ORM Tables, Entities and Queries.
 */
class CoreResolverOLD implements ResolverInterface
{
    /**
     * Application namespace.
     *
     * @var string
     */
    protected string $appNamespace = 'App';

    /**
     * Plugin name overrides.
     *
     * @var array<string, string>
     */
    protected array $overrides = [];

    /**
     * Constructor
     *
     * @param string $appNamespace The application namespace
     * @param array<string, string> $overrides A list of plugin name overrides.
     */
    public function __construct(string $appNamespace = 'App', array $overrides = [])
    {
        $this->appNamespace = $appNamespace;
        $this->overrides = $overrides;
    }

    /**
     * Get a policy for an ORM Table, Entity or Query.
     *
     * @param mixed $resource The resource.
     * @return object
     * @throws \Authorization\Policy\Exception\MissingPolicyException When a policy for the
     * resource has not been defined or cannot be resolved.
     */
    public function getPolicy(mixed $resource): object
    {
        if ($resource instanceof EntityInterface) {
            return $this->getEntityPolicy($resource);
        }
        if ($resource instanceof RepositoryInterface) {
            return $this->getRepositoryPolicy($resource);
        }
        if ($resource instanceof QueryInterface) {
            /** @var \Cake\Datasource\RepositoryInterface $table */
            $table = $resource instanceof Query ? $resource->getRepository() : $resource->repository();

            return $this->getRepositoryPolicy($table);
        }

        $name = is_object($resource) ? get_class($resource) : gettype($resource);
        throw new MissingPolicyException([$name]);
    }

    /**
     * Get a policy for an entity
     *
     * @param \Cake\Datasource\EntityInterface $entity The entity to get a policy for
     * @return object
     */
    protected function getEntityPolicy(EntityInterface $entity): object
    {
        $class = get_class($entity);
        $entityNamespace = '\Model\Entity\\';
        $namespace = str_replace('\\', '/', substr($class, 0, strpos($class, $entityNamespace)));
        $name = substr($class, strpos($class, $entityNamespace) + strlen($entityNamespace));

        return $this->findPolicy($class, $name, $namespace);
    }

    /**
     * Get a policy for a table
     *
     * @param \Cake\Datasource\RepositoryInterface $table The table/repository to get a policy for.
     * @return object
     */
    protected function getRepositoryPolicy(RepositoryInterface $table): object
    {
        $class = get_class($table);
        $tableNamespace = '\Model\Table\\';
        $namespace = str_replace('\\', '/', substr($class, 0, strpos($class, $tableNamespace)));
        $name = substr($class, strpos($class, $tableNamespace) + strlen($tableNamespace));

        return $this->findPolicy($class, $name, $namespace);
    }

    /**
     * Locate a policy class using conventions
     *
     * @param string $class The full class name.
     * @param string $name The name suffix of the resource.
     * @param string $namespace The namespace to find the policy in.
     * @return object
     * @throws \Authorization\Policy\Exception\MissingPolicyException When a policy for the
     * resource has not been defined.
     */
    protected function findPolicy(string $class, string $name, string $namespace): object
    {
        $namespace = $this->getNamespace($namespace);
        $policyClass = false;

        // plugin entities can have application overrides defined.
        if ($namespace !== $this->appNamespace) {
            $policyClass = App::className($name, 'Policy\\' . $namespace, 'Policy');
        }

        // Check the application/plugin.
        if ($policyClass === false) {
            $policyClass = App::className($namespace . '.' . $name, 'Policy', 'Policy');
        }

        if ($policyClass === false) {
            throw new MissingPolicyException([$class]);
        }

        return new $policyClass();
    }

    /**
     * Returns plugin namespace override if exists.
     *
     * @param string $namespace The namespace to find the policy in.
     * @return string
     */
    protected function getNamespace(string $namespace): string
    {
        if (isset($this->overrides[$namespace])) {
            return $this->overrides[$namespace];
        }

        return $namespace;
    }
}
