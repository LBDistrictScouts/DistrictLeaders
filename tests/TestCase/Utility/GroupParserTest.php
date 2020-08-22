<?php
declare(strict_types=1);

namespace App\Test\TestCase\Utility;

use App\Utility\GroupParser;
use Cake\TestSuite\TestCase;

/**
 * Class TextSafeTest
 *
 * @package App\Test\TestCase\Utility
 */
class GroupParserTest extends TestCase
{
    public function provideParseSection(): array
    {
        return [
            'Double District Network' => [
                'Scout Network',
                'Letchworth And Baldock',
                'Scout Network',
            ],
            'Simple Group' => [
                '11th Letchworth',
                '11th Letchworth',
                '11th Letchworth',
            ],
            'SAS' => [
                'Active Support Unit 1',
                'Letchworth And Baldock',
                'Scout Active Support',
            ],
            'Double National Network' => [
                'Scout Network',
                'UK Scout Network',
                'Scout Network',
            ],
            'County Section' => [
                'Mountaineering',
                'Hertfordshire',
                'Mountaineering',
            ],
            'Apostrophe Group' => [
                'Cub Scout 1',
                '16th Hitchin',
                'Cubs',
            ],
            'Apostrophe Renamed Group' => [
                'Cub Scout 1',
                '7th Letchworth',
                'Cubs',
            ],
            'Bracketed Group' => [
                '7th Letchworth Beavers',
                '7th Letchworth',
                'Beavers',
            ],
            'Standard Cub Section' => [
                'Cub Scout 1',
                '5th Letchworth',
                'Cubs',
            ],
            'Complex Group Section' => [
                '7th Letchworth St.Thomas A\'Becket',
                '7th Letchworth',
                '7th Letchworth',
            ],
            'Bracketed Group Section' => [
                '4th Letchworth (St Pauls)',
                '4th Letchworth',
                '4th Letchworth',
            ],
            'Renamed Beaver Standard Section' => [
                'Beaver Section',
                '4th Letchworth',
                'Beavers',
            ],
            'Renamed Cub Standard Section' => [
                'Cub Section',
                '4th Letchworth',
                'Cubs',
            ],
            'Renamed Scout Section' => [
                'Scout Section',
                '4th Letchworth',
                'Scouts',
            ],
            'Renamed Specific Cub Section' => [
                '1st Baldock Knights',
                '1st Baldock',
                'Knights',
            ],
            'Renamed Specific Second Cub Section' => [
                '1st Baldock Templars',
                '1st Baldock',
                'Templars',
            ],
            'Explorers' => [
                'Oak Eagle Explorer Unit',
                'Letchworth And Baldock',
                'Oak Eagle Explorer Unit',
            ],
        ];
    }

    /**
     * Test Parse Section method
     *
     * @param string $section The Complex String
     * @param string $group The Context Group
     * @param string $expected The output
     * @return void
     * @dataProvider provideParseSection
     */
    public function testParseSection(string $section, string $group, string $expected): void
    {
        $fieldValue = GroupParser::parseSection($section, $group);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideAliasGroup(): array
    {
        return [
            'District' => [
                'Letchworth And Baldock',
                'Letchworth And Baldock',
            ],
            'Simple Group' => [
                '11th Letchworth',
                '11th Letchworth',
            ],
            'County' => [
                'Hertfordshire',
                'Hertfordshire',
            ],
            'Bracketed Group' => [
                '16th Hitchin (St Faiths)',
                '16th Hitchin',
            ],
            'Complex Group' => [
                '7th Letchworth St.Thomas A\'Becket',
                '7th Letchworth',
            ],
            'Complex Bracketed Group' => [
                '2nd Ware (St. Mary\'s)',
                '2nd Ware',
            ],
            'St Bracketed' => [
                '4th Letchworth (St Pauls)',
                '4th Letchworth',
            ],
        ];
    }

    /**
     * Test Alias Group method
     *
     * @param string $group The Complex String
     * @param string $expected The output
     * @dataProvider provideAliasGroup
     * @return void
     */
    public function testAliasGroup(string $group, string $expected): void
    {
        $fieldValue = GroupParser::aliasGroup($group);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideAliasSectionType(): array
    {
        return [
            'District' => [
                'Letchworth And Baldock',
                'District',
            ],
            'Simple Group' => [
                '11th Letchworth',
                '11th Letchworth',
            ],
            'County' => [
                'Hertfordshire',
                'County',
            ],
            'Renamed Specific Cub Section' => [
                'Knights',
                'Cubs',
            ],
            'Renamed Specific Second Cub Section' => [
                'Templars',
                'Cubs',
            ],
            'Explorers' => [
                'Oak Eagle Explorer Unit',
                'Explorers',
            ],
            'ASU' => [
                'Scout and Guide Graduate Association (SAGGA) ASU',
                'Scout Active Support',
            ],
            'UK Scout Network' => [
                'UK Scout Network',
                'Scout Network',
            ],
        ];
    }

    /**
     * Test Alias Section Type method
     *
     * @param string $group The Complex String
     * @param string $expected The output
     * @dataProvider provideAliasSectionType
     * @return void
     */
    public function testAliasSectionType(string $group, string $expected): void
    {
        $fieldValue = GroupParser::aliasSectionType($group);
        TestCase::assertSame($expected, $fieldValue);
    }

    public function provideSectionCleanRole(): array
    {
        return [
            'ADC Cubs' => [
                'Assistant District Commissioner (Section)',
                'Cubs',
                'Assistant District Commissioner (Cubs)',
            ],
            'ADC Scouts' => [
                'Assistant District Commissioner (Section)',
                'Scouts',
                'Assistant District Commissioner (Scouts)',
            ],
            'ABSL' => [
                'Assistant Section Leader',
                'Beavers',
                'Assistant Beaver Scout Leader',
            ],
            'ACSL' => [
                'Assistant Section Leader',
                'Cubs',
                'Assistant Cub Scout Leader',
            ],
            'AESL' => [
                'Assistant Section Leader',
                'Explorers',
                'Assistant Explorer Scout Leader',
            ],
            'ASL' => [
                'Assistant Section Leader',
                'Scouts',
                'Assistant Scout Leader',
            ],
            'BSL' => [
                'Section Leader',
                'Beavers',
                'Beaver Scout Leader',
            ],
            'CSL' => [
                'Section Leader',
                'Cubs',
                'Cub Scout Leader',
            ],
            'ESL' => [
                'Section Leader',
                'Explorers',
                'Explorer Scout Leader',
            ],
            'SL' => [
                'Section Leader',
                'Scouts',
                'Scout Leader',
            ],
            'BSA' => [
                'Section Assistant',
                'Beavers',
                'Beaver Scout Section Assistant',
            ],
            'CSA' => [
                'Section Assistant',
                'Cubs',
                'Cub Scout Section Assistant',
            ],
            'SSA' => [
                'Section Assistant',
                'Scouts',
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
    public function testParseRole(string $roleValue, string $sectionType, string $expected): void
    {
        $fieldValue = GroupParser::parseRole($roleValue, $sectionType);
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
     * @param string $roleValue The Complex String
     * @param string $expected The Output
     * @return void
     * @dataProvider provideTransposedCleanRole
     */
    public function testTransposedParseRole(string $roleValue, string $expected): void
    {
        $fieldValue = GroupParser::parseRole($roleValue, null);
        TestCase::assertSame($expected, $fieldValue);
    }
}
