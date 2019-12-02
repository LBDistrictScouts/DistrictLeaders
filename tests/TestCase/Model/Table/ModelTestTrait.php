<?php


namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * Trait ModelTestTrait
 *
 * @package App\Test\TestCase\Model\Table
 */
trait ModelTestTrait
{
    /**
     * @param array $requiredFields Required Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     *
     * @return void
     */
    protected function validateRequired($requiredFields, $table, $good, $validator = 'default')
    {
        foreach ($requiredFields as $require) {
            $requiredArray = call_user_func($good);
            unset($requiredArray[$require]);
            $new = $table->newEntity($requiredArray, ['validate' => $validator]);
            TestCase::assertSame('This field is required', $new->getError($require)['_required']);
            TestCase::assertFalse($table->save($new));
        }
    }

    /**
     * @param array $notRequiredFields Required Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     *
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
     *
     * @return void
     */
    protected function validateNotEmpty($field, $table, $good, $validator = 'default', $message = 'This field cannot be left empty')
    {
        $notEmptyArray = call_user_func($good);
        $notEmptyArray[$field] = '';
        $new = $table->newEntity($notEmptyArray, ['validate' => $validator]);
        TestCase::assertSame($message, $new->getError($field)['_empty']);
        TestCase::assertFalse($table->save($new));
    }

    /**
     * @param array $notEmptyFields Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     *
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
     *
     * @return void
     */
    protected function validateEmpties($emptyFields, $table, $good, $validator = 'default')
    {
        foreach ($emptyFields as $empty) {
            $emptyArray = call_user_func($good);
            $emptyArray[$empty] = '';
            $new = $table->newEntity($emptyArray, ['validate' => $validator]);
            TestCase::assertInstanceOf($table->getEntityClass(), $table->save($new));
        }
    }

    /**
     * @param array $maxLengthFields Associative Max Length Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     *
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
            $maxLengthArray[$maxField] = substr($string, 1, $maxLength);
            $new = $table->newEntity($maxLengthArray, ['validate' => $validator]);
            TestCase::assertInstanceOf($instance, $table->save($new));

            $newMaxLengthArray = call_user_func($good);
            $newMaxLengthArray[$maxField] = substr($string, 1, $maxLength + 1);
            $new = $table->newEntity($newMaxLengthArray, ['validate' => $validator]);
            TestCase::assertSame('The provided value is invalid', $new->getError($maxField)['maxLength']);
            TestCase::assertFalse($table->save($new));
        }
    }

    /**
     * @param string $field Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     * @param string $validator The Validator to be tested
     * @param string $message The Output Message Expected
     *
     * @return void
     */
    protected function validateEmail($field, $table, $good, $validator = 'default', $message = 'You must use a Scouting Email Address')
    {
        // Bad Email
        $newEntityArray = call_user_func($good);
        $newEntityArray[$field] = 'jacob@ll';
        $new = $table->newEntity($newEntityArray, ['validate' => $validator]);
        TestCase::assertSame('The provided value is invalid', $new->getError($field)['email']);
        TestCase::assertSame($message, $new->getError($field)['validDomainEmail']);
        TestCase::assertFalse($table->save($new));

        $newEntityArray = call_user_func($good);
        $newEntityArray[$field] = 'jacob@button.com';
        $new = $table->newEntity($newEntityArray, ['validate' => $validator]);
        TestCase::assertNotContains('email', $new->getErrors());
        TestCase::assertSame($message, $new->getError($field)['validDomainEmail']);
        TestCase::assertFalse($table->save($new));

        $newEntityArray = call_user_func($good);
        $new = $table->newEntity($newEntityArray, ['validate' => $validator]);
        TestCase::assertNotContains('email', $new->getErrors());
        TestCase::assertNotContains('validDomainEmail', $new->getErrors());
        TestCase::assertInstanceOf($table->getEntityClass(), $table->save($new));
    }

    /**
     * @param string $field Field Name
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     *
     * @return void
     */
    protected function validateUniqueRule($field, $table, $good)
    {
        $existing = $table->get(1)->toArray();
        $instance = $table->getEntityClass();

        $values = call_user_func($good);
        $new = $table->newEntity($values);
        TestCase::assertInstanceOf($instance, $table->save($new));

        $values = call_user_func($good);
        $values[$field] = $existing[$field];
        $new = $table->newEntity($values);
        TestCase::assertFalse($table->save($new));
    }

    /**
     * @param array $uniqueFieldArray Array of Field Names
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     *
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
     *
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
    }

    /**
     * @param array $keyAndAssociatedTable Array of Foreign Key Names & Associated Tables
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     *
     * @return void
     */
    protected function validateExistsRules($keyAndAssociatedTable, $table, $good)
    {
        foreach ($keyAndAssociatedTable as $foreignKey => $associated) {
            $this->validateExistsRule($foreignKey, $table, $associated, $good);
        }
    }

    /**
     * @param \Cake\ORM\Table $table The Table to be tested
     */
    protected function validateInstallBase($table)
    {
        $before = $table->find('all')->count();

        $installed = $table->installBaseTypes();

        TestCase::assertNotEquals($before, $installed);
        TestCase::assertNotEquals(0, $installed);

        $after = $table->find('all')->count();
        TestCase::assertTrue($after > $before);
    }

    /**
     * @param array $expected Array of Expected Value
     * @param \Cake\ORM\Table $table The Table being Validated
     * @param integer $count Number of Items Expected
     * @param array|null $dates Date Fields to be omitted
     * @param int|array|null $get The Get Value
     */
    protected function validateInitialise($expected, $table, $count, $dates = null, $get = 1)
    {
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
}
