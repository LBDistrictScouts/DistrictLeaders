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
            'None Prov: ADC with Brackets' => 'Assistant District Commissioner (Scouts)',
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

    public function provideTransposedCleanRole(): array
    {
        return [
            'ADC Cubs' => [
                'Assistant District Commissioner (Section) - Cub Scouts',
                'Assistant District Commissioner (Cub Scouts)',
            ],
            'ADC Scouts' => [
                'Assistant District Commissioner (Section) - Scouts',
                'Assistant District Commissioner (Scouts)',
            ],
            'ABSL' => [
                'Assistant Section Leader - Beaver Scouts',
                'Assistant Beaver Scout Leader',
            ],
            'ACSL' => [
                'Assistant Section Leader - Cub Scouts',
                'Assistant Cub Scout Leader',
            ],
            'AESL' => [
                'Assistant Section Leader - Explorer Scouts',
                'Assistant Explorer Scout Leader',
            ],
            'ASL' => [
                'Assistant Section Leader - Scouts',
                'Assistant Scout Leader',
            ],
            'BSL' => [
                'Section Leader - Beaver Scouts',
                'Beaver Scout Leader',
            ],
            'CSL' => [
                'Section Leader - Cub Scouts',
                'Cub Scout Leader',
            ],
            'ESL' => [
                'Section Leader - Explorer Scouts',
                'Explorer Scout Leader',
            ],
            'SL' => [
                'Section Leader - Scouts',
                'Scout Leader',
            ],
            'BSA' => [
                'Section Assistant - Beaver Scouts',
                'Beaver Scout Section Assistant',
            ],
            'CSA' => [
                'Section Assistant - Cub Scouts',
                'Cub Scout Section Assistant',
            ],
            'SSA' => [
                'Section Assistant - Scouts',
                'Scout Section Assistant',
            ],
        ];
    }

    /**
     * Test _getApplicableModel method
     *
     * @param string|null $roleValue The Complex String
     * @param string|null $expected The Output
     * @dataProvider provideTransposedCleanRole
     * @return void
     */
    public function testGetTransposedCleanRole(?string $roleValue, ?string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_ROLE, $roleValue);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_CLEAN_ROLE);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideSectionCleanRole(): array
    {
        return [
            'ADC Cubs' => [
                'Assistant District Commissioner (Section)',
                '2nd Baldock - Cub Scout 1',
                'Assistant District Commissioner (Cubs)',
            ],
            'ADC Scouts' => [
                'Assistant District Commissioner (Section)',
                '2nd Baldock - Scout 1',
                'Assistant District Commissioner (Scouts)',
            ],
            'ABSL' => [
                'Assistant Section Leader',
                '2nd Baldock - Beaver Scout 1',
                'Assistant Beaver Scout Leader',
            ],
            'ACSL' => [
                'Assistant Section Leader',
                '2nd Baldock - Cub Scout 1',
                'Assistant Cub Scout Leader',
            ],
            'AESL' => [
                'Assistant Section Leader',
                'Letchworth And Baldock - Oak Eagle Explorer Unit',
                'Assistant Explorer Scout Leader',
            ],
            'ASL' => [
                'Assistant Section Leader',
                '2nd Baldock - Scout 1',
                'Assistant Scout Leader',
            ],
            'BSL' => [
                'Section Leader',
                '2nd Baldock - Beaver Scout 1',
                'Beaver Scout Leader',
            ],
            'CSL' => [
                'Section Leader',
                '2nd Baldock - Cub Scout 1',
                'Cub Scout Leader',
            ],
            'ESL' => [
                'Section Leader',
                'Letchworth And Baldock - Oak Eagle Explorer Unit',
                'Explorer Scout Leader',
            ],
            'SL' => [
                'Section Leader',
                '2nd Baldock - Scout 1',
                'Scout Leader',
            ],
            'BSA' => [
                'Section Assistant',
                '2nd Baldock - Beaver Scout 1',
                'Beaver Scout Section Assistant',
            ],
            'CSA' => [
                'Section Assistant',
                '2nd Baldock - Cub Scout 1',
                'Cub Scout Section Assistant',
            ],
            'SSA' => [
                'Section Assistant',
                '2nd Baldock - Scout 1',
                'Scout Section Assistant',
            ],
        ];
    }

    /**
     * Test _getApplicableModel method
     *
     * @param string $roleValue The Complex String
     * @param string $sectionType The Section Type Context
     * @param string $expected The Output
     * @return void
     * @dataProvider provideSectionCleanRole
     */
    public function testGetSectionCleanRole(string $roleValue, string $sectionType, string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_ROLE, $roleValue);
        $this->CompassRecord->set(CompassRecord::FIELD_LOCATION, $sectionType);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_CLEAN_ROLE);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideCleanGroup(): array
    {
        return [
            'Null Name' => [
                null,
                null,
            ],
            'Double Group' => [
                'Letchworth And Baldock - Letchworth and Baldock - Scout Network',
                'Letchworth And Baldock',
            ],
            'Simple Group' => [
                '11th Letchworth',
                '11th Letchworth',
            ],
            'SAS' => [
                'Letchworth And Baldock - Active Support Unit 1',
                'Letchworth And Baldock',
            ],
            'Double National' => [
                'UK Scout Network - UK Scout Network - Scout Network',
                'UK Scout Network',
            ],
            'County Section' => [
                'Hertfordshire - Mountaineering',
                'Hertfordshire',
            ],
            'Bracketed Group' => [
                '16th Hitchin (St Faiths) - Cub Scout 1',
                '16th Hitchin',
            ],
            'Complex Group' => [
                '7th Letchworth St.Thomas A\'Becket',
                '7th Letchworth',
            ],
            'Complex Bracketed Group' => [
                '2nd Ware (St. Mary\'s) - Thundridge Beaver Colony',
                '2nd Ware',
            ],
            'St Bracketed' => [
                '4th Letchworth (St Pauls)',
                '4th Letchworth',
            ],
            'Group Section' => [
                '5th Letchworth - Cub Scout 1',
                '5th Letchworth',
            ],
        ];
    }

    /**
     * Test _getCrudFunction method
     *
     * @param string|null $location The Complex String
     * @param string|null $expected The output
     * @dataProvider provideCleanGroup
     * @return void
     */
    public function testGetCleanGroup(?string $location, ?string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_LOCATION, $location);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_CLEAN_GROUP);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideCleanSection(): array
    {
        $data = $this->provideCleanSectionType();

        $mapReplace = [
            'Double District Network' => 'Letchworth And Baldock Scout Network',
            'Simple Group' => '11th Letchworth Group',
            'SAS' => 'Letchworth And Baldock Scout Active Support',
            'Double National Network' => 'UK Scout Network',
            'County Section' => 'Hertfordshire Mountaineering',
            'Apostrophe Group' => '16th Hitchin Cubs',
            'Apostrophe Renamed Group' => '7th Letchworth Cubs',
            'Bracketed Group' => '7th Letchworth Beavers',
            'Standard Cub Section' => '5th Letchworth Cubs',
            'Simple Group Section' => '2nd Baldock Group',
            'Complex Group Section' => '7th Letchworth Group',
            'Bracketed Group Section' => '4th Letchworth Group',
            'Renamed Beaver Standard Section' => '4th Letchworth Beavers',
            'Renamed Cub Standard Section' => '4th Letchworth Cubs',
            'Renamed Scout Section' => '4th Letchworth Scouts',
            'Renamed Specific Cub Section' => '1st Baldock Knights',
            'Renamed Specific Second Cub Section' => '1st Baldock Templars',
        ];

        foreach ($mapReplace as $index => $replace) {
            $data[$index][1] = $replace;
        }

        return $data;
    }

    /**
     * Test _getCrudFunction method
     *
     * @param string|null $location The Complex String
     * @param string|null $expected The output
     * @dataProvider provideCleanSection
     * @return void
     */
    public function testGetCleanSection(?string $location, ?string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_LOCATION, $location);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_CLEAN_SECTION);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideCleanSectionType(): array
    {
        return [
            'Null Name' => [
                null,
                null,
            ],
            'Double District Network' => [
                'Letchworth And Baldock - Letchworth and Baldock - Scout Network',
                'Scout Network',
            ],
            'Simple Group' => [
                '11th Letchworth',
                'Group',
            ],
            'SAS' => [
                'Letchworth And Baldock - Active Support Unit 1',
                'Scout Active Support',
            ],
            'Double National Network' => [
                'UK Scout Network - UK Scout Network - Scout Network',
                'Scout Network',
            ],
            'County Section' => [
                'Hertfordshire - Mountaineering',
                'Mountaineering',
            ],
            'Apostrophe Group' => [
                '16th Hitchin (St Faiths) - Cub Scout 1',
                'Cubs',
            ],
            'Apostrophe Renamed Group' => [
                '7th Letchworth St.Thomas A\'Becket - Cub Scout 1',
                'Cubs',
            ],
            'Bracketed Group' => [
                '7th Letchworth St.Thomas A\'Becket - 7th Letchworth Beavers',
                'Beavers',
            ],
            'Standard Cub Section' => [
                '5th Letchworth - Cub Scout 1',
                'Cubs',
            ],
            'Simple Group Section' => [
                '2nd Baldock',
                'Group',
            ],
            'Complex Group Section' => [
                '7th Letchworth St.Thomas A\'Becket',
                'Group',
            ],
            'Bracketed Group Section' => [
                '4th Letchworth (St Pauls)',
                'Group',
            ],
            'Renamed Beaver Standard Section' => [
                '4th Letchworth (St Pauls) - Beaver Section',
                'Beavers',
            ],
            'Renamed Cub Standard Section' => [
                '4th Letchworth (St Pauls) - Cub Section',
                'Cubs',
            ],
            'Renamed Scout Section' => [
                '4th Letchworth (St Pauls) - Scout Section',
                'Scouts',
            ],
            'Renamed Specific Cub Section' => [
                '1st Baldock - 1st Baldock Knights',
                'Cubs',
            ],
            'Renamed Specific Second Cub Section' => [
                '1st Baldock - 1st Baldock Templars',
                'Cubs',
            ],
        ];
    }

    /**
     * Test _getCleanSectionType method
     *
     * @param string|null $location The Complex String
     * @param string|null $expected The output
     * @dataProvider provideCleanSectionType
     * @return void
     */
    public function testGetCleanSectionType(?string $location, ?string $expected): void
    {
        $this->CompassRecord->set(CompassRecord::FIELD_LOCATION, $location);
        $fieldValue = $this->CompassRecord->get(CompassRecord::FIELD_CLEAN_SECTION_TYPE);
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
