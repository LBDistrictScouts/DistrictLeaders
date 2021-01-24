<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Test\Factory\UserStateFactory;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;
use CakephpFixtureFactories\Factory\BaseFactory;

/**
 * Trait ModelTestTrait
 *
 * @package App\Test\TestCase\Model\Table
 */
trait ModelTestTrait
{
    /**
     * @var array An array for Default Error Messages
     */
    private $defaultErrorMessages = [
        '_required' => 'This field is required',
        '_empty' => 'This field cannot be left empty',
        '_isUnique' => 'This value is already in use',
        '_existsIn' => 'This value does not exist',
        'email' => 'The provided value is invalid',
        'maxLength' => 'The provided value is invalid',
        'unique' => 'The provided value is invalid',
        'validDomainEmail' => 'You must use a Scouting Email Address',
        'regex' => 'The provided value is invalid',
    ];

    /**
     * Function that will return the Entity Name string
     *
     * @param \Cake\ORM\Table $table
     * @return string
     */
    private function getEntityName(Table $table): string
    {
        $entity = $table->getEntityClass();

        return strrev(explode('\\', strrev($entity))[0]);
    }

    /**
     * Function that will return the class string for the Entity Factory
     *
     * @param \Cake\ORM\Table $table
     * @return string
     */
    private function getFactoryName(Table $table): string
    {
        $entity = $this->getEntityName($table);

        return 'App\Test\Factory\\' . $entity . 'Factory';
    }

    /**
     * Function that will return the 'make' callable string for the Entity Factory
     *
     * @param \Cake\ORM\Table $table
     * @return string
     */
    private function getFactoryMake(Table $table): string
    {
        return $this->getFactoryName($table) . '::make';
    }

