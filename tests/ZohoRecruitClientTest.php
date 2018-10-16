<?php
/**
 * This file is part of the Apora.ZohoRecruitClient
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace Apora\ZohoRecruitClient;

use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;
use PHPUnit\Framework\TestCase;

class ZohoRecruitClientTest extends TestCase
{
    const TEST_INI_FILE = 'zoho-recruit-test.ini';

    /** @var ZohoRecruitClient */
    protected static $zohoRecruitClient;

    protected static $testRecordId;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        /*$ini_properties = parse_ini_file(self::TEST_INI_FILE);

        self::$zohoRecruitClient = new ZohoRecruitClient(
            $ini_properties['module'],
            $ini_properties['authtoken']
        );*/

        self::$zohoRecruitClient = new ZohoRecruitClient('', '');

        /*self::$testRecordId = $ini_properties['record_id'];*/
    }

    public function testIsInstanceOfZohoRecruitClient()
    {
        $actual = self::$zohoRecruitClient;
        $this->assertInstanceOf(ZohoRecruitClient::class, $actual);
    }

    /*public function testGetRecords()
    {
        $actual = ZohoRecruitClientTest::$zohoRecruitClient->getRecords()->request();
        $this->assertContainsOnlyInstancesOf(Record::class, $actual);
    }

    public function testGetRecordById()
    {
        $actual = ZohoRecruitClientTest::$zohoRecruitClient
            ->getRecordById(ZohoRecruitClientTest::$testRecordId)
            ->request();
        $this->assertContainsOnlyInstancesOf(Record::class, $actual);
        $this->assertEquals(1, sizeof($actual));
        $this->assertEquals(ZohoRecruitClientTest::$testRecordId, $actual[1]->get('JOBOPENINGID'));
    }

    public function testAddRecords()
    {

        $actual = ZohoRecruitClientTest::$zohoRecruitClient
            ->addRecords()
            ->addRecord(array(
                'Posting Title' => 'Test Position',
                'Department' => 'IT',
                'Assigned Recruiter' => 'Tester',
                'Job description' => 'Test',
                'Client Name' => 'Test',
                'Company Description' => 'Mobile web and app development.',
                'Country' => 'Portugal'
            ))
            ->request();

        $this->assertContainsOnlyInstancesOf(Result::class, $actual);
        $this->assertEquals(1, sizeof($actual));
    }

    public function testUpdateRecords()
    {

        $actual = ZohoRecruitClientTest::$zohoRecruitClient
            ->updateRecords()
            ->addRecord(array(
                'Id' => ZohoRecruitClientTest::$testRecordId,
                'Posting Title' => 'Test'
            ))
            ->request();

        $this->assertContainsOnlyInstancesOf(Result::class, $actual);
        $this->assertEquals(1, sizeof($actual));
    }*/

    /*public function testUploadFile()
    {
        $actual = self::$zohoRecruitClient
            ->uploadFile()
            ->id(self::$testRecordId)
            ->type('Attach resume')
            ->uploadFromPath(__DIR__ . '/Profile.pdf', 'pp.pdf')
            ->request();
        print_r($actual);
    }*/
}
