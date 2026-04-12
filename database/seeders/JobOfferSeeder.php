<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    public function run(): void
    {
        $jobOffers = [
            [
                'title' => 'Junior Frontend Developer',
                'description' => 'Modern webalkalmazások fejlesztése React és TypeScript használatával.',
                'salary_min' => 450000,
                'salary_max' => 650000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd0ee0efd855180d0ec7',
                'company_id' => '69d3e338e0efd855180d0f06',
            ],
            [
                'title' => 'Backend PHP Developer',
                'description' => 'Laravel alapú rendszerek fejlesztése és karbantartása.',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'location' => 'Szeged',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd12e0efd855180d0ec8',
                'company_id' => '69d3e39be0efd855180d0f0b',
            ],
            [
                'title' => 'Full Stack Developer',
                'description' => 'Frontend és backend fejlesztési feladatok ellátása modern technológiákkal.',
                'salary_min' => 600000,
                'salary_max' => 1000000,
                'location' => 'Debrecen',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd1ae0efd855180d0ec9',
                'company_id' => '69d3e35be0efd855180d0f08',
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'CI/CD pipeline-ok kialakítása és felhő infrastruktúra kezelése.',
                'salary_min' => 700000,
                'salary_max' => 1200000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd23e0efd855180d0ecb',
                'company_id' => '69d3e3aae0efd855180d0f0c',
            ],
            [
                'title' => 'QA Engineer',
                'description' => 'Automatizált és manuális tesztelés végrehajtása.',
                'salary_min' => 400000,
                'salary_max' => 650000,
                'location' => 'Győr',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd27e0efd855180d0ecc',
                'company_id' => '69d3e37de0efd855180d0f0a',
            ],
            [
                'title' => 'Mobile App Developer',
                'description' => 'iOS és Android alkalmazások fejlesztése Flutter vagy React Native használatával.',
                'salary_min' => 550000,
                'salary_max' => 900000,
                'location' => 'Pécs',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd1fe0efd855180d0eca',
                'company_id' => '69d3e36be0efd855180d0f09',
            ],
            [
                'title' => 'Data Analyst',
                'description' => 'Adatok elemzése és riportok készítése üzleti döntések támogatására.',
                'salary_min' => 500000,
                'salary_max' => 750000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd43e0efd855180d0ed0',    // Data Scientist
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => 'Felhasználóbarát felületek tervezése és prototípusok készítése.',
                'salary_min' => 450000,
                'salary_max' => 700000,
                'location' => 'Szeged',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3ce05e0efd855180d0ee6',    // UI/UX designer
                'company_id' => '69d3e415e0efd855180d0f12', // WebCore Studio Kft.
            ],
            [
                'title' => 'System Administrator',
                'description' => 'Szerverek és hálózati rendszerek üzemeltetése.',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'location' => 'Miskolc',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd2ce0efd855180d0ecd',    // Rendszergazda
                'company_id' => '69d3e3f8e0efd855180d0f10', // IronGate Solutions Kft.
            ],
            [
                'title' => 'Cloud Engineer',
                'description' => 'AWS vagy Azure alapú rendszerek tervezése és karbantartása.',
                'salary_min' => 750000,
                'salary_max' => 1300000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd23e0efd855180d0ecb',    // DevOps mérnök
                'company_id' => '69d3e3dae0efd855180d0f0f', // CloudPeak Kft.
            ],
            [
                'title' => 'AI Engineer',
                'description' => 'Gépi tanulási modellek fejlesztése és integrálása.',
                'salary_min' => 800000,
                'salary_max' => 1400000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd49e0efd855180d0ed1',    // AI / Machine Learning mérnök
                'company_id' => '69d3e422e0efd855180d0f13', // FutureStack Kft.
            ],
            [
                'title' => 'Cybersecurity Specialist',
                'description' => 'Rendszerek biztonságának felügyelete és sebezhetőségek kezelése.',
                'salary_min' => 700000,
                'salary_max' => 1200000,
                'location' => 'Debrecen',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd4ce0efd855180d0ed2',    // Cybersecurity szakember
                'company_id' => '69d3e3f8e0efd855180d0f10', // IronGate Solutions Kft.
            ],
            [
                'title' => 'Business Analyst',
                'description' => 'Üzleti folyamatok elemzése és optimalizálása.',
                'salary_min' => 500000,
                'salary_max' => 850000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cdece0efd855180d0ee0',    // Üzletfejlesztő
                'company_id' => '69d3e349e0efd855180d0f07', // GreenLeaf Solutions Kft.
            ],
            [
                'title' => 'Java Developer',
                'description' => 'Nagyvállalati alkalmazások fejlesztése Java és Spring használatával.',
                'salary_min' => 650000,
                'salary_max' => 1100000,
                'location' => 'Szeged',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd12e0efd855180d0ec8',    // Backend fejlesztő
                'company_id' => '69d3e466e0efd855180d0f17', // DevHive Kft.
            ],
            [
                'title' => 'Game Developer',
                'description' => 'Játékok fejlesztése Unity vagy Unreal Engine használatával.',
                'salary_min' => 500000,
                'salary_max' => 900000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd1ae0efd855180d0ec9',    // Fullstack fejlesztő
                'company_id' => '69d3e44be0efd855180d0f15', // QuantumSoft Kft.
            ],
            [
                'title' => 'Product Manager',
                'description' => 'Termékfejlesztési folyamatok koordinálása és stratégia kialakítása.',
                'salary_min' => 800000,
                'salary_max' => 1300000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cde8e0efd855180d0edf',    // Projektmenedzser
                'company_id' => '69d3e422e0efd855180d0f13', // FutureStack Kft.
            ],
            [
                'title' => 'Technical Support Engineer',
                'description' => 'Ügyféltámogatás és technikai problémák megoldása.',
                'salary_min' => 400000,
                'salary_max' => 600000,
                'location' => 'Szeged',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd36e0efd855180d0ece',    // IT support
                'company_id' => '69d3e458e0efd855180d0f16', // LogicLane Kft.
            ],
            [
                'title' => 'Database Administrator',
                'description' => 'Adatbázisok kezelése, optimalizálása és karbantartása.',
                'salary_min' => 650000,
                'salary_max' => 1000000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd3ce0efd855180d0ecf',    // Adatmérnök (Data Engineer)
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'Scrum Master',
                'description' => 'Agilis csapatok támogatása és folyamatok facilitálása.',
                'salary_min' => 700000,
                'salary_max' => 1100000,
                'location' => 'Debrecen',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cde8e0efd855180d0edf',    // Projektmenedzser
                'company_id' => '69d3e35be0efd855180d0f08', // BlueWave Technologies Kft.
            ],
            [
                'title' => 'Embedded Systems Engineer',
                'description' => 'Beágyazott rendszerek fejlesztése és tesztelése.',
                'salary_min' => 600000,
                'salary_max' => 1000000,
                'location' => 'Győr',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cdc8e0efd855180d0ed7',    // Mechatronikai mérnök
                'company_id' => '69d3e37de0efd855180d0f0a', // NovaBuild Kft.
            ],
            [
                'title' => 'Senior React Developer',
                'description' => 'Dinamikusan fejlődő csapatunkba keresünk tapasztalt Senior React fejlesztőt. Feladataid közé tartozik komplex, nagy forgalmú webalkalmazások architektúrájának tervezése és implementálása React, TypeScript és Redux Toolkit segítségével. Elvárjuk a legalább 4 éves React tapasztalatot, a REST API és GraphQL ismeretét, valamint a CI/CD pipeline-ok kezelését. Előnyt jelent a Next.js ismerete és az agilis csapatokban szerzett tapasztalat. Cégünk rugalmas munkaidőt, versenyképes fizetést, konferencia-részvételi lehetőségeket és évi két alkalommal csapatépítőt kínál.',
                'salary_min' => 700000,
                'salary_max' => 1100000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd0ee0efd855180d0ec7',    // Frontend fejlesztő
                'company_id' => '69d3e415e0efd855180d0f12', // WebCore Studio Kft.
            ],
            [
                'title' => 'Python Backend Developer',
                'description' => 'A DataBridge Kft. Python fejlesztőt keres adatintenzív háttérrendszerek fejlesztéséhez. A pozíció magában foglalja REST API-k tervezését FastAPI vagy Django REST Framework alapokon, adatbázis-sémák optimalizálását PostgreSQL és Redis környezetben, valamint microservice architektúrák karbantartását. Elvárjuk a Python 3.x alapos ismeretét, SQL tapasztalatot és Docker-használatot. A cég rugalmas távmunkát, egészségpénztári juttatást és évi szakmai fejlesztési keretet biztosít.',
                'salary_min' => 600000,
                'salary_max' => 1000000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd12e0efd855180d0ec8',    // Backend fejlesztő
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'Network Engineer',
                'description' => 'Keresünk tapasztalt hálózati mérnököt vállalati infrastruktúránk üzemeltetéséhez és fejlesztéséhez. Feladataid: LAN/WAN hálózatok tervezése és konfigurálása, tűzfal- és VPN-megoldások kezelése (Cisco, Fortinet), hálózati incidensek kivizsgálása és elhárítása, kapacitástervezés. Elvárjuk a CCNA/CCNP minősítést vagy ezzel egyenértékű tapasztalatot, legalább 3 éves vállalati hálózat-üzemeltetési múltat és az ITIL-folyamatok ismeretét. Cégünk cafeteria-csomagot, laptop-juttatást és folyamatos képzési lehetőségeket kínál.',
                'salary_min' => 550000,
                'salary_max' => 900000,
                'location' => 'Miskolc',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd2ce0efd855180d0ecd',    // Rendszergazda
                'company_id' => '69d3e3f8e0efd855180d0f10', // IronGate Solutions Kft.
            ],
            [
                'title' => 'Information Security Analyst',
                'description' => 'IronGate Solutions Kft. kiberbiztonság-elemzőt keres fejlődő biztonsági csapatába. Felelősségi köröd: biztonsági incidensek észlelése és kezelése SIEM-rendszerek segítségével, sérülékenységvizsgálatok koordinálása, biztonsági auditok lebonyolítása és jelentések készítése a vezető felé. Szükséges: CEH, CISSP vagy hasonló minősítés, Splunk/QRadar tapasztalat, alapos ismeret a NIST és ISO 27001 keretrendszerekről. Rugalmas munkaidőt, magasabb cafeteria-keretet és kibertámadás-szimulációs gyakorlati tréningeket biztosítunk.',
                'salary_min' => 750000,
                'salary_max' => 1200000,
                'location' => 'Székesfehérvár',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd4ce0efd855180d0ed2',    // Cybersecurity szakember
                'company_id' => '69d3e3f8e0efd855180d0f10', // IronGate Solutions Kft.
            ],
            [
                'title' => 'Senior Data Engineer',
                'description' => 'Nagy adatmennyiségeket kezelő adatmérnököt keresünk, aki tapasztalt adatfolyamatok és adattárházak tervezésében. Feladatok: ETL/ELT pipeline-ok fejlesztése Apache Spark és Airflow segítségével, adatmodellek kialakítása BigQuery vagy Redshift platformon, adatminőség-ellenőrzési folyamatok bevezetése, BI-csapattal való szoros együttműködés. Elvárás: 4+ év adatmérnöki tapasztalat, Python vagy Scala ismeret, felhőplatformok (GCP/AWS) ismerete. Cégünk versenyszintű fizetést, részvényopciót és home office lehetőséget nyújt.',
                'salary_min' => 700000,
                'salary_max' => 1200000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd3ce0efd855180d0ecf',    // Adatmérnök (Data Engineer)
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'Gépészmérnök',
                'description' => 'NovaBuild Kft. gépészmérnököt keres győri gyártóüzemébe. A munkakör feladatai: gépészeti rendszerek tervezése és műszaki dokumentációk elkészítése AutoCAD és SolidWorks szoftverekkel, gyártási folyamatok optimalizálása, karbantartási tervek kidolgozása és felügyelete. Elvárjuk a gépészmérnöki diplomát, 2+ éves ipari tapasztalatot és a CAD-szoftverek magabiztos kezelését. Az állás határozatlan idejű szerződéssel, céges gépjármű-juttatással és évente teljesítményarányos bonusszal jár.',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'location' => 'Győr',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cdbae0efd855180d0ed4',    // Gépészmérnök
                'company_id' => '69d3e37de0efd855180d0f0a', // NovaBuild Kft.
            ],
            [
                'title' => 'Villamosmérnök',
                'description' => 'Tapasztalt villamosmérnököt keresünk ipari automatizálási projektekhez. Feladatok közé tartozik PLC-programozás (Siemens S7, Allen-Bradley), villamos tervek készítése EPLAN szoftverrel, helyszíni üzembe helyezés és átadás-átvétel koordinálása, karbantartási utasítások kidolgozása. Elvárjuk a villamosmérnöki végzettséget és legalább 3 éves releváns tapasztalatot. Juttatásként céges autót, mobilt, szakmai fejlesztési keretet és versenyképes bérezést biztosítunk.',
                'salary_min' => 550000,
                'salary_max' => 850000,
                'location' => 'Győr',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cdbfe0efd855180d0ed5',    // Villamosmérnök
                'company_id' => '69d3e37de0efd855180d0f0a', // NovaBuild Kft.
            ],
            [
                'title' => 'Karbantartó Technikus',
                'description' => 'Karbantartó technikust keresünk debreceni gyáregységünkbe. Az Ön feladata lesz a termelőgépek és -berendezések megelőző és korrektív karbantartásának elvégzése, meghibásodások gyors diagnózisa és elhárítása, karbantartási naplók naprakészen tartása, és az üzemeltetési csapattal való szoros együttműködés. Elvárjuk a villamos vagy gépész szakmai képzettséget, 2+ éves karbantartói tapasztalatot és hidraulikus/pneumatikus rendszerek ismeretét. Műszakpótlék, étkezési hozzájárulás és stabil munkahelyi körülmények várnak.',
                'salary_min' => 380000,
                'salary_max' => 560000,
                'location' => 'Debrecen',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cdcde0efd855180d0ed8',    // Karbantartó technikus
                'company_id' => '69d3e35be0efd855180d0f08', // BlueWave Technologies Kft.
            ],
            [
                'title' => 'Könyvelő',
                'description' => 'GreenLeaf Solutions Kft. tapasztalt könyvelőt keres budapesti irodájába. Feladatok: havi könyvelési zárások elvégzése, ÁFA-bevallások és társasági adó elkészítése, bankegyeztetések, főkönyvi könyvelés, bérszámfejtési folyamatok támogatása. Elvárjuk a mérlegképes könyvelői vizsgát, 3+ éves releváns tapasztalatot és a Könyvelőkirály vagy SAP ismeretét. Csapatunk 10 fős, barátságos munkakörnyezetet, rugalmas munkaidőt és rendszeres szakmai továbbképzéseket biztosít.',
                'salary_min' => 400000,
                'salary_max' => 600000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cdd9e0efd855180d0edb',    // Könyvelő
                'company_id' => '69d3e349e0efd855180d0f07', // GreenLeaf Solutions Kft.
            ],
            [
                'title' => 'Pénzügyi Elemző',
                'description' => 'Ambiciózus pénzügyi elemzőt keresünk, aki képes komplex pénzügyi modelleket készíteni és stratégiai döntéseket alátámasztó elemzéseket nyújtani a menedzsment számára. Feladataid: havi, negyedéves és éves pénzügyi riportok összeállítása, cost-benefit elemzések, cash flow előrejelzések, befektetési projektek értékelése. Elvárjuk a pénzügyi/közgazdász diplomát, Excel haladó szintű ismeretét (Power Query, Power BI előny), és 2+ éves elemzői tapasztalatot. Versenyképes bérezés, részvényopció és karrierfejlesztési programok várnak.',
                'salary_min' => 550000,
                'salary_max' => 900000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cddde0efd855180d0edc',    // Pénzügyi elemző
                'company_id' => '69d3e349e0efd855180d0f07', // GreenLeaf Solutions Kft.
            ],
            [
                'title' => 'HR Business Partner',
                'description' => 'Dinamikusan növekvő technológiai cégünk HR Business Partnert keres. A munkakör felöleli a toborzás-kiválasztási folyamatok végigvitelét, munkavállalói teljesítményértékelési rendszer koordinálását, onboarding programok szervezését, munkaügyi adminisztráció kezelését és a munkajogi kérdésekben való tanácsadást a menedzsmentnek. Elvárjuk a HR-es diplomát vagy releváns képzést, 3+ éves HRBP tapasztalatot és kiváló kommunikációs készségeket. Juttatáscsomag: cafeteria, laptop, home office lehetőség.',
                'salary_min' => 550000,
                'salary_max' => 850000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cde1e0efd855180d0edd',    // HR munkatárs
                'company_id' => '69d3e422e0efd855180d0f13', // FutureStack Kft.
            ],
            [
                'title' => 'IT Recruiter',
                'description' => 'IT toborzó kollégát keresünk gyorsan bővülő csapatunkba. Feladataid: műszaki pozíciók aktív betöltése (LinkedIn Recruiter, álláshirdetések, referral), jelöltek előszűrése és kompetencia-interjúk lebonyolítása, munkáltatói márkaépítésben való aktív részvétel, munkaerőpiaci trendek és bérsávok figyelemmel kísérése. Elvárjuk a HR vagy kommunikációs diplomát, 1+ éves IT-toborzói tapasztalatot és az angol tárgyalási szintű ismeretét. Rugalmas munkaidőt, prémiumos javadalmazási rendszert és kellemes irodai környezetet biztosítunk.',
                'salary_min' => 450000,
                'salary_max' => 700000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cde5e0efd855180d0ede',    // Toborzó (Recruiter)
                'company_id' => '69d3e422e0efd855180d0f13', // FutureStack Kft.
            ],
            [
                'title' => 'Ügyfélszolgálati Munkatárs',
                'description' => 'LogicLane Kft. ügyfélszolgálati munkatársat keres békéscsabai irodájába. Feladataid: bejövő ügyfélmegkeresések kezelése telefonon, e-mailben és chat-csatornákon, panaszok kivizsgálása és megoldása SLA-n belül, ügyféladatok rögzítése CRM-rendszerben, heti riportok összeállítása az ügyfélszolgálati vezető részére. Elvárjuk a legalább érettségi végzettséget, kiváló szóbeli és írásbeli kommunikációs készségeket és türelmes, empatikus hozzáállást. Betanítást és rendszeres belső képzéseket biztosítunk.',
                'salary_min' => 320000,
                'salary_max' => 450000,
                'location' => 'Békéscsaba',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cdf0e0efd855180d0ee1',    // Ügyfélszolgálat
                'company_id' => '69d3e458e0efd855180d0f16', // LogicLane Kft.
            ],
            [
                'title' => 'Marketing Manager',
                'description' => 'Tapasztalt Marketing Managert keresünk, aki átveszi a teljes marketing-részleg operatív irányítását. Felelősségi területek: integrált marketing-kampányok stratégiai tervezése és megvalósítása, éves marketingköltségvetés kezelése, ügynökségekkel és médiapartnerekkel való együttműködés, márkakommunikáció és -arculat konzisztenciájának biztosítása, marketingcsapat mentorálása. Elvárjuk a marketing végzettséget, 5+ éves releváns tapasztalatot, Google Analytics és CRM-ismeretet. Prémiumos bérezés, cafeteria és céges telefon.',
                'salary_min' => 700000,
                'salary_max' => 1100000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cdfae0efd855180d0ee3',    // Marketing manager
                'company_id' => '69d3e349e0efd855180d0f07', // GreenLeaf Solutions Kft.
            ],
            [
                'title' => 'Social Media Manager',
                'description' => 'Kreatív és adatvezérelt Social Media Managert keresünk, aki képes közösségi médiacsatornáinkat (Instagram, Facebook, LinkedIn, TikTok) stratégiai szemlélettel fejleszteni. Feladataid: tartalomstratégia kidolgozása, posztok szövegezése és ütemezése, közösségmenedzsment, influencer-együttműködések koordinálása, teljesítménymutatók (engagement, reach, konverzió) elemzése és riportálása. Elvárjuk a 2+ éves közösségimédia-kezelési tapasztalatot és a grafikai eszközök (Canva, Adobe) ismeretét. Alkotói szabadságot és rugalmas munkaidőt kínálunk.',
                'salary_min' => 400000,
                'salary_max' => 650000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cdfee0efd855180d0ee4',    // Social media manager
                'company_id' => '69d3e415e0efd855180d0f12', // WebCore Studio Kft.
            ],
            [
                'title' => 'Grafikus Tervező',
                'description' => 'Webcore Studio Kft. kreatív grafikust keres szegedi stúdiójába. Feladatok: arculati elemek, nyomtatott és digitális marketinganyagok tervezése, webes bannerek és közösségi médiás kreatívok elkészítése, animált tartalmak készítése After Effects-szel, nyomdakész fájlok előkészítése. Elvárjuk az Adobe Creative Suite (Photoshop, Illustrator, InDesign) haladó szintű ismeretét, erős tipográfiai érzéket és online portfóliót. Inspiráló, fiatal csapatot, rugalmas munkaidőt és lehetőséget kínálunk kreatív kibontakozásra.',
                'salary_min' => 380000,
                'salary_max' => 600000,
                'location' => 'Szeged',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3ce02e0efd855180d0ee5',    // Grafikus
                'company_id' => '69d3e415e0efd855180d0f12', // WebCore Studio Kft.
            ],
            [
                'title' => 'SEO Specialista',
                'description' => 'Tapasztalt SEO specialistát keresünk, aki képes organikus forgalmunkat következetes és mérhető eredményekkel növelni. Feladataid: átfogó kulcsszókutatás és versenytárselemzés, on-page és technikai SEO optimalizálás, linképítési stratégiák kidolgozása és végrehajtása, SEO-teljesítmény rendszeres mérése Google Search Console, Ahrefs és Semrush eszközökkel, tartalom-csapattal való szoros együttműködés. Elvárjuk a 3+ éves SEO-tapasztalatot és algoritmikus frissítések követésének képességét. Teljesen remote munkavégzés lehetséges.',
                'salary_min' => 450000,
                'salary_max' => 750000,
                'location' => 'Szeged',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3ce0de0efd855180d0ee8',    // SEO szakember
                'company_id' => '69d3e415e0efd855180d0f12', // WebCore Studio Kft.
            ],
            [
                'title' => 'B2B Értékesítési Tanácsadó',
                'description' => 'Tapasztalt B2B értékesítési tanácsadót keresünk vállalati ügyfélkörünk bővítésére. Feladataid: új üzleti lehetőségek feltárása és hideghívás útján való ügyfélakvizíció, termékbemutatók és ajánlatok összeállítása, tárgyalások levezetése és szerződéskötések, meglévő ügyfelek gondozása és cross-sell/up-sell lehetőségek kiaknázása. Elvárjuk a legalább 2 éves B2B értékesítési tapasztalatot, kiváló tárgyalási készséget és eredményorientált hozzáállást. Magas prémiumrendszer, céges autó és laptop juttatással.',
                'salary_min' => 400000,
                'salary_max' => 800000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3ce19e0efd855180d0eeb',    // Értékesítő
                'company_id' => '69d3e349e0efd855180d0f07', // GreenLeaf Solutions Kft.
            ],
            [
                'title' => 'Key Account Manager',
                'description' => 'Kulcsfontosságú ügyfeleinket gondozó Key Account Managert keresünk. Fő feladataid: stratégiai ügyfélkapcsolatok fenntartása és fejlesztése, éves üzleti tervek megalkotása és megvalósítása, ügyfél-elégedettség mérése és javítása, belsős csapatokkal (marketing, fejlesztés, support) való koordináció az ügyféligények teljesítése érdekében, éves tárgyalások és szerződésmegújítások lebonyolítása. Elvárjuk az 5+ éves account management tapasztalatot, stratégiai szemléletmódot és folyékony angol tudást. Prémiumos bérezés, részvényopció.',
                'salary_min' => 700000,
                'salary_max' => 1200000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3ce24e0efd855180d0eee',    // Key account manager
                'company_id' => '69d3e422e0efd855180d0f13', // FutureStack Kft.
            ],
            [
                'title' => 'Területi Képviselő',
                'description' => 'Területi képviselőt keresünk Észak-Magyarország régióra. Feladataid: meglévő viszonteladói és végfelhasználói ügyfélkör rendszeres látogatása és kapcsolattartás, új ügyfelek felkutatása és akvirálása, termékbemutatók tartása, éves forgalmi célok elérése, versenypiaci aktivitás és ügyféligények riportálása az értékesítési igazgatónak. Elvárjuk a B-kategóriás jogosítványt, 2+ éves terepen végzett értékesítési tapasztalatot, és önálló munkavégzési képességet. Céges autó, telefon, laptop és teljesítményarányos jutalom.',
                'salary_min' => 380000,
                'salary_max' => 650000,
                'location' => 'Miskolc',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce20e0efd855180d0eed',    // Területi képviselő
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'Ápoló',
                'description' => 'Miskolci egészségügyi intézményünkbe ápolót keresünk belgyógyászati osztályra. A munkakör tartalmazza a betegek gondozását és felügyeletét, vitális paraméterek mérését és dokumentálását, orvosi utasítások végrehajtását, gyógyszerelési feladatokat, és a betegek hozzátartozóival való kapcsolattartást. Elvárjuk az ápolói diplomát, aktív működési engedélyt és empatikus, precíz munkavégzést. Nővér-szállás lehetséges, műszakpótlék, étkezési juttatás és folyamatos szakmai képzési lehetőségek biztosítottak.',
                'salary_min' => 400000,
                'salary_max' => 580000,
                'location' => 'Miskolc',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce34e0efd855180d0ef1',    // Ápoló
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'Gyógyszerész',
                'description' => 'Kaposvári patikánkba gyógyszerészt keresünk teljes vagy részmunkaidőben. Feladataid: receptre és vény nélkül kiadható gyógyszerek kiszolgálása, betegek tájékoztatása a gyógyszerek szedéséről és interakcióiról, gyógyszerkészletek kezelése és rendelése, gyógyszertár adminisztrációs feladatainak ellátása. Elvárjuk a gyógyszerész diplomát és aktív kamarai tagságot. Kellemes, kis csapatos munkakörnyezetet, rugalmas beosztást és versenyképes bérezést kínálunk.',
                'salary_min' => 500000,
                'salary_max' => 750000,
                'location' => 'Kaposvár',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce38e0efd855180d0ef2',    // Gyógyszerész
                'company_id' => '69d3e405e0efd855180d0f11', // BrightMind Kft.
            ],
            [
                'title' => 'Gyógytornász',
                'description' => 'Dinamikusan fejlődő rehabilitációs központunkba gyógytornászt keresünk. Feladatok: egyéni terápiás tervek kidolgozása és végrehajtása ortopédiai, neurológiai és sportrehabilitációs páciensek számára, állapotfelmérések és dokumentáció vezetése, mozgásfejlesztő csoportfoglalkozások tartása, kollégákkal való szakmai együttműködés és esetmegbeszélések. Elvárjuk a gyógytornász diplomát, aktív kamarai tagságot és pozitív, motiváló személyiséget. Részleges home-visit lehetőség, rendszeres szupervízió és szakmai konferenciák finanszírozása.',
                'salary_min' => 430000,
                'salary_max' => 650000,
                'location' => 'Pécs',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3ce3fe0efd855180d0ef4',    // Gyógytornász
                'company_id' => '69d3e36be0efd855180d0f09', // SmartCore Systems Kft.
            ],
            [
                'title' => 'Általános Iskolai Tanár (Informatika)',
                'description' => 'Általános iskolai informatika tanárt keresünk veszprémi intézményünkbe. Feladataid: informatika tantárgy tanítása 5–8. évfolyamon, tanmenetek és órák tervezése a kerettanterv alapján, tanulók digitális kompetenciáinak fejlesztése, szülő-pedagógus kapcsolat ápolása és fogadóórák tartása, iskolai rendezvényeken való közreműködés. Elvárjük a tanári diplomát (informatika szak), pedagógiai érzéket és modern oktatási módszerek iránti nyitottságot. Pedagógus bérezési bértáblának megfelelő juttatás, nyári szünet.',
                'salary_min' => 380000,
                'salary_max' => 550000,
                'location' => 'Veszprém',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce47e0efd855180d0ef6',    // Tanár
                'company_id' => '69d3e44be0efd855180d0f15', // QuantumSoft Kft.
            ],
            [
                'title' => 'Soft Skills Tréner',
                'description' => 'BrightMind Kft. soft skills trénert keres vállalati képzési portfóliójának bővítésére. Feladataid: kommunikáció, tárgyalástechnika, időmenedzsment és csapatmunka témájú tréningek tervezése és megtartása, igényfelmérések elvégzése ügyfelek számára, tréninganyagok kidolgozása és frissítése, képzési hatékonyság mérése és riportálása. Elvárjuk a tréner/coach végzettséget, 3+ éves trénerként szerzett tapasztalatot és lenyűgöző prezentációs képességeket. Rugalmas beosztást, projekt alapú prémiumot és saját szakmai fejlődési keretet kínálunk.',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'location' => 'Kaposvár',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3ce4ee0efd855180d0ef8',    // Tréner
                'company_id' => '69d3e405e0efd855180d0f11', // BrightMind Kft.
            ],
            [
                'title' => 'Logisztikai Koordinátor',
                'description' => 'NetFusion Kft. logisztikai koordinátort keres nyíregyházi telephelyére. Feladataid: bejövő és kimenő szállítmányok szervezése és nyomkövetése, fuvarozói ajánlatok bekérése és kiértékelése, vámügyintézési folyamatok koordinálása, raktárkészlet figyelemmel kísérése és rendelések kezelése ERP-rendszerben, szállítói reklamációk és késések kezelése. Elvárjük a logisztikai végzettséget, SAP vagy hasonló ERP-rendszer ismeretét és angol alapfokú kommunikációs képességet. Étkezési utalvány, rendszeres csapatrendezvények.',
                'salary_min' => 400000,
                'salary_max' => 620000,
                'location' => 'Nyíregyháza',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce66e0efd855180d0efd',    // Logisztikai koordinátor
                'company_id' => '69d3e434e0efd855180d0f14', // NetFusion Kft.
            ],
            [
                'title' => 'Raktáros',
                'description' => 'Kecskemét közelében lévő elosztóközpontunkba raktárost keresünk. Az Ön feladata lesz az áruk be- és kiszállításának végrehajtása, komissiózás vonalkódos letapogatóval, készletleltárok elvégzése, a raktár rendjének és tisztaságának fenntartása, valamint a targoncavezetési teendők ellátása érvényes targoncavezető-engedéllyel. Elvárjuk az alapfokú végzettséget, raktárosi tapasztalatot és targoncavezetői engedélyt. Betanulási támogatás, műszakpótlék, cafeteria juttatás és bejárási hozzájárulás biztosított.',
                'salary_min' => 300000,
                'salary_max' => 420000,
                'location' => 'Kecskemét',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce62e0efd855180d0efc',    // Raktáros
                'company_id' => '69d3e3c9e0efd855180d0f0e', // AlphaByte Kft.
            ],
            [
                'title' => 'Beszerző',
                'description' => 'Tapasztalt beszerzőt keresünk szombathelyi központunkba. Feladataid: rendszeres és eseti beszerzési igények koordinálása, szállítói ajánlatok bekérése és összehasonlítása, keretszerződések tárgyalása és megkötése, szállítói teljesítmény értékelése, szoros együttműködés a pénzügyi és logisztikai csapatokkal. Elvárjük a gazdasági/műszaki végzettséget, 2+ éves beszerzési tapasztalatot és jó tárgyalókészséget. Kompetitív bérezés, home office lehetőség hetente 2 napban, szakmai fejlesztési program.',
                'salary_min' => 450000,
                'salary_max' => 700000,
                'location' => 'Szombathely',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3ce69e0efd855180d0efe',    // Beszerző
                'company_id' => '69d3e3dae0efd855180d0f0f', // CloudPeak Kft.
            ],
            [
                'title' => 'Villanyszerelő',
                'description' => 'Tapasztalt villanyszerelőt keresünk ipari és lakóépületi projektjeinkhez Szombathely és környékén. Feladatok: villamos hálózatok és elosztótáblák tervezési dokumentáció alapján történő szerelése, hibadiagnózis és javítás, gépek és berendezések villamos csatlakoztatása, elvégzett munkák dokumentálása és átadása. Elvárjuk a villanyszerelői szakképzettséget, érvényes villanyszerelői engedélyt (MV kategória előny), B-jogosítványt és önálló munkavégzési képességet. Céges autó, szerszámpótlék, teljesítményprémium.',
                'salary_min' => 380000,
                'salary_max' => 600000,
                'location' => 'Szombathely',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce72e0efd855180d0f00',    // Villanyszerelő
                'company_id' => '69d3e3dae0efd855180d0f0f', // CloudPeak Kft.
            ],
            [
                'title' => 'Ipari Hegesztő',
                'description' => 'Győri gyártóüzemünkbe ipari hegesztőt keresünk acélszerkezetek gyártásához. Feladataid: MIG/MAG és TIG hegesztési eljárások alkalmazása különféle anyagokhoz (acél, rozsdamentes acél, alumínium), hegesztési utasítások olvasása és értelmezése, elvégzett munkák minőségellenőrzése, munkahelyi rend és biztonság betartása. Elvárjuk az érvényes hegesztői vizsgákat (135, 141 előnyös), legalább 2 éves üzemi tapasztalatot és pontosságot. Műszakpótlék, veszélyességi pótlék, étkezési hozzájárulás és stabil foglalkoztatás.',
                'salary_min' => 360000,
                'salary_max' => 550000,
                'location' => 'Győr',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3ce7be0efd855180d0f02',    // Hegesztő
                'company_id' => '69d3e37de0efd855180d0f0a', // NovaBuild Kft.
            ],
            [
                'title' => 'PPC Specialista',
                'description' => 'Webcore Studio Kft. PPC specialistát keres szegedi csapatába. Feladataid: Google Ads és Meta Ads kampányok stratégiai tervezése, beállítása és optimalizálása, napi/heti riportálás az ügyfelek felé, A/B tesztek tervezése és kiértékelése, kulcsszókutatás és versenytárelemzés, hirdetési büdzsék hatékony elosztása és menedzsmentje. Elvárjük a Google Ads és Meta Blueprint tanúsítványt, 2+ éves PPC-kezelési tapasztalatot és analitikus gondolkodásmódot. Remote munkavégzés lehetséges, teljesítményalapú jutalom.',
                'salary_min' => 450000,
                'salary_max' => 750000,
                'location' => 'Szeged',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3ce11e0efd855180d0ee9',    // PPC szakértő
                'company_id' => '69d3e415e0efd855180d0f12', // WebCore Studio Kft.
            ],
            [
                'title' => 'Content Creator',
                'description' => 'Kreatív tartalomkészítőt keresünk márkaépítési és digitális marketing csapatunkba. Feladataid: blog-, közösségimédia- és e-mail-tartalmak írása SEO-szempontok figyelembevételével, videószkriptekhez és podcastokhoz szükséges szövegek készítése, szerkesztői naptár karbantartása és betartása, analitikai adatok alapján tartalomstratégia finomítása, kreatív kampányokban való részvétel ötletbörze szintjén. Elvárjük a kiváló íráskészséget, 1+ éves tartalomkészítői tapasztalatot és alapszintű SEO-ismeretet. Teljesen remote munkavégzés lehetséges.',
                'salary_min' => 380000,
                'salary_max' => 600000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3ce08e0efd855180d0ee7',    // Tartalomkészítő (Content creator)
                'company_id' => '69d3e349e0efd855180d0f07', // GreenLeaf Solutions Kft.
            ],
        ];

        foreach ($jobOffers as $offer) {
            JobOffer::updateOrCreate(
                ['title' => $offer['title']],
                $offer
            );
        }
    }
}
