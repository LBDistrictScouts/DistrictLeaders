<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\CompassRecord;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Capability Test Case
 */
class CompassRecordTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\CompassRecord
     */
    public $CompassRecord;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->CompassRecord = new CompassRecord([
            CompassRecord::FIELD_DOCUMENT_VERSION_ID => 1,
            CompassRecord::FIELD_TITLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_FORENAMES => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_SURNAME => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE1 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE2 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE3 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_TOWN => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_COUNTY => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_POSTCODE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_COUNTRY => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ROLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_LOCATION => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_PHONE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_EMAIL => 'jacob@fish.com',
        ]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CompassRecord);

        parent::tearDown();
    }

    public function provideProvisional(): array
    {
        return [
            'Null Value' => [
                null,
                null,
            ],
            'Prov: SAS' => [
                'Scout Active Support Member (Prov)',
                true,
            ],
            'Prov: Youth Commissioner' => [
                'District Youth Commissioner (Prov)',
                true,
            ],
            'None Prov: Exec Committee' => [
                'District Executive Committee Member',
                false,
            ],
            'None Prov: ADC with Brackets' => [
                'Assistant District Commissioner (Section) - Scouts',
                false,
            ],
            'None Prov: President' => [
                'District President',
                false,
            ],
            'PreProv: Occasional' => [
                'District Occasional Helper (Pre-Prov)',
                true,
            ],
        ];
    }

    /**
     * Test _getCrudFunction method
     *
     * @param string|null $roleValue The Complex String
     * @param bool|null $expected The output
     * @dataProvider provideProvisional
     * @return void
     */
    public function testGetProvisional(?string $roleValue, ?bool $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_ROLE, $roleValue);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_PROVISIONAL);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideCleanRole(): array
    {
        $data = $this->provideProvisional();

        $replace = [
            'Prov: SAS' => 'Scout Active Support Member',
            'Prov: Youth Commissioner' => 'District Youth Commissioner',
            'None Prov: Exec Committee' => 'District Executive Committee Member',
            'None Prov: ADC with Brackets' => 'Assistant District Commissioner (Section)',
            'None Prov: President' => 'District President',
            'PreProv: Occasional' => 'District Occasional Helper',
        ];

        foreach (array_keys($data) as $index) {
            if (key_exists($index, $replace)) {
                $data[$index][1] = $replace[$index];
            }
        }

        return $data;
    }

    /**
     * Test _getApplicableModel method
     *
     * @param string|null $roleValue The Complex String
     * @param string|null $expected The Output
     * @dataProvider provideCleanRole
     * @return void
     */
    public function testGetCleanRole(?string $roleValue, ?string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_ROLE, $roleValue);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_CLEAN_ROLE);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideFirstName(): array
    {
        return [
            'Null Name' => [
                null,
                null,
            ],
            'Three Names' => [
                'Edward Charles Kyle',
                'Edward',
            ],
            'Two Names' => [
                'David Arthur',
                'David',
            ],
            'Hyphenated' => [
                'Joe-Dee',
                'Joe-Dee',
            ],
            'Hyphenated Two Names' => [
                'Lucy-May Gillian',
                'Lucy-May',
            ],
            'One Name' => [
                'Kimberly',
                'Kimberly',
            ],
        ];
    }

    /**
     * Test _getCrudFunction method
     *
     * @param string|null $forenameValue The Complex String
     * @param string|null $expected The output
     * @dataProvider provideFirstName
     * @return void
     */
    public function testGetFirstName(?string $forenameValue, ?string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_FORENAMES, $forenameValue);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_FIRST_NAME);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideLastName(): array
    {
        return [
            'Null Name' => [
                null,
                null,
            ],
            'Hyphenated' => [
                'Paleman-Brown',
                'Paleman-Brown',
            ],
            'Hyphenated Two Names' => [
                'Lucy-May Gillian',
                'Lucy-May Gillian',
            ],
            'One Name' => [
                'D\'Arcy',
                'D\'Arcy',
            ],
        ];
    }

    /**
     * Test _getCrudFunction method
     *
     * @param string|null $forenameValue The Complex String
     * @param string|null $expected The output
     * @dataProvider provideLastName
     * @return void
     */
    public function testGetLastName(?string $forenameValue, ?string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_SURNAME, $forenameValue);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_LAST_NAME);
        TestCase::assertSame($expected, $fieldValue);
    }
}
