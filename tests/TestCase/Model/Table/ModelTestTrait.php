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
     *
     * @return void
     */
    protected function validateRequired($requiredFields, $table, $good)
    {
        foreach ($requiredFields as $require) {
            $requiredArray = call_user_func($good);
            unset($requiredArray[$require]);
            $new = $table->newEntity($requiredArray);
            TestCase::assertFalse($table->save($new));
        }
    }

    /**
     * @param array $notRequiredFields Required Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     *
     * @return void
     */
    protected function validateNotRequired($notRequiredFields, $table, $good)
    {
        foreach ($notRequiredFields as $notRequired) {
            $notRequiredArray = call_user_func($good);
            unset($notRequiredArray[$notRequired]);
            $new = $table->newEntity($notRequiredArray);
            TestCase::assertInstanceOf($table->getEntityClass(), $table->save($new));
        }
    }

    /**
     * @param array $notEmptyFields Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     *
     * @return void
     */
    protected function validateNotEmpties($notEmptyFields, $table, $good)
    {
        foreach ($notEmptyFields as $notEmpty) {
            $notEmptyArray = call_user_func($good);
            $notEmptyArray[$notEmpty] = '';
            $new = $table->newEntity($notEmptyArray);
            TestCase::assertFalse($table->save($new));
        }
    }

    /**
     * @param array $emptyFields Not Empty Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     *
     * @return void
     */
    protected function validateEmpties($emptyFields, $table, $good)
    {
        foreach ($emptyFields as $empty) {
            $emptyArray = call_user_func($good);
            $emptyArray[$empty] = '';
            $new = $table->newEntity($emptyArray);
            TestCase::assertInstanceOf($table->getEntityClass(), $table->save($new));
        }
    }

    /**
     * @param array $maxLengthFields Associative Max Length Fields Array
     * @param \Cake\ORM\Table $table The Table to be tested
     * @param callable $good The Good Generation Function
     *
     * @return void
     */
    protected function validateMaxLengths($maxLengthFields, $table, $good)
    {
        $instance = $table->getEntityClass();

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string; // 128 -> 256
        $string .= $string; // 256 -> 512
        $string .= $string; // 512 -> 1024

        foreach ($maxLengthFields as $maxField => $maxLength) {
            $maxLengthArray = call_user_func($good);
            $maxLengthArray[$maxField] = substr($string, 1, $maxLength);
            $new = $table->newEntity($maxLengthArray);
            TestCase::assertInstanceOf($instance, $table->save($new));

            $newMaxLengthArray = call_user_func($good);
            $newMaxLengthArray[$maxField] = substr($string, 1, $maxLength + 1);
            $new = $table->newEntity($newMaxLengthArray);
            TestCase::assertFalse($table->save($new));
        }
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
     */
    protected function validateInitialise($expected, $table, $count, $dates = null)
    {
        $actual = $table->get(1)->toArray();

        foreach ($dates as $date) {
            $dateValue = $actual[$date];
            if (!is_null($dateValue)) {
                TestCase::assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
            }
            unset($actual[$date]);
        }

        TestCase::assertEquals($expected, $actual);

        $tableCount = $table->find('all')->count();
        TestCase::assertEquals($count, $tableCount);
    }
}
