<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 09/09/15
 * Time: 10:44
 */

use RDeLeo\MultiThreadScraper\Libraries\TestHelperTrait;
use RDeLeo\MultiThreadScraper\Core\MultiScraperFacade;


class MultiScraperFacadeTest extends PHPUnit_Framework_TestCase
{
    use TestHelperTrait;
    protected   $multiScraperFacade;
    protected   $threadNumber;
    protected   $reflectionClass;

    public function __construct()
    {
        $this->threadNumber = 1;
        $urlsArray = Array(
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=0',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=1',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=2',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=3',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=5',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=6',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=7',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=8',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=9',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=11',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=12',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=13',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=14',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=4',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=10',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28aka%7Caki%7Cbashi%7Cgawa%7Ckawa%7Cfuru%7Cfuku%7Cfuji%7Chana%7Chara%7Charu%7Chashi%7Chira%7Chon%7Choshi%7Cichi%7Ciwa%7Ckami%7Ckawa%7Cki%7Ckita%7Ckuchi%7Ckuro%7Cmarui%7Cmatsu%7Cmiya%7Cmori%7Cmoto%7Cmura%7Cnabe%7Cnaka%7Cnishi%7Cno%7Cda%7Cta%7Co%7Coo%7Coka%7Csaka%7Csaki%7Csawa%7Cshita%7Cshima%7Ci%7Csuzu%7Ctaka%7Ctake%7Cto%7Ctoku%7Ctoyo%7Cue%7Cwa%7Cwara%7Cwata%7Cyama%7Cyoshi%7Ckei%7Cko%7Czawa%7Czen%7Csen%7Cao%7Cgin%7Ckin%7Cken%7Cshiro%7Czaki%7Cyuki%7Casa%29%28%7C%7C%7C%7C%7C%7C%7C%7C%7C%7Cbashi%7Cgawa%7Ckawa%7Cfuru%7Cfuku%7Cfuji%7Chana%7Chara%7Charu%7Chashi%7Chira%7Chon%7Choshi%7Cchi%7Cwa%7Cka%7Ckami%7Ckawa%7Cki%7Ckita%7Ckuchi%7Ckuro%7Cmarui%7Cmatsu%7Cmiya%7Cmori%7Cmoto%7Cmura%7Cnabe%7Cnaka%7Cnishi%7Cno%7Cda%7Cta%7Co%7Coo%7Coka%7Csaka%7Csaki%7Csawa%7Cshita%7Cshima%7Csuzu%7Ctaka%7Ctake%7Cto%7Ctoku%7Ctoyo%7Cue%7Cwa%7Cwara%7Cwata%7Cyama%7Cyoshi%7Ckei%7Cko%7Czawa%7Czen%7Csen%7Cao%7Cgin%7Ckin%7Cken%7Cshiro%7Czaki%7Cyuki%7Csa%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28a%7Ci%7Cu%7Ce%7Co%7C%7C%7C%7C%7C%29%28ka%7Cki%7Cki%7Cku%7Cku%7Cke%7Cke%7Cko%7Cko%7Csa%7Csa%7Csa%7Cshi%7Cshi%7Cshi%7Csu%7Csu%7Cse%7Cso%7Cta%7Cta%7Cchi%7Cchi%7Ctsu%7Cte%7Cto%7Cna%7Cni%7Cni%7Cnu%7Cnu%7Cne%7Cno%7Cno%7Cha%7Chi%7Cfu%7Cfu%7Che%7Cho%7Cma%7Cma%7Cma%7Cmi%7Cmi%7Cmi%7Cmu%7Cmu%7Cmu%7Cmu%7Cme%7Cmo%7Cmo%7Cmo%7Cya%7Cyu%7Cyu%7Cyu%7Cyo%7Cra%7Cra%7Cra%7Cri%7Cru%7Cru%7Cru%7Cre%7Cro%7Cro%7Cro%7Cwa%7Cwa%7Cwa%7Cwa%7Cwo%7Cwo%29%28ka%7Cki%7Cki%7Cku%7Cku%7Cke%7Cke%7Cko%7Cko%7Csa%7Csa%7Csa%7Cshi%7Cshi%7Cshi%7Csu%7Csu%7Cse%7Cso%7Cta%7Cta%7Cchi%7Cchi%7Ctsu%7Cte%7Cto%7Cna%7Cni%7Cni%7Cnu%7Cnu%7Cne%7Cno%7Cno%7Cha%7Chi%7Cfu%7Cfu%7Che%7Cho%7Cma%7Cma%7Cma%7Cmi%7Cmi%7Cmi%7Cmu%7Cmu%7Cmu%7Cmu%7Cme%7Cmo%7Cmo%7Cmo%7Cya%7Cyu%7Cyu%7Cyu%7Cyo%7Cra%7Cra%7Cra%7Cri%7Cru%7Cru%7Cru%7Cre%7Cro%7Cro%7Cro%7Cwa%7Cwa%7Cwa%7Cwa%7Cwo%7Cwo%29%28%7C%28ka%7Cki%7Cki%7Cku%7Cku%7Cke%7Cke%7Cko%7Cko%7Csa%7Csa%7Csa%7Cshi%7Cshi%7Cshi%7Csu%7Csu%7Cse%7Cso%7Cta%7Cta%7Cchi%7Cchi%7Ctsu%7Cte%7Cto%7Cna%7Cni%7Cni%7Cnu%7Cnu%7Cne%7Cno%7Cno%7Cha%7Chi%7Cfu%7Cfu%7Che%7Cho%7Cma%7Cma%7Cma%7Cmi%7Cmi%7Cmi%7Cmu%7Cmu%7Cmu%7Cmu%7Cme%7Cmo%7Cmo%7Cmo%7Cya%7Cyu%7Cyu%7Cyu%7Cyo%7Cra%7Cra%7Cra%7Cri%7Cru%7Cru%7Cru%7Cre%7Cro%7Cro%7Cro%7Cwa%7Cwa%7Cwa%7Cwa%7Cwo%7Cwo%29%7C%28ka%7Cki%7Cki%7Cku%7Cku%7Cke%7Cke%7Cko%7Cko%7Csa%7Csa%7Csa%7Cshi%7Cshi%7Cshi%7Csu%7Csu%7Cse%7Cso%7Cta%7Cta%7Cchi%7Cchi%7Ctsu%7Cte%7Cto%7Cna%7Cni%7Cni%7Cnu%7Cnu%7Cne%7Cno%7Cno%7Cha%7Chi%7Cfu%7Cfu%7Che%7Cho%7Cma%7Cma%7Cma%7Cmi%7Cmi%7Cmi%7Cmu%7Cmu%7Cmu%7Cmu%7Cme%7Cmo%7Cmo%7Cmo%7Cya%7Cyu%7Cyu%7Cyu%7Cyo%7Cra%7Cra%7Cra%7Cri%7Cru%7Cru%7Cru%7Cre%7Cro%7Cro%7Cro%7Cwa%7Cwa%7Cwa%7Cwa%7Cwo%7Cwo%29%28%7C%28ka%7Cki%7Cki%7Cku%7Cku%7Cke%7Cke%7Cko%7Cko%7Csa%7Csa%7Csa%7Cshi%7Cshi%7Cshi%7Csu%7Csu%7Cse%7Cso%7Cta%7Cta%7Cchi%7Cchi%7Ctsu%7Cte%7Cto%7Cna%7Cni%7Cni%7Cnu%7Cnu%7Cne%7Cno%7Cno%7Cha%7Chi%7Cfu%7Cfu%7Che%7Cho%7Cma%7Cma%7Cma%7Cmi%7Cmi%7Cmi%7Cmu%7Cmu%7Cmu%7Cmu%7Cme%7Cmo%7Cmo%7Cmo%7Cya%7Cyu%7Cyu%7Cyu%7Cyo%7Cra%7Cra%7Cra%7Cri%7Cru%7Cru%7Cru%7Cre%7Cro%7Cro%7Cro%7Cwa%7Cwa%7Cwa%7Cwa%7Cwo%7Cwo%29%29%29%28%7C%7C%7Cn%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28zh%7Cx%7Cq%7Csh%7Ch%29%28ao%7Cian%7Cuo%7Cou%7Cia%29%28%7C%28l%7Cw%7Cc%7Cp%7Cb%7Cm%29%28ao%7Cian%7Cuo%7Cou%7Cia%29%28%7Cn%29%7C-%28l%7Cw%7Cc%7Cp%7Cb%7Cm%29%28ao%7Cian%7Cuo%7Cou%7Cia%29%28%7C%28d%7Cj%7Cq%7Cl%29%28a%7Cai%7Ciu%7Cao%7Ci%29%29%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%3Cs%3Cv%7CV%3E%28tia%29%7Cs%3Cv%7CV%3E%28os%29%7CB%3Cv%7CV%3Ec%28ios%29%7CB%3Cv%7CV%3E%3Cc%7CC%3Ev%28ios%7Cos%29%3E',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%27%29%7C%29%28a%7Ce%7Ci%7Co%7Cu%29%28%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%27%29%7C%29%28a%7Ce%7Ci%7Co%7Cu%29%28%28%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%27%29%7C%29%28a%7Ce%7Ci%7Co%7Cu%29%7C%29%28%28%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%27%29%7C%29%28a%7Ce%7Ci%7Co%7Cu%29%7C%29%28%28%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%27%29%7C%29%28a%7Ce%7Ci%7Co%7Cu%29%7C%29%28%28%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%27%29%7C%29%28a%7Ce%7Ci%7Co%7Cu%29%7C%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%29%28a%7Ce%7Ci%7Co%7Cu%7Ca%27%7Ce%27%7Ci%27%7Co%27%7Cu%27%7Cae%7Cai%7Cao%7Cau%7Coi%7Cou%7Ceu%7Cei%29%28k%7Cl%7Cm%7Cn%7Cp%7C%29%7C%29%28h%7Ck%7Cl%7Cm%7Cn%7Cp%7Cw%7C%29%28a%7Ce%7Ci%7Co%7Cu%7Ca%27%7Ce%27%7Ci%27%7Co%27%7Cu%27%7Cae%7Cai%7Cao%7Cau%7Coi%7Cou%7Ceu%7Cei%29%28k%7Cl%7Cm%7Cn%7Cp%7C%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=sv%28nia%7Clia%7Ccia%7Csia%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%3C%3Cs%7Css%3E%7C%3CVC%7CvC%7CB%7CBVs%7CVs%3E%3E%3Cv%7CV%7Cv%7C%3Cv%28l%7Cn%7Cr%29%7Cvc%3E%3E%28th%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=c%27%3Cs%7Ccvc%3E',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%3Ci%7Cs%3Ev%28mon%7Cchu%7Czard%7Crtle%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28%7C%28%3CB%3E%7Cs%7Ch%7Cty%7Cph%7Cr%29%29%28i%7Cae%7Cya%7Cae%7Ceu%7Cia%7Ci%7Ceo%7Cai%7Ca%29%28lo%7Cla%7Csri%7Cda%7Cdai%7Cthe%7Csty%7Clae%7Cdue%7Cli%7Clly%7Cri%7Cna%7Cral%7Csur%7Crith%29%28%7C%28su%7Cnu%7Csti%7Cllo%7Cria%7C%29%29%28%7C%28n%7Cra%7Cp%7Cm%7Clis%7Ccal%7Cdeu%7Cdil%7Csuir%7Cphos%7Cru%7Cdru%7Crin%7Craap%7Crgue%29%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28cham%7Cchan%7Cjisk%7Clis%7Cfrich%7Cisk%7Class%7Cmind%7Csond%7Csund%7Cass%7Cchad%7Clirt%7Cund%7Cmar%7Clis%7Cil%7C%3CBVC%3E%29%28jask%7Cast%7Cista%7Cadar%7Cirra%7Cim%7Cossa%7Cassa%7Cosia%7Cilsa%7C%3CvCv%3E%29%28%7C%28an%7Cya%7Cla%7Csta%7Csda%7Csya%7Cst%7Cnya%29%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28ch%7Cch%27t%7Csh%7Ccal%7Cval%7Cell%7Char%7Cshar%7Cshal%7Crel%7Claen%7Cral%7Cjh%27t%7Calr%7Cch%7Cch%27t%7Cav%29%28%7C%28is%7Cal%7Cow%7Cish%7Cul%7Cel%7Car%7Ciel%29%29%28aren%7Caeish%7Caith%7Ceven%7Cadur%7Culash%7Calith%7Catar%7Caia%7Cerin%7Caera%7Cael%7Cira%7Ciel%7Cahur%7Cishul%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28ethr%7Cqil%7Cmal%7Cer%7Ceal%7Cfar%7Cfil%7Cfir%7Cing%7Cind%7Cil%7Clam%7Cquel%7Cquar%7Cquan%7Cqar%7Cpal%7Cmal%7Cyar%7Cum%7Card%7Cenn%7Cey%29%28%7C%28%3Cvc%3E%7Con%7Cus%7Cun%7Car%7Cas%7Cen%7Cir%7Cur%7Cat%7Col%7Cal%7Can%29%29%28uard%7Cwen%7Carn%7Con%7Cil%7Cie%7Con%7Ciel%7Crion%7Crian%7Can%7Cista%7Crion%7Crian%7Ccil%7Cmol%7Cyon%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28taith%7Ckach%7Cchak%7Ckank%7Ckjar%7Crak%7Ckan%7Ckaj%7Ctach%7Crskal%7Ckjol%7Cjok%7Cjor%7Cjad%7Ckot%7Ckon%7Cknir%7Ckror%7Ckol%7Ctul%7Crhaok%7Crhak%7Ckrol%7Cjan%7Ckag%7Cryr%29%28%3Cvc%3E%7Cin%7Cor%7Can%7Car%7Coch%7Cun%7Cmar%7Cyk%7Cja%7Carn%7Cir%7Cros%7Cror%29%28%7C%28mund%7Card%7Carn%7Ckarr%7Cchim%7Ckos%7Crir%7Carl%7Ckni%7Cvar%7Can%7Cin%7Cir%7Ca%7Ci%7Cas%29%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28aj%7Cch%7Cetz%7Cetzl%7Ctz%7Ckal%7Cgahn%7Ckab%7Caj%7Cizl%7Cts%7Cjaj%7Clan%7Ckach%7Cchaj%7Cqaq%7Cjol%7Cix%7Caz%7Cbiq%7Cnam%29%28%7C%28%3Cvc%3E%7Caw%7Cal%7Cyes%7Cil%7Cay%7Cen%7Ctom%7C%7Coj%7Cim%7Col%7Caj%7Can%7Cas%29%29%28aj%7Cam%7Cal%7Caqa%7Cende%7Celja%7Cich%7Cak%7Cix%7Cin%7Cak%7Cal%7Cil%7Cek%7Cij%7Cos%7Cal%7Cim%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28yi%7Cshu%7Ca%7Cbe%7Cna%7Cchi%7Ccha%7Ccho%7Cksa%7Cyi%7Cshu%29%28th%7Cdd%7Cjj%7Csh%7Crr%7Cmk%7Cn%7Crk%7Cy%7Cjj%7Cth%29%28us%7Cash%7Ceni%7Cakra%7Cnai%7Cral%7Cect%7Care%7Cel%7Curru%7Caja%7Cal%7Cuz%7Cict%7Carja%7Cichi%7Cural%7Ciru%7Caki%7Cesh%29',
            'http://www.rinkworks.com/namegen/fnames.cgi?d=1&f=%28syth%7Csith%7Csrr%7Csen%7Cyth%7Cssen%7Cthen%7Cfen%7Cssth%7Ckel%7Csyn%7Cest%7Cbess%7Cinth%7Cnen%7Ctin%7Ccor%7Csv%7Ciss%7Cith%7Csen%7Cslar%7Cssil%7Csthen%7Csvis%7Cs%7Css%7Cs%7Css%29%28%7C%28tys%7Ceus%7Cyn%7Cof%7Ces%7Cen%7Cath%7Celth%7Cal%7Cell%7Cka%7Cith%7Cyrrl%7Cis%7Cisl%7Cyr%7Cast%7Ciy%29%29%28us%7Cyn%7Cen%7Cens%7Cra%7Crg%7Cle%7Cen%7Cith%7Cast%7Czon%7Cin%7Cyn%7Cys%29'
        );
        $csvFileName = date('Y-m-d_H-i-s.', time())."_ScraperTest01.csv";
        $csvFilePath = "/var/www/html/MultiThreadScraper/assets/";

        try{
            $this->multiScraperFacade   = new MultiScraperFacade($this->threadNumber, $urlsArray, $csvFileName, $csvFilePath);
            $this->reflectionClass      = new \ReflectionClass(get_class($this->multiScraperFacade));
        } catch(\Exception $e) {
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }

    }