    /**
     * @param \Cake\ORM\Table $table
     * @param array $parameter
     * @param int $quantity
     * @return \CakephpFixtureFactories\Factory\BaseFactory
     */
    private function factoryMake(Table $table, array $parameter = [], int $quantity = 1): BaseFactory
    {
        $class = $this->getFactoryName($table);
        $config = ['generatePrimaryKey' => false];

        /** @var BaseFactory $factory */
        $factory = new UserStateFactory($config);

        return $factory::make($parameter, $quantity);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $entity
     * @param string $field The Field expected to error
     * @param string $errorType the expected error type
     * @param string|null $message The expected error message output
     * @return void
     */
    private function checkError(
        EntityInterface $entity,
        string $field,
        string $errorType,
        ?string $message = null
    ) {
        if (!key_exists($errorType, $this->defaultErrorMessages)) {
            TestCase::assertTrue(false, 'No Error type exists for this field: ' . $field);
        }

        if (
            $errorType == '_isUnique'
            && key_exists('unique', $entity->getError($field))
            && !key_exists('_isUnique', $entity->getError($field))
        ) {
            $errorType = 'unique';
        }

        if (is_null($message)) {
            $message = $this->defaultErrorMessages[$errorType];
        }

        TestCase::assertSame(
            $message,
            $entity->getError($field)[$errorType],
            'Error Type Message doesn\'t match for field: ' . $field . '. It is: ' . $entity->getError($field)[$errorType]
        );
    }

    /**
     * @param array $requiredFields Required Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @return void
     */
    protected function validateRequired($requiredFields, $table, $good, $validator = 'default')
    {
        foreach ($requiredFields as $require) {
            $requiredArray = call_user_func($good);
            unset($requiredArray[$require]);
            $new = $table->newEntity($requiredArray, ['validate' => $validator]);
            $this->checkError($new, $require, '_required');
            TestCase::assertFalse($table->save($new));
        }
    }

    /**
     * @param array $notRequiredFields Required Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @return void
     */
    protected function validateNotRequired($notRequiredFields, $table, $good, $validator = 'default')
    {
        foreach ($notRequiredFields as $notRequired) {
            $notRequiredArray = call_user_func($good);
            unset($notRequiredArray[$notRequired]);
            $new = $table->newEntity($notRequiredArray, ['validate' => $validator]);
            TestCase::assertInstanceOf($table->getEntityClass(), $table->save($new));
        }
    }

    /**
     * @param string $field Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @param string $message The Output Message Expected
     * @return void
     */
    protected function validateNotEmpty($field, $table, $good, $validator = 'default', $message = null)
    {
        $notEmptyArray = call_user_func($good);
        $notEmptyArray[$field] = '';
        $new = $table->newEntity($notEmptyArray, ['validate' => $validator]);
        $this->checkError($new, $field, '_empty', $message);
        TestCase::assertFalse($table->save($new));
    }

    /**
     * @param array $notEmptyFields Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @return void
     */
    protected function validateNotEmpties($notEmptyFields, $table, $good, $validator = 'default')
    {
        foreach ($notEmptyFields as $notEmpty) {
            $this->validateNotEmpty($notEmpty, $table, $good, $validator);
        }
    }

    /**
     * @param array $emptyFields Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @return void
     */
    protected function validateEmpties($emptyFields, $table, $good, $validator = 'default')
    {
        foreach ($emptyFields as $empty) {
            $emptyArray = call_user_func($good);
            $emptyArray[$empty] = '';
            $new = $table->newEntity($emptyArray, ['validate' => $validator]);
            TestCase::assertInstanceOf(
                $table->getEntityClass(),
                $table->save($new),
                $empty . ' Field was not valid as empty.'
            );
        }
    }

    /**
     * @param array $maxLengthFields Associative Max Length Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @return void
     */
    protected function validateMaxLengths($maxLengthFields, $table, $good, $validator = 'default')
    {
        $instance = $table->getEntityClass();

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string; // 128 -> 256
        $string .= $string; // 256 -> 512
        $string .= $string; // 512 -> 1024

        foreach ($maxLengthFields as $maxField => $maxLength) {
            $maxLengthArray = call_user_func($good);
            if (strlen($maxLengthArray[$maxField]) != $maxLength) {
                $maxLengthArray[$maxField] = substr($string, 1, $maxLength);
            }
            $new = $table->newEntity($maxLengthArray, ['validate' => $validator]);
            TestCase::assertInstanceOf($instance, $table->save($new));

            $newMaxLengthArray = call_user_func($good);
            $newMaxLengthArray[$maxField] = substr($string, 1, $maxLength + 1);
            $new = $table->newEntity($newMaxLengthArray, ['validate' => $validator]);
            $this->checkError($new, $maxField, 'maxLength');
            TestCase::assertFalse($table->save($new));
        }
    }

    /**
     * @param array $regex The Regex Field with various passing and erring strings
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string|null $validator The Validator to be tested
     * @return void
     */
    protected function validateRegex(array $regex, Table $table, callable $good, ?string $validator = 'default')
    {
        $instance = $table->getEntityClass();

        foreach ($regex as $regexField => $testArray) {
            foreach ($testArray as $textValue => $expected) {
                $newEntityData = call_user_func($good);
                $newEntityData[$regexField] = $textValue;
                $new = $table->newEntity($newEntityData, ['validate' => $validator]);

                if ($expected) {
                    TestCase::assertInstanceOf($instance, $table->save($new));
                } else {
                    $this->checkError($new, $regexField, 'regex');
                    TestCase::assertFalse($table->save($new));
                }
            }
        }
    }

    /**
     * @param string $field Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @param string|null $message The Output Message Expected
     * @return void
     */
    protected function validateEmail($field, $table, $good, $validator = 'default', $message = null)
    {
        // Bad Email
        $newEntityArray = call_user_func($good);
        $newEntityArray[$field] = 'jacob@ll';
        $new = $table->newEntity($newEntityArray, ['validate' => $validator]);
        TestCase::assertFalse($table->save($new));
        $this->checkError($new, $field, 'email');
        $this->checkError($new, $field, 'validDomainEmail', $message);

        $newEntityArray = call_user_func($good);
        $newEntityArray[$field] = 'jacob@button.com';
        $new = $table->newEntity($newEntityArray, ['validate' => $validator]);
        TestCase::assertFalse($table->save($new));
        TestCase::assertNotContains('email', $new->getErrors());
        $this->checkError($new, $field, 'validDomainEmail', $message);

        $newEntityArray = call_user_func($good);
        $new = $table->newEntity($newEntityArray, ['validate' => $validator]);
        TestCase::assertNotContains('email', $new->getErrors());
        TestCase::assertNotContains('validDomainEmail', $new->getErrors());
        TestCase::assertInstanceOf($table->getEntityClass(), $table->save($new));
    }

    /**
     * @param string|array $field Field Name
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @return void
     */
    protected function validateUniqueRule($field, $table, $good)
    {
        $instance = $table->getEntityClass();

        $existing = $table->newEntity(call_user_func($good));
        TestCase::assertInstanceOf($instance, $table->save($existing));

        $values = call_user_func($good);
        if (is_array($field)) {
            foreach ($field as $uqField) {
                $values[$uqField] = $existing[$uqField];
            }
            $field = $field[0];
        } else {
            $values[$field] = $existing[$field];
        }

        $new = $table->newEntity($values);
        TestCase::assertFalse($table->save($new));
        $this->checkError($new, $field, '_isUnique');
    }

    /**
     * @param array $uniqueFieldArray Array of Field Names
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @return void
     */
    protected function validateUniqueRules($uniqueFieldArray, $table, $good)
    {
        foreach ($uniqueFieldArray as $uniqueField) {
            $this->validateUniqueRule($uniqueField, $table, $good);
        }
    }

    /**
     * @param string $field Field Name
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param \Cake\ORM\Table $association The Associated Table to be tested
     * @param callable $good The Good Generation Function
     * @param array|null $options Options Array for Save Entity
     * @return void
     */
    protected function validateExistsRule($field, $table, $association, $good, $options = [])
    {
        $values = call_user_func($good);
        $instance = $table->getEntityClass();

        $types = $association->find('list')->toArray();

        $fKey = max(array_keys($types));

        $values[$field] = $fKey;
        $new = $table->newEntity($values, $options);
        TestCase::assertInstanceOf($instance, $table->save($new));

        $values = call_user_func($good);
        $types = $association->find('list')->toArray();
        $fKey = max(array_keys($types));

        $values[$field] = $fKey + 1;
        $new = $table->newEntity($values, $options);
        TestCase::assertFalse($table->save($new));
        $this->checkError($new, $field, '_existsIn');
    }

    /**
     * @param array $existsArray Array of Foreign Key Names & Associated Tables
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @return void
     */
    protected function validateExistsRules($existsArray, $table, $good)
    {
        foreach ($existsArray as $foreignKey => $associated) {
            $this->validateExistsRule($foreignKey, $table, $associated, $good);
        }
    }

    /**
     * @param \Cake\ORM\Table $table The Table to be tested
     */
    protected function validateInstallBase($table)
    {
        $before = $table->find('all');
        $beforeKeys = array_keys($before->toArray());

        $installAlias = 'installBase' . $table->getRegistryAlias();
        $installed = call_user_func([$table, $installAlias]);

        TestCase::assertGreaterThan(0, $installed);

        $after = $table->find('all');
        TestCase::assertGreaterThanOrEqual($before->count(), $after->count());
        TestCase::assertGreaterThanOrEqual($installed, $after->count());

        if (!empty($beforeKeys)) {
            $after = $after->whereNotInList($table->getPrimaryKey(), $beforeKeys);
        }
        TestCase::assertGreaterThan(0, $after->count());
    }

    /**
     * @param array $expected Array of Expected Value
     * @param \Cake\ORM\Table $table The Table being Validated
     * @param int $count Number of Items Expected
     * @param array|null $dates Date Fields to be omitted
     * @param int|array|null $get The Get Value
     */
    protected function validateInitialise(
        array $expected,
        Table $table,
        int $count,
        ?array $dates = null,
        $get = 1
    ): void {
        if (is_array($get)) {
            $actual = $table->find('all')->where($get)->first()->toArray();
        } else {
            $actual = $table->get($get)->toArray();
        }

        if (!is_null($dates)) {
            foreach ($dates as $date) {
                $dateValue = $actual[$date];
                if (!is_null($dateValue)) {
                    TestCase::assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
                }
                unset($actual[$date]);
            }
        }

        TestCase::assertEquals($expected, $actual);

        $tableCount = $table->find('all')->count();
        TestCase::assertEquals($count, $tableCount);
    }

    /**
     * @param \Cake\ORM\Table $table
     */
    protected function validateAutoInitialise(Table $table): void
    {
        try {
            $savedEntity = $this->factoryMake($table)->persist();
            TestCase::assertInstanceOf($table->getEntityClass(), $savedEntity, 'Save Exception');
        } catch (\Exception $exception) {
            throw $exception;
        }

        $actual = $table->get($savedEntity->id)->toArray();
        $expected = $savedEntity->toArray();
        TestCase::assertEquals($expected, $actual);

        $count = $table->find('all')->count();
        TestCase::assertEquals(1, $count);
    }
}