    public function __destruct()
    {
        unset($this->multiScraperFacade);
        unset($this->reflectionClass);
    }

    public function testRoundUp()
    {
        echo $this->startTest(__METHOD__);
        try {
            $method = $this->reflectionClass->getMethod("roundUp");
            $method->setAccessible(true);
            $parameters01 = Array(4.2);
            $parameters02 = Array(4.8);
            $result01 = $method->invokeArgs($this->multiScraperFacade, $parameters01);
            $result02 = $method->invokeArgs($this->multiScraperFacade, $parameters02);

            $this->assertEquals(5, $result01);
            $this->assertEquals(5, $result02);
            echo ".. Result01    : ".$result01."\n";
            echo ".. Result02    : ".$result02."\n";
        } catch (\Exception $e) {
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }
        unset($method);
        echo $this->endTest();
    }

    public function testProcessUrls()
    {
        echo $this->startTest(__METHOD__);
        try {
            $method = $this->reflectionClass->getMethod("processUrls");
            $method->setAccessible(true);
            $parameters = Array("");
            $method->invokeArgs($this->multiScraperFacade, $parameters);

            $reflectionProperty = $this->reflectionClass->getProperty('urlsPerThread');
            $reflectionProperty->setAccessible(true);
            $urlsPerThread = $reflectionProperty->getValue($this->multiScraperFacade);
            $count = count($urlsPerThread);
            $reflectionProperty = $this->reflectionClass->getProperty('threadNumber');
            $reflectionProperty->setAccessible(true);
            $newThreadNumber = $reflectionProperty->getValue($this->multiScraperFacade);

            echo ".. Thread requested : ".$this->threadNumber."\n";
            echo ".. Thread used      : ".$newThreadNumber."\n";
            echo ".. UrlGroups        : ".$count."\n";
            $this->assertEquals($newThreadNumber, $count);

        } catch (\Exception $e) {
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";

        }
        unset($method);
        unset($reflectionProperty);
        echo $this->endTest();
    }

    public function testExecute()
    {
        echo $this->startTest(__METHOD__);
        try {
            $this->multiScraperFacade->execute();
            $arrayResults = $this->reflectionClass->getProperty('results')->getValue($this->multiScraperFacade);
            $countResults = 0;
            foreach($arrayResults AS $results)
            {
                $countResults = $countResults + count($results);
            }
            echo ".. Expected results : 3927\n";
            echo ".. Results          : ".$countResults."\n";
            $this->assertEquals(3927, $countResults);
        } catch (\Exception $e) {
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }
        echo $this->endTest();
    }
}